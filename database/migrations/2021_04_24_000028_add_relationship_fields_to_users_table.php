<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id', 'country_fk_3760830')->references('id')->on('countries');
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign('level_id', 'level_fk_3760833')->references('id')->on('levels');
            $table->unsignedBigInteger('university_id')->nullable();
            $table->foreign('university_id', 'university_fk_3760834')->references('id')->on('universites');
        });
    }
}
