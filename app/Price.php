<?php

namespace App;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class Price extends Model
{
    use SoftDeletes;

    public $table = 'prices';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $appends = ['has_it' , 'name'];
    protected $hidden = ['created_at' , 'updated_at' , 'deleted_at' ];

    protected $fillable = [
        'num_std',
        'hours',
        'price',
        'commission',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function getNameAttribute()
    {
        return 'عدد الطلاب' . $this->num_std . ' الساعات  -' . $this->hours ;
    }
    public function getHasItAttribute()
    {
        $auth =Auth::guard('api')->user() ;
        if($auth){
            $is_exist = TutorQuta::where('quta_id' ,$this->id)->where('user_id', $auth->id)->where('display',1)->first();
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
