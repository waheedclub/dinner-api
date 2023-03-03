<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Amount extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    protected function createdAt() : Attribute {
        return new Attribute(
            get: fn($value) => date('Y-m-d' , strtotime($value))
        );
    }
}
