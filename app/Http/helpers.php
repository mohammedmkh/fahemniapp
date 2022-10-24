<?php


 // hello new world
use App\User;
use Illuminate\Support\Facades\Cache;

function getFullUser($id){
    $user = User::find($id);

    if($user->role == 3){
        $user = User::with('country','city' , 'level' , 'university' ,'TutorsCourses.course' ,'times.time','quta.price')->where('id' ,$id)->first();
        return $user ;
    }
    $user = User::with('country' ,'city', 'level' , 'university')->where('id' ,$id)->first();
    return $user ;
}


function  alertSuccessUpdate($message = null , $title = null){


    if(session()->get('language') == 'en'){
        $message = ' The Editing Item Success Updating ' ;
        $title = 'Success Update ' ;
        toastr()->success( $message ,  $title , ['timeOut' => 445000]);
    }else{
        $message = ' تمت عملية التعديل بنجاح ' ;
        $title = ' نجاح الاجراء ' ;
        toastr()->success( $message ,  $title , ['timeOut' => 445000]);
    }


}



function  alertSuccessAdd($message = null , $title = null){

     $note = '' ;

    if(session()->get('language') == 'en'){
        $message = ' The Add Item Success created ' ;
        $title = 'Success Add ' ;
        toastr()->success( $message,  $title , ['timeOut' => 5000]);
    }else{
        $message = ' تمت عملية الاضافة بنجاح ' ;
        $title = ' نجاح الاجراء ' ;
        toastr()->success( $message ,    $title , ['timeOut' => 5000]);
    }


}

function adminPath(){
    return 'panel/';
}

function getFirstMessageError($validator){
    if ($validator && $validator->fails()) {

        $messages = $validator->errors()->toArray();
        foreach ($messages as $key => $row) {
            $errors['field'] = $key;
            return $row[0] .' '. $key;

        }
    }
}



function sendSMSOld( $phone, $message ){


    $pin_country = '+966' ;
    $phone = $pin_country . substr($phone, 1);


    $username = 'awesfaheem';
    $password = 'Fah$$m@123';
    $yourMobile=$phone;
    $messages = array(
        array('to'=>$yourMobile, 'body'=>$message),
    );

    $result = send_message( json_encode($messages), 'https://api.bulksms.com/v1/messages', $username, $password );

    // dd( $result);
    return ;



}


function sendSMS( $phone, $message ){


    $curl = curl_init();
    $phone =substr($phone, 1);
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://msegat.com/gw/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"userName\"\r\n\r\nfahemniapp\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"apiKey\"\r\n\r\n4752fc70143ce170e7cf8a2aa2c9e46f\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"numbers\"\r\n\r\n966".$phone."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"userSender\"\r\n\r\nOTP\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"msg\"\r\n\r\n".$message." \r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"By\"\r\n\r\nLink\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
            "postman-token: 79d2304a-e79c-9dcb-7714-882b4fcdfcfa"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    // dd($response , $message );
    curl_close($curl);




}


function send_message ( $post_body, $url, $username, $password) {
    $ch = curl_init( );
    $headers = array(
        'Content-Type:application/json',
        'Authorization:Basic '. base64_encode("$username:$password")
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_body );
    // Allow cUrl functions 20 seconds to execute
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 20 );
    // Wait 10 seconds while trying to connect
    curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
    $output = array();
    $output['server_response'] = curl_exec( $ch );
    $curl_info = curl_getinfo( $ch );
    $output['http_status'] = $curl_info[ 'http_code' ];
    $output['error'] = curl_error($ch);
    curl_close( $ch );
    return $output;
}



