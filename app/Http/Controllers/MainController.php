<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PalmTickets;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MainExport;
use App\Models\PurchaseOrder;

class MainController extends Controller
{
    public function index()
    {
        return view('main');
    }

    public function test()
    {
        $purchase_order = PurchaseOrder::where('PONumber', 'SJIO/HO/PO/2401/011')->first();

        return view('test', compact('purchase_order'));
    }

    public function datatable(Request $request)
    {
        $filters = $request->get('filters');

        $query = DB::connection('sqlsrv')->table('dbo.VIEW_CUSTOM_FINANCE_REPORT_1')
            ->where('POApprovedBy', '=', 'handara.utomo');
        
        if ($filters['po_date_start']) {
            $query->where('POCreateDate', '>=', $filters['po_date_start']);
        }

        if ($filters['po_date_end']) {
            $query->where('POCreateDate', '<=', $filters['po_date_end']);
        }

        $datatable = datatables($query);

        return $datatable->toJson();
    }

    public function export(Request $request)
    {
        return (new MainExport())->download('Finance Tracking.xlsx');
    }
}
