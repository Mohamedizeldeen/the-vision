<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'description',
        'content',
        'location',
        'location_url',
        'publish_status',
        'event_type',
        'published_at',
        'image',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'publish_status' => 'boolean',
        'published_at' => 'datetime',
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
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', Carbon::today());
    }

    public function scopePast($query)
    {
        return $query->where('end_date', '<', Carbon::today());
    }

    public function scopeActive($query)
    {
        return $query->where('start_date', '<=', Carbon::today())
                    ->where('end_date', '>=', Carbon::today());
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeOrderByDate($query)
    {
        return $query->orderBy('start_date')->orderBy('start_time');
    }

    // Accessors
    public function getIsUpcomingAttribute()
    {
        return $this->start_date >= Carbon::today();
    }

    public function getIsActiveAttribute()
    {
        return $this->start_date <= Carbon::today() && $this->end_date >= Carbon::today();
    }

    public function getIsPastAttribute()
    {
        return $this->end_date < Carbon::today();
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('img/' . $this->image) : null;
    }

    public function getDurationAttribute()
    {
        $start = Carbon::parse($this->start_date . ' ' . $this->start_time);
        $end = Carbon::parse($this->end_date . ' ' . $this->end_time);
        return $start->diffForHumans($end, true);
    }
}
