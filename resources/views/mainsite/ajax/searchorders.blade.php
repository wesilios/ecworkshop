@if($orders->isNotEmpty())
    @foreach($orders as $order)
    <tr>
        <td><a href="{{ route('customer.order',[$order->orderCode]) }}">{{ $order->orderCode }}</a></td>
        <td style="text-align:center">{{ $order->totalQty }}</td>
        <td style="text-align:center">{{ number_format( $order->totalPrice , 0, ",",".") }} đ</td>
        <td style="text-align:right">{{ $order->status->name }}</td>
    </tr>
    @endforeach
@else
    <tr>
        <td colspan="4">Bạn chưa có đơn hàng nào</td>
    </tr>
@endif