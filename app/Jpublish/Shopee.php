<?php

namespace App\Jpublish;

class Shopee implements Platform
{
    public function send()
    {
        return 'Shopee 已收到商品發佈通知';
    }
}