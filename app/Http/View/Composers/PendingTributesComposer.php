<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Tribute;

class PendingTributesComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $pendingTributesCount = 0;

        if (Auth::check()) {
            $user = Auth::user();
            $memorialIds = $user->memorials->pluck('id');

            $pendingTributesCount = Tribute::whereIn('memorial_id', $memorialIds)
                ->where('status', 'pending')
                ->count();
        }

        $view->with('pendingTributesCount', $pendingTributesCount);
    }
}