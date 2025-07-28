<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceItem extends Model
{
    protected $connection = "sqlsrv";
    protected $table = "dbo.AP_PurchaseDetails";
    protected $primaryKey = 'PurchaseDetailID';

    public function source()
    {
        return $this->belongsTo(PurchaseOrderItem::class, 'SourceID', 'PODetailID');
    }
}
