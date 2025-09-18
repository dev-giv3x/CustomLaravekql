<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class Role extends Model
{
    use HasFactory;

    public $timestamp = false;
    protected $fillable = [
        'name'
    ];
}