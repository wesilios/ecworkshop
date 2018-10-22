<div class="item_name_nw">{{ $item->brand->name . ' ' .$item->item->name }}</div>
<div class="item_des_nw">{{ $item->item->summary }}</div>
<hr>
<div class="item_price_nw">Giá: 
	@if($item->item->price_off > 0 || $item->item->price_off != null)
        {{ number_format($item->item->price_off,0, ",",".") }} VNĐ
        <span style="font-size:13px;color:#333333;text-decoration:line-through;">
        	{{ number_format($item->item->price,0, ",",".") }} VNĐ
        </span>
        
    @else
        {{ number_format($item->item->price,0, ",",".") }} VNĐ
    @endif
</div>
<div class="item_status_nw">{{ $item->item->itemStatus->name }}</div>
@if($size != null)
<div class="item_size_nw"><span>{{ $item->size->name }}</span></div>
@else
@endif
@if($colors != null && $colors->isNotEmpty())
<div class="newform">
    <select name="color" id="color">
        @foreach($item->colors as $color)
        <option value="{{ $color->id }}">{{ $color->name }}</option>
        @endforeach
    </select>
</div>
@else
@endif