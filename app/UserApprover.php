<?php

namespace App;
use App\RapidXUser;

use Illuminate\Database\Eloquent\Model;

class UserApprover extends Model
{
    protected $table = 'tbl_user_approvers';
    protected $connection = 'mysql';

    public function rapidx_user_details()
    {
    	return $this->hasOne(RapidXUser::class, 'id', 'rapidx_id');
    } 

    // public function get_project_in_charge()
    // {
    //     return $this->hasOne(ApproverEmailRecipient::class, 'id', 'rapidx_id');
    // }
}
