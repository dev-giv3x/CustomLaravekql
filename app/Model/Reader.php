<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class Reader extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'ticket_number',
        'firstname',
        'lastname',
        'patronomic',
        'phone_number',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class, 'readers_id');
    }
}
