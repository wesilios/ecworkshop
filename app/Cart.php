<?php

namespace App;

class Cart
{
    //
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
    	if($oldCart)
    	{
    		$this->items = $oldCart->items;
    		$this->totalQty = $oldCart->totalQty;
    		$this->totalPrice = $oldCart->totalPrice;
    	}
    }

    public function add($item, $id, $quantity, $color, $color_id, $size, $size_id)
    {
    	$storedColor = ['color'=>$color, 'quantity'=>0];
    	$storedSize = ['size'=>$size, 'quantity'=>0];
        $storedItem = ['quantity'=>0, 'price'=>0, 'item'=>$item, 'colors'=>[], 'sizes'=>[]];
    	if($this->items)
    	{
    		if(array_key_exists($id, $this->items))
    		{
    			$storedItem = $this->items[$id];
    		}
    	}

        if(array_key_exists($color_id, $storedItem['colors']))
        {
            $storedColor = $storedItem['colors'][$color_id];
        }

        if(array_key_exists($size_id, $storedItem['sizes']))
        {
            $storedSize = $storedItem['sizes'][$size_id];
        }

        if($item->price_off > 0 || $item->price_off != null)
        {
            $itemTruePrice = $item->price_off;
        }
        else
        {
            $itemTruePrice = $item->price;
        }

    	$storedItem['quantity'] += $quantity;
    	$storedItem['price'] = $itemTruePrice * $storedItem['quantity'];

        if($color_id === 0)
        {
           $storedColor['quantity'] = 0;
           $storedItem['colors'][$color_id] = [];
           $storedItem['sizes'][$size_id] = [];
        }
        else
        {
            $storedColor['quantity'] += $quantity;
            $storedItem['colors'][$color_id] = $storedColor;
            $storedItem['sizes'][$size_id] = $storedSize;
        }

    	$this->items[$id] = $storedItem;
    	$this->totalQty += $quantity;

        if($quantity > 0)
        {
            $this->totalPrice += $itemTruePrice * $quantity;
        }
        else
        {
            $this->totalPrice += $itemTruePrice;
        }

    }
}
