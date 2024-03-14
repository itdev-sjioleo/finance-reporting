<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;

    protected $connection = "sqlsrv";
    protected $table = "dbo.AP_Purchases";
    protected $primaryKey = 'PurchaseID';

    public function PurchaseInvoiceItem()
    {
        return $this->hasMany(PurchaseInvoiceItem::class, 'PurchaseID', 'PurchaseID');
    }

    public function InvoiceReceiptItem()
    {
        return $this->belongsTo(InvoiceReceiptItem::class, 'PurchaseID', 'ItemID');
    }
}
