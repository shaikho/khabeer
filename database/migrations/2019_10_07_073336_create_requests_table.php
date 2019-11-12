<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_m_s', function (Blueprint $table) {
            $table->string('id');
            $table->string('subno')->unique();
            $table->string('subserviceprice');
            $table->string('subservicename')->nullable();
            $table->string('subservicearabicname')->nullable();
            $table->string('enddate');
            $table->string('location')->nullable();
            $table->string('userid');
            $table->string('providerid');
            $table->string('subserviceslug')->nullable();
            $table->string('cancelled')->nullable();
            $table->string('cancelmessage')->nullable();
            $table->string('status')->nullable();
            $table->string('user_lang')->nullable();
            $table->string('userauth')->nullable();
            $table->string('providorlang')->nullable();
            $table->string('providorauth')->nullable();
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
        Schema::dropIfExists('requests');
    }
}
