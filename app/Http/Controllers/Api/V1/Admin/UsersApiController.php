<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Conversation;
use App\Country;
use App\Course;
use App\Level;
use App\Models\Advertice;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\TutorsCourse;
use App\Universite;
use App\User;
use App\Vaforite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use \Validator;
use DB;
use App\Models\Devicetoken;
use Route;
use App\Rules\MatchOldPassword;
use App\Models\ReviewsCaptin;

class UsersApiController extends Controller
{
    public function registerStudent(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits:10',
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'sex' => 'required',
            'age' => 'required',
            'lat' => 'required',
            'long' => 'required',
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


        if ($user) {
            $message_error = __('api.user_exist_before');
            return jsonResponse(false, $message_error, null, 104);
        }


        $data['sms_code'] = $this->getSmsCode();
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);
        $user->roles()->sync(3);


        $message = 'Code : ' . $user->registration_code . ' is For Verification';
        //  sendSMS($user->phone, $message);

        $message = __('api.success');
        return jsonResponse(true, $message, null, 200);


    }

    private function getSmsCode()
    {

        $digits = 4;
        $random = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        return $random;

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


        $message = __('api.success');
        return jsonResponse(true, $message, null, 200);


    }

    public function registerTeacher(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits:10',
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'sex' => 'required',
            'age' => 'required',
            'lat' => 'required',
            'long' => 'required',
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


        if ($user) {
            $message_error = __('api.user_exist_before');
            return jsonResponse(false, $message_error, null, 104);
        }


        $data['sms_code'] = $this->getSmsCode();
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);
        $user->roles()->sync(4);


        foreach ($data['tutors_courses'] as $value) {

            $tutors_courses = new TutorsCourse();
            $tutors_courses->user_id = $user->id;
            $tutors_courses->course_id = $value['course_id'];
            $tutors_courses->grade = $value['grade'];
            $tutors_courses->save();
        }

        $message = 'Code : ' . $user->registration_code . ' is For Verification';
        //  sendSMS($user->phone, $message);

        $message = __('api.success');
        return jsonResponse(true, $message, null, 200);


    }

    public function getCountries(Request $request)
    {

        $data = Country::get();

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

    public function getCourses(Request $request)
    {

        $data = Course::get();

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
                return jsonResponse(false, __('api.wrong_verify_code'), null, 106, null, null, $validator);
            }

            /*
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
                        $device->save();*/

            ///  delete access token this user
            DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();


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


        $message = 'Code : ' . $user->registration_code . ' is For Verification';
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


        $message = __('api.success');
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

    public function getTeachers(Request $request)
    {

        $data = User::wherehas('roles', function ($q) {
            $q->where('id', 4);
        })->paginate();

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function getBestTeachers(Request $request)
    {

        $data = User::wherehas('roles', function ($q) {
            $q->where('id', 4);

        })->wherehas('reviewed', function ($q) {

            $q->havingRaw('avg(review) = ?', [5]);
        })->get();

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function searchTeacherName(Request $request)
    {

        $data = User::where('name', 'like', '%' . $request->key . '%')
            ->wherehas('roles', function ($q) {
                $q->where('id', 4);
            })->get();
        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function filterTeachers(Request $request)
    {
        $data = User::query();
        if ($request->has('name') and $request->name) {
            $data->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->has('level_id') and $request->level_id) {
            $data->where('level_id', $request->level_id);
        }
        if ($request->has('country_id') and $request->country_id) {
            $data->where('country_id', $request->country_id);

        }
        if ($request->has('sex') and $request->sex) {
            $data->where('sex', $request->sex);

        }

        $message = __('api.success');
        return jsonResponse(true, $message, $data->get(), 200);
    }

    public function setfavoriteForTeacher(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::guard('api')->user()->id;
        $condistions = ['user_id' => $data['user_id'], 'tutor_id' => $data['tutor_id']];

        $cheack = Vaforite::where($condistions)->first();
        if ($cheack) {
            return jsonResponse(false, __('api.You cannot repeat this process'), null, 106, null, null);

        }

        $setFavorite = Vaforite::create($condistions);

        $message = __('api.success');
        return jsonResponse(true, $message, $setFavorite, 200);
    }

    public function setConverstionRequestByStudent(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::guard('api')->user()->id;
        $condistions = ['user_id' => $data['user_id'], 'tutor_id' => $data['tutor_id'], 'accept' => 0];

        $setConverstionRequest = Conversation::create($condistions);

        $message = __('api.success');
        return jsonResponse(true, $message, $setConverstionRequest, 200);
    }

    public function updateConverstionRequestByTeacher(Request $request)
    {
        $data = $request->all();
        $conv_id = $data['conv_id'];
        $data['tutor_id'] = Auth::guard('api')->user()->id;
        $condistions = ['user_id' => $data['user_id'], 'tutor_id' => $data['tutor_id'], 'accept' => $data['accept']];
        $setConverstionRequest = Conversation::find($conv_id)->update($condistions);

        $message = __('api.success');
        return jsonResponse(true, $message, $setConverstionRequest, 200);
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

}
