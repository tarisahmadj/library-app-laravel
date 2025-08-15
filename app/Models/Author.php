<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;
    protected $fillable = ['name','email'];
    // Relasi ke books
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    // Relasi ke ratings (jika rating terkait ke author lewat books)
    public function ratings()
    {
        return $this->hasManyThrough(Rating::class, Book::class);
    }

    /**
     * Ambil daftar ID author yang masuk top 10 berdasarkan rata-rata rating.
     * 
     * @return array
     */
    public static function getTop10Ids(): array
    {
        return self::query()
            ->select('id')
            ->whereHas('ratings', fn($q) => $q->where('score', '>', 5))
            ->withCount([
                'ratings as votes_count' => fn($q) => $q->where('score', '>', 5)
            ])
            ->orderByDesc('votes_count')
            ->take(10)
            ->pluck('id')
            ->toArray();
    }
    public static function getTop10(): \Illuminate\Support\Collection
    {
        return self::query()
            ->withCount([
                'ratings as votes_count' => fn($q) => $q->where('score', '>', 5)
            ])
            ->whereHas('ratings', fn($q) => $q->where('score', '>', 5))
            ->orderByDesc('votes_count')
            ->limit(10)
            ->get(['id', 'name']);
    }
}
