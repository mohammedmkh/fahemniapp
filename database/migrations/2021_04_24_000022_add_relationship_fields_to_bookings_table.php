<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_3760808')->references('id')->on('users');
            $table->unsignedBigInteger('tutor_id')->nullable();
            $table->foreign('tutor_id', 'tutor_fk_3760809')->references('id')->on('users');
            $table->unsignedBigInteger('price_id')->nullable();
            $table->foreign('price_id', 'price_fk_3760814')->references('id')->on('prices');
        });
    }
}
