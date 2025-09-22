<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Podcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'content',
        'audio_file',
        'duration',
        'file_size',
        'tags',
        'meta_description',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                    ->where('published_at', '<=', Carbon::now());
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Accessors
    public function getIsPublishedAttribute()
    {
        return $this->published_at && $this->published_at <= Carbon::now();
    }

    public function getAudioUrlAttribute()
    {
        return $this->audio_file ? asset('audio/' . $this->audio_file) : null;
    }

    public function getDurationAttribute($value)
    {
        // Return the stored duration from database
        return $value;
    }
}
