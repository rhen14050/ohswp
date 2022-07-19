<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblApproverEmailRecipients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_approver_email_recipients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_in_charge');
            $table->string('pic_apprv_date_time')->comment = 'Approved / Disapproved';
            $table->string('safety_officer_in_charge_id');
            $table->string('soic_apprv_date_time')->comment = 'Approved / Disapproved';
            $table->string('soic_apprv_date_time2')->comment = 'Approved / Disapproved';
            $table->string('over_all_safety_officer_id');
            $table->string('oaso_apprv_date_time')->comment = 'Approved / Disapproved';
            $table->string('oaso_apprv_date_time2')->comment = 'Approved / Disapproved';
            $table->string('hrd_manager_id');
            $table->string('hrd_apprv_date_time')->comment = 'Approved / Disapproved';
            $table->string('hrd_apprv_date_time2')->comment = 'Approved / Disapproved';
            $table->string('ems_manager_id');
            $table->string('ems_apprv_date_time')->comment = 'Approved / Disapproved';
            $table->string('safety_officer_in_charge_remark');
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
        Schema::dropIfExists('tbl_approver_email_recipients');
    }
}
