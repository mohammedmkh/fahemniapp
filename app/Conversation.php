<?php

namespace App;

use Carbon\Carbon;
use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use SoftDeletes;

    public $table = 'conversations';

    protected $appends = [ 'accept_name' , 'last_message'];

    public function getAcceptNameAttribute()
    {
        if($this->accept == 0){
            return 'قيد المراجعة' ;
        }elseif($this->accept == 1){
            return ' تم القبول' ;
        }elseif($this->accept == 2){
            return ' مرفوض ' ;
        }



    }
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'tutor_id',
        'accept',
        'end_conv',
        'sendbird_channel',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    public function getLastMessageAttribute( )
    {

        // $conversation->load('user', 'tutor');
        // get messages from the application

        $teacher_id = $this->tutor->application_chat_id ;
        $student_id = $this->student->application_chat_id ;

        //$m="1629923467823";
        // $msg['date']=date('Y-m-d H:i:s', strtotime($message->createdAtTime));


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,            "https://apps.applozic.com/rest/ws/analytics/message?applicationId=3b7632a496392dc1eb19f9302fa269&pageSize=300&from=". $teacher_id."&to=".$student_id );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           0 );
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json' , 'Application-Key: 3b7632a496392dc1eb19f9302fa269', 'Authorization: Basic YWRtaW5ib3Q6YWRtaW5ib3Q=' , 'Of-User-Id:adminbot'));
        $result=curl_exec ($ch);

        $chat = [];
        $teacher['name']=$this->tutor->name ;
        $teacher['image']=$this->tutor->image_path ;
        $student['name']=$this->student->name ;
        $student['image']=$this->student->image_path ;
        //  dd($result ,$teacher_id  , $student_id);
        $result = json_decode( $result);

        if($result && count($result->response) > 0){
            $msg = [] ;
            foreach ($result->response as $message){


                $message->createdAtTime =(String)$message->createdAtTime;
                // $msg['date']=date('Y-m-d H:i:s', strtotime($message->createdAtTime));
                //dd( $msg ,$message->createdAtTime );
                $msg['date']= Carbon::parse($message->createdAtTime /1000)->toDateTimeString();
                $msg['content']= $message->content ;
                if(isset($message->fileMeta) && $message->fileMeta != ''){
                    $msg['type'] = 'audio' ;
                }else{
                    $msg['type'] = 'text' ;
                }
                //  $msg['type']= isset($message->fileMeta) ? 'text': 'audio' ;
                if($message->fromUserId ==  $teacher_id){
                    $msg['is_teacher']=true;
                }else{
                    $msg['is_teacher']=false;
                }

                // dd($message->createdAtTime);
                return  $msg ;
            }
        }

        return null ;
       // $chat = array_reverse( $chat);

    }
}
