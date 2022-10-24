<?php

namespace App;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang;
class Universite extends Model
{
    use SoftDeletes;

    public $table = 'universites';
    protected $appends = ['name'];
    protected $hidden = ['created_at' , 'updated_at' , 'deleted_at' , 'name_ar' ,'name_en'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name_en',
        'name_ar',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getNameAttribute()
    {
        $lang = Lang::getLocale();
        if($lang == 'ar' || $lang == 'arabic'){
            return $this->name_ar ;
        }

        return $this->name_en ;
    }

}
