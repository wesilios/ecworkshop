<?php

namespace App;

class ItemSearch
{
    //
    public $items = null;

    public function __construct($oldItem)
    {
    	if($oldItem)
    	{
    		$this->items = $oldItem->items;
    	}
    }

    public function add($item, $id, $itemSub, $item_category_id)
    {
        $storedItem = ['item'=>$item, 'itemSub'=>$itemSub, 'item_category_id'=>$item_category_id];
    	if($this->items)
    	{
    		if(array_key_exists($id, $this->items))
    		{
    			$storedItem = $this->items[$id];
    		}
    	}
        
    	$this->items[$id] = $storedItem;	
    }
}
