<tr>
	<th>#Id</th>
	<th>Mã đơn hàng</th>
	<th>Số lượng</th>
	<th>Tổng tiền</th>
	<th>Trạng thái</th>
	<th>Ngày đăng</th>
	<th>Action</th>
</tr>
<tr>
	@php
		$i = 1
	@endphp
	@if($orders->isNotEmpty())
		@foreach($orders as $order)
			<tr>
				<td>{{ $i }}</td>
				<td><a href="{{ route('admin.order',[$order->orderCode]) }}">{{ $order->orderCode }}</a></td>
				<td>{{ $order->totalQty }}</td>
				<td>{{ number_format($order->totalPrice,0, ",",".") }} đ</td>
				<td>
					@switch($order->order_status_id)
						@case(1)
							<a href="{{ route('admin.orders.status',[$order->order_status_id]) }}"><span class="label label-primary">{{ $order->status->name }}</span></a>
							@break
						@case(2)
							<a href="{{ route('admin.orders.status',[$order->order_status_id]) }}"><span class="label label-success">{{ $order->status->name }}</span></a>
							@break
						@case(3)
							<a href="{{ route('admin.orders.status',[$order->order_status_id]) }}"><span class="label label-info">{{ $order->status->name }}</span></a>
							@break
						@default
							<span class="label label-danger">Hủy</span>
							@break
					@endswitch
					
				</td>
				<td>{{ date("F jS, Y", strtotime($order->created_at)) }}</td>
				<td>
					<a href="{{ route('admin.order',[$order->orderCode]) }}" class="btn btn-info btn-sm"><i class="fa fa-eye "></i> Xem</a>
					<a href="#" data-toggle="modal" data-target="#delete" class="btn btn-danger btn-sm">
						<i class="fa fa-trash "></i> Xóa
					</a>
				</td>
			</tr>
			@php
        		$i++;
			@endphp
		@endforeach
	@else
		<tr>
			<td colspan="7" style="text-align:center">Không tìm thấy đơn hàng theo mã này!</td>
		</tr>
	@endif
</tr>