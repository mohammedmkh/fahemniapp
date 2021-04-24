<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Countries
    Route::apiResource('countries', 'CountriesApiController');

    // Levels
    Route::apiResource('levels', 'LevelsApiController');

    // Universites
    Route::apiResource('universites', 'UniversitesApiController');

    // Courses
    Route::apiResource('courses', 'CoursesApiController');

    // Tutors Courses
    Route::apiResource('tutors-courses', 'TutorsCoursesApiController');

    // Prices
    Route::apiResource('prices', 'PricesApiController');

    // Wallet
    Route::apiResource('wallets', 'WalletApiController');

    // Reviews
    Route::apiResource('reviews', 'ReviewsApiController');

    // Vaforite
    Route::apiResource('vaforites', 'VaforiteApiController');

    // Conversations
    Route::apiResource('conversations', 'ConversationsApiController');

    // Settings
    Route::apiResource('settings', 'SettingsApiController');

    // Help
    Route::apiResource('helps', 'HelpApiController');

    // Booking
    Route::apiResource('bookings', 'BookingApiController');

    // Devicetokens
    Route::apiResource('devicetokens', 'DevicetokensApiController');

    // Notifications
    Route::apiResource('notifications', 'NotificationsApiController');
});
