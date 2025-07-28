<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    protected $connection = "sqlsrv";
    protected $table = "dbo.AP_Purchases";
    protected $primaryKey = 'PurchaseID';

    public function PurchaseInvoiceItem()
    {
        return $this->hasMany(PurchaseInvoiceItem::class, 'PurchaseID', 'PurchaseID');
    }
}
