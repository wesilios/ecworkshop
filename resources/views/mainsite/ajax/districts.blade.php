<option value="0">-- Quận/Huyện --</option>
@if(!empty($districts))
  	@foreach($districts as $key => $value)
    	<option value="{{ $key }}">{{ $value }}</option>
  	@endforeach
@else
	<option value="he">Test</option>
@endif