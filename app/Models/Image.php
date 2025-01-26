<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'prompt',
        'image_path',
        'width',
        'height',
        'aspect_ratio',
        'seed',
        'category_ids',
        'is_published',
        'can_download',
        'hide_prompt',
    ];

    protected $casts = [
        'category_ids' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function categories()
    {
        // If category_ids is null, return an empty collection
        if (is_null($this->category_ids)) {
            return collect();
        }

        // Ensure category_ids is always treated as an array
        return Category::whereIn('id', (array) $this->category_ids)->get();
    }




    protected $dates = ['deleted_at'];

    // Search filter scope
    public function scopeFilter($query, $filters)
    {
        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%')
                ->orWhere('prompt', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['category'])) {
            // Use whereJsonContains to filter by category_ids array
            $query->whereJsonContains('category_ids', $filters['category']);
        }
    }

    // Sorting scope
    public function scopeSortBy($query, $sortOrder)
    {
        switch ($sortOrder) {
            case 'most_liked':
                // Using a subquery to sort by the number of likes
                $query->withCount('likes')
                    ->orderBy('likes_count', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    }
}
