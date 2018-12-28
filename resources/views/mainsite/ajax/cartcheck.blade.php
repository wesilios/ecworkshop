<div class="item_name_nw">{{ $item->brand->name . ' ' .$item->name }}</div>
<div class="item_des_nw">{{ $item->summary }}</div>
<hr>
<div class="item_price_nw">Giá:
	@if($item->price_off > 0 || $item->price_off != null)
        {{ number_format($item->price_off,0, ",",".") }} VNĐ
        <span style="font-size:13px;color:#333333;text-decoration:line-through;">
        	{{ number_format($item->price,0, ",",".") }} VNĐ
        </span>

    @else
        {{ number_format($item->price,0, ",",".") }} VNĐ
    @endif
</div>
<div class="item_status_nw">{{ $item->itemStatus->name }}</div>
@if($item->sizes->isNotEmpty())
    <div class="newform">
        <select name="size" id="size">
            @foreach($item->sizes as $sz)
                <option value="{{ $sz->id }}">{{ $sz->name }}</option>
            @endforeach
        </select>
    </div>
<div class="item_size_nw"><span>{{ $item->size->name }}</span></div>
@else
@endif
@if($item->colors->isNotEmpty())
<div class="newform">
    <select name="color" id="color">
        @foreach($item->colors as $color)
        <option value="{{ $color->id }}">{{ $color->name }}</option>
        @endforeach
    </select>
</div>
@else
@endif