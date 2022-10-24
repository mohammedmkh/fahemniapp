<?php

namespace App;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang ;
use Auth;
class Times extends Model
{
    use SoftDeletes;

    public $table = 'times';


    protected $appends = ['has_it'];
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
    ];

    public function getHasItAttribute()
    {
        $auth =Auth::guard('api')->user() ;
        if($auth){
            $is_exist = TutorTimes::where('time_id' ,$this->id)->where('user_id', $auth->id)->where('display' , 1)->first();
            if($is_exist){
                return 1;
            }

        }

       return 0;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
