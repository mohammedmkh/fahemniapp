<?php

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
   // Artisan::call('route:cache');

});



Route::get('/addpay/{id}', 'HomeController@addpay')->name('addpay');
Route::get('/thankyou', 'HomeController@thankyou')->name('thankyou');

Route::get('/payService', 'HomeController@payService')->name('thankyou');

Route::get('/back', 'HomeController@back')->name('thankyou');
Route::get('/failer', 'HomeController@failer')->name('failer');

Route::get('/test', 'HomeController@test')->name('test');


Route::post('/payThisBooking', 'HomeController@payThisBooking')->name('payThisBooking');


Route::get('setLang/{lang}', function($lang){

    session(['language' => $lang]);
    App::setLocale($lang);
    return Redirect::back();
});
Route::get('/', function(){


    return  redirect()->route('login');
});
//Route::get('/', 'HomeController@index')->name('home');

Route::get('/getTimes/{id}', 'HomeController@getTimes')->name('getTimes');


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin' , 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home_2');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');


    Route::post('notrefundBooking' ,'BookingController@notrefundBooking' );
    Route::post('refundBooking' ,'BookingController@refundBooking' );
    Route::get('refundexample' ,'BookingController@refundExample' );
    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    Route::delete('students/destroy', 'StudentsController@massDestroy')->name('students.massDestroy');
    Route::resource('students', 'StudentsController');

    Route::delete('teachers/destroy', 'TeachersController@massDestroy')->name('teachers.massDestroy');
    Route::resource('teachers', 'TeachersController');


    Route::post('acceptTeacher', 'TeachersController@acceptTeacher');
    Route::post('acceptCourserequest', 'CoursesRequestsController@acceptCourserequest');

    // Countries
    Route::delete('countries/destroy', 'CountriesController@massDestroy')->name('countries.massDestroy');
    Route::resource('countries', 'CountriesController');


    Route::delete('cities/destroy', 'CitiesController@massDestroy')->name('cities.massDestroy');
    Route::resource('cities', 'CitiesController');

    // Levels
    Route::delete('levels/destroy', 'LevelsController@massDestroy')->name('levels.massDestroy');
    Route::resource('levels', 'LevelsController');

    // Universites
    Route::delete('universites/destroy', 'UniversitesController@massDestroy')->name('universites.massDestroy');
    Route::resource('universites', 'UniversitesController');

    // Courses
    Route::delete('courses/destroy', 'CoursesController@massDestroy')->name('courses.massDestroy');
    Route::resource('courses', 'CoursesController');

    Route::delete('reports/destroy', 'ReportsController@massDestroy')->name('reports.massDestroy');
    Route::resource('reports', 'ReportsController');


    Route::delete('coursesrequests/destroy', 'CoursesRequestsController@massDestroy')->name('coursesrequests.massDestroy');
    Route::resource('coursesrequests', 'CoursesRequestsController');
    // Tutors Courses
    Route::delete('tutors-courses/destroy', 'TutorsCoursesController@massDestroy')->name('tutors-courses.massDestroy');
    Route::resource('tutors-courses', 'TutorsCoursesController');

    // Prices
    Route::delete('prices/destroy', 'PricesController@massDestroy')->name('prices.massDestroy');
    Route::resource('prices', 'PricesController');

    // Wallet
    Route::delete('wallets/destroy', 'WalletController@massDestroy')->name('wallets.massDestroy');
    Route::resource('wallets', 'WalletController');

    // Reviews
    Route::delete('reviews/destroy', 'ReviewsController@massDestroy')->name('reviews.massDestroy');
    Route::resource('reviews', 'ReviewsController');

    // Vaforite
    Route::delete('vaforites/destroy', 'VaforiteController@massDestroy')->name('vaforites.massDestroy');
    Route::resource('vaforites', 'VaforiteController');

    // Conversations
    Route::delete('conversations/destroy', 'ConversationsController@massDestroy')->name('conversations.massDestroy');
    Route::resource('conversations', 'ConversationsController');

    // Settings
    Route::delete('settings/destroy', 'SettingsController@massDestroy')->name('settings.massDestroy');
    Route::resource('settings', 'SettingsController');

    // Help
    Route::delete('helps/destroy', 'HelpController@massDestroy')->name('helps.massDestroy');
    Route::resource('helps', 'HelpController');

    // Booking
    Route::delete('bookings/destroy', 'BookingController@massDestroy')->name('bookings.massDestroy');
    Route::resource('bookings', 'BookingController');

    Route::get('bookingsreport', 'BookingController@bookingsReport');
    // Devicetokens
    Route::delete('devicetokens/destroy', 'DevicetokensController@massDestroy')->name('devicetokens.massDestroy');
    Route::resource('devicetokens', 'DevicetokensController');

    // Notifications
    Route::delete('notifications/destroy', 'NotificationsController@massDestroy')->name('notifications.massDestroy');
    Route::resource('notifications', 'NotificationsController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
