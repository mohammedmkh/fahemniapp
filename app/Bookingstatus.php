<?php

namespace App;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Lang ;

class Bookingstatus extends Model
{


    public $table = 'booking_statuses';


    protected $hidden = [ 'status_name_ar' ,'status_name_en' ];
    protected $appends = ['status_name'] ;


    public function getStatusNameAttribute(){
        $lang = Lang::getLocale();
        if($lang == 'ar' || $lang == 'arabic'){
            return $this->status_name_ar ;
        }

        return $this->status_name_en ;


    }

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];



    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
