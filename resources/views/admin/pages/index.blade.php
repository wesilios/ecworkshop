@extends('layouts.adminapp')

@section('content')
	<section class="content-header">
		<h1>
			Tất cả trang
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Tất cả trang</li>
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
			          	<h3 class="box-title">Danh sách trang</h3>
			        </div><!-- /.box-header -->
	       			<div class="box-body table-responsive no-padding">
	          			<table class="table table-hover">
          					<tr>
								<th>#Id</th>
								<th>Tên trang</th>
								<th>Trang cha(nếu có)</th>
								<th>Slug</th>
								<th>Ngày đăng</th>
								<th>Đăng bởi</th>
								<th></th>
		                    </tr>
		                    <tr>
		                    	@if($pages->count() > 0)
									@foreach($pages as $page)
										<tr>
											<td>{{ $i }}</td>
											<td>{{ $page->name }}</td>
											<td>{{ $page->page_id != 0 ? $page->pageParent->name : 'Không có trang cha' }}</td>
											<td>{{ $page->slug }}</td>
											<td>{{ date("F jS, Y", strtotime($page->created_at)) }}</td>
											<td>{{ $page->admin->name }}</th>
											<td>
												<a href="" class="btn btn-default btn-sm">Xem</a>
												<a href="{{ route('pages.edit',[$page->id]) }}" class="btn btn-default btn-sm">Sửa</a>
											</td>
										</tr>
										@php
						            		$i++;
										@endphp
									@endforeach
								@else
								<td colspan="9" style="text-align:center">Chưa có trang nào</td>
		                    	@endif
		                    </tr>
		                </table>
		                <div class="text-center">
		                	{!! $pages->links()!!}
		                </div>
		            </div>
		        </div>
		        <a href="{{ route('pages.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> Thêm trang mới</a>
            </div>
		</div>
	</section>
@endsection