function sendFCM($title, $body, $data, $tokens, $badge)
{


    $notif = new  \App\Notification ;
    $notif->user_id =  $data['user_id'];
    $notif->action_type =$data['action_type']  ;
    $notif->action_id  = $data['action_id'] ;
    $notif-> title = $data['title'] ;
    $notif-> body = $data['body']  ;
    $notif-> is_read = 0 ;
    $date = Carbon\Carbon::now()->toDateTimeString();
    if($date){
        $notif-> date = $date;
        $notif->save();
    }
    $notif->save();


    if(isset($tokens) && $tokens != null){
        if( !$tokens->device_token | $tokens->is_notify == 0){
            return ;
        }
        $token[] =  $tokens->device_token ;
        $device = $tokens->device_type ;

    }else{
        return ;
    }


     //dd($tokens);


    $user = User::where('id' , $notif->user_id)->first() ;
    if($user){

        $count_unread = \App\Notification::where('user_id' , $data['user_id'] )->where('is_read' , 0 )->count();


        $newData['action_type'] = $data['action_type'] ;
        $newData['action_id'] = $data['action_id'] ;
        $newData['date'] = $data['date'] ;

        $msg = [
            'action_id' => $data['action_id'],
            'action_type' =>$data['action_type'],
            'date' => $data['date'] ,
            'title' => $title,
            'body' => $body,
            'icon' => 'myicon',
            'sound' => 'mySound',
            'badge' => 1
        ];

        if ($device == 'ios' | $device == 'IOS'  ) {

            $fields = [
                'registration_ids' => $token,
                'notification' => $msg
            ];

        } else {
            $fields = [
                'registration_ids' => $token,
                'data' => $msg,
            ];
        }

        // dd( json_encode($fields));
        $headers = [
            'Authorization:key=' . 'AAAAl2PmUUQ:APA91bGx-JTi90lYcYNDU25MSRBxwPxrnH1Vk_NwBpfk6i0l2Q31eULv7IOTpKYtof5BUeacCvVidb9kQVx3UXDsZmCKovMCX7ozuhAxBB3vY4t771N7oa_fvt0AlZOrRxRREMgDph8w',
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        // dd($result , $fields);
        return $result;
    }

}


function removeFile($path)
{

    if(file_exists($path)){
        unlink($path);
    };

}




function uploadDocument($file)
{


    $dest = public_path('documentfiles/');


    $name = time() . Str::random(4). '.' . $file->getClientOriginalExtension();
    $destinationPath = $dest ;
    $file->move($destinationPath, $name);

    return $name;
}


function uploadFile($file, $width=500, $dest=null)
{


    $name = time() . Str::random(4). '.' . $file->getClientOriginalExtension();
    $name = $name ;
    if($dest == null) {
        $dest = 'images/upload';
    };
    $final = $dest.'/'.$name;
    $file->move( $dest, $name);

    return   $final;
}



function jsonResponse($status, $message, $data=null, $code=null, $page= null , $page_count=null ,$validator=null)
{

    try {
        $validator=null;

        $result['status'] = $status;
        $result['message'] = $message;


        if($data === []){
            $result['items'] = [];
        }elseif($data != null ){
            $result['items'] = $data ;
        }

        if($code){
            $result['code'] = $code;
        }
        if($page){
            $result['page'] = $page;
        }
        if($page_count){
            $result['page_count'] = $page_count;
        }



        if ($validator && $validator->fails()) {

            $messages = $validator->errors()->toArray();
            foreach ($messages as $key => $row) {
                $errors['field'] = $key;
                $errors['message'] = $row[0];
                $arr[] = $errors;
            }

            $result['items'] =$arr;

        }
        // dd('m');
        // return response()->json($result, 200, [], JSON_NUMERIC_CHECK);

        return response()->json($result);
    } catch (Exception $ex) {
        return response()->json([
            'line' => $ex->getLine(),
            'message' => $ex->getMessage(),
            'getFile' => $ex->getFile(),
            'getTrace' => $ex->getTrace(),
            'getTraceAsString' => $ex->getTraceAsString(),
        ], $code);
    }
}



function admin_assets($dir)
{
    return url('/admin_assets/assets/' . $dir);
}

function getLocal()
{
    return app()->getLocale();
}



function convertAr2En($string)
{
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    $num = range(0, 9);
    $convertedPersianNums = str_replace($persian, $num, $string);
    $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);
    return $englishNumbersOnly;
}

