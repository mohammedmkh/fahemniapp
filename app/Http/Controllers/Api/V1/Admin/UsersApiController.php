<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\AccountFavorite;
use App\City;
use App\Conversation;
use App\Country;
use App\Course;
use App\Http\Resources\ProviderResource;
use App\Level;
use App\Models\Advertice;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Notification;
use App\Price;
use App\Times;
use App\TutorQuta;
use App\TutorsCourse;
use App\TutorTimes;
use App\Universite;
use App\User;
use App\Userhealthy;
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
//use App\Rules\MatchOldPassword;
class UsersApiController extends Controller
{
    public function registerStudent(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits:10',
            'email' => 'unique:users',
            'name' => 'required',
            'level_id' => 'required',
            'country_id' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => ['same:password'],]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $data = $request->all();
        $user = User::where('phone', $request->phone)->first();

        // check Oauth Credentials
        $cred = DB::table('oauth_clients')->where('name', $request->client_id)
            ->where('secret', $request->client_secret)->first();
        if (!$cred) {
            $message_error = __('api.cred_not_found');
            return jsonResponse(false, $message_error, null, 100);
        }


        if ($user && $user->verify == 1) {
            $message_error = __('api.user_exist_before');
            return jsonResponse(false, $message_error, null, 104);
        }




        $data['password'] = bcrypt($request->password);
        $data['role'] = 2;
        if($user){
            $user->update($data);
        }else{
            $user = User::create($data);
        }

        $user->roles()->sync(2);

        if($request->has('answers') &&  count($request->answers) > 0){
            foreach ($request->answers as $answer){

                $user_healthy =new Userhealthy;
                $user_healthy->user_id = $user->id;
                $user_healthy->question_id = $answer['question_id'];
                $user_healthy->answer = $answer['answer'];
                $user_healthy->save();
                //dd( $naswer);
            }
        }



        $user->save();
        //  $user = User::with('role')->find( $user->id);
        $user->sms_code = $this->getSmsCode();
        $user->save();
        $message = 'Code : ' . $user->sms_code . ' Is For Verification Student';
        $message = 'Pin Code is: ' . $user->sms_code ;
        sendSMS($user->phone, $message);

