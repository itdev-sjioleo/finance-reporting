<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceItem extends Model
{
    use HasFactory;

    protected $connection = "sqlsrv";
    protected $table = "dbo.AP_PurchaseDetails";
    protected $primaryKey = 'PurchaseDetailID';

    public function PurchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class, 'PurchaseID', 'PurchaseID');
    }

    public function PurchaseOrderItem()
    {
        return $this->belongsTo(PurchaseOrderItem::class, 'SourceID', 'PODetailID');
    }
}
