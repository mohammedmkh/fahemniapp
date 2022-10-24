<?php

namespace App;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang ;
class TutorQuta extends Model
{
    use SoftDeletes;

    public $table = 'tutor_quta';


    protected $hidden = ['created_at' , 'updated_at' , 'deleted_at'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'created_at',
        'updated_at',
        'deleted_at',
        'display'
    ];



    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function price()
    {
        return $this->belongsTo(Price::class, 'quta_id' ,'id');
    }
}
