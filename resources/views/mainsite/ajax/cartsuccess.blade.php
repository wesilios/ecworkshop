<div class="modal-dialog modal_add_to_cart">
    <!-- Modal content-->
    <div class="modal-content">
        <!--<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modal Header</h4>
        </div>-->
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-5">
                    <img class="img-responsive img-item img-hover" src="{{ asset($url) }}" alt="" id="img_item_preview">
                </div>
                <div class="col-lg-7">
                    <div class="item_name_nw" id="title_item_preview">{{ $item->brand->name . ' ' .$item->name }}</div>
                    <div class="item_des_nw" id="quantity_item_preview">Số lượng: {{ $quantity }}</div>
                    <div class="item_price_nw" id="total_item_preview">
                        @if($item->price_off > 0 || $item->price_off != null)
                            {{ number_format($item->price_off,0, ",",".") }} VNĐ
                        @else
                            {{ number_format($item->price,0, ",",".") }} VNĐ
                        @endif
                    </div>
                    <button type="button" class="btn btn-primary btn-continue" data-dismiss="modal">Tiếp tục mua hàng</button>
                    <a href="{{route('cart.index')}}" type="button" class="btn btn-primary btn-check-out">Thanh toán</a>
                </div>
            </div>
        </div><!-- /modal-body -->
    </div><!-- /modal-content -->
</div><!-- /modal-dialog -->