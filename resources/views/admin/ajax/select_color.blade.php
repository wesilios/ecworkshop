<label>Màu đầu đốt</label>
{!! Form::select(
	'color_id[]',
	$colors,
	null,
	['class'=>'form-control select2-multi', 'multiple'=>'multiple']
	);
!!}