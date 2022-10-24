<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorsCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('tutors_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('grade')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
