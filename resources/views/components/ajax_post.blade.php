<script>
	$('.custom-link').click(function(event){
			event.preventDefault();
			var datalabel = $(this).attr('data-label');
			var datatype = $(this).attr('data-type');
			$('.target-form').show();
			$('.tagert-label').text(datalabel);
			$('#target-type').val(datatype);
			$('#main-info').val('');
			$('#main-submit').prop( "disabled", true);
		});
		$('#main-info').keydown(function(event){
			var main_info = $(this).val();
			if(main_info.length > 0)
			{
				$('#main-submit').prop( "disabled", false);
			}
			else {
				$('#main-submit').prop( "disabled", true);
			}
		});

		$('#main-submit').click(function(event){
			event.preventDefault();
			var token = $("input[name='_token']").val();
			var type = $("#target-type").val();
			var post_value = $('#main-info').val();
			$.ajax({
                url:"{{ route('admin.ajax.post') }}",
                method:'POST',
                dataType:'json',
                data:{
                    type:type,
					post_value:post_value,
					_token:token
                },
                success:function(data){
                	if(data.colors == 0 && data.juice_sizes == 0)
                	{
                		$('#select_brand_div').html('');
                		$('#select_brand_div').html(data.brands);
                	}

                	if(data.brands == 0 && data.juice_sizes == 0)
                	{
                		$('#select_color_div').html('');
                		$('#select_color_div').html(data.colors);
                	}

                	if(data.brands == 0 && data.colors == 0)
                	{
                		$('#select_juice_size_div').html('');
                		$('#select_juice_size_div').html(data.juice_sizes);
                	}

                	$('.select2-multi').select2();
					$('.select2-single').select2();
					$('.alert').show();
					$('.target-form').hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                   console.log(xhr.status);
                   console.log(xhr.responseText);
                   console.log(thrownError);
               }
            });
		});
</script>