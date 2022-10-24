<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpsTable extends Migration
{
    public function up()
    {
        Schema::create('helps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question_ar')->nullable();
            $table->string('question_en')->nullable();
            $table->string('answer_en')->nullable();
            $table->string('answer_ar')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
