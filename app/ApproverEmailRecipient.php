<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ApproverEmailRecipient extends Model
{
    protected $table = 'tbl_approver_email_recipients';
    protected $connection = 'mysql';

    public function safety_officer_in_charge()
    {
    	return $this->hasOne(RapidXUser::class, 'id', 'safety_officer_in_charge_id');
    }

    public function over_all_safety_officer()
    {
    	return $this->hasOne(RapidXUser::class, 'id', 'over_all_safety_officer_id');
    }

    public function hrd_manager()
    {
    	return $this->hasOne(RapidXUser::class, 'id', 'hrd_manager_id');
    }

    public function ems_manager()
    {
    	return $this->hasOne(RapidXUser::class, 'id', 'ems_manager_id');
    }

    public function project_in_charge_details()
    {
    	return $this->hasOne(RapidXUser::class, 'name', 'project_in_charge');
    }


    public function user_approver_details()
    {
    	return $this->hasOne(UserApprover::class, 'id', 'rapidx_id');
    }

    public function work_permit_details()
    {
    	return $this->hasOne(WorkPermitInformation::class, 'counter', 'counter');
    }


}
