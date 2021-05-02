<?php


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {

    Route::post('validationCode', 'UsersApiController@validationCode');
    Route::post('login', 'UsersApiController@login');
    Route::post('validationCodeResetPassword', 'UsersApiController@validationCodeResetPassword');
    Route::post('checkPhoneResetPassword', 'UsersApiController@checkPhoneResetPassword');
    Route::post('resetPassword', 'UsersApiController@resetPassword');


    /************************************************************************************ STUDENT*/

    Route::post('registerStudent', 'UsersApiController@registerStudent');




    /**************************************************************************** TEACHER */

    Route::post('registerTeacher', 'UsersApiController@registerTeacher');
    Route::get('getCountries', 'UsersApiController@getCountries');
    Route::get('getUniversity', 'UsersApiController@getUniversity');
    Route::get('getLevels', 'UsersApiController@getLevels');
    Route::get('getCourses', 'UsersApiController@getCourses');
    Route::get('getCoursesGrades', 'UsersApiController@getCoursesGrades');

});



Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {

    Route::get('myInfo', 'UsersApiController@myInfo');
    Route::post('updateProfile', 'UsersApiController@updateProfile');
    Route::post('updatePassword', 'UsersApiController@updatePassword');
    Route::get('logout', 'UsersApiController@logout');


    /************************************************************************************ STUDENT*/

    Route::get('getTeachers', 'UsersApiController@getTeachers');
    Route::get('getBestTeachers', 'UsersApiController@getBestTeachers');
    Route::post('searchTeacherName', 'UsersApiController@searchTeacherName');
    Route::post('filterTeachers', 'UsersApiController@filterTeachers');
    Route::post('setfavoriteForTeacher', 'UsersApiController@setfavoriteForTeacher');
    Route::post('setConverstionRequestByStudent', 'UsersApiController@setConverstionRequestByStudent');
    Route::post('updateConverstionRequestByTeacher', 'UsersApiController@updateConverstionRequestByTeacher');
    Route::post('getConverstionRequestsForTeacher', 'UsersApiController@getConverstionRequestsForTeacher');




    /**************************************************************************** TEACHER */




});
