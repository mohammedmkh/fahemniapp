<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('text_policy')->nullable();
            $table->string('tex_policy_ar')->nullable();
            $table->string('aboutus_en')->nullable();
            $table->string('aboutus_ar')->nullable();
            $table->string('terms_ar')->nullable();
            $table->string('terms_en')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
