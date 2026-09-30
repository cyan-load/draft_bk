<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke profil siswa
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function calendarEvents()
    {
        return $this->hasMany(CalendarEvent::class, 'user_id');
    }

    public function handledCounselings()
    {
        return $this->hasMany(CounselingSession::class, 'guru_id');
    }

    public function appNotifications()
    {
        return $this->hasMany(AppNotification::class, 'user_id')->orderBy('created_at', 'desc');
    }

    public function unreadNotificationsCount()
    {
        return $this->appNotifications()->where('is_read', false)->count();
    }
}