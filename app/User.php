<?php

namespace App;

use \DateTimeInterface;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable, HasApiTokens;

    public $table = 'users';

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = ['reviewedRating', 'IsFavorite'];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'verify',
        'phone',
        'sex',
        'age',
        'country_id',
        'lat',
        'long',
        'level_id',
        'university_id',
        'bio',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function userTutorsCourses()
    {
        return $this->hasMany(TutorsCourse::class, 'user_id', 'id');
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function university()
    {
        return $this->belongsTo(Universite::class, 'university_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function findForPassport($username)
    {
        // dd($username );
        $user = $this->where('phone', $username)->first();

        return $user;
    }

    public function reviewer()
    {
        return $this->hasMany(Review::class, 'reviewer_id');

    }

    public function reviewed()
    {
        return $this->hasMany(Review::class, 'reviewed_id');

    }

    public function favoriteTeacher()
    {
        return $this->hasMany(Vaforite::class, 'tutor_id');

    }

    public function getReviewedRatingAttribute()
    {
        return $this->reviewed()->avg('review') ?: 0;
    }

    public function getIsFavoriteAttribute()
    {
        if(!Auth::check()){
            return 0 ;

        }
        $cheackIsFavorite = $this->favoriteTeacher()->where('user_id', Auth::guard('api')->id())->count();

        return $cheackIsFavorite > 0 ? 1:0 ;
    }
}
