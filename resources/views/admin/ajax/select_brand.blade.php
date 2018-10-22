<label>Hãng sản phẩm</label>
{!! Form::select(
	'brand_id',
	$brands,
	null,
	['class'=>'form-control select2-single']
	);
!!}
@if ($errors->has('category_id'))
    <span class="help-block">
        <strong>{{ $errors->first('category_id') }}</strong>
    </span>
@endif