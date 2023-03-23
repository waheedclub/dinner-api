<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food_users extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'food_users';
    protected $guarded = ['id'];
}
