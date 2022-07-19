<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblWorkPermitInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_work_permit_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            //===== PERMIT NUMBER HAS A FORMAT AND RESETS EVERY YEAR/MONTH ======//
            $table->string('permit_number');
            $table->string('validity');
            //===== SET IF URGENT OR NORMAL ACTIVITY =====//
            $table->bigInteger('classification')->comment = '0-normal,1-urgent';
            //===== PERMIT TYPE BASED ON TEMPLATE =====//
            $table->bigInteger('work_permit_type');
            $table->string('person_in_charge');
            $table->string('department');
            $table->string('activity');
            $table->string('description');
            $table->bigInteger('local_number');
            $table->string('location');
            $table->unsignedTinyInteger('status')->default(0)
            ->comment = '0- Approval of Project in Charge
                        1- Approval Safety Officer in Charge
                        2- Approval Over-all Safety Officer in Charge
                        3- Approval of HRD Manager
                        4- Approval of EMS Manager';
            $table->string('clearance_status_clear');
            $table->string('clearance_status_not_clear');
            $table->bigInteger('contractor_id')->unsigned();
            $table->bigInteger('contractor_pic_id')->unsigned()->comment = 'Contractor person in-charge';
            $table->bigInteger('contractor_soic_id')->unsigned()->comment = 'Contractor safety officer in-charge';
            // $table->string('project_duration');
            // $table->string('work_schedule');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('time');
            // $table->bigInteger('status');
            $table->bigInteger('counter');
            $table->bigInteger('logdel');
            $table->string('moc1');
            $table->string('moc2');
            $table->string('moc3');
            $table->timestamps();

            $table->foreign('contractor_id')->references('id')->on('tbl_contractors');
            $table->foreign('contractor_pic_id')->references('id')->on('tbl_contractor_contact_people');
            $table->foreign('contractor_soic_id')->references('id')->on('tbl_contractor_contact_people');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_work_permit_information');
    }
}
