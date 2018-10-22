$(document).ready(function(){

	$('.btn-cart').click(function(event){
		var $this = $(this);
		var item_id = $this.attr("id");
		var token = $("input[name='_token']").val();
		var main_item_id = $('#hid_item_id_'+item_id).val();
        var item_category_id = $('#hid_category_id_'+item_id).val();
        //alert(item_category_id);
		/*$.post("cart/check/item", {
			item_id:item_id,
			main_item_id:main_item_id,
			item_category_id:item_category_id,
			_token:token
			},

			function(data){
				$('#ajax-location').html(data);
                $('.modal').modal();
		});*/

		$.ajax({
                url:"cart/check/item",
                method:'POST',
                dataType:'json',
                data:{
                    item_id:item_id,
					main_item_id:main_item_id,
					item_category_id:item_category_id,
					_token:token
                },
                success:function(data){
                	$('#img-model').attr({
                        src: data.img
                    });
                    $('#ajax-location').html(data.option);
                    $('#item_id').val(data.item_id);
                    $('#item_category_id').val(data.item_category_id);
                    $('#a-add-to-cart').attr({
                        href: "/cart/add/" + data.item_id_id
                    });
                    $('#quantity').val(1);
                	$('#item_check').modal();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                   console.log(xhr.status);
                   console.log(xhr.responseText);
                   console.log(thrownError);
               }
            });
		
	});

	$('.btn-add-cart').click(function(even){
		var item_id = $('#item_id').val();
        var item_category_id = $('#item_category_id').val();
        var quantity = $('#quantity').val();
        var token = $("input[name='_token']").val();
        var color = $("#color").val();
        if(color == undefined)
        {
            color = null;
        }
        $.ajax({
                url:"/cart/add/item",
                method:'POST',
                dataType:'json',
                data:{
                    item_id:item_id,
					item_category_id:item_category_id,
					quantity:quantity,
                    color:color,
					_token:token
                },
                success:function(data, textStatus, req){
                	$('#item_check').modal('hide');
                    $('#add_to_cart_notify').html(data.option);
                	$('#add_to_cart_notify').modal();
                    $('.badge').text(data.totalQty);
                    //alert(data.totalQty);
                	//alert(data.item_name);
                },
                error: function (xhr, ajaxOptions, thrownError) {
		           console.log(xhr.status);
		           console.log(xhr.responseText);
		           console.log(thrownError);
		       }
            });
	});

    $('.btn-add-buy-cart').click(function(even){
        var item_id = $('#item_id').val();
        var item_category_id = $('#item_category_id').val();
        var quantity = $('#quantity').val();
        var token = $("input[name='_token']").val();
        var color = $("#color").val();
        if(color == undefined)
        {
            color = null;
        }
        $.ajax({
                url:"/cart/add/item",
                method:'POST',
                dataType:'json',
                data:{
                    item_id:item_id,
                    item_category_id:item_category_id,
                    quantity:quantity,
                    color:color,
                    _token:token
                },
                success:function(data, textStatus, req){
                    window.location.href = data.route;
                    //alert(data.route);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                   console.log(xhr.status);
                   console.log(xhr.responseText);
                   console.log(thrownError);
               }
            });
    });

});