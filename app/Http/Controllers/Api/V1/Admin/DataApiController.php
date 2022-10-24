<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Booking;
use App\Bookingstatus;
use App\Conversation;
use App\Country;
use App\Course;
use App\CourseRequest;
use App\Help;
use App\Level;
use App\Models\Advertice;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Price;
use App\Questions;
use App\Report;
use App\Review;
use App\Setting;
use App\Times;
use App\TutorQuta;
use App\TutorsCourse;
use App\TutorTimes;
use App\Universite;
use App\User;
use App\Vaforite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use \Validator;
use DB;
use App\Devicetoken;
use Route;
use App\Rules\MatchOldPassword;
use App\Models\ReviewsCaptin;
use Carbon\Carbon;
use Lang;
class DataApiController extends Controller
{


    public function  reportCoversation(Request $request){
        $user = Auth::guard('api')->user() ;
        $con_id = $request->coversation_id ;
        if(! $con_id ){
            $con_id = $request->sendbird_channel;
        }
        $text = $request->text ;

        $conv = Conversation::where('sendbird_channel' ,    $con_id)->first();

        if($conv){

            $report =new Report ;
            $report->conversation_id =  $conv->id ;
            $report->sendbird_channel =  $con_id;
            $report->text =  $text ;
            $report->user_id = $user->id;
            $report->tutor_id = $conv->tutor_id ;
            $report->student_id = $conv->user_id ;
            $report->save();
        }


        $message = __('api.success');
        return jsonResponse(true, $message, null, 200);
    }

    public function testuserschat(){

        $users = User::where('role' , 3)->get();
        foreach ($users as $user){
            $ch = curl_init();
            $fields = [
                "userId"=>$user->id.'_teacher'
            ];
            $fields = json_encode($fields ) ;
            curl_setopt($ch, CURLOPT_URL,            "https://apps.applozic.com/rest/ws/user/v2/create" );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt($ch, CURLOPT_POST,           1 );
            curl_setopt($ch, CURLOPT_POSTFIELDS,     $fields );
            curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json' , 'Application-Key: 3b7632a496392dc1eb19f9302fa269', 'Authorization: Basic YWRtaW5ib3Q6YWRtaW5ib3Q='));
            $result=curl_exec ($ch);

           // dd( $result);
            $user->application_chat_id = $user->id.'_teacher';
            $user->save();
        }

        $users = User::where('role' , 2)->get();
        foreach ($users as $user){
            $ch = curl_init();
            $fields = [
                "userId"=>$user->id.'_student'
            ];
            $fields = json_encode($fields ) ;
            curl_setopt($ch, CURLOPT_URL,            "https://apps.applozic.com/rest/ws/user/v2/create" );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt($ch, CURLOPT_POST,           1 );
            curl_setopt($ch, CURLOPT_POSTFIELDS,     $fields );
            curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json' , 'Application-Key: 3b7632a496392dc1eb19f9302fa269', 'Authorization: Basic YWRtaW5ib3Q6YWRtaW5ib3Q='));
            $result=curl_exec ($ch);
            $user->application_chat_id = $user->id.'_teacher';
            $user->save();
        }


    }

    public function testingsms(){
       // dd('hello');
        $message = 'your code activation is 5673';
        $phone = '0501049050' ;

       // $phone = '+966501049050' ;
        sendSMS( $phone ,$message ) ;
    }
    public function getQuestions(Request $request)
    {

        $data = Questions::get();

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }


