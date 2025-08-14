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
        return cache()->remember('top10_author_ids', now()->addMinutes(10), function () {
            return self::withAvg('ratings', 'score')
                ->orderByDesc('ratings_avg_score')
                ->limit(10)
                ->pluck('id')
                ->toArray();
        });
    }
}
