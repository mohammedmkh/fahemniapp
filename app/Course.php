<?php

namespace App;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang ;
class Course extends Model
{
    use SoftDeletes;

    public $table = 'courses';

    protected $appends = ['name'];

    protected $hidden = ['created_at' , 'updated_at'  , 'deleted_at' , 'name_ar' ,'name_en' , 'parent'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name_ar',
        'name_en',
        'code',
        'parent',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getNameAttribute()
    {
        $lang = Lang::getLocale();
        if($lang == 'ar' || $lang == 'arabic'){
            $name = $this->name_ar ;
        }else{
            $name = $this->name_en ;
        }

        if($this->code != '' && $this->parent <> 0){
            return  $name . ' - ' . $this->code  ;
        }
        return  $name;
    }


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