    public function getTimes(Request $request)
    {

        $data = Times::get();

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function setMyTime(Request $request)
    {
        $user = Auth::guard('api')->user() ;
        if($request->add == 1){
            $time_turor =  TutorTimes::where('user_id' , $user->id)->where('time_id' , $request->time_id)->first();
            if(! $time_turor ){
                $time_turor = new TutorTimes ;
            }
           $time_turor->user_id = $user->id ;
           $time_turor->time_id = $request->time_id ;
           $time_turor->display = 1 ;
            $time_turor->save();
            $message = __('api.success');
            return jsonResponse(true, $message, $time_turor, 200);
        }else{
            // not delete but set like not to display

            TutorTimes::where('user_id' , $user->id)->where('time_id' , $request->time_id)->update([
                'display' => 0
            ]);
        }

        $message = __('api.success');
        return jsonResponse(true, $message,null, 200);
    }

    public function setMyQuta(Request $request)
    {
        $user = Auth::guard('api')->user() ;
        if($request->add == 1){
            $time_turor =  TutorQuta::where('user_id' , $user->id)->where('quta_id' , $request->quta_id)->first();
            if(! $time_turor ){
                $time_turor = new TutorQuta ;
            }
            $time_turor->user_id = $user->id ;
            $time_turor->quta_id = $request->quta_id ;
            $time_turor->display = 1 ;
            $time_turor->save();
            $message = __('api.success');
            return jsonResponse(true, $message, $time_turor, 200);
        }else{

            TutorQuta::where('user_id' , $user->id)->where('quta_id' , $request->quta_id)
                ->update([
                    'display' => 0
                ]);
        }

        $message = __('api.success');
        return jsonResponse(true, $message,null, 200);
    }


    public function updateMyCourses(Request $request)
    {
        $user = Auth::guard('api')->user() ;
        $is_course_exist = TutorsCourse::where('user_id' , $user->id)->delete();
        foreach ($request->courses as $course){

            $tutors_courses = new TutorsCourse();
            $tutors_courses->user_id = $user->id;
            $tutors_courses->course_id =$course['course_id'];
            $tutors_courses->grade = $course['grade'];
            $tutors_courses->save();
            /*
            $is_course_exist = TutorsCourse::where('course_id' ,$course['course_id'])->where('user_id' , $user->id)->first();
            if($is_course_exist){
               // dd($course['grade']);
                $is_course_exist->grade = $course['grade'];
                $is_course_exist->save();
               // dd($course['grade'] ,$is_course_exist );
            }else{
                $tutors_courses = new TutorsCourse();
                $tutors_courses->user_id = $user->id;
                $tutors_courses->course_id =$course['course_id'];
                $tutors_courses->grade = $course['grade'];
                $tutors_courses->save();
            }*/


        }

        $message = __('api.success');
        return jsonResponse(true, $message, null, 200);

    }




    public function getQuta(Request $request)
    {

        $d = Price::where('num_std' ,1)->get();
        $data['one_student']= $d ;
        $d = Price::where('num_std' ,2)->get();
        $data['two_student']= $d ;
        $d = Price::where('num_std' ,3)->get();
        $data['three_student']= $d ;

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }



    public function uploadImage(Request $request)
    {
        if ($request->file) {

                $file = $request->file ;
                $file_name = uploadFile($file, 300, 'images/upload');
                $link =  $file_name;
                $items['file'] = url('/') . '/' . $link;
                $items['path'] = $link;
                $data = (object)$items;

            return jsonResponse(true, __('api.success'), $data, 200);
        }

        $message = __('api.file_has_error');
        return jsonResponse(false, $message, null, 130);
    }


    public function addCourseRequest(Request $request){

        $user = Auth::guard('api')->user() ;
        $data = $request->all();
        if($user){
            $data['user_id']= $user->id ;
        }
        $data = CourseRequest::create($data);

        return jsonResponse(true, __('api.success'), $data, 200);
    }


    public function getConverstionRequests(Request $request){
        $user = Auth::guard('api')->user() ;
        $data = Conversation::with('student' , 'tutor')->where('accept', 1)->where('tutor_id' , $user->id)->orderBy('id' , 'desc')->paginate(20);

        $items = $data->items();
        return jsonResponse(true, __('api.success'), $items, 200,  $data ->currentPage(), $data ->lastPage());
    }


    public function getReviews($id){
       // $user = Auth::guard('api')->user() ;
        $data = Review::with('reviewer','reviewer.country')->where('reviewed_id' ,$id)->orderBy('id' , 'desc')->paginate(20);

        $items = $data->items();
        return jsonResponse(true, __('api.success'), $items, 200,  $data ->currentPage(), $data ->lastPage());
    }


    public function getConverstionRequestsById($id){
        $user = Auth::guard('api')->user() ;
        $data = Conversation::with('student' , 'tutor')->where('id' , $id)->first();

        return jsonResponse(true, __('api.success'), $data, 200);
    }


    public function booking(Request $request){
        $user = Auth::guard('api')->user() ;
        $validator = Validator::make($request->all(), [
            'price_id' => 'required',
            'time_id' => 'required',
            'tutor_id' => 'required',
            'date' => 'required',
           ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        /// we need to get the price
        ///
        $error = false ;
        $TutorQuta = TutorQuta::where('id', $request->price_id )->first();
        if($TutorQuta ){
            $price = $TutorQuta ->price->price ;
            $tutor_earn = $TutorQuta ->price->commission *  $price /100 ;

           // dd($tutor_earn );
        }else{
            return jsonResponse(false, __('api.error'), null , 200);
        }



        $the_time = TutorTimes::where('id' , $request->time_id)->first();
        if(!  $the_time){
            return jsonResponse(false, __('api.error'), null , 200);
        }

        $the_time = $the_time ->time->time ;



       //return $TutorQuta->price ;

        $booking = new Booking;
        $booking->user_id  = $user->id ;
        $booking->tutor_id = $request->tutor_id ;
        $booking->price_id = $request->price_id ;
        $booking->time_id  = $request->time_id ;
        $booking->the_time =  $the_time ;
        $booking->date = $request->date ;
        $booking->total =   $price ;
        $booking->the_price = $price;
        $booking->payed = 0 ;
        $booking->tutor_earn = $tutor_earn ;
        $booking->save();

        // return to user with this information


        // todo  money booking





       $data = Booking::with('price.price' , 'times.time' , 'tutor' )->where('id' , $booking->id)->first();


        return jsonResponse(true, __('api.success'),  $data , 200);
    }




    public function myBookingStudent(){
        $user = Auth::guard('api')->user() ;

        $data = Booking::with('price.price' , 'times.time' , 'tutor.country' )
            ->where('user_id' , $user->id)
            ->whereIn('status' , [1,2,3])
            ->orderBy('id' , 'desc')->paginate(20);



        $items = $data->items();




        return jsonResponse(true, __('api.success'), $items, 200,  $data ->currentPage(), $data ->lastPage());
    }

    public function myBookingStudentEnd(){
        $user = Auth::guard('api')->user() ;

        $data = Booking::with('price.price' , 'times.time' , 'tutor.country'  )
            ->where('user_id' , $user->id)
            ->whereIn('status' , [4 ,5 ,6])
            ->orderBy('id' , 'desc')->paginate(20);

        $items = $data->items();



        return jsonResponse(true, __('api.success'), $items, 200,  $data ->currentPage(), $data ->lastPage());
    }
    public function myBookingTutor2(){
        $user = Auth::guard('api')->user() ;

        $data = Booking::with('price.price' , 'times.time' , 'student.country')
            ->whereIn('status' , [1,2,3])
            ->where('tutor_id' , $user->id)->orderBy('id' , 'desc')->paginate(20);


       $items = $data->all();


        return jsonResponse(true, __('api.success'), $items, 200,  $data ->currentPage(), $data ->lastPage());
    }


    public function myBookingTutor(){
        $user = Auth::guard('api')->user() ;

        $data = Booking::with('price.price' , 'times.time' , 'student.country')
            ->whereIn('status' , [1,2,3])
            ->where('tutor_id' , $user->id)->orderBy('id' , 'desc')->paginate(20);

        $items = $data->items();


        return jsonResponse(true, __('api.success'), $items, 200,  $data ->currentPage(), $data ->lastPage());
    }


    public function myBookingTutorEnd(){
        $user = Auth::guard('api')->user() ;

        $data = Booking::with('price.price' , 'times.time' , 'student.country' )
                ->whereIn('status' , [4 ,5 ,6]     )
                ->where('tutor_id' , $user->id     )
                ->orderBy('id'  , 'desc'  )
                ->paginate(20 ) ;

        $items = $data->items();


        return jsonResponse(true, __('api.success'), $items, 200,  $data ->currentPage(), $data ->lastPage());
    }



    public function cancelBooking(Request $request){
        $user = Auth::guard('api')->user() ;
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $booking = Booking::where('user_id' , $user->id)->where('id' , $request->booking_id)->first();
        if(! $booking){
            return jsonResponse(false, __('api.error'), null , 200);
        }


            $booking->status = 5;
            $booking->note_cancel = $request->note_cancel;
            $booking->save();

            /// todo send notification to student
            ///
            $user_id = $booking->tutor_id;
            $tokens = Devicetoken::where('user_id', $user_id)->first();
            $title = '  تم الغاء الحجز ';
            $body = 'لديك حجز تم الغاءه من قبل الطالب';
            $data['action_type'] = 'cancelbooking';
            $data['action_id'] = $booking->id;
            $data['user_id'] = $user_id;
            $data['date'] = Carbon::now()->timestamp;
            $data['title'] = $title;
            $data['body'] = $body;

            sendFCM($title, $body, $data, $tokens, 1, 1);



        return jsonResponse(true, __('api.success'),  $booking  , 200);
    }



    public function acceptBooking(Request $request){

        $user = Auth::guard('api')->user() ;
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
            'accept' => 'required',
        ]);

        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $booking = Booking::where('tutor_id' , $user->id)->where('id' , $request->booking_id)->first();
        if(! $booking){
            return jsonResponse(false, __('api.error'), null , 200);
        }

        if($request->accept == 1){
            $booking->status = 2;
            $booking->save();

            /// todo send notification to student
            ///
            $user_id = $booking->user_id;
            $tokens = Devicetoken::where('user_id', $user_id)->first();
            $title = ' الموافقة على الحجز ';


            $body = 'تم الموافقة من '.$booking->tutor->name.' بخصوص الحجز ';
            $data['action_type'] = 'acceptbooking';
            $data['action_id'] = $booking->id;
            $data['user_id'] = $user_id;
            $data['date'] = Carbon::now()->timestamp;
            $data['title'] = $title;
            $data['body'] = $body;

            sendFCM($title, $body, $data, $tokens, 1, 1);

        }else{
           // TODO /// return the money to student

            $booking->status = 6;
            $booking->note_cancel = $request->note_cancel ;
            // add note to cancel
            $booking->save();

            /// todo send notification to student
            ///
            $user_id = $booking->user_id;
            $tokens = Devicetoken::where('user_id', $user_id)->first();
            $title = '  حجزك مرفوض ';
            $body = 'تم الرفض من قبل المعلم على حجزك';
            $data['action_type'] = 'rejecttbooking';
            $data['action_id'] = $booking->id;
            $data['user_id'] = $user_id;
            $data['date'] = Carbon::now()->timestamp;
            $data['title'] = $title;
            $data['body'] = $body;

            sendFCM($title, $body, $data, $tokens, 1, 1);

        }



        return jsonResponse(true, __('api.success'),  $booking  , 200);
    }

    public function runningBooking(Request $request){
        $user = Auth::guard('api')->user() ;
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }
        $booking = Booking::where('tutor_id' , $user->id)->where('id' , $request->booking_id)->first();
        if(! $booking){
            return jsonResponse(false, __('api.error'), null , 200);
        }
        $booking->status = 3 ;
        $booking->save();


        /// todo send notification to student
        ///
        $user_id = $booking->user_id;
        $tokens = Devicetoken::where('user_id', $user_id)->first();
        $title = '   بدآ الدرس الان  ';
        $body = 'لديك درس  بدا الان ';
        $data['action_type'] = 'runningbooking';
        $data['action_id'] = $booking->id;
        $data['user_id'] = $user_id;
        $data['date'] = Carbon::now()->timestamp;
        $data['title'] = $title;
        $data['body'] = $body;

        sendFCM($title, $body, $data, $tokens, 1, 1);

        return jsonResponse(true, __('api.success'),  $booking, 200);
    }

