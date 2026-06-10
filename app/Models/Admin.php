<?php
namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, Filterable;

    protected $guard = 'admin'; // Utilisé pour auth:admin

    protected $fillable = [
        'name',
        'email',
        'profile_picture',
        'password',
        'role',
        'is_suspended',
    ];

    protected $casts = [
        'is_suspended' => 'boolean',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relations
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function portfolioItems()
    {
        return $this->hasMany(PortfolioItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    /**
     * Vérifier si l'admin a un rôle spécifique.
     */
    public function hasRole($role)
    {
        return $this->role === $role; 
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isSuspended()
    {
        return $this->is_suspended;
    }

    /**
     * Filtrer par recherche textuelle
     */
    public function filterSearch(Builder $query, $search): Builder
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }

    public function filterRole(Builder $query, $role): Builder
    {
        return $query->where('role', $role);
    }
}
