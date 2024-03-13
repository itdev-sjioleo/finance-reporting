@extends('layout')

@section('title', 'Finance Tracking')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div><strong>PO Amount</strong> <div id="po_amount">-</div></div>
                <div><strong>GR Amount</strong> <div id="gr_amount">-</div></div>
                <div><strong>IR Amount</strong> <div id="ir_amount">-</div></div>
                <div><strong>PVR Amount</strong> <div id="pvr_amount">-</div></div>
                <div><strong>PV Amount</strong> <div id="pv_amount">-</div></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-row align-items-end" style="gap: 2rem">
                <div>
                    <p class="font-weight-bold">Tanggal PO</p>
                    <div class="d-inline-flex align-items-center" style="gap: 1rem">
                        <div>
                            Dari
                        </div>
                        <div>
                            <input id="filter-po-date-start" type="date" class="form-control">
                        </div>
                        <div>
                            Ke
                        </div>
                        <div>
                            <input id="filter-po-date-end" type="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div>
                    <button id="btn-filter" class="btn btn-primary">Filter</button>
                </div>
            </div>
            <hr>
            <table id="table-main" class="table table-striped table-bordered text-nowrap">
                <thead>
                    <tr>
                        <td>Status</td>
                        <td>Purchase Order</td>
                        <td>Supplier Bank</td>
                        <td>Purchase Invoice</td>
                        <td>Invoice Receipt</td>
                        <td>Payment Voucher Request</td>
                        <td>Payment Voucher</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let table = null;
        let masterPOAmount = 0;
        let masterGRAmount = 0;
        let masterIRAmount = 0;
        let masterPVRAmount = 0;
        let masterPVAmount = 0;

        $(document).ready(function() {
            table = $('#table-main').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('/') }}" + '/main-datatable',
                    data: function(d) {
                        d.filters = {
                            po_date_start: $('#filter-po-date-start').val(),
                            po_date_end: $('#filter-po-date-end').val(),
                        };
                    }
                },
                ordering: false,
                stateSave: false,
                pageLength: 100,
                lengthMenu: [ [100, -1], [100, "All"] ],
                columns: [
                    {
                        data: 'ItemType',
                        render: (data, _, row) => {
                            let beginDate = row.POCreateDate;
                            let endDate = moment();
                            let html = '';

                            if (data == '#.#.#.#') {
                                html += '<p>Belum GRN</p>';
                            }
                            if (data == 'PO.#.#.#') {
                                html += '<p>Belum IR</p>';
                            }
                            if (data == 'PO.PI.#.#') {
                                html += '<p>Belum PVR</p>';
                            }
                            if (data == 'PO.PI.APR.#') {
                                html += '<p>Belum PV</p>';
                            }
                            if (data == 'PO.PI.APR.APR') {
                                endDate = row.PVRCreateDate;
                                html += '<p>Sudah PV</p>';
                            }

                            html += `<p>${Math.floor(moment(endDate).diff(moment(beginDate)) / 86400000)} Hari</p>`;

                            return html;
                        }
                    },
                    {
                        data: 'PONumber',
                        render: (data, _, row) => {
                            return `
                                PO Number: ${row.PONumber}<br>
                                PO Create Date: ${moment(row.POCreateDate).format('DD/MM/YYYY HH:mm')}<br>
                                PO Created By: ${row.POCreatedBy}<br>
                                PO Approved Date: ${moment(row.POApprovedDate).format('DD/MM/YYYY HH:mm')}<br>
                                PO Approved By: ${row.POApprovedBy}<br>
                                PO Supplier Code: ${row.POSupplierCode}<br>
                                PO Supplier Name: ${row.POSupplierName}<br>
                                PO Amount: ${Rupiah.format(row.POAmount)}
                            `;
                        }
                    },
                    {
                        data: 'SupBank',
                        render: (data, _, row) => {
                            return `
                                Supplier Bank: ${row.SupBank}<br>
                                Supplier Account No: ${row.SupAccountNo}<br>
                                Supplier Account Name: ${row.SupAccountName}
                            `;
                        }
                    },
                    {
                        data: 'GRNumber',
                        render: (data, _, row) => {
                            if (!row.GRNumber) {
                                return '-';
                            }
                            return `
                                PI Number: ${row.GRNumber}<br>
                                PI Created Date: ${moment(row.GRCreateDate).format('DD/MM/YYYY HH:mm')}<br>
                                PI Reference No: ${row.GRReferenceNo}<br>
                                PI Amount: ${Rupiah.format(row.GRAmount)}
                            `;
                        }
                    },
                    {
                        data: 'IRReceiptNo',
                        render: (data, _, row) => {
                            if (!row.IRReceiptNo) {
                                return '-';
                            }
                            return `
                                IR Number: ${row.IRReceiptNo}<br>
                                IR Create Date: ${moment(row.IRCreateDate).format('DD/MM/YYYY HH:mm')}<br>
                                IR Payment Date: ${moment(row.IRPaymentDate).format('DD/MM/YYYY HH:mm')}<br>
                                IR Net Amount: ${Rupiah.format(row.IRNetAmount)}<br>
                            `;
                        }
                    },
                    {
                        data: 'PVRNumber',
                        render: (data, _, row) => {
                            if (!row.PVRNumber) {
                                return '-';
                            }
                            return `
                                PVR Number: ${row.PVRNumber}<br>
                                PVR Created Date: ${moment(row.PVRCreateDate).format('DD/MM/YYYY HH:mm')}<br>
                                PVR Created By: ${row.PVRCreatedBy}<br>
                                PVR Amount Paid: ${Rupiah.format(row.PVRAmountPaid)}<br>
                                PVR Deducted PPh: ${Rupiah.format(row.PVRDeductedPPh)}<br>
                                PVR Net Amount Paid: ${Rupiah.format(row.PVRNetAmountPaid)}<br>
                                PVR Approved Date: ${moment(row.PVRApprovedDate).format('DD/MM/YYYY HH:mm')}<br>
                                PVR Approved By: ${row.PVRApprovedBy}<br>
                                PVR Remarks: ${row.PVRRemarks}
                            `;
                        }
                    },
                    {
                        data: 'PVNumber',
                        render: (data, _, row) => {
                            if (!row.PVNumber) {
                                return '-';
                            }
                            return `
                                PV Number: ${row.PVNumber}<br>
                                PV Created Date: ${moment(row.PVRCreateDate).format('DD/MM/YYYY HH:mm')}<br>
                                PV Created By: ${row.PVCreatedBy}<br>
                                PV Amount Paid: ${Rupiah.format(row.PVAmountPaid)}<br>
                                PV Bank Name: ${row.PVBankName}<br>
                                PV Remarks: ${row.PVRemarks}
                            `;
                        }
                    },
                ],
                scrollCollapse: true,
                scrollX: true,
                scrollY: 600,
                initComplete: function () {
                    // this.api()
                    //     .columns()
                    //     .every(function () {
                    //         let column = this;
                    //         let title = column.footer().textContent;
            
                    //         // Create input element
                    //         let input = document.createElement('input');
                    //         input.placeholder = title;
                    //         input.classList.add('form-control');
                    //         column.footer().replaceChildren(input);
            
                    //         // Event listener for user input
                    //         input.addEventListener('keyup', () => {
                    //             if (column.search() !== this.value) {
                    //                 column.search(input.value).draw();
                    //             }
                    //         });
                    //     });
                },
                drawCallback: function() {
                    this.api().rows().every(function(rowIdx, tableLoop, rowLoop) {
                        masterPOAmount += parseFloat(this.data().POAmount ?? 0);
                        masterGRAmount += parseFloat(this.data().GRAmount ?? 0);
                        masterIRAmount += parseFloat(this.data().IRNetAmount ?? 0);
                        masterPVRAmount += parseFloat(this.data().PVRNetAmountPaid ?? 0);
                        masterPVAmount += parseFloat(this.data().PVAmountPaid ?? 0);
                    });
                    refreshGrandTotal();
                },
                dom: `
                    <'row justify-content-between'
                        <'col-auto'l>
                        <'col-auto'f>
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
                        text: 'Export All',
                        className: 'btn btn-primary',
                        action: function () {
                            window.location.href = baseURL + '/main-export';
                        }
                    },
                ],
            });

            $('#btn-filter').click(() => {table.ajax.reload()});
        });

        function refreshGrandTotal() {
            $('#po_amount').text(Rupiah.format(masterPOAmount));
            $('#gr_amount').text(Rupiah.format(masterGRAmount));
            $('#ir_amount').text(Rupiah.format(masterIRAmount));
            $('#pvr_amount').text(Rupiah.format(masterPVRAmount));
            $('#pv_amount').text(Rupiah.format(masterPVAmount));
        }
    </script>
@endsection