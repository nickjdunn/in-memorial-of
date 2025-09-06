<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Memorial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ExampleMemorialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a dedicated "Example" user to own the memorial
        $exampleUser = User::firstOrCreate(
            ['email' => 'example@inmemorialof.com'],
            [
                'name' => 'Example User',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'memorial_slots_purchased' => 1,
            ]
        );

        // 2. Only create the memorial if it doesn't already exist
        if ($exampleUser->memorials()->count() === 0) {
            Memorial::create([
                'user_id' => $exampleUser->id,
                'full_name' => 'Eleanor Vance',
                'date_of_birth' => '1945-06-15',
                'date_of_passing' => '2023-11-22',
                'biography' => "Eleanor Vance was a beacon of light and warmth to all who knew her. Born in a small coastal town, she developed a lifelong love for the sea and the stories it held. As a librarian for over 40 years, she nurtured a love of reading in thousands of children, always ready with a smile and the perfect book recommendation.\n\nShe was a devoted mother, a cherished grandmother, and a friend whose laughter could fill any room. Eleanor's passion was her garden, where she spent countless hours cultivating beautiful roses that were the envy of the neighborhood. Her legacy is one of kindness, generosity, and the simple joy of sharing a story. She will be deeply missed and forever remembered.",
                'profile_photo_path' => null, // We won't add a photo to keep it generic
                'slug' => 'eleanor-vance-' . Str::random(10),
                'primary_color' => '#4c1d95', // A respectful deep purple
                'font_family_name' => 'Playfair Display',
                'font_family_body' => 'Lora',
                'photo_shape' => 'rounded-full',
            ]);
        }
    }
}