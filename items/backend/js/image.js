

$(document).ready(function()
{	
	filemanagerListeners();
	igniteImagemanager();
	uploadListeners();
	toggleImageListeners(true);
});

function igniteImagemanager()
{
//	$('#filemanager').button();
	$('#image_container').sortable(
	{
		handle: '.move',
	});
	//$('#image_container').disableSelection();
}

function filemanagerListeners()
{
	$('#filemanager').on('click', function()
	{
		//openFilemanager();
		$('#upload_input').click();
	});
	
	$('.save').on('click', function()
	{
		
		var type = $(this).attr('type');
		
		savePhotos(type);
	});
	
	$('.goback').on('click', function()
	{
		var type = $(this).attr('type');
		
		
		window.location.href = rootUrl + 'entities/Content/'+type;
	});
}
function uploadListeners()
{
	
	$('#upload_input').change(function()
	{
		var files = this.files;
		
		for(var i = 0; i< files.length; i++)
		{
			var xhr = new XMLHttpRequest();
			var fd = new FormData;
			fd.append('data', files[i]);
			fd.append('filename', files[i].name);
			fd.append('uploadpath', '/WIE/items/uploads/images/');
			xhr.addEventListener('load', function(e)  
			{
				console.log(e);
				var ret = $.parseJSON(this.responseText);
				
				if(ret.success)
				{
					addImage(ret);
					
				}
				else
				{
					alert('Error while uploading');
				}
		    });
			
			xhr.open('post', rootUrl + 'Backend/upload_image'); 
			xhr.send(fd);
		}
	
	});
}

function openFilemanager()
{
	$('#filemanPanel iframe').attr('src', rootUrl + 'items/exhibitionary/fileman/index.html');
	$('#filemanPanel').dialog({
		width: parseInt($(window).width() * 0.8),
		height: parseInt($(window).height() * 0.8),
		modal:true, 
	});
}

function closeFilemanager()
{
	$('#filemanPanel').dialog('destroy');
}

function addImage(imageData)
{
	var clone = $('.image.isTemplate').clone();
	clone.removeClass('isTemplate');
	clone.find('.imagefile').attr('src', imageData.path);
	clone.find('.imagefile').attr('fname', imageData.filename);
	$('#image_container').append(clone);
	toggleImageListeners(false);
	toggleImageListeners(true);
}


function toggleImageListeners(toggle)
{
	if(toggle)
	{
		$('#image_container .image .delete').on('click', function()
		{
			$(this).parent().parent().remove();
		});
	}
	else
	{
		$('#image_container .image .delete').off('click');
	}
}


function savePhotos(type)
{
	var i = 0;
	var photos = [];
	$('#image_container .image').each(function()
	{
		
		photos.push(
		{
			'ordering': i++,
			'fname': $(this).find('.imagefile').attr('fname'),
			'description': $(this).find('.imagetext').val(),
		});
	});
	
	
	
	switch(type)
	{
		case 'landing_page': {var url = 'save_photos'};break;
		case 'objekt': {var url = 'save_photos_object'};break;
		case 'lage': {var url = 'save_photos_lage'};break;
		case 'ausstattung': {var url = 'save_photos_aus'};break;
		case 'detail': {var url = 'save_photos_detail'};break;
	}
	
	$.ajax(
	{
		url: rootUrl + 'Backend/'+url,
		data: {
			'photos': photos, cv_id: cv_id, 
		},
		method: 'POST',
		success: function(data)
		{
			var ret = $.parseJSON(data);
			
			if(ret.success)
			{
				window.alert('Save successful!');
			}
			else
			{
				window.alert('Error while saving');
			}
		}
	});		
}