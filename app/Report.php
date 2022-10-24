<?php

namespace App;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

use Lang ;
class Report extends Model
{


    public $table = 'report_conversation';



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }



}
