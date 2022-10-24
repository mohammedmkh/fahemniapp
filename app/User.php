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

    protected $casts = [
        'role' => 'integer', 'country_id'=>'integer' , 'level_id' => 'integer'
        , 'university_id' => 'integer' ,'sms_code'=> 'string'
    ];
    protected $appends = ['reviewedRating', 'IsFavorite' , 'role_name' , 'cv_path' , 'grades_doc_path' ,
        'image_path' , 'sex_name' ,'age' , 'best_course' , 'verify_name' , 'status_name'
        ,'count_booking' ,'count_booking_finish', 'is_complete_bank_account'];

    protected $fillable = [
        'name',
        'role' ,
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'status',
        'verify',
        'phone',
        'sex',
        'country_id',
        'city_id',
        'lat',
        'long',
        'level_id',
        'university_id',
        'bio',
        'cv',
        'grades_doc',
        'birthday',
        'created_at',
        'updated_at',
        'deleted_at',
        'bank_name' ,
        'bank_user_name' ,
        'bank_account' ,
        'bank_iban'
    ];


    public function getBioAttribute($value)
    {
        //return 'Man';
        if($value == null || $value == ''){
            return '' ;
        }
        return $value ;
    }

    public function getBestCourseAttribute()
    {
        if( $this->TutorsCourses != ''){
            return $this->TutorsCourses[0]->course->name ?? '' ;
        }else{
            return null;
        }
      //  return $user ;
    }


    public function getStatusNameAttribute()
    {
        if($this->status == 0){
            return __('api.not_verify') ;
        }
        if($this->status == 2){
            return __('api.rejected') ;
        }
        return __('api.verify') ;
    }


    public function getVerifyNameAttribute()
    {
        if($this->verify == 0){
            return __('api.not_verify') ;
        }

        return __('api.verify') ;
    }
    public function getSexNameAttribute()
    {
        if($this->sex == 0){
            return __('api.female') ;
        }

        return __('api.male') ;
    }

    public function getCountBookingAttribute(){

        $bookings = Booking::where('tutor_id' , $this->id)->where('status', 4)->count();

        return $bookings ;
    }

    public function getCountBookingFinishAttribute(){

        $bookings = Booking::where('tutor_id' , $this->id)->where('is_posting' , 0)->where('status', 4)->count();

        return $bookings ;
    }


    public function getAgeAttribute(){
        if($this->birthday != ''){
            $age =   \Carbon\Carbon::parse($this->birthday)->diff(\Carbon\Carbon::now())->format('%y years');
          return $age;
        }
        return '20 years';
       // return $item;
    }

    public function getIsCompleteBankAccountAttribute(){
        if($this->bank_name != ''){
          return 1 ;
        }
        return 0;
        // return $item;
    }



    public function getCvPathAttribute()
    {
        if($this->cv != ''){
            return url('/').'/'.$this->cv ;
        }
        return '';

    }

    public function getGradesDocPathAttribute()
    {
        if($this->grades_doc != ''){
            return url('/').'/'.$this->grades_doc ;
        }
        return '';

    }

    public function getImagePathAttribute()
    {
        if($this->image != ''){
            return url('/').'/'.$this->image ;
        }

        if($this->sex == 0 )
            return url('/').'/female.png';

        return url('/').'/user.jpeg';
       // return __('api.teacher') ;
    }

    public function getRoleNameAttribute()
    {
       if($this->role == 2){
           return __('api.student') ;
       }
       return __('api.teacher') ;
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function TutorsCourses()
    {
        return $this->hasMany(TutorsCourse::class, 'user_id', 'id');
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

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
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

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'tutor_id');

    }

    public function userHealthy()
    {
        return $this->hasMany(Userhealthy::class, 'user_id');

    }
    public function reviewed()
    {
        return $this->hasMany(Review::class, 'reviewed_id');

    }

    public function times()
    {
        return $this->hasMany(TutorTimes::class, 'user_id')->where('display' ,1);

    }

    public function quta()
    {
        return $this->hasMany(TutorQuta::class, 'user_id')->where('display' ,1);;

    }

    public function favoriteTeacher()
    {
        return $this->hasMany(Vaforite::class, 'tutor_id');

    }




    public function getReviewedRatingAttribute()
    {
        return (double)$this->reviewed()->avg('review') ?: 0;
    }

    public function getIsFavoriteAttribute()
    {
        if(!Auth::guard('api')->id()){
            return 0 ;

        }
        $cheackIsFavorite = $this->favoriteTeacher()->where('user_id', Auth::guard('api')->id())->count();

        return $cheackIsFavorite > 0 ? 1:0 ;
    }
}
