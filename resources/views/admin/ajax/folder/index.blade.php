<h5>Folders</h5>
<div class="row">
	@if($folder_list)
		@foreach($folder_list as $fd)
			@if($folder->id != $fd->id)
				<a href="{{ route('admin.folder.show',['id'=>$fd->id,'slug'=>$fd->slug])  }}" data-folder-id="{{ $fd->id }}" data-folder-slug="{{ $fd->slug }}" class="folder-link">
					<div class="col-md-2">
						<div class="folder">
							<i class="fa fa-folder"></i> <span>{{ $fd->name }}</span>
						</div>
					</div>
				</a>
			@endif
		@endforeach
	@endif
</div>

<script type="text/javascript">
	$('.folder-link').click(function(e) {
			e.preventDefault();
			$(this).toggleClass('active');
		});

		$('.folder-link').dblclick(function(e){
			var href = $(this).attr('href');
			window.location = href;
		});
</script>