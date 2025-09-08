<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'tributes_enabled', // This allows it to be mass-assigned
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_passing' => 'date',
        'tributes_enabled' => 'boolean', // This is the critical fix
    ];

    /**
     * Get the user that owns the memorial.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tributes for the memorial.
     */
    public function tributes(): HasMany
    {
        return $this->hasMany(Tribute::class);
    }
}