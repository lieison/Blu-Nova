/*** * @@EDIT * @param {type} param * @@CATEGORIA PARATE DEL FRONT-END  */jQuery(document).ready(function(){	design.products.inicategory();});//ROLI -- PRODUCT CATEGORY design.products.inicategory = function(){	jQuery.ajax({		type: "POST",		dataType: "json",		url: baseURL + "ajax.php?type=categories",	}).done(function( data ) {		if (typeof data.categories != 'undefined' && data.categories != '')		{			var html = '<select data-level="1" id="parent-categories-1" class="form-control input-sm" onchange="design.products.changeCategory(this)"><option value="0"> '+lang.designer.category+' </option>';			for(i=0; i<data.categories.length; i++)			{				html = html + '<option value="'+data.categories[i].id+'">'+data.categories[i].title+'</option>';			}			jQuery('#list-categories').html('<div class="col-xs-4 col-md-12">'+html+'</div>');		}	});}