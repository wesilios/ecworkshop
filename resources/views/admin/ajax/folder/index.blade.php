<h5>Folders</h5>
<div class="row">
	@if($folder_list)
		@foreach($folder_list as $fd)
			@if($folder->id != $fd->id)
				<a href="#" data-folder-id="{{ $fd->id }}" data-folder-slug="{{ $fd->slug }}" class="folder-link">
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