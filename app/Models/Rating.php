<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = ['book_id','score','comment'];
    
    public function book()
    { 
        return $this->belongsTo(Book::class); 
    }
}
