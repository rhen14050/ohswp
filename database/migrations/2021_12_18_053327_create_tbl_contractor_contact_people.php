<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblContractorContactPeople extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_contractor_contact_people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('company_id')->unsigned()->comment = 'From tbl_contractors `id`';
            $table->string('email');
            $table->bigInteger('classification')->comment = '0-Person in-charge, 1-Safety Officer in-charge';
            $table->bigInteger('status');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('tbl_contractors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_contractor_contact_people');
    }
}
