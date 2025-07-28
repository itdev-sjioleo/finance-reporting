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

class TestController extends Controller
{
    public function index()
    {
        return view('test');
    }

    public function sim(Request $request)
    {
        ini_set('max_execution_time', '3600');

        $file = $request->file('file');

        $item_list = Excel::toArray(new ItemListImport, $file);
        $item_list = Arr::flatten($item_list);

        $results = array();
        
        $ic_items = DB::connection('sqlsrv')->table('IC_Items')->select('ItemCode', 'ItemName')->get();
        // dd($item_list);
        foreach($item_list as $search_text) {
            $sub_results = array();
            foreach($ic_items as $item) {
                $sim = Similarity::sim($search_text, $item->ItemName);
                if ($sim['simtl_index'] >= 1) {
                    // array_push($sub_results, $item->ItemCode.' '.$item->ItemName);
                    array_push($sub_results, ['SourceItemName' => $search_text, 'ItemCode' => $item->ItemCode, 'ItemName' => $item->ItemName]);
                } 
                elseif (
                    $sim['simtl_index'] >= 0.7
                    && $sim['sim_percent'] >= 35
                ) {
                    // array_push($sub_results, $item->ItemCode.' '.$item->ItemName);
                    array_push($sub_results, ['SourceItemName' => $search_text, 'ItemCode' => $item->ItemCode, 'ItemName' => $item->ItemName]);
                } 
                // elseif (
                //     $sim['simtl_index'] >= 0.6
                //     && $sim['sim_percent'] >= 50
                // ) {
                //     array_push($sub_results, ['SourceItemName' => $search_text, 'ItemCode' => $item->ItemCode, 'ItemName' => $item->ItemName]);
                // }
            };
            if(count($sub_results) == 0) {
                $results = array_merge($results, array(array('SourceItemName' => $search_text, 'ItemCode' => ' ', 'ItemName' => ' ')));
            } else {
                $search_arr = explode(" ", $search_text);
                $first_num_string = null;
                foreach ($search_arr as $sub_search) {
                    if (preg_match('~[0-9]+~', $sub_search)) { 
                        $first_num_string = $sub_search;
                        break; 
                    }
                }
                if ($first_num_string != null) {
                    $new_sub_results = array();
                    foreach ($sub_results as $key => $value) {
                        if(str_contains($value['ItemName'], $first_num_string)) {
                            array_push($new_sub_results, $value);
                        }
                    }
                    if (count($new_sub_results) == 0) {
                        $results = array_merge($results, array(array('SourceItemName' => $search_text, 'ItemCode' => ' ', 'ItemName' => ' ')));
                    } else {
                        $results = array_merge($results, $new_sub_results);
                    }
                } else {
                    $results = array_merge($results, $sub_results);
                }
            }
        }
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
