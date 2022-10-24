<?php

namespace App;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Userhealthy extends Model
{
    use SoftDeletes;

    public $table = 'user_healthy';
    protected $appends = ['answer_name'] ;

    public function getAnswerNameAttribute(){
       if($this->answer == 1)
       {
           return 'نعم' ;

       }

       return 'لا' ;
    }

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'question_id',
        'answer',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function question()
    {
        return $this->belongsTo(Questions::class,'question_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
