<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PalmTickets;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Services\DataTable;
use App\Services\Similarity;
use App\Imports\ItemListImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;

class Test2Controller extends Controller
{
    public function index()
    {
        return view('test2');
    }

    public function sim(Request $request)
    {
        ini_set('max_execution_time', '3600');

        $file = $request->file('file');

        $user_search_list = Excel::toArray(new ItemListImport, $file);
        $user_search_list = Arr::flatten($user_search_list);

        $results = array();
        
        $users_list = DB::connection('sqlsrv2')->table('SH_UObject')->select('Name', 'Fullname', 'Dept', 'Remarks')->where('ObjectType', 'User')->where('Dis', 0)->get();

        foreach($user_search_list as $search_text) {
            $sub_results = array();
            foreach($users_list as $user) {
                $sim = similar_text($search_text, $user->Fullname, $percent);
                Log::debug($percent);
                if ($percent > 70) {
                    array_push($sub_results, ['SourceName' => $search_text, 'username' => $user->Name, 'Fullname' => $user->Fullname]);
                }
            }
            if(count($sub_results) == 0) {
                array_push($sub_results, ['SourceName' => $search_text, 'username' => ' ', 'Fullname' => ' ']);
            }
            $results = array_merge($results, $sub_results);
        }

        // dd($results);

        header("Content-Disposition: attachment; filename=\"demo.xls\"");
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;");
        header("Pragma: no-cache");
        header("Expires: 0");
        $out = fopen("php://output", 'w');
        foreach ($results as $data)
        {
            fputcsv($out, $data,"\t");
        }
        fclose($out);
    }
}
