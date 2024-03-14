<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceReceiptItem extends Model
{
    use HasFactory;

    protected $connection = "sqlsrv";
    protected $table = "dbo.FI_APReceiptItems";
    protected $primaryKey = 'ReceiptItemID';

    public function InvoiceReceipt()
    {
        return $this->belongsTo(InvoiceReceipt::class, 'ReceiptID', 'ReceiptID');
    }
}
