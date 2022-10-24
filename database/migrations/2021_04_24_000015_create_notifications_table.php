<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('action_type')->nullable();
            $table->string('actionid')->nullable();
            $table->string('action')->nullable();
            $table->integer('reed')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
