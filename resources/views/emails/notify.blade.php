<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <title></title>
    <style>
    	body {
			font-family: Roboto;
			padding: 0px 5px;
    	}

		div {
			display: block;
		}

    	h1, h2, h3, h4, h5 {
    		width: 100%;
    		margin: 5px 0px 15px;
    		display: block;
    	}

		.table-responsive table {
			width: 100%;
			font-size: 14px;
			border: 1px solid #9f0606;
			border-spacing: 0px;
		}

		.table-responsive > table > thead > tr {
			font-weight: 500;
			text-transform: uppercase;
		}

		.table-responsive > table > thead >tr > th {
			padding: 7px 5px;
			font-size: 15px;
			background-color: #9f0606;
			color: #ffffff;
		}

		.table-responsive > table > tbody >tr > td {
			padding: 7px 5px;
			border-top: 1px solid #dddddd;
		}
		
		.table-responsive > table > tbody >tr > td span{
			font-size: 12px;
		}

		.table-responsive > table > tfoot >tr > th {
			border-top: 1px solid #dddddd;
			font-size: 15px;
			padding: 5px 5px 5px 0px;
			font-weight: 500;
		}

		.top-nav > div.column-6 {
			display: block;
			position: relative;
		    min-height: 1px;
			width: 100%;
			float: none;
		}

		.div-logo {
			display: block;
		    height: 120px;
		    width: 150px;
		    padding: 2.5px 15px;
		    font-size: 18px;
		    line-height: 20px;
		    margin: 0px auto;
		}

		.div-logo .logo {
			width: 150px;
			margin: 0px auto;
		}

		.order-info {
			font-size: 14px;
			display: inline-block;
			margin: 25px 0px;
		}

		@media screen and (min-width: 768px) {
			.top-nav > div.column-6 {
				display: block;
				position: relative;
			    min-height: 1px;
				width: 50%;
				float: left;
			}

			.div-logo {
				display: inline-block;
			    height: 120px;
			    width: 150px;
			    padding: 2.5px 15px;
			    font-size: 18px;
			    line-height: 20px;
			    margin: 0px auto;
			}

			.div-logo .logo {
				width: 150px;
				margin: 0px auto;
			}

			.order-info {
				font-size: 14px;
				display: inline-block;
				margin: 25px 0px;
			}
		}

		footer {
			background-color: #9f0606;
			padding: 25px 0px;
			margin-top: 20px;
		}

		footer ul {
			padding: 5px 0px;
			border-top: 1px dashed;
			border-bottom: 1px dashed;
			border-color: #ffffff;
			width: 90%;
			margin: 0px auto;
		}

		footer ul > li {
			display: block;
			list-style-type: none; 
			padding: 5px 0px;
			border-right: 0px solid #ffffff;
			border: none;
			width: 100%;
			text-align: center;
		}

		footer ul > li:last-child {
			border: none;
		}

		footer ul > li a {
			color: #ffffff;
			font-size: 12px;
			text-decoration: none;
		}

		@media screen and (min-width: 768px) {

			footer ul {
				padding: 5px 15px;
				border-top: 1px dashed;
				border-bottom: 1px dashed;
				border-color: #ffffff;
				margin: 0px auto;
				width: auto;
			}

			footer ul > li {
				display: inline-block;
				list-style-type: none; 
				padding: 5px 15px;
				border-right: 1px solid #ffffff;
				width: 20%;
				text-align: center;
			}

			footer ul > li:last-child {
				border: none;
			}

			footer ul > li a {
				color: #ffffff;
				font-size: 12px;
				text-decoration: none;
			}

			body {
				font-family: Roboto;
				padding: 0px 15px;
	    	}
		}

    </style>
</head>
<body>
	<div class="top-nav">
		<div class="column-6">
			<div class="div-logo">
				<img class="img-responsive logo" src="{{ asset('images/black.png') }}"/>
			</div>
		</div>
		<div class="column-6 order-info">
			<table>
				<tr>
					<td style="width:40%"><strong>Tên khách hàng:</strong></td>
					<td>{{ $customer->name }}</td>
				</tr>
				<tr>
					<td><strong>Địa chỉ giao hàng:</strong></td>
					<td>{{ $order->address .', '. $order->district .', '. $order->city}}</td>
				</tr>
				<tr>
					<td><strong>Mã đơn hàng:</strong></td>
					<td><span style="color:#3097D1">{{ $order->orderCode }}</td>
				</tr>
				<tr>
					<td><strong>Ghi chú:</strong></td>
					<td>
						@if($order->note == null || $order->note == '')
						N/A
						@else
						{{ $order->note }}
						@endif
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="table-responsive">
		<table class="table table-order">
			<thead>
				<tr>
					<th>Sản phẩm</th>
					<th>Số lượng</th>
					<th style="text-align:right">Thành tiền</th>
				</tr>
			</thead>
			<tbody>
				@php
					$totalPrice = 0;
				@endphp
				@foreach($order->orderDetail as $item)
					@if($item->feature === null || $item->feature === '')
						<tr>
							<td>{{ $item->item_name }}</td>
							<td style="text-align:center">{{ $item->quantity }}</td>
							<td style="text-align:right">{{ number_format( $item->price , 0, ",",".") }} đ</td>
						</tr>
					@else
						<tr>
							<td>{{ $item->item_name }} <br>
								<span>--- Điểm đặc trưng: {{ $item->feature }}</span>
							</td>
							<td style="text-align:center">{{ $item->quantity  }}</td>
							<td style="text-align:right">{{ number_format( $item->price , 0, ",",".") }} đ</td>
						</tr>
					@endif
					@php
						$totalPrice += $item->price;
					@endphp
				@endforeach
				@php
					$shippingfee = $order->totalPrice - $totalPrice;
				@endphp
				<tr>
					<td colspan="2" style="text-align:center">Phí vận chuyển</td>
					<td style="text-align:right">{{ number_format( $shippingfee , 0, ",",".") }} đ</td>
				</tr>
			</tbody>
			<tfoot>

				<tr>
					<th colspan="2" style="text-align:center">Tổng tiền</th>
					<th style="text-align:right">{{ number_format( $order->totalPrice , 0, ",",".") }} đ</th>
				</tr>
			</tfoot>
		</table>
	</div>
	<footer>
		<h4 style="text-align:center;text-transform:uppercase;color:white">Điều khoản chung</h4>
		<ul>
			@foreach($menu->pages as $page)
				<li><a href="{{ route('items.cat.index',[$page['slug']]) }}">{{ $page['name']}}</a></li>
			@endforeach
		</ul>
	</footer>
	
</body>
</html>
