<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jcart\Cart as Cart;

class QuestionController extends Controller
{
    public function q1($n=1)
    {
        if ($n<1) {
            return;
        }
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

    public function q2($action = "content", $itemId = null)
    {
        $cart = app(Cart::class);
        switch ($action) {
            case 'add':
                $cart->addCart('1', 'products name', 2, '399');
                break;
            case 'update':
                $cart->updateQty($itemId, 10);
                break;
            case 'remove':
                $cart->removeItem($itemId);
                break;
            case 'destroy':
                $cart->destroyCart();
                break;
            case 'get':
                dd($cart->get($itemId));
                break;
            case 'total':
                return $cart->total();
                break;
            default:
                break;
        }
        return $cart->content();
    }
}
