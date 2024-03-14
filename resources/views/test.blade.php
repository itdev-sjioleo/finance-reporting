@extends('layout')

@section('title', 'Finance Tracking')

@section('content')

<table class="table">
    <thead>
        <tr>
            <th>Purchase Order</th>
            <th>Purchase Invoice</th>
            <th>Invoice Receipt</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @php
                $pi_arr = array();
                $ir_arr = array();
            @endphp
            <td>
                {{ $purchase_order->PONumber }}
            </td>
            <td>
                @foreach($purchase_order->PurchaseOrderItem as $po_item)
                    @php
                        foreach($po_item->PurchaseInvoiceItem as $pi_item) {
                            if(!in_array($pi_item->PurchaseInvoice, $pi_arr)) {
                                array_push($pi_arr, $pi_item->PurchaseInvoice);
                            }
                        }
                    @endphp
                    @foreach($pi_arr as $pi)
                        {{ $pi->PurchaseNumber }}<br>
                    @endforeach
                @endforeach
            </td>
            <td>
                @php
                    foreach($pi_arr as $pi) {
                        if(!in_array($pi->InvoiceReceiptItem->InvoiceReceipt, $ir_arr)) {
                            array_push($ir_arr, $pi->InvoiceReceiptItem->InvoiceReceipt);
                        }
                    }
                @endphp
                @foreach($ir_arr as $ir)
                    {{ $ir->ReceiptNo }}<br>
                @endforeach
            </td>
        </tr>
    </tbody>
</table>

@endsection