<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    public $primaryKey = 'id';
    public $timestamps = true;
    public $userid = 'user_id';
    //use HasFactory;
}
