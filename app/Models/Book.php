<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title','author_id','category_id','published_year','price'];
    
    public function author()
    { 
        return $this->belongsTo(Author::class); 
    }
    public function category()
    { 
        return $this->belongsTo(Category::class); 
    }
    public function ratings()
    { 
        return $this->hasMany(Rating::class); 
    }
     public static function getTop10Ids(): array
    {
         return self::withAvg('ratings', 'score')
        ->orderByDesc('ratings_avg_score')
        ->limit(10)
        ->pluck('id')
        ->toArray();
    }
    public static function getTop10(): \Illuminate\Support\Collection
    {
        return self::query()
            ->with('author') // optional kalau mau keluar nama author
            ->withAvg('ratings as avg_score', 'score')
            ->withCount(['ratings as votes_count' => fn($q) => $q->where('score','>',5)])
            ->orderByDesc('avg_score')
            ->limit(10)
            ->get(['id', 'title', 'author_id']);
    }
}
