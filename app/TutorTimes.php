<?php

namespace App;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang ;
class TutorTimes extends Model
{
    use SoftDeletes;

    public $table = 'tutor_times';


    protected $hidden = ['created_at' , 'updated_at' , 'deleted_at'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'time',
        'created_at',
        'updated_at',
        'deleted_at',
        'display'
    ];



    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function time()
    {
        return $this->belongsTo(Times::class, 'time_id' ,'id');
    }
}
