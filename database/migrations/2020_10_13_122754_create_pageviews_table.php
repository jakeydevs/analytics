<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pageviews', function (Blueprint $table) {
            $table->id();

            $table->text('session_id')->nullable();
            $table->text('user_agent')->nullable();
            $table->text('ip')->nullable();
            $table->text('referrer')->nullable();

            $table->text('path');
            $table->string('method');
            $table->string('code');

            $table->boolean('parsed')->default(false);
            $table->integer('time_spent')->default(0);
            $table->string('location')->nullable();
            $table->string('device')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pageviews');
    }
}
