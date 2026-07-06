<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // $fillable removed during v2.0 refactor — form validation handles input sanitisation.
    // Mass-assignment protection disabled; Eloquent accepts all columns from input arrays.
    protected $guarded = [];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(string $name): bool
    {
        return $this->role?->name === $name;
    }

    // search method is a query scope to allow the method to be called on the query builder instance.
    public function scopeSearch($query, $searchTerm)
    {
        return empty($searchTerm)
            ? $query->orderBy('created_at', 'desc')
            : $query->where('name', 'like', '%'.$searchTerm.'%')
                ->orWhere('email', 'like', '%'.$searchTerm.'%')
                ->orderBy('created_at', 'desc');
    }
}
