(function($) {
	"use strict";
	
	jQuery(document).ready(function(){
		jQuery('.quickviewbtn .quickview').each(function(){
			roadtip(jQuery(this), 'html');
		});
		//Header Search by category
		var cateToggler = jQuery('.cate-toggler');
		
		jQuery('.header-search .product-categories').prepend('<li><a href="'+jQuery('#searchform').attr('action')+'">'+cateToggler.html()+'</a></li>');
		
		cateToggler.on('click', function(){
			jQuery('.header-search .product-categories').toggleClass('open');
		});
		
		/* Init values */
		var searchCat = ''; //category to search, set when click on a category
		var currentCat = RoadgetParameterByName( 'product_cat', jQuery('.header-search .product-categories .current-cat a').attr('href') ); /* when SEO off */
		var currentCatName = jQuery('.current-cat a').html();
		
		if(currentCatName!=''){
			cateToggler.html(currentCatName);
			
			//change form action when click submit
			jQuery('#wsearchsubmit').on('click', function(){
				if( searchCat==''){
					jQuery('#searchform').attr( 'action', jQuery('.header-search .product-categories .current-cat a').attr('href') );
				}
			});
		}
		if(currentCat!='') {
			/* when SEO off, we need product_cat */
			if( !(jQuery('#product_cat').length > 0) ) {
				jQuery('#searchform').append('<input type="hidden" id="product_cat" name="product_cat" value="'+currentCat+'" />');
			}
			jQuery('#product_cat').val(currentCat);
		}
		
		jQuery('.header-search .product-categories a').each(function(){
			jQuery(this).on('click', function(event){
				event.preventDefault();
				
				jQuery('.header-search .product-categories a.active').removeClass('active');
				jQuery(this).addClass('active');
				jQuery('.header-search .product-categories').removeClass('open');
				jQuery('#searchform').attr( 'action', jQuery(this).attr('href') );
				cateToggler.html(jQuery(this).html());
				searchCat = jQuery(this).attr('href');
				
				/* when SEO off, we need product_cat */
				if( !( jQuery('#product_cat').length > 0) && ( RoadgetParameterByName( 'product_cat', jQuery(this).attr('href') ) != '' ) ) {
					jQuery('#searchform').append('<input type="hidden" id="product_cat" name="product_cat" value="" />');
				}
				jQuery('#product_cat').val( RoadgetParameterByName( 'product_cat', jQuery(this).attr('href') ) );
			});
		});
		
		//Product Tabs - noSlider
		jQuery('.new-products .wpb_wrapper > h3').each(function(){
			var newProductsTitle = jQuery(this).html();
			jQuery(this).html('<span>'+newProductsTitle+'</span><i class="cross-icon"><i></i></i>');
		});
		window.setTimeout(function(){
			var tabCount = 1;
			var tabTotal = jQuery('.home-tabs-noslider .wpb_content_element').length;
			jQuery('.home-tabs-noslider').prepend('<div class="container"><ul class="home-tabs-title"></ul></div>');
			var tabTitle = jQuery('.home-tabs-noslider .home-tabs-title');
			jQuery('.home-tabs-noslider .wpb_content_element').each(function(){
				var tabClass = '';
				var tabLinkClass = '';
				var tabWidget = jQuery(this);
				var widgetTitle = tabWidget.find('h3').html();
				tabWidget.attr('id', 'wpb_content_element-'+tabCount);
				
				if(tabCount==1) {
					tabClass = 'first';
					tabLinkClass = 'active';
					
					tabWidget.addClass('active');
					 
				} else {
					jQuery(this).addClass('heightzero');
				}
				if(tabCount == tabTotal) {
					tabClass = 'last';
				}
				
				tabTitle.append('<li class="'+tabClass+'"><a class="tab-link '+tabLinkClass+'" href="#" rel="wpb_content_element-'+tabCount+'">'+widgetTitle+'</a></li>');
				
				tabCount++;
				
				//tab click
				jQuery('.home-tabs-noslider .tab-link').each(function(){
					jQuery(this).on('click', function(event){
						event.preventDefault();
						var tabRel = jQuery(this).attr('rel');
						
						jQuery('.home-tabs-noslider .tab-link').removeClass('active');
						jQuery(this).addClass('active');
						
						jQuery('.home-tabs-noslider .wpb_content_element').addClass('heightzero');
						jQuery('#'+tabRel).removeClass('heightzero');
						
						jQuery('.home-tabs-noslider .wpb_content_element').removeClass('active');
						jQuery('#'+tabRel).addClass('active');
						 
					});
				});
			});
			
		}, 1000 );
		
		//Products carousel
		jQuery('.products-carousel .wpb_wrapper > h3').each(function(){
			var pwidgetTitle = jQuery(this).html();
			jQuery(this).html('<span>'+pwidgetTitle+'</span>');
		});
		jQuery('.products-carousel .shop-products').slick({
			infinite: false,
			slidesToShow: 4,
			slidesToScroll: 1,
			speed: 500,
			easing: 'linear',
			swipeToSlide: true,
			autoplaySpeed: 1000,
			responsive: [
				{
				  breakpoint: 1200,
				  settings: {
					slidesToShow: 4,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 992,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 767,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
			]
		});
	});

})(jQuery);