function payment( $email, $amount, $order_id)
{
    $url = 'https://maktapp.credit/v3/AddTransaction';
    $data =  array('token'=> '5F127A9C-23A2-4787-90BA-427014D735A8',
        'amount'  => $amount ,
        'currencyCode' => 'QAR' ,
        'orderId' => $order_id,
        'note' => ' test payment' ,
        'lang' => 'ar' ,
        'customerEmail' => $email   ,
        'customerCountry' => 'qatar'
    );
    $options = array();
    $defaults = array(
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_URL => $url,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_TIMEOUT => 4,
        CURLOPT_POSTFIELDS => http_build_query($data)
    );
    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if( ! $result = curl_exec($ch))
    {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

function validatePayment($order_id)
{
    $url = 'https://maktapp.credit/v3/ValidatePayment';
    $data =  array('token'=> '5F127A9C-23A2-4787-90BA-427014D735A8',
        'orderId' => $order_id
    );
    $options = array();
    $defaults = array(
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_URL => $url,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_TIMEOUT => 4,
        CURLOPT_POSTFIELDS => http_build_query($data)
    );
    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if( ! $result = curl_exec($ch))
    {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

function random_number($digits)
{
    return str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
}

function type()
{
    return [__('common.store'),__('common.product'),__('common.url')];
}

function position()
{
    return [__('common.site'),__('common.mobile')];
}

function typeArrive()
{


    return[
        '1'=>__('print.delivery'),
        '2'=>__('print.pickup'),
        '3'=>__('print.both')
    ];

}

function optionArrive()
{
    return[

        '1'=>__('print.have_delivery_team'),
        '2'=>__('print.link_delivery_company'),
        '3'=>__('print.both')
    ];

}

function sendNotificationToUsers( $tokens_android, $tokens_ios, $order_id, $message )
{
    try {
        $headers = [
            'Authorization: key=AAAAmx9XTuw:APA91bEhmJOmE4HRvBcuIDZNC40HYD4NNZL5oGM0KkwcLb_wGCPhyiIgZsTiaBPDQZtID2adZU29uy_vUMLXFW8wXBqDAHb1xvoGHuJ1_GbtdJSdaAdVLrslAYOFiYbhyVeJURZmBUrK',
            'Content-Type: application/json'
        ];

        if(!empty($tokens_ios)) {
            $dataForIOS = [
                "registration_ids" => $tokens_ios,
                "notification" => [
                    'body' => $message,
                    'type' => "notify",
                    'title' => 'Karm',
                    'order_id' => $order_id,
                    'badge' => 1,
                    'typeMsg' => 2,//order
                    'icon' => 'myicon',//Default Icon
                    'sound' => 'mySound'//Default sound
                ]
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataForIOS));
            $result = curl_exec($ch);
            curl_close($ch);
            // $resultOfPushToIOS = "Done";
            //   return $result; // to check does the notification sent or not
        }
        if(!empty($tokens_android)) {
            $dataForAndroid = [
                "registration_ids" => $tokens_android,
                "data" => [
                    'body' => $message,
                    'type' => "notify",
                    'title' => 'Karm',
                    'order_id' => $order_id,
                    'badge' => 1,
                    'typeMsg' => 2,//order
                    'icon' => 'myicon',//Default Icon
                    'sound' => 'mySound'//Default sound
                ]
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataForAndroid));
            $result = curl_exec($ch);
            curl_close($ch);
            //    $resultOfPushToAndroid = "Done";
        }
        //   return $resultOfPushToIOS." ".$resultOfPushToAndroid;
        //    return $result;
    } catch (\Exception $ex) {
        return $ex->getMessage();
    }





}

function sendNotificationToUsersChat( $tokens_android, $tokens_ios, $order_id, $message )
{
    try {
        $headers = [
            'Authorization: key=AAAAmx9XTuw:APA91bEhmJOmE4HRvBcuIDZNC40HYD4NNZL5oGM0KkwcLb_wGCPhyiIgZsTiaBPDQZtID2adZU29uy_vUMLXFW8wXBqDAHb1xvoGHuJ1_GbtdJSdaAdVLrslAYOFiYbhyVeJURZmBUrK',
            'Content-Type: application/json'
        ];

        if(!empty($tokens_ios)) {
            $dataForIOS = [
                "registration_ids" => $tokens_ios,
                "notification" => [
                    'body' => $message,
                    'type' => "notify",
                    'title' => 'Karm',
                    'order_id' => $order_id,
                    'badge' => 1,
                    'typeMsg' => 1,//chat
                    'icon' => 'myicon',//Default Icon
                    'sound' => 'mySound'//Default sound
                ]
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataForIOS));
            $result = curl_exec($ch);
            curl_close($ch);
            // $resultOfPushToIOS = "Done";
            //   return $result; // to check does the notification sent or not
        }
        if(!empty($tokens_android)) {
            $dataForAndroid = [
                "registration_ids" => $tokens_android,
                "data" => [
                    'body' => $message,
                    'type' => "notify",
                    'title' => 'Karm',
                    'order_id' => $order_id,
                    'badge' => 1,
                    'typeMsg' => 1,//chat
                    'icon' => 'myicon',//Default Icon
                    'sound' => 'mySound'//Default sound
                ]
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataForAndroid));
            $result = curl_exec($ch);
            curl_close($ch);
            //    $resultOfPushToAndroid = "Done";
        }
        //   return $resultOfPushToIOS." ".$resultOfPushToAndroid;
        //    return $result;
    } catch (\Exception $ex) {
        return $ex->getMessage();
    }





}

function slugURL($title){
    $WrongChar = array('@', '؟', '.', '!','?','&','%','$','#','{','}','(',')','"',':','>','<','/','|','{','^');

    $titleNoChr = str_replace($WrongChar, '', $title);
    $titleSEO = str_replace(' ', '-', $titleNoChr);
    return $titleSEO;
}


function print_number_count($number) {
    $units = array( '', 'K', 'M', 'B');
    $power = $number > 0 ? floor(log($number, 1000)) : 0;
    if($power > 0)
        return @number_format($number / pow(1000, $power), 2, ',', ' ').' '.$units[$power];
    else
        return @number_format($number / pow(1000, $power), 0, '', '');
}


