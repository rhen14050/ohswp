<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RapidXDepartment;

class RapidXUser extends Model
{
    protected $table = 'users';
    protected $connection = 'rapidx';

}
