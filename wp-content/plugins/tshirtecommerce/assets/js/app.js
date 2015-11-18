var app = {
	admin:{
		ini: function(){
			jQuery('#designer-products .tab-content a.modal-link').click(function(){
				var link = jQuery(this).attr('href');
				if(jQuery(this).hasClass('add-link'))
					app.admin.add(this);
				else
					app.admin.load(link);
				return false;
			});
		},
		product: function(e, index){
			if (document.getElementById('designer-products') == null)
			{
				var div = '<div class="modal fade" id="designer-products" tabindex="-1" role="dialog" style="z-index:10520;" aria-labelledby="myModalLabel" aria-hidden="true">'
						+ '<div class="modal-dialog modal-lg" style="width: 95%;">'
						+ 	'<div class="modal-content">'
						+		'<div class="modal-header">'
						+			'<button type="button" data-dismiss="modal" class="close close-list-design">'
						+				'<span aria-hidden="true">×</span>'
						+				'<span class="sr-only">Close</span>'
						+			'</button>'
						+		'</div>'
						+ 		'<div class="modal-body">'
						+		'&#65279;<center><h3>Please wait some time. loading...</h3></center>'
						+		'</div>'
						+	'</div>'
						+ '</div></div>';
				jQuery('body').append(div);
			}
			jQuery('#designer-products').modal('show');			
			var key = e.getAttribute('key');			
			var data = {};
			data.key	= key;
			data.action = 'designer_action';
			var link = ajaxurl.split('wp-admin');
			
			if (index == 0)
				var url = link[0]+'tshirtecommerce/admin-blank.php';
			else if (index == 2)
				var url = link[0]+'tshirtecommerce/admin-users.php';
			else
				var url = link[0]+'tshirtecommerce/admin.php';
			jQuery.post(url, data, function(response) {			
				jQuery('#designer-products .modal-body').html(response);
				app.admin.ini();
			});
			return false; 
		},
		load: function(link)
		{
			var data = {};
			data.key	= '1';
			data.action = 'designer_action';
			data.link = link;
			var link = ajaxurl.split('wp-admin');
			var url = link[0]+'tshirtecommerce/admin.php';
			jQuery('#designer-products .modal-body').html('&#65279;<center><h3>Please wait some time. loading...</h3></center>');
			jQuery.post(ajaxurl, data, function(response) {
				jQuery('#designer-products .modal-body').html(response);				
				app.admin.ini();
			});
			return false; 
		},
		add: function(e)
		{
			var id = jQuery(e).data('id');
			var title = jQuery(e).data('title');
			var img = jQuery(e).children('img').attr('src');
			document.getElementById('_product_id').value = id;
			document.getElementById('_product_title_img').value = title +'::'+ img;
			
			var html = '<img src="'+img+'" class="img-responsive" alt="'+title+'">';
			html = html + '<br /><center>'+title+'</center>';
			
			jQuery('#add_designer_product').html(html);
			
			jQuery('#designer-products').modal('hide');
		},
		clear: function(){
			var check = confirm('You sure want clear this product?');
			if (check == true)
			{
				document.getElementById('_product_id').value = '';
				document.getElementById('_product_title_img').value = '';
				jQuery('#add_designer_product').html('');
			}
		}
	},
	cart: function(content){
		var data = {
			action: 'woocommerce_add_to_cart',
			product_id: content.product_id,
			quantity: content.quantity,
			price: content.price,
			rowid: content.rowid,
			color_hex: content.color_hex,
			color_title: content.color_title,
			teams: content.teams,
			options: content.options,
			images: content.images			
		};
		
		if (typeof product_variation != 'undefined' && product_variation > 0)
		{
			data.variation_id = product_variation;
			data.action = 'woocommerce_add_to_cart_variable_rc';
		}
		if (typeof product_attributes != 'undefined')
		{
			data.variation = product_attributes;
		}
		jQuery.ajax({
			url: wp_ajaxurl,
			method: "POST",
			data: data
		}).done(function(response) {
			if(response != 0) {
				window.location.href = woo_url_cart;
			}
		});
	}
}

function variationProduct(e)
{
	var variation_form = jQuery(e).parents('.variations_form');
	
	var variation_id = variation_form.find('.variation_id').val();
	
	var item = '';
	
	variation_form.find('select[name^=attribute]').each(function() {
		var attribute = jQuery(this).attr("name");
		var attributevalue = jQuery(this).val();
		if (item == '')
			item = '&attributes=' + attribute +'|'+ attributevalue;
		else
			item = item +';'+ attribute +'|'+ attributevalue;
	});
	var product_id = variation_form.find( 'input[name=product_id]' ).val();
	if (product_id == '')
		product_id = variation_form.data('product_id');
	if (typeof product_id == 'undefined') product_id = '';
	
	var link = jQuery('.product-design-link').val();
	if (link != '' && product_id != '')
	{
		if (link.indexOf('?') == -1)
		{
			link = link + '?product_id='+product_id+'&variation_id='+variation_id +item;
		}
		else
		{
			link = link + '&product_id='+product_id+'&variation_id='+variation_id +item;
		}
		window.location.href = link;
	}
}

function setHeigh(height){
	height = height + 10;
	document.getElementById('tshirtecommerce-designer').setAttribute('height', height + 'px');
}

function viewBoxdesign(){
	var width = jQuery(document).width();
	var height = jQuery(document).height();
	if (width < 700 || height < 300)
	{
		var url = urlDesignload.replace('index.php', 'mobile.php');
		jQuery('body').append('<div id="modal-design-bg"></div><div id="modal-designer"><a href="'+urlBack+'" class="btn btn-dange btn-xs">Close</a><iframe id="tshirtecommerce-designer" scrolling="no" frameborder="0" width="100%" height="100%" src="'+url+'"></iframe></div>');
	}
	else
	{
		jQuery('.row-designer').html('<iframe id="tshirtecommerce-designer" scrolling="no" frameborder="0" noresize="noresize" width="100%" height="100%" src="'+urlDesignload+'"></iframe>');
	}
}
jQuery(document).ready(function(){
	if (jQuery('.row-designer').length > 0)
	{
		viewBoxdesign();
	}
});