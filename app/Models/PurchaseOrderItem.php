<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $connection = "sqlsrv";
    protected $table = 'dbo.AP_PurchaseOrderDetails';
    protected $primaryKey = 'PODetailID';
}
