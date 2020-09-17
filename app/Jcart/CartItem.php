<?php

namespace App\Jcart;

class CartItem
{
    public $itemId;
    public $id;
    public $qty;
    public $name;
    public $price;

    /**
     * @param int|string $id
     * @param string     $name
     * @param float      $price
     */
    public function __construct($id, $name, $price)
    {
        if(empty($id)) {
            throw new \InvalidArgumentException('缺少id');
        }
        if(empty($name)) {
            throw new \InvalidArgumentException('缺少商品名');
        }
        if(strlen($price) < 0 || !is_numeric($price)) {
            throw new \InvalidArgumentException('缺少價格');
        }

        $this->id       = $id;
        $this->name     = $name;
        $this->price    = floatval($price);
        $this->itemId = $this->generateitemId($id);
    }

    /**
     * 設定數量
     *
     * @param int|float $qty
     */
    public function setQty($qty)
    {
        if(empty($qty) || !is_numeric($qty)) {
            throw new \InvalidArgumentException('缺少數量');
        }
        $this->qty = $qty;
    }

    /**
     * 新增CartItem
     *
     * @param int|string $id
     * @param string     $name
     * @param float      $price
     * @return CartItem
     */
    public static function buildCartItem($id, $name, $price)
    {
        return new self($id, $name, $price);
    }

    /**
     * 產生購物車用ID
     *
     * @param string $id
     * @return string
     */
    protected function generateitemId($id)
    {
        return md5($id.time());
    }

}
