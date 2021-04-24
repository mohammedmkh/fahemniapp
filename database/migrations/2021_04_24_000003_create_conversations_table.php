<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('accept')->nullable();
            $table->integer('end_conv')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
