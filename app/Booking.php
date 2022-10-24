<?php

namespace App;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    public $table = 'bookings';

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = ['booking_status' ,'finish_time' ,'start_time', 'finish_timestamp' , 'payed_name'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $fillable = [
        'user_id',
        'tutor_id',
        'date',
        'time_id',
        'payed',
        'status',
        'price_id',
        'total',
        'created_at',
        'updated_at',
        'deleted_at',
        'the_time'
    ];



    protected $casts = [
        'is_review_tutor' => 'integer',
        'is_review_student' =>'integer' ,
        'bio' => 'string' ,
        'payed' =>'integer' ,
    ];

    public function getPayedNameAttribute()
    {
       if($this->payed == 1){
           return 'مدفوع' ;
       }
       return 'غير مدفوع' ;
    }
    public function getBookingStatusAttribute()
    {
        return $this->belongsTo(Bookingstatus::class, 'status')->first()->status_name ?? ' In Payment Proccess ';
    }

    public function getfinishTimestampAttribute()
    {

        $time = $this->finish_time ;
        return Carbon::parse( $time );
    }

    public function getStartTimeAttribute()
    {

        $time_start = $this->the_time  ;
        $date = $this->date;
        $start_finish  = Carbon::parse( $date . $time_start)->toDateTimeString();

        return $start_finish  ;

    }

    public function getfinishTimeAttribute()
    {
        $hours =  $this->price->price ->hours ?? 1;
        $time_start = $this->the_time  ;
        $date = $this->date;
        $time_finish  = Carbon::parse( $date . $time_start)->addHours($hours)->toDateTimeString();

        return $time_finish  ;

    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function price()
    {
        return $this->belongsTo(TutorQuta::class, 'price_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function times()
    {
        return $this->belongsTo(TutorTimes::class, 'time_id')->where('display' ,1);;
    }


}