    public function completeBooking(Request $request){
        $user = Auth::guard('api')->user() ;
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }
        $booking = Booking::where('tutor_id' , $user->id)->where('id' , $request->booking_id)->first();
        if(! $booking){
            return jsonResponse(false, __('api.error'), null , 200);
        }
        $booking->status = 4 ;
        $booking->review_student = $request->review_student ;
        $booking->note_on_student = $request->note_on_student;
        $booking->is_review_student = 1 ;
        $booking->save();


        /// todo send notification to student
        ///
        $user_id = $booking->user_id;
        $tokens = Devicetoken::where('user_id', $user_id)->first();
        $title = '   تم انتهاء حجزك ';
        $body = 'لديك حجز أصبح مكتمل ';
        $data['action_type'] = 'completetbooking';
        $data['action_id'] = $booking->id;
        $data['user_id'] = $user_id;
        $data['date'] = Carbon::now()->timestamp;
        $data['title'] = $title;
        $data['body'] = $body;

        sendFCM($title, $body, $data, $tokens, 1, 1);

        return jsonResponse(true, __('api.success'),  $booking, 200);
    }


    public function bookingById($id){


        $booking = Booking::with('price.price' , 'times.time' , 'tutor' ,'student' )->where('id' , $id)->first();
        return jsonResponse(true, __('api.success'),  $booking, 200);
    }

    public function reviewTutor(Request $request){
        $user = Auth::guard('api')->user() ;
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
            'review_tutor' => 'required',

        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $booking = Booking::where('id' , $request->booking_id)->where('user_id' , $user->id)->first();
        if(! $booking){
            return jsonResponse(false, __('api.error'), null , 200);
        }

        $review = new Review ;

        $review->type = 1 ;
        $review->review = $request->review_tutor  ;
        $review->note = $request->note_on_tutor ;
        $review->reviewed_id = $booking->tutor_id;
        $review->reviewer_id = $booking->user_id;
        $review->save();

        $booking->review_tutor = $request->review_tutor ;
        $booking->note_on_tutor = $request->note_on_tutor ;
        $booking->is_review_tutor = 1 ;
        $booking->save();


        return jsonResponse(true, __('api.success'),  $booking, 200);
    }


    public function reviewStudent(Request $request){
        $user = Auth::guard('api')->user() ;
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
            'review_student' => 'required',

        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $booking = Booking::where('id' , $request->booking_id)->where('tutor_id' , $user->id)->first();
        if(! $booking){
            return jsonResponse(false, __('api.error'), null , 200);
        }

        // add in other table the review
        $booking->review_student = $request->review_student ;
        $booking->note_on_student = $request->note_on_student ;
        $booking->is_review_student = 1 ;
        $booking->save();


        $review = new Review ;

        $review->type = 2 ;
        $review->review = $request->review_student  ;
        $review->note = $request->note_on_student ;
        $review->reviewed_id = $booking->user_id;
        $review->reviewer_id = $booking->tutor_id ;
        $review->save();


        return jsonResponse(true, __('api.success'),  $booking, 200);
    }


    public function BookingStatuses(){


        $bookings = Bookingstatus::all();
        return jsonResponse(true, __('api.success'),  $bookings, 200);
    }


    public function help(Request $request){

        $feedback = Help::all();
        $message = __('api.success');
        return jsonResponse(true, $message, $feedback, 200);

    }

    public function getSettings(){
        $lang = Lang::getLocale();

        $settings = Setting::where('id' , 1)->first();

        if($lang == 'ar' || $lang == 'arabic'){
            $data['about_us'] =   $settings->aboutus_ar ;
            $data['terms'] =   $settings->terms_ar ;
            $data['text_policy'] =   $settings->tex_policy_ar ;
        }else{
            $data['terms'] =   $settings->terms_en ;
            $data['text_policy'] =   $settings->text_policy ;
            $data['about_us'] =   $settings->aboutus_en;
        }

        $array = array();
        $m = array();
        if($settings->facebook != ''){
            $array['link']= $settings->facebook ;
            $array['name']= 'facebook' ;
            $array['icon']=  url('/').'/images/facebook.png';
            $m[] = $array ;
        }

        if($settings->linkedin != ''){
            $array['link']= $settings->linkedin ;
            $array['name']= 'linkedin' ;
            $array['icon']=  url('/').'/images/linkedin.png';
             $m[]= $array ;
        }

        if($settings->phone != ''){
            $array['link']= $settings->phone ;
            $array['name']= 'phone' ;
            $array['icon']=  url('/').'/images/phone.png';
            $m[]= $array ;
        }
        if($settings->mail != ''){
            $array['link']= $settings->mail ;
            $array['name']= 'mail' ;
            $array['icon']=  url('/').'/images/gmail.png';
            $m[]= $array ;
        }
        if($settings->whatsapp != ''){
            $array['link']= $settings->whatsapp ;
            $array['name']= 'whatsapp' ;
            $array['icon']=  url('/').'/images/whatsapp.png';
            $m[]= $array ;
        }
        $data['contact_us'] =$m;
        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);

    }
}
