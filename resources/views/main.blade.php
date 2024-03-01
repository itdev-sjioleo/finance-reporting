@extends('layout')

@section('title', 'Finance Tracking')

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="table-main" class="table table-striped table-bordered text-nowrap">
                <thead>
                    <tr>
                        <td>Status</td>
                        <td>PO Number</td>
                        <td>PO Created Date</td>
                        <td>PO Created By</td>
                        <td>PO Approved Date</td>
                        <td>PO Approved By</td>
                        <td>PO Supplier Code</td>
                        <td>PO Supplier Name</td>
                        <td>Sup Bank</td>
                        <td>Sup Account No</td>
                        <td>Sup Account Name</td>
                        <td>GR Number</td>
                        <td>GR Create Date</td>
                        <td>GR Created By</td>
                        <td>GR Reference No</td>
                        <td>IR Receipt No</td>
                        <td>IR Create Date</td>
                        <td>IR Created By</td>
                        <td>IR Payment Date</td>
                        <td>IR Net Amount</td>
                        <td>PVR Number</td>
                        <td>PVR Create Date</td>
                        <td>PVR Created By</td>
                        <td>PVR Amount Paid</td>
                        <td>PVR Deducted PPh</td>
                        <td>PVR Net Amount Paid</td>
                        <td>PVR Approved Date</td>
                        <td>PVR Approved By</td>
                        <td>PVR Remarks</td>
                        <td>PV Number</td>
                        <td>PV Create Date</td>
                        <td>PV Created By</td>
                        <td>PV Amount Paid</td>
                        <td>PV Bank Name</td>
                        <td>PV Remarks</td>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <td>Status</td>
                        <td>PO Number</td>
                        <td>PO Created Date</td>
                        <td>PO Created By</td>
                        <td>PO Approved Date</td>
                        <td>PO Approved By</td>
                        <td>PO Supplier Code</td>
                        <td>PO Supplier Name</td>
                        <td>Sup Bank</td>
                        <td>Sup Account No</td>
                        <td>Sup Account Name</td>
                        <td>GR Number</td>
                        <td>GR Create Date</td>
                        <td>GR Created By</td>
                        <td>GR Reference No</td>
                        <td>IR Receipt No</td>
                        <td>IR Create Date</td>
                        <td>IR Created By</td>
                        <td>IR Payment Date</td>
                        <td>IR Net Amount</td>
                        <td>PVR Number</td>
                        <td>PVR Create Date</td>
                        <td>PVR Created By</td>
                        <td>PVR Amount Paid</td>
                        <td>PVR Deducted PPh</td>
                        <td>PVR Net Amount Paid</td>
                        <td>PVR Approved Date</td>
                        <td>PVR Approved By</td>
                        <td>PVR Remarks</td>
                        <td>PV Number</td>
                        <td>PV Create Date</td>
                        <td>PV Created By</td>
                        <td>PV Amount Paid</td>
                        <td>PV Bank Name</td>
                        <td>PV Remarks</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const table = $('#table-main').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('/') }}" + '/main-datatable',
                },
                order: [[1, 'desc']],
                stateSave: false,
                pageLength: 100,
                lengthMenu: [ [100, -1], [100, "All"] ],
                columns: [
                    {
                        data: 'ItemType',
                        render: (data) => {
                            if (data == '#.#.#.#') {
                                return 'Belum GRN';
                            }
                            if (data == 'PO.#.#.#') {
                                return 'Belum IR';
                            }
                            if (data == 'PO.PI.#.#') {
                                return 'Belum PVR';
                            }
                            if (data == 'PO.PI.APR.#') {
                                return 'Belum PV';
                            }
                            if (data == 'PO.PI.APR.APR') {
                                return 'Sudah PV';
                            }
                        }
                    },
                    {data: 'PONumber'},
                    {data: 'POCreatedDate'},
                    {data: 'POCreatedBy'},
                    {data: 'POApprovedDate'},
                    {data: 'POApprovedBy'},
                    {data: 'POSupplierCode'},
                    {data: 'POSupplierName'},
                    {data: 'SupBank'},
                    {data: 'SupAccountNo'},
                    {data: 'SupAccountName'},
                    {data: 'GRNumber'},
                    {data: 'GRCreateDate'},
                    {data: 'GRCreatedBy'},
                    {data: 'GRReferenceNo'},
                    {data: 'IRReceiptNo'},
                    {data: 'IRCreateDate'},
                    {data: 'IRCreatedBy'},
                    {data: 'IRPaymentDate'},
                    {data: 'IRNetAmount'},
                    {data: 'PVRNumber'},
                    {data: 'PVRCreateDate'},
                    {data: 'PVRCreatedBy'},
                    {data: 'PVRAmountPaid'},
                    {data: 'PVRDeductedPPh'},
                    {data: 'PVRNetAmountPaid'},
                    {data: 'PVRApprovedDate'},
                    {data: 'PVRApprovedBy'},
                    {data: 'PVRRemarks'},
                    {data: 'PVNumber'},
                    {data: 'PVCreateDate'},
                    {data: 'PVCreatedBy'},
                    {data: 'PVAmountPaid'},
                    {data: 'PVBankName'},
                    {data: 'PVRemarks'},
                ],
                scrollCollapse: true,
                scrollX: true,
                scrollY: 400,
                initComplete: function () {
                    this.api()
                        .columns()
                        .every(function () {
                            let column = this;
                            let title = column.footer().textContent;
            
                            // Create input element
                            let input = document.createElement('input');
                            input.placeholder = title;
                            input.classList.add('form-control');
                            column.footer().replaceChildren(input);
            
                            // Event listener for user input
                            input.addEventListener('keyup', () => {
                                if (column.search() !== this.value) {
                                    column.search(input.value).draw();
                                }
                            });
                        });
                },
                dom: `
                    <'row'
                        <'col-auto flex-grow-1'
                            <'row'
                                <'col-auto'l>
                                <'col-auto ml-5'f>
                            >
                        >
                        <'col-auto'B>
                    >
                    <'row'
                        <'col-sm-12'tr>
                    >
                    <'row'
                        <'col-sm-12 col-md-5'i>
                        <'col-sm-12 col-md-7'p>
                    >
                `,
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Export Excel',
                        className: 'btn btn-primary',
                        action: function () {
                            window.location.href = baseURL + '/main-export';
                        }
                    },
                ],
            });
        });
    </script>
@endsection