<?php

namespace App\Jcart;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;

class Cart
{
    private $session;

    private $instance;

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
        $this->instance = 'cart.default';
    }

    /**
     * 新增商品
     *
     * @param mixed     $id
     * @param mixed     $name
     * @param int|float $qty
     * @param float     $price
     * @return CartItem
     */
    public function addCart($id, $name = null, $qty = null, $price = null)
    {
        $cartItem = $this->createCartItem($id, $name, $qty, $price);
        $content = $this->getContent();
        $content->put($cartItem->itemId, $cartItem);
        $this->session->put($this->instance, $content);
        return $cartItem;
    }

    /**
     * 更新數量
     *
     * @param string $itemId
     * @param int|float  $qty
     * @return CartItem
     */
    public function updateQty($itemId, $qty)
    {
        $cartItem = $this->get($itemId);
        $cartItem->qty = $qty;
        $content = $this->getContent();

        if ($cartItem->qty <= 0) {
            $this->remove($cartItem->itemId);
            return;
        } else {
            $content->put($cartItem->itemId, $cartItem);
        }
        $this->session->put($this->instance, $content);
        return $cartItem;
    }

    /**
     * 移除商品
     *
     * @param string $itemId
     * @return void
     */
    public function removeItem($itemId)
    {
        $cartItem = $this->get($itemId);
        $content = $this->getContent();
        $content->pull($cartItem->itemId);
        $this->session->put($this->instance, $content);
    }

    /**
     * 清空購物車
     *
     * @return void
     */
    public function destroyCart()
    {
        $this->session->remove($this->instance);
    }

    /**
     * 取得商品
     *
     * @param string $itemId
     * @return CartItem
     */
    public function get($itemId)
    {
        $content = $this->getContent();
        if ( ! $content->has($itemId)){
            throw new \InvalidArgumentException("The cart does not contain itemId {$itemId}.");
        }
        return $content->get($itemId);
    }

    /**
     * 取得所有商品
     *
     * @return \Illuminate\Support\Collection
     */
    public function content()
    {
        if (is_null($this->session->get($this->instance))) {
            return new Collection([]);
        }
        return $this->session->get($this->instance);
    }

    /**
     * 取得購物車總共價格
     *
     * @return string
     */
    public function total()
    {
        $content = $this->getContent();
        $total = $content->reduce(function ($total, $item) {
            return $total + $item->qty * $item->price;
        });
        return $total;
    }

    /**
     * 取得購物車Collection物件
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getContent()
    {
        if ($this->session->has($this->instance)) {
            return $this->session->get($this->instance);
        }
        return new Collection;
    }

    /**
     * 新增一個購物車物件
     *
     * @param int     $id
     * @param string     $name
     * @param int|float $qty
     * @param float     $price
     * @return CartItem
     */
    private function createCartItem($id, $name, $qty, $price)
    {
        $cartItem = CartItem::buildCartItem($id, $name, $price);
        $cartItem->setQty($qty);
        return $cartItem;
    }
}
