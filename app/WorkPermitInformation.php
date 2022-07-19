<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contractor;
use App\ContractorContactPerson;
use App\ApproverEmailRecipient;
use App\Worker;

class WorkPermitInformation extends Model
{
    protected $table = 'tbl_work_permit_information';
    protected $connection = 'mysql';

    public function contractor_id(){
        return $this->hasOne(Contractor::class, 'id', 'contractor_id');
    }

    public function contractor_id_name(){
        return $this->hasOne(Contractor::class, 'id', 'contractor_id');
    }

    public function contractor_details(){
        return $this->hasOne(Contractor::class, 'id', 'contractor_id');
    }

    public function contractor_person_in_charge(){
        return $this->hasOne(ContractorContactPerson::class, 'id', 'contractor_pic_id');
    }

    public function contractor_safety_officer_in_charge(){
        return $this->hasOne(ContractorContactPerson::class, 'id', 'contractor_soic_id');
    }

    public function rapidx_user_details()
    {
    	return $this->hasOne(RapidXUser::class, 'id', 'rapidx_id');
    }

    public function approver_in_charge()
    {
    	return $this->hasOne(ApproverEmailRecipient::class, 'counter', 'counter');
    }


}
