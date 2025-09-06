<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Memorial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'date_of_birth',
        'date_of_passing',
        'biography',
        'profile_photo_path',
        'slug',
        'primary_color',
        'font_family_name',
        'font_family_body',
        'photo_shape',
    ];

    /**
     * Get the user that owns the memorial.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}