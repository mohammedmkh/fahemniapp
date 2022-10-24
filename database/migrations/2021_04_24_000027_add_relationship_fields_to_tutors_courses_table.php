<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTutorsCoursesTable extends Migration
{
    public function up()
    {
        Schema::table('tutors_courses', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_3760741')->references('id')->on('users');
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id', 'course_fk_3760742')->references('id')->on('courses');
        });
    }
}
