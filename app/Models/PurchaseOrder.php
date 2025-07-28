<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $connection = "sqlsrv";
    protected $table = "dbo.AP_PurchaseOrders";
    protected $primaryKey = 'POID';

    public function PurchaseOrderItem()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'POID', 'POID');
    }
}
