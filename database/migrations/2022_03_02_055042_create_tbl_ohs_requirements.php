<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblOhsRequirements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_ohs_requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ohs_requirement1');
            $table->string('ohs_requirement2');
            $table->string('ohs_requirement3');
            $table->string('ohs_requirement4');
            $table->string('ohs_requirement5');
            $table->string('ohs_requirement6');
            $table->string('ohs_requirement7');
            $table->string('ohs_requirement8');
            $table->string('ohs_requirement9');
            $table->string('ohs_requirement10');
            $table->string('ohs_requirement11');
            $table->string('ohs_requirement12');
            $table->string('ohs_requirement13');
            $table->string('ohs_requirement14');
            $table->string('ohs_requirement15');
            $table->string('ohs_requirement16');
            $table->string('ohs_requirement17');
            $table->string('ohs_requirement18');
            $table->string('ohs_requirement19');
            $table->string('ohs_requirement20');
            $table->string('ohs_requirement21');
            $table->integer('counter');
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
        Schema::dropIfExists('tbl_ohs_requirements');
    }
}
