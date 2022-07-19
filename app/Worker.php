<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $table = 'tbl_worker';
    protected $connection = 'mysql';
}
