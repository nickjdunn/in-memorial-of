<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tribute extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'memorial_id',
        'name',
        'message',
    ];

    /**
     * Get the memorial that the tribute belongs to.
     */
    public function memorial(): BelongsTo
    {
        return $this->belongsTo(Memorial::class);
    }
}