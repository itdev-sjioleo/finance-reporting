<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceReceipt extends Model
{
    use HasFactory;

    protected $connection = "sqlsrv";
    protected $table = "dbo.FI_APReceipt";
    protected $primaryKey = 'ReceiptID';

    public function InvoiceReceiptItem()
    {
        return $this->hasMany(InvoiceReceiptItem::class, 'ReceiptID', 'ReceiptID');
    }
}
