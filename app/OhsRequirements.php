<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\WorkPermitInformation;


class OhsRequirements extends Model
{
    protected $table = 'tbl_ohs_requirements';
    protected $connection = 'mysql';

    public function ohs_requirements_id()
    {
    	return $this->hasOne(WorkPermitInformation::class, 'counter', 'counter');
    } 
}
