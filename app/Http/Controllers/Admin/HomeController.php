<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\CourseRequest;
use App\Report;
use App\TutorTimes;
use App\User;

class HomeController
{
    public function index()
    {
        //dd('hello');

        // get booking tha cancel to refund process
        $booking_cancel_from_student = 0 ;
        $booking_cancel_from_tutor = 0 ;
         $booking_cancel_from_student = Booking::where('status' ,5)->where('is_refunded' , 0)->count();
        $booking_cancel_from_tutor = Booking::where('status' ,6)->where('is_refunded' , 0)->count();
         $tutors_count = User::where('role' , 3)->where('status' ,1)->count();
         $students_count = User::where('role' , 2)->count();
         $reports_count = Report::where('status' ,0)->count();
         $courses_count  = CourseRequest::where('status' , 0)->count();


         return view('home' , compact('reports_count' , 'courses_count'
             , 'students_count' , 'tutors_count' , 'booking_cancel_from_student' , 'booking_cancel_from_tutor'));
    }



}
