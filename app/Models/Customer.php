<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable {
    use HasFactory, Notifiable;

    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'FirstName',
        'LastName',
        'StreetName',
        'Suburb',
        'PostCode',
        'DateOfBirth',
        'PhNumber',
        'Username',
        'Email',
        'Password',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    public function getAuthPassword() {
        return $this->Password;
    }

    // Laravel expects 'email' to be the name of the email field
    public function getEmailForPasswordReset() {
        return $this->Email;
    }

    public function orders() {
        return $this->hasMany(Order::class, 'customer_id'); // Verify the foreign key name
    }
}
