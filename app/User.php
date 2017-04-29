<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return string
     */
    public function getNameAttribute($name)
    {
        return $name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmailAttribute($email)
    {
        return $email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = $email;

        return $this;
    }

    /**
     * Notification for password reset.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
