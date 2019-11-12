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
        Schema::create('serviceprovidors', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('username');
            $table->string('phonenumber')->Unique();
            $table->string('password')->Nullable();
            $table->string('buildingno')->Nullable();
            $table->string('unitno')->Nullable();
            $table->string('docs')->Nullable();
            $table->string('profileimg')->Nullable();
            $table->string('role')->Nullable();
            $table->string('postalcode')->Nullable();
            $table->string('neighborhood')->Nullable();
            $table->string('nationalid')->Nullable();
            $table->string('nationaladdress')->Nullable();
            $table->string('rate')->Nullable();
            $table->string('clients')->Nullable();
            $table->string('type')->Nullable();
            $table->string('approved')->Nullable();
            $table->string('code')->Nullable();
            $table->string('active')->Nullable();
            $table->string('requestid')->Nullable();
            $table->string('subserviceid')->Nullable();
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
