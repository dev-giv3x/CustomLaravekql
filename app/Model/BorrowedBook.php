<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class BorrowedBook extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'book_id',
        'reader_id',
        'date_issue',
        'date_return'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function reader()
    {
        return $this->belongsTo(Reader::class, 'reader_id');
    }
}
