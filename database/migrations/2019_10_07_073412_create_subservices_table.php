<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubservicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_services', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('subservicename');
            $table->string('subservicenamearabic');
            $table->string('price');
            $table->string('status')->nullable();
            $table->string('iconurl')->nullable();
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->string('descriptionarabic')->nullable();
            $table->string('serviceid');
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
        Schema::dropIfExists('subservices');
    }
}
