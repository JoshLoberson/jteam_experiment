<?php

namespace App\Jpublish;

class Yahoo implements Platform
{
    public function send()
    {
        return 'Yahoo 已收到商品發佈通知';
    }
}