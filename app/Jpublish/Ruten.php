<?php

namespace App\Jpublish;

class Ruten implements Platform
{
    public function send()
    {
        return 'Ruten 已收到商品發佈通知';
    }
}