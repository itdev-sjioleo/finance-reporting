<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceReceiptItem extends Model
{
    protected $connection = "sqlsrv";
    protected $table = "dbo.FI_APReceiptItems";
    protected $primaryKey = 'ReceiptItemID';

    public function source()
    {
        return $this->belongsTo(PurchaseInvoice::class, 'ItemID', 'PurchaseID');
    }
}
