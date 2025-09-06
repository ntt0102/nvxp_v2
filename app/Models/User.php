<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\MailResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id', 'member_id', 'username', 'password', 'email', 'role', 'avatar', 'remember_token', 'created_at', 'updated_at'
    ];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return (int) $this->role > 0;
    }

    /**
     * @return string
     */
    public function getAvatarPath()
    {
        $avatar = $this->avatar ? $this->avatar : config('adminlte.avatar-' . ($this->gender == 2 ? 'fe' : '') . 'male');
        return asset("/images/avatar/{$avatar}");
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        $member = Member::find($this->member_id);
        return $member ? $member->name : "";
    }

    /**
     * @return interger
     */
    public function getMemberId()
    {
        $member = Member::find($this->member_id);
        return $member ? $member->id : 0;
    }

    /**
     * @return mixed
     */
    // public function getRecordTitle()
    // {
    //     return $this->name;
    // }

    /**
     * Sends the password reset notification.
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }

    // /**
    //  * Get the modified user.
    //  */
    // public function gender()
    // {
    //     return $this->belongsTo('App\Models\Classify', 'gender', 'other_key');
    // }

    public function member()
    {
        return $this->belongsTo('App\Models\Member');
    }
}
