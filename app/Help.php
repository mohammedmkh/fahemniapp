<?php

namespace App;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang ;
class Help extends Model
{
    use SoftDeletes;

    public $table = 'helps';


    protected $appends = ['question' , 'answer'];

    protected $hidden = ['created_at' , 'updated_at' , 'deleted_at' , 'question_ar' ,'question_en' , 'answer_en' , 'answer_ar'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'question_ar',
        'question_en',
        'answer_en',
        'answer_ar',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function getAnswerAttribute()
    {
        $lang = Lang::getLocale();
        if($lang == 'ar' || $lang == 'arabic'){
            return $this->answer_ar ;
        }

        return $this->answer_en ;
    }

    public function getQuestionAttribute()
    {
        $lang = Lang::getLocale();
        if($lang == 'ar' || $lang == 'arabic'){
            return $this->question_ar ;
        }

        return $this->question_en ;
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
