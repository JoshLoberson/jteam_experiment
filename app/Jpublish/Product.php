<?php

namespace App\Jpublish;

class Product
{
    private $platform;

    public function __construct(platform $platform)
    {
        $this->platform = $platform;
    }

    public function publish()
    {
        return $this->platform->send();
    }
}