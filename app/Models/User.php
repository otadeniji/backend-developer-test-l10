<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    public function watched()
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }

    // New methods for achievements and badges

    public function unlockedAchievements()
    {
        // Assuming an 'achievements' table and a corresponding model
        return $this->belongsToMany(Achievement::class)->withTimestamps();
    }

    public function nextAvailableAchievements()
    {
        $unlocked = $this->unlockedAchievements()->pluck('id');
        return Achievement::whereNotIn('id', $unlocked)->orderBy('id')->limit(1)->get();
    }

    public function currentBadge()
    {
        $count = $this->unlockedAchievements()->count();
        if ($count >= 10) return 'Master';
        if ($count >= 8) return 'Advanced';
        if ($count >= 4) return 'Intermediate';
        return 'Beginner';
    }

    public function nextBadge()
    {
        $currentBadge = $this->currentBadge();
        switch ($currentBadge) {
            case 'Beginner': return 'Intermediate';
            case 'Intermediate': return 'Advanced';
            case 'Advanced': return 'Master';
            default: return null; // No next badge after 'Master'
        }
    }

    public function remainingToUnlockNextBadge()
    {
        $count = $this->unlockedAchievements()->count();
        if ($count < 4) return 4 - $count;
        if ($count < 8) return 8 - $count;
        if ($count < 10) return 10 - $count;
        return 0; // No more badges to unlock after 'Master'
    }
}
