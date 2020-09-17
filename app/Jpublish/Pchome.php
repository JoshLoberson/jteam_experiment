<?php

namespace App\Jpublish;

class Pchome implements Platform
{
    public function send()
    {
        return 'Pchome 已收到商品發佈通知';
    }
}