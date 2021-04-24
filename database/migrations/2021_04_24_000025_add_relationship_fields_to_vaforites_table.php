<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVaforitesTable extends Migration
{
    public function up()
    {
        Schema::table('vaforites', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_3760770')->references('id')->on('users');
            $table->unsignedBigInteger('tutor_id')->nullable();
            $table->foreign('tutor_id', 'tutor_fk_3760771')->references('id')->on('users');
        });
    }
}
