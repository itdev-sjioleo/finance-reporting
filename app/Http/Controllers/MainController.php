<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PalmTickets;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReceiptionExport;
use App\Exports\ReceiptionNtExport;

class MainController extends Controller
{
    public function index()
    {
        return view('main');
    }

    public function datatable(Request $request)
    {
        $filters = $request->get('filters');

        $query = DB::connection('sqlsrv')->table('dbo.VIEW_CUSTOM_FINANCE_REPORT_1')
            ->where('POApprovedBy', '=', 'handara.utomo');

        $datatable = datatables($query);

        return $datatable->toJson();
    }

    public function export(Request $request)
    {
        return (new ReceiptionExport())->download('Finance Tracking.xlsx');
    }
}
