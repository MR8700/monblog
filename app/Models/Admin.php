<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin'; // Utilisé pour auth:admin

    protected $fillable = [
        'name',
        'email',
        'password',
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
}
