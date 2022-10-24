<?php

namespace App;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang ;


class CourseRequest extends Model
{
    use SoftDeletes;

    public $table = 'course_requests';


    protected $hidden = ['created_at' , 'updated_at' , 'deleted_at' ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'course_name',
        'course_code',
        'details',
        'created_at',
        'updated_at',
        'deleted_at',
    ];




    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
