<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentVoucherRequest extends Model
{
    protected $connection = "sqlsrv";
    protected $table = "dbo.FI_APRequest";
    protected $primaryKey = 'VoucherID';

    public function source()
    {
        return $this->hasMany(PaymentVoucherRequestItem::class, 'VoucherID', 'VoucherID');
    }
}
