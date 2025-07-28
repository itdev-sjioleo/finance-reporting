<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentVoucherItem extends Model
{
    protected $connection = "sqlsrv";
    protected $table = "dbo.FI_ARAPItems";
    protected $primaryKey = 'VoucherItemID';

    public function source()
    {
        return $this->belongsTo(InvoiceReceipt::class, 'ItemID', 'ReceiptID');
    }
}
