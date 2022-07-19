<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contractor;

class ContractorContactPerson extends Model
{
    protected $table = 'tbl_contractor_contact_people';
    protected $connection = 'mysql';

    public function contractor_id(){
        return $this->hasOne(Contractor::class, 'id', 'company_id');
    }

}
