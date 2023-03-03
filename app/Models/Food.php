<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    protected $table = 'foods';

    protected $guarded = ['id'];

    protected $appends = ['total_amount'];

    public function users() {
        return $this->belongsToMany(User::class, Food_users::class, 'food_id', 'user_id')->withPivot('amount');
    }

    public function added_by_user() {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function given_by_user() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    protected function totalAmount() : Attribute {
        return new Attribute(
            get: fn() => $this->hotel_amount + $this->other_amount
        );
    }
}
