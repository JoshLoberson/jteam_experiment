<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function q1($n=0)
    {
        // 迭代效能優於遞迴
        for ($i=1; $i <= $n; $i++) {
            if ($i > 2) {
                $arr[$i] = $arr[$i-1] + $arr[$i-2];
            }else{
                $arr[$i] = $i;
            }
        }
        return $arr[$n];
    }
}
