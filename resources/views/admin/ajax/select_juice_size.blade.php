<label>Dung tích</label>
{!! Form::select(
	'size_id',
	$juice_sizes,
	null,
	['class'=>'form-control select2-multi']
	);
!!}