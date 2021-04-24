<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToConversationsTable extends Migration
{
    public function up()
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_3760776')->references('id')->on('users');
            $table->unsignedBigInteger('tutor_id')->nullable();
            $table->foreign('tutor_id', 'tutor_fk_3760777')->references('id')->on('users');
        });
    }
}