        $message = __('api.success');
        return jsonResponse(true, $message, $user, 200);


    }

    private function getSmsCode()
    {

        $digits = 4;
        $random = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        return $random;

    }

    public function setNotify(Request $request){

        $user = Auth::guard('api')->user();

        $user->is_notify = $request->is_notify ;
        $user->save();

        Devicetoken::where('user_id', $user->id)->update([
            'is_notify'=> $request->is_notify
        ]);


        $message = __('api.success');
        return jsonResponse(true, $message,    null  , 200);
    }
    public function updatePassword(Request $request)
    {
        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required','min:6'],
            'new_confirm_password' => ['same:new_password'],]);

        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }
        $changePassword = User::find($user->id)->update(['password' => bcrypt($request->new_password)]);

        $message = __('api.success');
        return jsonResponse(true, $message, $changePassword, 200);

    }

    public function validationCode(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'required|numeric',
            'phone' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $user = User::where('phone', $request->phone)->first();

        // check Oauth Credentials
        $cred = DB::table('oauth_clients')->where('name', $request->client_id)
            ->where('secret', $request->client_secret)->first();
        if (!$cred) {
            $message_error = __('api.cred_not_found');
            return jsonResponse(false, $message_error, null, 100);
        }


        if (!$user) {
            $message_error = __('api.user_not_found');
            return jsonResponse(false, $message_error, null, 101);
        }


        if ($request->code == '1122') {

            $user = User::where('phone', $request->phone)->first();

        } else {

            $user = User::where('phone', $request->phone)
                ->where('sms_code', $request->code)
                ->first();
        }

        if (!$user) {
            $message = __('api.wrong_verify_code');
            return jsonResponse(false, $message, null, 106);
        }

        $user->verify = 1;
        $user->save();


        if($user->role == 3){
            $message = __('api.success_under_review');
        }else{
            $message = __('api.success');
        }

        return jsonResponse(true, $message, null, 200);


    }

    public function registerTeacher(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits:10',
            'name' => 'required',
            'level_id' => 'required',
            'country_id' => 'required',
            'bio' => 'required',
            'cv' => 'required',
            'university_id' => 'required',
            'tutors_courses' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => ['same:password'],]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $data = $request->all();
        $user = User::where('phone', $request->phone)->first();

        // check Oauth Credentials
        $cred = DB::table('oauth_clients')->where('name', $request->client_id)
            ->where('secret', $request->client_secret)->first();
        if (!$cred) {
            $message_error = __('api.cred_not_found');
            return jsonResponse(false, $message_error, null, 100);
        }


        if ($user && $user->verify == 1 ) {
            if($user->role == 3){
                $message_error = __('api.user_exist_before');
                return jsonResponse(false, $message_error, null, 104);
            }
        }

        $data['sms_code'] = $this->getSmsCode();
        $data['password'] = bcrypt($request->password);
        $data['role']= 3 ;
        if($user){
            $user->update($data);
        }else{
            $user = User::create($data);
        }

        $user->roles()->sync(3);






        foreach ($data['tutors_courses'] as $value) {

            $tutors_courses = new TutorsCourse();
            $tutors_courses->user_id = $user->id;
            $tutors_courses->course_id = $value['course_id'];
            $tutors_courses->grade = $value['grade'];
            $tutors_courses->save();
        }


        /// create one Object of times quta and price
        $quta =new TutorQuta;
        $quta->user_id = $user->id ;
        $quta->quta_id = Price::take(1)->first()->id;
        $quta->save();

        $time  =new TutorTimes;
        $time->user_id = $user->id ;
        $time->time_id = Times::take(1)->first()->id;
        $time->save();

        $user->sms_code = $this->getSmsCode();
        $user->save();
        $message = 'Code : ' . $user->sms_code . ' Is For Verification';
        $message = 'Pin Code is: ' . $user->sms_code ;
        sendSMS($user->phone, $message);

        $message = __('api.success');
        return jsonResponse(true, $message, null, 200);


    }

    public function getCountries(Request $request)
    {

        $data = Country::get();

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }
    public function getCities(Request $request , $id)
    {

        $data = City::where('country_id' , $id)->get();

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }


    public function getUniversity(Request $request)
    {

        $data = Universite::get();

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function getLevels(Request $request)
    {

        $data = Level::get();

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }




    public function getCoursesWithCode(Request $request)
    {

        $data = Course::where('parent' , '<>' , 0)->get();
        $message = __('api.success');

        return jsonResponse(true, $message, $data, 200);
    }

    public function getCourses(Request $request)
    {

        $data = Course::where('parent' , 0)->get();
        $message = __('api.success');

        return jsonResponse(true, $message, $data, 200);
    }

    public function getCoursesGrades(Request $request)
    {

        $user = Auth::guard('api')->user();

        $data = TutorsCourse::where('user_id', $user->id)->get();

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|min:6',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }

        //
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            if ($user->verify != 1) {
                // send sms activation
             //   $message = 'Code : ' . $user->sms_code . ' Is For Verification';
                $message = 'Pin Code is: ' . $user->sms_code ;
                sendSMS($user->phone, $message);
                return jsonResponse(false, __('api.wrong_verify_code'), null, 106, null, null, $validator);
            }




             DB::table('testinglogin')->insert([
                 'text'=> json_encode( $request->all()) ,
                 'type' => 'login'
             ]);

            if( $request->device_token != ''){
                Devicetoken::where('device_token', $request->device_token)->delete();

                $device = Devicetoken::where('user_id', $user->id)->first();
                if ($device) {
                    Devicetoken::where('user_id', $user->id)->where('id', '<>', $device->id)->delete();
                } else {
                    $device = new  Devicetoken;
                }
                $device->device_type = $request->device_type;
                $device->device_token = $request->device_token;
                $device->user_id = $user->id;
                $device->save();
            }


            $tokenRequest = $request->create('/oauth/token', 'POST', $request->all());
            $request->request->add([
                'grant_type' => $request->grant_type,
                'client_id' => $request->client_id,
                'client_secret' => $request->client_secret,
                'username' => $request->phone,
                'password' => $request->password,
                'scope' => null,
            ]);
            //dd($tokenRequest);
            $response = Route::dispatch($tokenRequest);
            $json = (array)json_decode($response->getContent());

            if (isset($json['error'])) {
                $message = __('api.wrong_login');
                return jsonResponse(false, $message, null, 109);
            }

            $user = User::where('id' , $user->id)->first();
            /*
            if($user->application_chat_id == null){

                $ch = curl_init();

                if($user->role == 3){
                    $string=$user->id.'_teacher';
                    $fields = [
                        "userId"=>  $string
                    ];
                }else{
                    $string=$user->id.'_student';
                    $fields = [
                        "userId"=>  $string
                    ];
                }


                $fields = json_encode($fields ) ;
                curl_setopt($ch, CURLOPT_URL,            "https://apps.applozic.com/rest/ws/user/v2/create" );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
                curl_setopt($ch, CURLOPT_POST,           1 );
                curl_setopt($ch, CURLOPT_POSTFIELDS,     $fields );
                curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json' , 'Application-Key: 3b7632a496392dc1eb19f9302fa269', 'Authorization: Basic YWRtaW5ib3Q6YWRtaW5ib3Q='));
                $result=curl_exec ($ch);
                $user->application_chat_id = $string;
                $user->save();

            }

            */


            $user = getFullUser($user->id);
            $json['user'] = $user;

            $header = $request->header('Accept-Language');


            $message = __('api.success');
            return jsonResponse(true, $message, $json, 200);
        }


        return jsonResponse(false, __('api.wrong_login'), null, 115);


    }

    public function myInfo(Request $request)
    {

        $user = Auth::guard('api')->user();
        $user = getFullUser($user->id);

        $message = __('api.success');
        return jsonResponse(true, $message, $user, 200);

    }

    public function checkPhoneResetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits:10',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }

        $user = User::where('phone', $request->phone)->first();
        // check Oauth Credentials
        $cred = DB::table('oauth_clients')->where('name', $request->client_id)
            ->where('secret', $request->client_secret)->first();

        if (!$cred) {
            $message_error = __('api.cred_not_found');
            return jsonResponse(false, $message_error, null, 100);
        }


        if (!$user) {
            $message_error = __('api.user_not_exist');
            return jsonResponse(false, $message_error, null, 104);
        }

        $user->sms_code = $this->getSmsCode();
        $user->save();

        $message = 'Pin Code is: ' . $user->sms_code ;
        sendSMS($user->phone, $message);

        $message = __('api.success');
        return jsonResponse(true, $message, null, 200);


    }

    public function validationCodeResetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'required|numeric',
            'phone' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $user = User::where('phone', $request->phone)->first();

        // check Oauth Credentials
        $cred = DB::table('oauth_clients')->where('name', $request->client_id)
            ->where('secret', $request->client_secret)->first();
        if (!$cred) {
            $message_error = __('api.cred_not_found');
            return jsonResponse(false, $message_error, null, 100);
        }


        if (!$user) {
            $message_error = __('api.user_not_found');
            return jsonResponse(false, $message_error, null, 101);
        }


        if ($request->code == '1122') {

            $user = User::where('phone', $request->phone)->first();

        } else {

            $user = User::where('phone', $request->phone)
                ->where('sms_code', $request->code)
                ->first();
        }

        if (!$user) {
            $message = __('api.wrong_verify_code');
            return jsonResponse(false, $message, null, 106);
        }

        $user->is_reset = 1;
        $user->save();




        return jsonResponse(true, $message, null, 200);


    }

    public function resetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],]);

        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }

        // check Oauth Credentials
        $cred = DB::table('oauth_clients')->where('name', $request->client_id)
            ->where('secret', $request->client_secret)->first();
        if (!$cred) {
            $message_error = __('api.cred_not_found');
            return jsonResponse(false, $message_error, null, 100);
        }
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            if ($user->is_reset != 1) {
                return jsonResponse(false, __('api.wrong_verify_code'), null, 106, null, null, $validator);
            }

            $resetPassword = $user->update(['password' => bcrypt($request->new_password), 'is_reset' => 0]);

            $message = __('api.success');
            return jsonResponse(true, $message, null, 200);
        }


        return jsonResponse(false, __('api.wrong_resetPassword'), null, 115);


    }

    public function teachers(Request $request)
    {
        // dd( $request->all());

       $id =  Auth::guard('api')->user()->id;
       if($id > 0){
           if($request->course_id > 0){
               $course_id = $request->course_id;
               $courses = Course::where('parent' , $course_id)->pluck('id')->toArray();
               $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')->wherehas('roles', function ($q) {
                   $q->where('id', 3);
               })->wherehas('TutorsCourses', function ($query)use ($courses) {
                   $query->whereIn('course_id', $courses);
               })
                   ->where('verify' ,1)
                   ->where('status',1)
                   ->where('id' , '<>' , $id)
                   ->paginate(10);
           }else{
               $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')->wherehas('roles', function ($q) {
                   $q->where('id', 3);
               })
                   ->where('verify' ,1)
                   ->where('status',1)
                   ->where('id' , '<>' , $id)
                   ->paginate(10);

           }
       }else{
           if($request->course_id > 0){
               $course_id = $request->course_id;
               $courses = Course::where('parent' , $course_id)->pluck('id')->toArray();
               $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')->wherehas('roles', function ($q) {
                   $q->where('id', 3);
               })->wherehas('TutorsCourses', function ($query)use ($courses) {
                   $query->whereIn('course_id', $courses);
               })->where('verify' ,1)->where('status',1)->paginate(10);
           }else{
               $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')->wherehas('roles', function ($q) {
                   $q->where('id', 3);
               })->where('verify' ,1)->where('status',1)->paginate(10);

           }
       }



        $message = __('api.success');
        return jsonResponse(true, __('api.success'), $data->items(), 200, $data->currentPage(), $data->lastPage());

    }

    public function bestTeachers(Request $request)
    {
        $course_id = $request->course_id ;

        $id =  Auth::guard('api')->user()->id;
        if(  $id  > 0 ){
            // return $course_id ;
            if($course_id > 0){
                $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')->wherehas('roles', function ($q) {
                    $q->where('id', 3);

                })->wherehas('reviewed', function ($q) {
                    $q->havingRaw('avg(review) > ?', [3.5]);
                })->wherehas('TutorsCourses', function ($query)use ($course_id) {
                    $query->where('course_id', $course_id);
                })->where('verify' ,1)
                    ->where('id' , '<>' , $id)
                    ->where('status',1)->get();
            }else{
                $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')->wherehas('roles', function ($q) {
                    $q->where('id', 3);

                })->wherehas('reviewed', function ($q) {
                    $q->havingRaw('avg(review) > ?', [3.5]);
                })->where('verify' ,1)
                    ->where('id' , '<>' , $id)
                    ->where('status',1)->get();
            }

        }else{

            // return $course_id ;
            if($course_id > 0){
                $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')->wherehas('roles', function ($q) {
                    $q->where('id', 3);

                })->wherehas('reviewed', function ($q) {
                    $q->havingRaw('avg(review) > ?', [3.5]);
                })->wherehas('TutorsCourses', function ($query)use ($course_id) {
                    $query->where('course_id', $course_id);
                })->where('verify' ,1)->where('status',1)->get();
            }else{
                $data = User::with('country','city' , 'level' , 'university' ,'TutorsCourses.course')->wherehas('roles', function ($q) {
                    $q->where('id', 3);

                })->wherehas('reviewed', function ($q) {
                    $q->havingRaw('avg(review) > ?', [3.5]);
                })->where('verify' ,1)->where('status',1)->get();
            }

        }




        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function getTeachers(Request $request)
    {
        $user =  Auth::guard('api')->user();

        if( isset(  $user) && $user ->id  > 0 ){
          $id =   $user ->id;
            if($request->course_id > 0){

                $course_id = $request->course_id;
                $courses = Course::where('parent' , $course_id)->pluck('id')->toArray();
                $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')
                    ->wherehas('TutorsCourses', function ($query)use ($courses) {
                        $query->whereIn('course_id', $courses);
                    }) ->where('role',3)
                    ->where('verify' ,1)
                    ->where('id' , '<>' , $id)
                    ->where('status',1)->paginate(10);

            }else{
                $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')->where('role',3)
                    ->where('verify' ,1)
                    ->where('status',1)
                    ->where('id' , '<>' , $id)
                    ->paginate(10);

            }
        }else{
            if($request->course_id > 0){

                $course_id = $request->course_id;
                $courses = Course::where('parent' , $course_id)->pluck('id')->toArray();
                $data = User::with('country','city' , 'level' , 'university' ,'TutorsCourses.course')
                    ->wherehas('TutorsCourses', function ($query)use ($courses) {
                        $query->whereIn('course_id', $courses);
                    }) ->where('role',3)->where('verify' ,1)->where('status',1)->paginate(10);

            }else{
                $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')->where('role',3)
                    ->where('verify' ,1)->where('status',1)->paginate(10);

            }
        }


        $message = __('api.success');
        return jsonResponse(true, __('api.success'), $data->items(), 200, $data->currentPage(), $data->lastPage());

    }

    public function getBestTeachers(Request $request)
    {
        $course_id = $request->course_id ;


        $id = 0 ;
        try {
            $id =  Auth::guard('api')->user();
            if( $id){
                $id =  $id->id ;
            }
        } catch (Throwable $e) {

        }
        if( $id  > 0 ){
            if($course_id > 0){

                $courses = Course::where('parent' , $course_id)->pluck('id')->toArray();
                $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')->wherehas('reviewed', function ($q) {
                    $q->havingRaw('avg(review) > ?', [3.5]);
                })->wherehas('TutorsCourses', function ($query)use ($courses) {
                    $query->whereIn('course_id', $courses );
                })->where('role',3)
                    ->where('verify' ,1)
                    ->where('id' , '<>' , $id)
                    ->where('status',1)->get();
            }else{
                $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')->wherehas('reviewed', function ($q) {
                    $q->havingRaw('avg(review) > ?', [3.5]);
                })->where('role',3)
                    ->where('id' , '<>' , $id)
                    ->where('verify' ,1)->where('status',1)->get();
            }
        }else{
            if($course_id > 0){

                $courses = Course::where('parent' , $course_id)->pluck('id')->toArray();
                $data = User::with('country' , 'level' , 'university' ,'TutorsCourses.course')->wherehas('reviewed', function ($q) {
                    $q->havingRaw('avg(review) > ?', [3.5]);
                })->wherehas('TutorsCourses', function ($query)use ($courses) {
                    $query->whereIn('course_id', $courses );
                })->where('role',3)->where('verify' ,1)->where('status',1)->get();
            }else{
                $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')->wherehas('reviewed', function ($q) {
                    $q->havingRaw('avg(review) > ?', [3.5]);
                })->where('role',3)->where('verify' ,1)->where('status',1)->get();
            }
        }




        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function searchTeacherName(Request $request)
    {
        $user =  Auth::guard('api')->user();
        if(isset($user)){
            $id = $user->id ;
        }else{
            $id =  0 ;
        }
        if( $id  > 0 ){
            $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')
                ->where('role',3)
                ->where('status',1)
                ->where('id' , '<>' , $id)
                ->where('name', 'like', '%' . $request->key . '%')
                ->get();
        }else{
            $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')
                ->where('role',3)
                ->where('status',1)
                ->where('name', 'like', '%' . $request->key . '%')
                ->get();
        }

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function filterTeachers(Request $request)
    {

        DB::table('testinglogin')->insert([
            'text'=> json_encode( $request->all()) ,
            'type' => 'filterdata'
        ]);

        $user =  Auth::guard('api')->user();
        if(isset($user)){
            $id = $user->id ;
        }else{
            $id =  0 ;
        }

        $data = User::with('country' ,'city', 'level' , 'university' ,'TutorsCourses.course')->where('role',3);
        $data->where('status',1);
        if ($request->has('name') and $request->name !='') {
            $data->where('name', 'like', '%' . $request->name . '%');
        }

        if( $id  > 0 ){
            $data->where('id','<>' ,$id);
        }
        if ($request->has('university_id') and $request->university_id > 0) {
            $data->where('university_id', $request->university_id);
        }

        if ($request->has('country_id') and $request->country_id > 0) {
            $data->where('country_id', $request->country_id);
        }

        if ($request->has('sex') && $request->sex != null) {
            $data->where('sex', $request->sex);
        }

        if($request->has('rated') && $request->rated > 0){
            $rate = $request->rated ;
            $data->wherehas('reviewed', function ($q)use( $rate) {
                $q->raw('avg(review) > ?',  $rate);
            });
        }



        if($request->has('course_id') && $request->course_id > 0){
            $course_id = $request->course_id ;
            $courses = Course::where('parent' , $course_id)->pluck('id')->toArray();
            $data->wherehas('TutorsCourses', function ($q)use( $courses) {
                $q->whereIn('course_id',  $courses);
            });
        }


        $message = __('api.success');
        return jsonResponse(true, $message, $data->get(), 200);
    }

    public function setfavoriteForTeacher(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::guard('api')->user()->id;
        $condistions = ['user_id' => $data['user_id'], 'tutor_id' => $data['tutor_id']];
        $message = __('api.success');
        if($request->is_favorite == 0){
            Vaforite::where($condistions)->delete();
            return jsonResponse(true, $message, null, 200);
        }

        $cheack = Vaforite::where($condistions)->first();
        if ($cheack) {
            return jsonResponse(false, __('api.You cannot repeat this process'), null, 106, null, null);
        }

        $setFavorite = Vaforite::create($condistions);

        return jsonResponse(true, $message, $setFavorite, 200);
    }

    public function setConverstionRequestByStudent(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::guard('api')->user()->id;


        $condistions = ['user_id' => $data['user_id'], 'tutor_id' => $data['tutor_id']];
        $is_exist = Conversation::where($condistions)->first();
        if( $is_exist){
            $message = __('api.error_exist_conversation_before');
            return jsonResponse(false, $message, null, 200);
        }
        $setConverstionRequest = Conversation::create($condistions);

        // send notification to tutor he has conversation with student
        $user_id = $data['tutor_id'];
        $tokens = Devicetoken::where('user_id', $user_id)->first();
        $title = ' طلب محادثة  ';
        $body = ' هناك طلب من '.Auth::guard('api')->user()->name.'  لبدء محادثة معك ';
        $data['action_type'] = 'newconversation';
        $data['action_id'] = $setConverstionRequest->user_id;
        $data['user_id'] = $user_id;
        $data['date'] = Carbon::now()->timestamp;
        $data['title'] = $title;
        $data['body'] = $body;


        sendFCM($title, $body, $data, $tokens, 1, 1);

        $message = __('api.success');
        return jsonResponse(true, $message, $setConverstionRequest, 200);
    }

    public function updateConverstionRequestByTeacher(Request $request)
    {
        $data = $request->all();
        $conv_id = $data['conv_id'];
        $data['tutor_id'] = Auth::guard('api')->user()->id;
        $condistions = [ 'tutor_id' => $data['tutor_id'] ,'user_id' =>   $conv_id];

        //return $condistions;

        $setConverstionRequest = Conversation::where(   $condistions)->first();
        if( $setConverstionRequest){
            $setConverstionRequest ->accept = $request->accept ;
                $setConverstionRequest ->save();

                 $setConverstionRequest->sendbird_channel = $request->sendbird_channel ;
                if( $setConverstionRequest ->accept == 1){
                    // create chat session
                    $setConverstionRequest->sendbird_channel = $request->sendbird_channel ;

                    // we want to check if the channel has two member or not  if not
                    // we will add the other member to channel again






                }
            $setConverstionRequest ->save();
                //send notification to student the respond from the tutor
            $user_id = $setConverstionRequest->user_id;
            $tokens = Devicetoken::where('user_id', $user_id)->first();
            $title = 'الرد على طلبك ';
            $body = 'تم الرد على طلبك من '.Auth::guard('api')->user()->name.' بخصوص المحادثة ';
            $data['action_type'] = 'acceptordenyconversation';
            $data['action_id'] =  $setConverstionRequest->id;
            $data['user_id'] = $user_id;
            $data['date'] = Carbon::now()->timestamp;
            $data['title'] = $title;
            $data['body'] = $body;


            sendFCM($title, $body, $data, $tokens, 1, 1);

                /// remove notification from tutor from accept again

            Notification::where('action_type', 'newconversation')
                ->where('action_id' ,  $user_id)->where('user_id' , $data['tutor_id'])->delete();
                 ///


            $message = __('api.success');
            return jsonResponse(true, $message, $setConverstionRequest, 200);
        }

        $message = __('api.error_not_found');
        return jsonResponse(false, $message, null, 200);
    }

    public function getConverstionRequestsForTeacher(Request $request)
    {
        $data = $request->all();
        $data['tutor_id'] = Auth::guard('api')->user()->id;
        //$condistions = ['user_id' => $data['user_id'], 'tutor_id' => $data['tutor_id'], 'accept' => $data['accept']];

        $getConverstionRequest = Conversation::where('tutor_id',$data['tutor_id'])->orderBy('id','desc')->get();

        $message = __('api.success');
        return jsonResponse(true, $message, $getConverstionRequest, 200);
    }





    public function getMyConverstions(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::guard('api')->user()->id;

        $getConverstionRequest = Conversation::with('student' , 'tutor')->whereNotNull('accept')->where('user_id',$data['user_id'])->orderBy('id','desc')->get();

        $message = __('api.success');
        return jsonResponse(true, $message, $getConverstionRequest, 200);
    }


    public function updateProfile(Request $request){
        $user = Auth::guard('api')->user();

        if ($request->country_id && $request->country_id > 0 ) {
            $user->country_id = $request->country_id;
        }

        if ($request->city_id && $request->city_id > 0 ) {
            $user->city_id = $request->city_id;
        }

        if ($request->birthday && $request->birthday != '') {
            $user->birthday = $request->birthday;
        }

        if ($request->email && $request->email != '') {
            $user->email = $request->email;
        }

        if ($request->name && $request->name != '') {
            $user->name = $request->name;
        }
        if (isset($request->sex )) {

            $user->sex = $request->sex;
        }
      //  dd($request->sex);
        if ($request->lat && $request->lat != '') {
            $user->lat = $request->lat;
        }
        if ($request->long && $request->long != '') {
            $user->long = $request->long;
        }
        if ($request->image && $request->image != '') {
            $user->image = $request->image;
        }
        if ($request->bio && $request->bio != '') {
            $user->bio = $request->bio;
        }



        if ($request->level_id && $request->level_id != '') {
            $user->level_id = $request->level_id;
        }

        if ($request->cv && $request->cv != '') {
            $user->cv = $request->cv;
        }

        if ($request->grades_doc && $request->grades_doc != '') {
            $user->grades_doc = $request->grades_doc;
        }

        //// edit bank account /// for the

        if ($request->bank_name && $request->bank_name != '') {
            $user->bank_name = $request->bank_name;
        }

        if ($request->bank_user_name && $request->bank_user_name != '') {
            $user->bank_user_name = $request->bank_user_name;
        }

        if ($request->bank_account && $request->bank_account != '') {
            $user->bank_account = $request->bank_account;
        }

        if ($request->bank_iban && $request->bank_iban != '') {
            $user->bank_iban = $request->bank_iban;
        }


        $user ->save();
        $user = getFullUser($user->id);

        if($user->role == 3 && $user->status == 0 ){
            // check if user not active and type techaer  we will send to him   message to manager review
            $message = __('api.success_under_review');
        }else{
            $message = __('api.success');
        }




        return jsonResponse(true, $message, $user, 200);

       // return $user ;

    }


    public function logout(Request $request){

        $user = Auth::guard('api')->user() ;
        if($user) {
            $divecs_revoke = \App\Devicetoken::where('user_id', $user->id)->delete();
            $revoke = $user->token()->revoke();
        }

        return jsonResponse( true  , __('api.success') , null,200 );

    }


    public function getNotifications(Request $request)
    {
        $user = Auth::guard('api')->user();
        $notications = Notification::where('user_id', $user->id)->orderBy('id' , 'desc')->paginate(10);
        $items['data'] = $notications->items();
        $items['count_unread'] = Notification::where('user_id', $user->id)->where('is_read', 0)->count();

        return jsonResponse(true, __('api.success'), $items, 200, $notications->currentPage(), $notications->lastPage());

    }

    public function readNotification(Request $request)
    {
        $user = Auth::guard('api')->user();
        $notications = Notification::where('user_id', $user->id)->where('id', $request->notification_id)->first();
        if ($notications) {
            $notications->is_read = 1;
            $notications->save();
        }
        return jsonResponse(true, __('api.success'), null, 200);
    }

    public function readAllNotification(Request $request)
    {
        $user = Auth::guard('api')->user();
        $notications = Notification::where('user_id', $user->id)
            ->where('is_read', 0)->get();
        foreach ($notications as $notif) {
            $notif->is_read = 1;
            $notif->save();
        }

        return jsonResponse(true, __('api.success'), null, 200);
    }



    public function getStudent($id){

        $user = User::where('role' , 2)->where('id' , $id)->first();
        if(!$user)
            return jsonResponse(false, __('api.error_not_found'), null, 200);


        $user = User::with('country','city' , 'level' , 'university')->where('id' ,$id)->first();
        if($user)
            return jsonResponse(true, __('api.success'), $user , 200);


    }

    public function getTeacher($id){

        $user = User::where('role' , 3)->where('id' , $id)->first();
        if(!$user)
        return jsonResponse(false, __('api.error_not_found'), null, 200);


        $user = User::with('country','city' , 'level' , 'university' ,'TutorsCourses.course' ,'times.time','quta.price')->where('id' ,$id)->first();
        if($user){
            $user = getFullUser($user->id);
        }
        return jsonResponse(true, __('api.success'), $user , 200);


    }

    public function getMyFavorite(Request $request){
        $user = Auth::guard('api')->user();
        $myfavorite = Vaforite::with(['teacher.level', 'teacher.university' ,'teacher.country' ])->where('user_id' , $user->id)->get();
        return jsonResponse(true, __('api.success'), $myfavorite, 200);
    } 

    public function storeFavorite(Request $request){
        $messages = [
            'provider_id.required' => 'لم يتم ادخال رقم مزود الخدمة',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'provider_id' => 'required',
        ],$messages);

        if ($validator->fails()) {
            return response([
                'status' => false,
                'messages' => $validator->messages()->all(),
            ]);
        }

        $favorite = AccountFavorite::create([
            'user_id'=>auth('api')->user()->id,
            'provider_id' => $request->provider_id,
        ]);

        return response([
            'status' => true,
            'favorite' =>$favorite
        ]);
    }

    public function deleteFavorite(Request $request){
        $user = auth('api')->user();
        $messages = [
            'favorite_id.required' => 'لم يتم ادخال رقم الشركة المفضلة',
        ];

        $validator = Validator::make($request->all(), [
            'favorite_id' => 'required',
        ],$messages);

        if ($validator->fails()) {
            return response([
                'status' => false,
                'messages' => $validator->messages()->all(),
            ]);
        }

        $user = auth('api')->user();
        $favorite = $user->userFavorites()->where('provider_id',$request->favorite_id)->where('user_id',$user->id)->first();

        if ($favorite != null){
            $favorite->delete();
        }

        $favorites = $user->userFavorites()->get()->pluck('provider_id')->toArray();
        $result = User::whereIn('id',$favorites)->paginate(10);

        return ProviderResource::collection($result)->additional([
            'status'=>true
        ]);
    }
    
    
    

}
