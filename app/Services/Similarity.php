<?php

namespace App\Services;

class Similarity 
{
    public static function sim($search_text, $comparison_text)
    {
        $n_search = strlen($search_text);
        $n_comparison = strlen($comparison_text);
        $sim = similar_text(strtolower($search_text), strtolower($comparison_text), $percent);
        $result = 0;

        if ($n_search <= $n_comparison) {
            $result = $sim/$n_search;
        } else {
            $result = $sim/$n_comparison;
        }

        return [
            'simtl_index' => $result,
            'sim_percent' => $percent
        ];
    }
}