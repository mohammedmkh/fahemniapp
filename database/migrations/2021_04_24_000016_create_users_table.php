<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->datetime('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('verfiy')->nullable();
            $table->string('phone')->nullable();
            $table->string('sex')->nullable();
            $table->string('age')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->longText('bio')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
