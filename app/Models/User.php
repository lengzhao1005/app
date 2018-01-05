<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    use Notifiable {
        notify as protected laravelNotification;
    }

    public function notify($instance)
    {
        if($this->id == Auth::id()){
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotification($instance);
    }

    public function markAsRead()
    {
        $this->notification_count =0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','introduction',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics()
    {
        return $this->hasMany(Topics::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function isAuthOf($model)
    {
        return $this->id === $model->user_id;
    }
}
