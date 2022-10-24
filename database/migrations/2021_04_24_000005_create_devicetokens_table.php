<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicetokensTable extends Migration
{
    public function up()
    {
        Schema::create('devicetokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('device_type')->nullable();
            $table->string('device_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
