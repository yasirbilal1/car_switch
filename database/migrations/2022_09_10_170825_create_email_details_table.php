<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('email_id');
            $table->unsignedBigInteger('email_replier_id');
            $table->text('content');
            $table->foreign('email_id')->references('id')->on('emails');	
            $table->foreign('email_replier_id')->references('id')->on('email_recipients');	
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
        Schema::dropIfExists('email_details');
    }
};
