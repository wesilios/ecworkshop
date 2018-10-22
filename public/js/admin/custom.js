window.URL = window.URL || window.webkitURL;
$(document).ready(function(){
	$('.media-addnew').click(function(event){
		event.preventDefault();
		$('.uploadZone').show();
		$('.box-hidden').show();
	});
	$('.closeZone').click(function(event){
		event.preventDefault();
		$('.uploadZone').hide();
		$('.box-hidden').hide();
	});

	$('.selectFile').click(function(event){
		event.preventDefault();
		$('#form-file-hidden').click();
	});
	$('#form-file-hidden').change(function(event){
		var $this = $(this);
		var files = $this.prop('files');
		function validate(file)
		{
			var allowedExtension = ['jpeg','jpg', 'png', 'bmp', 'gif'];
            var fileExtension= file.split('.').pop().toLowerCase();
            var isValidFile = false;
            for(var index in allowedExtension) {
                if(fileExtension === allowedExtension[index]) {
                    isValidFile = true;
                    break;
                }
            }
	        return isValidFile;
		}
		if (!files.length) {
			alert("No image selected");
		}
		else{
			for (var i = 0; i < files.length; i++) 
			{
	            if(validate(files[i].name) === true)
	            {
	            	var src = window.URL.createObjectURL(files[i]);

					var col_sm_2 = document.createElement("div");
					col_sm_2.className = 'col-sm-2';
					$("#preview-image").append(col_sm_2);

					var thumbnails_img = document.createElement("div");
					thumbnails_img.className = 'thumbnails_img';
					thumbnails_img.style.backgroundImage = "url("+src+")";
					col_sm_2.append(thumbnails_img);
	            }
	            else{
	            	alert('Allowed Extensions are : *.' + allowedExtension.join(', *.'));
	            }
			}
		}
		
	});

	$('.selectImgA').click(function(event){
		event.preventDefault();
		var id = $(this).attr('id');
		var btn = "#selectImgbtn";
		$(btn.concat(id)).click();
	});

	$('.selectMultImgA').click(function(event){
		event.preventDefault();
		var id = $(this).attr('id');
		//alert(id);
		var thumbnails_img = "#thumbnails_img";
		$(thumbnails_img.concat(id)).toggleClass('active');

		if($("#selForm option[value='"+ id +"']").attr("selected"))
		{
			$("#selForm option[value='"+ id +"']").attr("selected", false);
		}
		else
		{
			$("#selForm option[value='"+ id +"']").attr("selected", true);
		}
		
	});

	$('.selectImgIndex').click(function(event){
		event.preventDefault();
		var id = $(this).attr('id');
		//alert(id);
		var thumbnails_img = "#thumbnails_index_img";
		$('.thumbnails_img').removeClass('active');
		$(thumbnails_img.concat(id)).toggleClass('active');
		$("#selIndexImgForm option").attr("selected", false);
		$("#selIndexImgForm option[value='"+ id +"']").attr("selected", true);
	});
});