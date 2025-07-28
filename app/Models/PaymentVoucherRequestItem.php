<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentVoucherRequestItem extends Model
{
    protected $connection = "sqlsrv";
    protected $table = "dbo.FI_APRequestItems";
    protected $primaryKey = 'VoucherItemID';

    public function source()
    {
        return $this->belongsTo(InvoiceReceipt::class, 'ItemID', 'ReceiptID');
    }
}
