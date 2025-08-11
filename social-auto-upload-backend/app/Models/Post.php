<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_path',
        'caption',
        'platform',
        'schedule',
        'status',
    ];

    /**
     * Casting untuk kolom tertentu
     */
    protected $casts = [
        'schedule' => 'datetime', // otomatis jadi Carbon instance
    ];

    /**
     * Default value untuk status
     */
    protected $attributes = [
        'status' => 'scheduled',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk filter postingan berdasarkan status
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter postingan berdasarkan platform
     */
    public function scopePlatform($query, string $platform)
    {
        return $query->where('platform', $platform);
    }

    /**
     * Cek apakah postingan sudah waktunya dipost
     */
    public function isDue(): bool
    {
        return $this->schedule <= Carbon::now();
    }
}
