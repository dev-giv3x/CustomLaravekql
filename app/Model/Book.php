<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class Book extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'title',
        'author',
        'year_public',
        'price',
        'is_new',
        'description'
    ];

    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class, 'book_id');
    }

}
