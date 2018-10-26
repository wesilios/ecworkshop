@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Danh sách slider
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Sliders</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
        <div class="row">
            <div class="col-xs-12">
				@php
            		$i = 1;
				@endphp
            	@if(session('status'))
            	<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                    {{ session('status') }}
                </div>
                @endif
                @if(session('delete'))
            	<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    {{ session('delete') }}
                </div>
                @endif
				<div class="box">
			        <div class="box-header">
			          	<h3 class="box-title">Danh sách slide ảnh</h3>
			        </div><!-- /.box-header -->
	       			<div class="box-body table-responsive no-padding table-bordered">
	          			<table class="table table-hover">
          					<tr>
								<th>#Id</th>
								<th>Tên slider</th>
								<th>Ngày tạo</th>
								<th>Ngày cập nhật</th>
								<th></th>
		                    </tr>
		                    <tr>
		                    	@if($sliders->count() > 0)
									@foreach($sliders as $slider)
										<tr>
											<td>{{ $i }}</td>
											<td>{{ $slider->name }}</td>
											<td>{{ $slider->created_at->diffForHumans() }}</td>
											<td>{{ $slider->updated_at->diffForHumans() }}</td>
											<td>
												<a href="{{ route('admin.sliders.edit', [$slider->id]) }}" class="btn btn-info btn-sm">Sửa</a>
											</td>
										</tr>
										@php
						            		$i++;
										@endphp
									@endforeach
								@else
								<td colspan="9" style="text-align:center">Chưa có slide ảnh nào</td>
		                    	@endif
		                    </tr>
		                </table>
		            </div>
		        </div>
            </div>
		</div>
	</section>
@endsection
