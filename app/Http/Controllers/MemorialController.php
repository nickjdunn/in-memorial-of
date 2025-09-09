<?php

namespace App\Http\Controllers;

use App\Models\Memorial;
use App\Models\Tribute;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Validation\Rule;

class MemorialController extends Controller
{
    private function combineDate($year, $month, $day)
    {
        if ($year && $month && $day && checkdate($month, $day, $year)) {
            return "{$year}-{$month}-{$day}";
        }
        return null;
    }

    public function create()
    {
        $user = auth()->user();
        if ($user->memorials()->count() >= $user->memorial_slots_purchased) {
            return redirect()->route('dashboard')->with('error', 'You must purchase a memorial slot before creating a new page.');
        }
        return view('memorials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'biography' => 'required|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'birth_month' => 'nullable|integer|min:1|max:12',
            'birth_day'   => 'nullable|integer|min:1|max:31',
            'birth_year'  => 'nullable|integer|min:1800',
            'passing_month' => 'nullable|integer|min:1|max:12',
            'passing_day'   => 'nullable|integer|min:1|max:31',
            'passing_year'  => 'nullable|integer|min:1800',
            'primary_color' => 'required|string|max:7',
            'font_family_name' => 'required|string|max:255',
            'font_family_body' => 'required|string|max:255',
            'photo_shape' => ['required', 'string', Rule::in(['rounded-full', 'rounded-2xl', '', 'shape-diamond', 'shape-octagon', 'shape-heart', 'shape-cross'])],
            'user_id' => 'sometimes|required|exists:users,id',
            'tributes_enabled' => 'nullable|string',
            'visibility' => ['required', Rule::in(['public', 'private'])],
            'password' => 'nullable|required_if:visibility,private|string|min:4',
        ]);

        $isAdminCreation = $request->has('user_id') && auth()->user()->is_admin;
        $targetUser = $isAdminCreation ? User::find($validated['user_id']) : auth()->user();

        if ($targetUser->memorials()->count() >= $targetUser->memorial_slots_purchased) {
            $redirectRoute = $isAdminCreation ? route('admin.users.edit', $targetUser) : route('dashboard');
            return redirect($redirectRoute)->with('error', 'This user has no available memorial slots.');
        }

        $birthDate = $this->combineDate($request->birth_year, $request->birth_month, $request->birth_day);
        $passingDate = $this->combineDate($request->passing_year, $request->passing_month, $request->passing_day);

