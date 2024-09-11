var item_activate_delay = false;

/***********************************
 * DEVICE SPECIFIC
 ************************************/

function toggleHandheldListeners(toggle)
{
	if(toggle)
	{
		$('.item').on('click', function(event)
		{
			if(!item_activate_delay)
			{
				item_activate_delay = true;
				setTimeout(function()
				{
					item_activate_delay = false;
				}, 100);
				canvasItemClickHandheld(event);
			}
			
		});
	}
	else
	{
		$('.item').off('touchend');
	}
}


function canvasItemClickHandheld(event)
{
	if(!dragging)
	{
		
		item = findHoverItem(event.pageX, event.pageY);
		
		if(item != null && item.attr('item_id') != 'null' && !item.hasClass('item continent_center'))
		{
			changeItemStatus($('.item[status="active"][item_id!="' + item.attr('item_id') + '"]'), 'inactive');
			
			if(item.attr('status') == 'active')
			{
				itemView(item.attr('item_id'));
			}
			else
			{
				changeItemStatus(item, 'active');
				toggleTooltip(item.attr('tt_header_' + language), event.pageX+10, event.pageY+10);
			}
		}
	}
}

/***********************************
 * OVERWRITING FROM DESKTOP.JS
 ************************************/