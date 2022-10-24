<?php

namespace App;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App;
class Questions extends Model
{
    use SoftDeletes;

    public $table = 'questions';

    protected $appends = ['question'] ;
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden=['question_ar', 'question_en' ,'created_at',
        'updated_at',
        'deleted_at',];
    protected $fillable = [
        'question_ar',
        'question_en',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getQuestionAttribute(){
     $lang = \App::getLocale();
     if($lang == 'en'){
         return $this->question_en;
     }

     return $this->question_ar;
    //  dd($lang );
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
