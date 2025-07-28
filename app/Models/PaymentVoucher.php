<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentVoucher extends Model
{
    protected $connection = "sqlsrv";
    protected $table = "dbo.FI_ARAP";
    protected $primaryKey = 'VoucherID';

    public function PaymentVoucherItem()
    {
        return $this->hasMany(PaymentVoucherItem::class, 'VoucherID', 'VoucherID');
    }
}
