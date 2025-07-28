<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;

class ItemListImport implements ToArray
{
    public function array(array $array)
    {
        return $array;
    }
}