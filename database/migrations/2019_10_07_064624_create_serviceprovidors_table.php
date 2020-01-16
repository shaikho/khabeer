<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Validation\Rules\Unique;
use phpDocumentor\Reflection\Types\Nullable;

class CreateServiceprovidorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_providors', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('username');
            $table->string('phonenumber')->unique();
            $table->string('password')->nullable();
            $table->string('buildingno')->nullable();
            $table->string('unitno')->nullable();
            $table->string('docs')->nullable();
            $table->string('profileimg')->nullable();
            $table->string('role')->nullable();
            $table->string('postalcode')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('nationalid')->nullable();
            $table->string('nationaladdress')->nullable();
            $table->string('rate')->nullable();
            $table->string('clients')->nullable();
            $table->string('type')->nullable();
            $table->string('approved')->nullable();
            $table->string('code')->nullable();
            $table->string('active')->nullable();
            $table->string('requestid')->nullable();
            $table->string('subserviceid')->nullable();
            $table->string('notification_token');
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
        Schema::dropIfExists('serviceprovidors');
    }
}
