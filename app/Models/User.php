<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'role',
        'pending_amount',
        'advance_amount',
        'image',
    ];

    protected $appends = ['total_spendings'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function getpendingAmount() {
    //     $pending_amount = $this->hasMany(Food_users::class, 'user_id')->where('user_id', auth()->user()->id)->sum('amount');
    //     return $pending_amount;
    // }

    protected function getadvanceAmountAttribute() {
        $pending_amount = $this->hasMany(Food_users::class, 'user_id')->where('user_id', $this->id)->sum('amount');

        $paid_amount = $this->hasMany(Food::class, 'owner_id')->where('owner_id', $this->id)->sum(\DB::raw('hotel_amount + other_amount'));
        $given_amount = $this->hasMany(Amount::class, 'sender_id')->where('sender_id', $this->id)->where('is_approved', 1)->sum('amount');
        $received_amount = $this->hasMany(Amount::class, 'receiver_id')->where('receiver_id', $this->id)->where('is_approved', 1)->sum('amount');
        $total = $paid_amount + $given_amount - $pending_amount - $received_amount;
        return round($total, 2);
    }

    protected function gettotalSpendingsAttribute() {

        $paid_amount = $this->hasMany(Food::class, 'owner_id')->where('owner_id', $this->id)->sum(\DB::raw('hotel_amount + other_amount'));
        $given_amount = $this->hasMany(Amount::class, 'sender_id')->where('sender_id', $this->id)->where('is_approved', 1)->sum('amount');
        $received_amount = $this->hasMany(Amount::class, 'receiver_id')->where('receiver_id', $this->id)->where('is_approved', 1)->sum('amount');
        $total = $paid_amount + $given_amount  - $received_amount;
        return round($total, 2);
    }
}
