<?php



Route::post('/v1/callbackmoyser', 'HomeController@backApi')->name('backApi');
Route::get('/v1/sendFCMtest', 'HomeController@sendFCMtest')->name('sendFCMtest');
Route::get('/v1/sendFCMtest2', 'HomeController@sendFCMtest2')->name('sendFCMtest2');
Route::get('/v1/sendFCMtest3', 'HomeController@sendFCMtest3')->name('sendFCMtest3');
Route::get('/v1/checkChannelChat' , 'HomeController@checkChannelChat')->name('checkChannelChat');
Route::get('/v1/checkChannelChat2' , 'HomeController@checkChannelChat2')->name('checkChannelChat2');


Route::get('/v1/testingchat' , 'HomeController@testingchat')->name('testingchat');

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin' ,'middleware' => ['apiLang']], function () {

    Route::post('validationCode', 'UsersApiController@validationCode');
    Route::post('login', 'UsersApiController@login');
    Route::post('validationCodeResetPassword', 'UsersApiController@validationCodeResetPassword');
    Route::post('checkPhoneResetPassword', 'UsersApiController@checkPhoneResetPassword');
    Route::post('resetPassword', 'UsersApiController@resetPassword');

    Route::post('reportCoversation', 'DataApiController@reportCoversation');
    //Route::post('signchannel', 'DataApiController@signChannel');
    /************************************************************************************ STUDENT*/

    Route::post('registerStudent', 'UsersApiController@registerStudent');
    Route::post('uploadImage', 'DataApiController@uploadImage');
    Route::post('testingsms', 'DataApiController@testingsms');

    Route::post('testuserschat', 'DataApiController@testuserschat');
    /**************************************************************************** TEACHER */

    Route::post('registerTeacher', 'UsersApiController@registerTeacher');
    Route::get('getCountries', 'UsersApiController@getCountries');

    Route::get('cities/{id}', 'UsersApiController@getCities');

    Route::get('getUniversity', 'UsersApiController@getUniversity');
    Route::get('getLevels', 'UsersApiController@getLevels');
    Route::get('getCourses', 'UsersApiController@getCourses');
    Route::get('getCoursesGrades', 'UsersApiController@getCoursesGrades');


    Route::get('getCoursesWithCode', 'UsersApiController@getCoursesWithCode');

     Route::get('getQuestions', 'DataApiController@getQuestions');
     Route::get('getQuta', 'DataApiController@getQuta');
     Route::get('getTimes', 'DataApiController@getTimes');

   // Route::post('getTeachers', 'UsersApiController@getTeachers');
  //  Route::post('getBestTeachers', 'UsersApiController@getBestTeachers');

    Route::get('teachers', 'UsersApiController@getTeachers');
    Route::get('bestTeachers', 'UsersApiController@getBestTeachers');

    Route::get('dataTeachers', 'UsersApiController@getTeachers');
    Route::get('dataBestTeachers', 'UsersApiController@getBestTeachers');

    Route::get('getTeachers', 'UsersApiController@getTeachers');
    Route::get('getBestTeachers', 'UsersApiController@getBestTeachers');

    Route::post('searchTeacherName', 'UsersApiController@searchTeacherName');
    Route::post('filterTeachers', 'UsersApiController@filterTeachers');

    Route::get('getTeacher/{id}' , 'UsersApiController@getTeacher');

    Route::get('BookingStatuses' , 'DataApiController@BookingStatuses');
    Route::get('getReviews/{id}' , 'DataApiController@getReviews');
    Route::get('help' , 'DataApiController@help');
    Route::get('getSettings' , 'DataApiController@getSettings');
    Route::post('addCourseRequest' , 'DataApiController@addCourseRequest');

});



Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api' ,'apiLang']], function () {

    Route::get('myInfo', 'UsersApiController@myInfo');
    Route::post('updateProfile', 'UsersApiController@updateProfile');
    Route::post('updatePassword', 'UsersApiController@updatePassword');
    Route::post('logout', 'UsersApiController@logout');


    /****************************************** STUDENT ******************/





    Route::post('setfavoriteForTeacher', 'UsersApiController@setfavoriteForTeacher');
    Route::post('setConverstionRequestByStudent', 'UsersApiController@setConverstionRequestByStudent');
    Route::post('updateConverstionRequestByTeacher', 'UsersApiController@updateConverstionRequestByTeacher');
    Route::post('getConverstionRequestsForTeacher', 'UsersApiController@getConverstionRequestsForTeacher');


   /// Route::post('','');
    ///

    Route::post('setMyTime' , 'DataApiController@setMyTime');
    Route::post('setMyQuta' , 'DataApiController@setMyQuta');
    Route::post('updateMyCourses' , 'DataApiController@updateMyCourses');

    Route::get('getConverstionRequests' , 'DataApiController@getConverstionRequests');
    Route::get('getConverstionRequests/{id}' , 'DataApiController@getConverstionRequestsById');



    Route::get('getNotifications' , 'UsersApiController@getNotifications');
    Route::post('readNotification' , 'UsersApiController@readNotification');
    Route::post('readAllNotification' , 'UsersApiController@readAllNotification');


    Route::get('getMyFavorite' , 'UsersApiController@getMyFavorite');

    Route::post('booking' , 'DataApiController@booking');
    Route::get('myBookingStudent' , 'DataApiController@myBookingStudent');
    Route::get('myBookingStudentEnd' , 'DataApiController@myBookingStudentEnd');

    Route::get('myBookingTutor' , 'DataApiController@myBookingTutor');
    Route::get('myBookingTutor2' , 'DataApiController@myBookingTutor2');

    Route::get('myBookingTutorEnd' , 'DataApiController@myBookingTutorEnd');

    Route::post('acceptBooking' , 'DataApiController@acceptBooking');
    Route::post('runningBooking' , 'DataApiController@runningBooking');


    Route::get('bookingById/{id}' , 'DataApiController@bookingById');
    Route::post('completeBooking' , 'DataApiController@completeBooking');

    Route::post('reviewTutor' , 'DataApiController@reviewTutor');
    Route::post('reviewStudent' , 'DataApiController@reviewStudent');

    Route::post('cancelBooking' , 'DataApiController@cancelBooking');

    Route::get('getStudent/{id}' , 'UsersApiController@getStudent');


    Route::get('getMyConverstions' , 'UsersApiController@getMyConverstions');
    Route::post('setNotify' , 'UsersApiController@setNotify');






});
