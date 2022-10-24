<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToReviewsTable extends Migration
{
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->foreign('reviewer_id', 'reviewer_fk_3760761')->references('id')->on('users');
            $table->unsignedBigInteger('reviewed_id')->nullable();
            $table->foreign('reviewed_id', 'reviewed_fk_3760762')->references('id')->on('users');
        });
    }
}
