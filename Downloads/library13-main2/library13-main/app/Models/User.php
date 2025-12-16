<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

   
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

   
    public function bookRequests(): HasMany
    {
        return $this->hasMany(BookRequest::class);
    }

  
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    
    public function getIsAdminAttribute(): bool
    {
        return $this->role === 'admin';
    }

   
    public function getIsCustomerAttribute(): bool
    {
        return $this->role === 'customer' || $this->role === null;
    }

   
    public function createCustomer(array $data = []): Customer
    {
        return $this->customer()->create(array_merge([
            'user_id' => $this->id,
        ], $data));
    }

    
    public function activeBookRequests()
    {
        return $this->bookRequests()
            ->whereIn('status', ['pending', 'approved'])
            ->get();
    }

   
    public function hasActiveRequestForBook($bookId): bool
    {
        return $this->bookRequests()
            ->where('book_id', $bookId)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
    }

    
    public function getActiveRequestsCountAttribute(): int
    {
        return $this->bookRequests()
            ->whereIn('status', ['pending', 'approved'])
            ->count();
    }

    
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

   
    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer')
            ->orWhereNull('role');
    }

   
    public function scopeWithCustomer($query)
    {
        return $query->whereHas('customer');
    }

    public function scopeWithBookRequests($query)
    {
        return $query->whereHas('bookRequests');
    }
}