        if ($birthDate && $passingDate && strtotime($passingDate) < strtotime($birthDate)) {
            return back()->withInput()->withErrors(['date_of_passing' => 'The ending date cannot be before the beginning date.']);
        }
        
        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $image = $request->file('profile_photo');
            $fileName = Str::random(40) . '.webp';
            $processedImage = Image::read($image);
            $processedImage->scaleDown(width: 800);
            Storage::disk('public')->put('photos/' . $fileName, (string) $processedImage->toWebp(75));
            $photoPath = 'photos/' . $fileName;
        }
        
        $slug = Str::slug($validated['full_name']) . '-' . uniqid();
        
        Memorial::create([
            'user_id' => $targetUser->id,
            'full_name' => $validated['full_name'],
            'date_of_birth' => $birthDate,
            'date_of_passing' => $passingDate,
            'biography' => $validated['biography'],
            'profile_photo_path' => $photoPath,
            'slug' => $slug,
            'primary_color' => $validated['primary_color'],
            'font_family_name' => $validated['font_family_name'],
            'font_family_body' => $validated['font_family_body'],
            'photo_shape' => $validated['photo_shape'],
            'tributes_enabled' => $request->has('tributes_enabled'),
            'visibility' => $validated['visibility'],
            'password' => $validated['password'],
        ]);
        
        if ($isAdminCreation) {
            return redirect()->route('admin.users.edit', $targetUser)->with('status', 'Memorial page created successfully for ' . $targetUser->name);
        }
        return redirect()->route('dashboard')->with('status', 'Memorial page created successfully!');
    }

    public function showPublic(Request $request, Memorial $memorial)
    {
        // Check if the page is private
        if ($memorial->visibility === 'private') {
            // Allow access if the logged-in user is the owner or an admin
            if (Auth::check() && (Auth::id() === $memorial->user_id || Auth::user()->is_admin)) {
                // They are authorized, proceed to show the page
            }
            // Check if the visitor has already unlocked this memorial in their session
            else if ($request->session()->get('memorial_access_' . $memorial->id) !== true) {
                // If not, show the password gate
                return view('memorials.auth.password', compact('memorial'));
            }
        }

        $approvedTributes = Tribute::where('memorial_id', $memorial->id)
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('memorials.show_public', compact('memorial', 'approvedTributes'));
    }

    public function checkPassword(Request $request, Memorial $memorial)
    {
        $request->validate(['password' => 'required']);

        if (Hash::check($request->password, $memorial->password)) {
            // Password is correct. Store access token in session.
            $request->session()->put('memorial_access_' . $memorial->id, true);
            return redirect()->route('memorials.show_public', $memorial->slug);
        }

        // Password was incorrect. Redirect back with an error.
        return back()->with('error', 'The password provided was incorrect.');
    }

    public function edit(Memorial $memorial)
    {
        if (auth()->id() !== $memorial->user_id && !auth()->user()->is_admin) {
            abort(403);
        }
        $memorial->load('tributes');
        $pendingTributes = $memorial->tributes->where('status', 'pending');
        $approvedTributes = $memorial->tributes->where('status', 'approved');
        return view('memorials.edit', compact('memorial', 'pendingTributes', 'approvedTributes'));
    }

    public function update(Request $request, Memorial $memorial)
    {
        if (auth()->id() !== $memorial->user_id && !auth()->user()->is_admin) {
            abort(403);
        }
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'biography' => 'required|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'birth_month' => 'nullable|integer|min:1|max:12',
            'birth_day'   => 'nullable|integer|min:1|max:31',
            'birth_year'  => 'nullable|integer|min:1800',
            'passing_month' => 'nullable|integer|min:1|max:12',
            'passing_day'   => 'nullable|integer|min:1|max:31',
            'passing_year'  => 'nullable|integer|min:1800',
            'primary_color' => 'required|string|max:7',
            'font_family_name' => 'required|string|max:255',
            'font_family_body' => 'required|string|max:255',
            'photo_shape' => ['required', 'string', Rule::in(['rounded-full', 'rounded-2xl', '', 'shape-diamond', 'shape-octagon', 'shape-heart', 'shape-cross'])],
            'redirect_to_user' => 'nullable|exists:users,id',
            'tributes_enabled' => 'nullable|string',
            'visibility' => ['required', Rule::in(['public', 'private'])],
            'password' => 'nullable|string|min:4',
        ]);

        $birthDate = $this->combineDate($request->birth_year, $request->birth_month, $request->birth_day);
        $passingDate = $this->combineDate($request->passing_year, $request->passing_month, $request->passing_day);
        if ($birthDate && $passingDate && strtotime($passingDate) < strtotime($birthDate)) {
            return back()->withInput()->withErrors(['date_of_passing' => 'The ending date cannot be before the beginning date.']);
        }

        if ($request->hasFile('profile_photo')) {
            if ($memorial->profile_photo_path) {
                Storage::disk('public')->delete($memorial->profile_photo_path);
            }
            $image = $request->file('profile_photo');
            $fileName = Str::random(40) . '.webp';
            $processedImage = Image::read($image);
            $processedImage->scaleDown(width: 800);
            Storage::disk('public')->put('photos/' . $fileName, (string) $processedImage->toWebp(75));
            $memorial->profile_photo_path = 'photos/' . $fileName;
        }

        $memorial->fill($validated);
        $memorial->date_of_birth = $birthDate;
        $memorial->date_of_passing = $passingDate;
        $memorial->tributes_enabled = $request->has('tributes_enabled');
        
        if ($validated['visibility'] === 'public') {
            $memorial->password = null;
        } else {
            if (!empty($request->password)) {
                $memorial->password = $request->password;
            }
        }
        
        $memorial->save();
        
        if ($request->has('redirect_to_user') && auth()->user()->is_admin) {
             return redirect()->route('admin.users.edit', $request->redirect_to_user)->with('status', 'Memorial page updated successfully!');
        }
        return redirect()->route('dashboard')->with('status', 'Memorial page updated successfully!');
    }

    public function destroy(Memorial $memorial)
    {
        if (auth()->id() !== $memorial->user_id && !auth()->user()->is_admin) {
            abort(403);
        }
        if ($memorial->profile_photo_path) {
            Storage::disk('public')->delete($memorial->profile_photo_path);
        }
        $memorial->delete();
        if (auth()->user()->is_admin) {
             return redirect()->route('admin.users.index')->with('status', 'Memorial page deleted successfully.');
        }
        return redirect()->route('dashboard')->with('status', 'Memorial page deleted successfully.');
    }
}