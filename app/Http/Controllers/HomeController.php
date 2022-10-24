<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Conversation;
use App\Devicetoken;
use App\TutorTimes;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function testingchat(Request  $request){

        $chats = Conversation::all();

        foreach ($chats as $chat){
            $channel = $chat->sendbird_channel ;
            $url = 'https://api-CDDB4171-09BE-4476-B29F-98EB112A9234.sendbird.com/v3/group_channels/'.$channel.'?show_member=true';

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array(
                "Api-Token: d9ee0417e82bcd3e609c8163b20c5d6691fa4dbf",
                "Content-Type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);



            $resp = json_decode($resp ) ;
            $members =  $resp->members ;

            $user_id_is_add = false ;
            $tutor_id_is_add = false ;

            foreach (  $members  as $member){
                $member_id =  $member->user_id ;
                $ids =    explode( '_' ,$member_id );
                $member_id = $ids[0];

                if( $member_id == $chat->user_id){
                    $user_id_is_add = true ;
                }

                if( $member_id == $chat->totur_id){
                    $tutor_id_is_add = true ;
                }
            }
            if( !$user_id_is_add){
                // we will add the  user_id_s  to channel


                // we before want to check if user exist  if not we will create the user

                $user_id = $chat->user_id.'_s';
                $url = 'https://api-CDDB4171-09BE-4476-B29F-98EB112A9234.sendbird.com/v3/users/'.$user_id;

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $headers = array(
                    "Api-Token: d9ee0417e82bcd3e609c8163b20c5d6691fa4dbf",
                    "Content-Type: application/json",
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $resp = curl_exec($curl);
                curl_close($curl);

                $resp = json_decode($resp ) ;

                //print_r( $resp);

                if(isset( $resp ->error) && $resp->error == true){
                    // we will create the user
                    print_r('we add ');

                    $channel = $chat->sendbird_channel ;
                    $url = 'https://api-CDDB4171-09BE-4476-B29F-98EB112A9234.sendbird.com/v3/users/';

                    $filedata = array('user_id' =>    $user_id , 'nickname' => $chat->user->name ,
                        'profile_url'  =>'https://sendbird.com/main/img/profiles/profile_05_512px.png');


                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                    $headers = array(
                        "Api-Token: d9ee0417e82bcd3e609c8163b20c5d6691fa4dbf",
                        "Content-Type: application/json",
                    );
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($filedata));
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    $resp = curl_exec($curl);
                    curl_close($curl);

                    $resp = json_decode($resp ) ;

                    print_r(  $resp );



                }



                //PUT
               // https://api-{application_id}.sendbird.com/v3/group_channels/{channel_url}/join
                 $channel = $chat->sendbird_channel ;
            $url = 'https://api-CDDB4171-09BE-4476-B29F-98EB112A9234.sendbird.com/v3/group_channels/'.$channel.'/join';

                $filedata = array('user_id' =>    $user_id);


                $curl = curl_init($url);
            curl_setopt(  $curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array(
                "Api-Token: d9ee0417e82bcd3e609c8163b20c5d6691fa4dbf",
                "Content-Type: application/json",
            );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($filedata));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $resp = curl_exec($curl);
                curl_close($curl);

                print_r($resp);
            }

            if( !$tutor_id_is_add){
                // we will add the  tutor_id_t  to channel


            }

        }



    }


    public function checkChannelChat2(){
        $channel = 'sendbird_group_channel_185449799_6b824c08cb4be244c5a21253ce8cef5177135dd1' ;
        $url = 'https://api-CDDB4171-09BE-4476-B29F-98EB112A9234.sendbird.com/v3/group_channels/'.$channel.'?show_member=true';

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Api-Token: d9ee0417e82bcd3e609c8163b20c5d6691fa4dbf",
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);



        $resp = json_decode($resp ) ;
        $members =  $resp->members ;

        foreach (  $members  as $member){
             $member_id =  $member->user_id ;
             $ids =    explode( '_' ,$member_id );
             $member_id = $ids[0];
            print_r(   $member_id );
        }


        //$count_members =   $resp['members'];

      //  print_r(  $resp );


    }

    public function checkChannelChat(){
        $channel = 'sendbird_group_channel_183621273_377963e9cdef3e0cf4f848230316ecb051ad2a45' ;
        $url = 'https://api-CDDB4171-09BE-4476-B29F-98EB112A9234.sendbird.com/v3/group_channels/'.$channel.'?show_member=true';

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Api-Token: d9ee0417e82bcd3e609c8163b20c5d6691fa4dbf",
            "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        $resp = json_decode($resp ) ;

        if( isset($resp->members) && count($resp->members) < 2){
            // delete this channel and create new channel


        }


    }

    public function sendFCMtest3(){
        $users =User::all();
        foreach ($users as $user){
            if($user['id'] == 197){
                $user_id = $user['id'];
                $tokens = Devicetoken::where('user_id', $user_id)->first();
                $title = '  فهمني 77';
                $body = 'تميز معنا في تطبيق فهمني';
                $data['action_type'] = 'test';
                $data['action_id'] = $user_id;
                $data['user_id'] = $user_id;
                $data['date'] = Carbon::now()->timestamp;
                $data['title'] = $title;
                $data['body'] = $body;
               // dd($data ,   $tokens);
                sendFCM($title, $body, $data, $tokens, 1, 1);
            }

        }

    }

    public function sendFCMtest2(){
        $users =User::all();
        foreach ($users as $user){
            if($user['id'] == 91){
                $user_id = $user['id'];
                $tokens = Devicetoken::where('user_id', $user_id)->first();
                $title = '  فهمني ';
                $body = 'تميز معنا في تطبيق فهمني';
                $data['action_type'] = 'test';
                $data['action_id'] = $user_id;
                $data['user_id'] = $user_id;
                $data['date'] = Carbon::now()->timestamp;
                $data['title'] = $title;
                $data['body'] = $body;
                sendFCM($title, $body, $data, $tokens, 1, 1);
            }

        }

    }

    public function sendFCMtest(){
        $users =User::all();
        foreach ($users as $user){
            $user_id = $user['id'];
           // dd( $user_id );
            $tokens = Devicetoken::where('user_id', $user_id)->first();
            $title = '  فهمني ';
            $body = 'تميز معنا في تطبيق فهمني';
            $data['action_type'] = 'test';
            $data['action_id'] = $user_id;
            $data['user_id'] = $user_id;
            $data['date'] = Carbon::now()->timestamp;
            $data['title'] = $title;
            $data['body'] = $body;
            sendFCM($title, $body, $data, $tokens, 1, 1);
        }

    }

    public function test(){

        $time = Carbon::now()->subMinutes(5)->toTimeString();
        $now_time = Carbon::now()->toTimeString();
        $date = Carbon::now()->toDateString();

        $bookings = Booking::where('date' , $date)->where('remind_notif' , 0)->get();

      foreach ($bookings as $booking){
          $diff=  Carbon::now()->diffInMinutes( $booking->times->time->time ) ;
          if($diff < 60){
              // send FCM  To Student And Tutor
              $user_id = $booking['tutor_id'];
              $tokens = Devicetoken::where('user_id', $user_id)->first();
              $title = ' لديك حجز قريبا ';
              $body = 'هناك حجز لديك مع طالب موعده بعد ساعة';
              $data['action_type'] = 'remind';
              $data['action_id'] = $booking->id;
              $data['user_id'] = $user_id;
              $data['date'] = Carbon::now()->timestamp;
              $data['title'] = $title;
              $data['body'] = $body;
              sendFCM($title, $body, $data, $tokens, 1, 1);

              $user_id = $booking['user_id'];
              $tokens = Devicetoken::where('user_id', $user_id)->first();
              $title = ' لديك حجز قريبا ';
              $body = ' هناك حجز لديك  موعده بعد ساعة ';
              $data['action_type'] = 'remind';
              $data['action_id'] = $booking->id;
              $data['user_id'] = $user_id;
              $data['date'] = Carbon::now()->timestamp;
              $data['title'] = $title;
              $data['body'] = $body;
              sendFCM($title, $body, $data, $tokens, 1, 1);

              $booking ->remind_notif = 1 ;
              $booking->save();

              DB::table('cronjob')->insert([
                  'created_at' => Carbon::now()->toDateTimeString() ,
                  'booking_id' => $booking ->id ,
                  'type' => 'remind before hour'
              ]);

          }
      }


    }


    public function backApi(Request $request){

        $j = json_encode($request->all());
        DB::table('testinglogin')->insert([
            'text'=>   $j ,
            'type' => 'll'
        ]);

        $id = $request->id;

        $ch = curl_init();

        if($id == '' ){
            $message = 'هناك خطا في رقم الترانزاكشن ';
            return jsonResponse(false, $message, null, 200);
        }

        curl_setopt($ch, CURLOPT_URL, 'https://api.moyasar.com/v1/payments/'.$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

       // curl_setopt($ch, CURLOPT_USERPWD, 'sk_live_JPn1Hx6CoMTH96kHSc89YKoN8QzMN2meMRne76hN' . ':' . '');
        curl_setopt($ch, CURLOPT_USERPWD, 'sk_test_VwfbpAEPDtmimRoDGcVgK98T5qiLYHrT1ZuihpbL' . ':' . '');


        $result = curl_exec($ch);
        $json = json_decode($result);
        curl_close($ch);



        DB::table('testinglogin')->insert([
            'text'=> $result ,
            'type' => 'payBackMobile'
        ]);
        if(isset($json->status)){
            $is_success = $json->status ;
            $booking_id = $request->booking_id;

            if($is_success   == 'paid') {

                $booking = Booking::where('id', $booking_id)->first();
                if ($booking) {
                    $booking->checkout_id = $json->id;
                    $booking->type_pay = $json->source->company;
                    $booking->status = 1;
                    $booking->save();

                    $user_id = $booking->tutor_id;
                    $tokens = Devicetoken::where('user_id', $user_id)->first();
                    $title = ' حجز جديد ';
                    $body = ' هناك حجز جديد من قبل طالب ' . $booking->student->name;
                    $data['action_type'] = 'newbooking';
                    $data['action_id'] = $booking->id;
                    $data['user_id'] = $user_id;
                    $data['date'] = Carbon::now()->timestamp;
                    $data['title'] = $title;
                    $data['body'] = $body;

                    sendFCM($title, $body, $data, $tokens, 1, 1);


                    $user_id = $booking->user_id;
                    $tokens = Devicetoken::where('user_id', $user_id)->first();
                    $title = ' تم الدفع بنجاح ';
                    $body = ' تم اضافة الحجز بنجاح مع الفهيم ' . $booking->tutor->name;
                    $data['action_type'] = 'newbooking';
                    $data['action_id'] = $booking->id;
                    $data['user_id'] = $user_id;
                    $data['date'] = Carbon::now()->timestamp;
                    $data['title'] = $title;
                    $data['body'] = $body;

                    sendFCM($title, $body, $data, $tokens, 1, 1);

                }


                $message = __('api.success');
                return jsonResponse(true, $message, null, 200);
            }



        }


        $message = 'هناك خطا في تاكيد عملية الدفع';
        return jsonResponse(false, $message, null, 200);


    }

    public function back(Request $request){

        $id = $request->id;

        $ch = curl_init();

        if($id == '' ){
            return ;
        }

        curl_setopt($ch, CURLOPT_URL, 'https://api.moyasar.com/v1/payments/'.$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_USERPWD, 'sk_live_JPn1Hx6CoMTH96kHSc89YKoN8QzMN2meMRne76hN' . ':' . '');

        $result = curl_exec($ch);
        $json = json_decode($result);
        curl_close($ch);
       // dd($json);
        // check if success payment

        DB::table('testinglogin')->insert([
            'text'=> $result ,
            'type' => 'payBack'
        ]);

        $is_success = $json->status ;

       // dd($is_success);
        if($is_success   == 'paid'){
            $booking_id = explode( "#",  $json->description );
            $booking_id = $booking_id [1];





            $booking = Booking::where('id' , $booking_id)->first();
            if($booking){
                $booking->checkout_id = $json->id;
                $booking->type_pay = $json->source->company;
                $booking->status = 1 ;
                $booking->save();

                $user_id = $booking->tutor_id;
                $tokens = Devicetoken::where('user_id', $user_id)->first();
                $title = ' حجز جديد ';
                $body = ' هناك حجز جديد من قبل طالب ' .$booking->student->name;
                $data['action_type'] = 'newbooking';
                $data['action_id'] = $booking->id;
                $data['user_id'] = $user_id;
                $data['date'] = Carbon::now()->timestamp;
                $data['title'] = $title;
                $data['body'] = $body;

                sendFCM($title, $body, $data, $tokens, 1, 1);


                $user_id = $booking->user_id;
                $tokens = Devicetoken::where('user_id', $user_id)->first();
                $title = ' تم الدفع بنجاح ';
                $body = ' تم اضافة الحجز بنجاح مع الفهيم ' .$booking->tutor->name;
                $data['action_type'] = 'newbooking';
                $data['action_id'] = $booking->id;
                $data['user_id'] = $user_id;
                $data['date'] = Carbon::now()->timestamp;
                $data['title'] = $title;
                $data['body'] = $body;

                sendFCM($title, $body, $data, $tokens, 1, 1);

            }

            return redirect('thankyou');
            ///  redirect to success page
        }else{


            return redirect('failer');
            ///  redirect to error page
        }


        return redirect('error');
    }


    public function addpay($id){
        $booking = Booking::where('id' , $id)->first();
        //dd( $booking);
        if($booking && $booking->status == null ){
         //   dd($booking->price->price->price);
            return view('pay' , compact('booking'));
        }
        return redirect('error');
    }

    public function payService(){

            return view('paytest' );

    }

    public function thankyou(){
        return view('thankyou');
    }
    public function failer(){
        return view('failer');
    }

    public function error(){
        return view('error');
    }
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getTimes($id){

       // dd($id);

        $data = TutorTimes::with('time')->where('user_id' , $id)->get();
        return response()->json($data);
    }


    public function payThisBooking(Request  $request){
       $id = $request->id ;

       $booking = Booking::where('id' ,    $id)->first();
       if( $booking){
           $booking->payed= 1 ;
           $booking->save();

           $data['success'] = true ;
           return response()->json($data);
       }
    }
}
