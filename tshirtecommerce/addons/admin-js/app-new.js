var sizesCn = {};
jQuery(document).ready(function(){
	jQuery('#app-wrap .labView').append('<div class="mask-items-view"><div class="mask-items-area"><div class="mask-item"></div></div></div>');
		
	jQuery.each(['front', 'back', 'left', 'right'], function(i, view){
		if (items.area[view] != '' && items.area[view] != '')
		{
			var params = eval ("(" + items.params[view] + ")");
			var area = eval ("(" + items.area[view] + ")");
			
			sizesCn[view] =  params.width / area.width;
		}
		
	});	
});

jQuery(document).on('move.tool.design', function(event, elm){
	var style = jQuery(elm).attr('style');
	jQuery(elm).parents('.labView').find('.mask-item').attr('style', style);
});

jQuery(document).on('select.item.design', function(event, e){
	
	var id = jQuery('.labView.active').attr('id');
	var view = id.replace('view-', '');
	
	if (jQuery(e).length == 0)
	{
		var elm = design.item.get();
		var e = elm[0];
	}
	if (typeof e == 'undefined') return;
	var style = jQuery(e).parents('.design-area').attr('style');
	jQuery(e).parents('.labView').find('.mask-items-area').attr('style', style);
	jQuery(e).parents('.labView').find('.mask-items-view').css('display', 'block');
	
	var style = jQuery(e).attr('style');
	var item = jQuery(e).parents('.labView').find('.mask-item');
	item.attr('style', style);
	
	// update size of item
	if (jQuery('.labView.active .mask-item .item-info').length == 0)
	{
		item.append('<span class="item-info"></span>');
	}
	
	if (jQuery('.labView.active .mask-item .item-mask-move').length == 0)
	{
		item.append('<div class="item-mask-move fa fa fa-arrows"></div>');
	}
	var width = jQuery(e).width() * sizesCn[view];
	width = width.toFixed(1);
	var height = jQuery(e).height() * sizesCn[view];
	height = height.toFixed(1);
	jQuery('.labView.active .mask-item .item-info').html(width +' x '+ height);
	
	// resize
	var type = item.data('type');
	if(jQuery('#'+type+'-lock').length && jQuery('#'+type+'-lock').is(':checked') == true)
	{
		var auto = false;
	}
	else
	{
		var auto = true;
	}
	item.resizable({
		minHeight: 15, 
		aspectRatio: auto,
		minWidth: 15,		
		handles: "se",
		grid: 1,
		alsoResize: ".drag-item.drag-item-selected",
		start: function( event, ui ){
		},
		stop: function( event, ui ) {
			jQuery(document).triggerHandler( "resize.item.design", ui);
			design.print.size();
			design.ajax.getPrice();
		},
		resize: function(event,ui){
			var $left = parseInt(ui.position.left),
				$top = parseInt(ui.position.top),
				$width = parseInt(ui.size.width),
				$height = parseInt(ui.size.height);
				
			var svg = jQuery(e).find('svg');									
					
			svg[0].setAttributeNS(null, 'width', $width);
			svg[0].setAttributeNS(null, 'height', $height);		
			svg[0].setAttributeNS(null, 'preserveAspectRatio', 'none');					
			
			if(jQuery(e).data('type') == 'clipart')
			{
				var file = jQuery(e).data('file');
				if(file.type == 'image')
				{	
					var img = jQuery(e).find('image');
					img[0].setAttributeNS(null, 'width', $width);
					img[0].setAttributeNS(null, 'height', $height);
				}
			}
			
			var width = $width * sizesCn[view];
			width = width.toFixed(1);
			var height = $height * sizesCn[view];
			height = height.toFixed(1);
			jQuery('.labView.active .mask-item .item-info').html(width +' x '+ height);
		}
	});
	
	var top = 0, left = 0;	
	item.draggable({
		scroll: false,
		start: function( event, ui ){
			top = ui.position.top;
			left = ui.position.left;
		},
		drag:function(event, ui){
			jQuery(e).css('left', ui.position.left);
			jQuery(e).css('top', ui.position.top);
		},
		stop: function( event, ui ) {
			var width = jQuery(this).width();
			var height = jQuery(this).height();
			var areaW = jQuery(this).parent().width();
			var areaH = jQuery(this).parent().height();
			if (
				(ui.position.left + width) < 5 
				|| (ui.position.top + height) < 5
				|| (ui.position.left + 5) > areaW
				|| (ui.position.top + 5) > areaH
			)
			{
				jQuery(e).css('left', left);
				jQuery(e).css('top', top);
				jQuery(this).css('left', left);
				jQuery(this).css('top', top);
			}
			jQuery(document).triggerHandler( "move.item.design", ui);
			design.ajax.getPrice();
		}
	});
	
	// add remove button
	if(e.item.remove != false)
	{
		if (jQuery('.labView.active .mask-item .item-mask-remove-on').length == 0)
		{
			var div = document.createElement('div');
			div.className = 'item-mask-remove-on fa fa-trash-o';
			div.setAttribute('title', lang.text.remove);
			div.setAttribute('onclick', 'design.item.mask.remove()');
			jQuery(item).append(div);		
		}		
	}
	
	// rotate
	if(typeof e.item.rotate != 'undefined' && e.item.rotate == true)
	{
		var deg = item.data('rotate');
		if (typeof deg == 'undefined') deg = 0;
		
		item.rotatable({
			angle: deg, 
			rotate: function(event, angle){
				var deg = parseInt(angle.r);
				if(deg < 0) deg = 360 + deg;
				jQuery('#' + type + '-rotate-value').val(deg);
				jQuery(e).data('rotate', deg);
				
				var radian = deg * Math.PI / 180;
				//jQuery(e).rotatable("setValue", radian);
				design.item.mask.rotate(jQuery(e), radian);
			}
		});
	}
	
	
	jQuery(e).draggable({ disabled: true });
});

jQuery('.rotate-refresh').click(function(){
	design.item.refresh('rotate');
	jQuery('.labView.active .mask-item').css('transform', 'rotate(0rad)');
});

jQuery('.rotate-value').on("focus change", function(){
	var e = design.item.get();
	var deg = jQuery(this).val();
	if(deg > 360) deg = 360;
	if(deg < 0) deg = 0;
	var angle = (jQuery(this).val() * Math.PI)/180;
	e.rotatable("setValue", angle);
	
	design.item.mask.rotate(jQuery('.labView.active .mask-item'), angle);
});

// remove name, number
jQuery(document).on('remove.team.design', function(event){
	jQuery('.mask-items-view').css('display', 'none');
});

jQuery(document).on('unselect.item.design remove.item.design', function(event, e){
	var item = jQuery('.labView.active .mask-items-view');
	item.css('display', 'none');
});

jQuery(document).on('size.update.text.design', function(event, w, h){
	jQuery('.labView.active .mask-item').css({'width':w+'px', 'height':h+'px'});
});

design.item.mask = {
	remove: function(){
		var e = design.item.get();
		var elm = e.children('.item-remove-on');
		if (elm.length > 0)
		{
			design.item.remove(elm[0]);			
		}
	},
	rotate: function(el, angle){
		el.css('transform','rotate(' + angle + 'rad)');
		el.css('-moz-transform','rotate(' + angle + 'rad)');
		el.css('-webkit-transform','rotate(' + angle + 'rad)');
		el.css('-o-transform','rotate(' + angle + 'rad)');
	}
};