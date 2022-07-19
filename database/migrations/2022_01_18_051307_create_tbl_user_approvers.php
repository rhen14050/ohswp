<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblUserApprovers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_user_approvers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_no');
            $table->integer('rapidx_id');
            $table->string('name');
            $table->string('classification');
            $table->integer('status');
            $table->string('username');
            $table->string('email');
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
        Schema::dropIfExists('tbl_user_approvers');
    }
}
