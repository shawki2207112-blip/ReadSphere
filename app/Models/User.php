<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * Attributes that may be assigned using create(), update(), or fill().
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];

    /**
     *  Attributes hidden when the model is converted to array or JSON.
     
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute type conversions.

     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * One user can have many borrowing records.
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }
    /**
     * Checking whether this user is an admin.
     */
    public function isAdmin():bool{
        return $this->role==='admin';
    }
}
