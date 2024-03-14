<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $connection = "sqlsrv";
    protected $table = 'dbo.AP_PurchaseOrderDetails';
    protected $primaryKey = 'PODetailID';

    public function PurchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'POID', 'POID');
    }

    public function PurchaseInvoiceItem()
    {
        return $this->hasMany(PurchaseInvoiceItem::class, 'SourceID', 'PODetailID');
    }
}
