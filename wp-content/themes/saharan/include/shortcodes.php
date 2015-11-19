<?php
//Shortcodes for Visual Composer

add_action( 'vc_before_init', 'road_vc_shortcodes' );
function road_vc_shortcodes() {
	
	//Popular categories
	vc_map( array(
		"name" => esc_html__( "Popular categories", 'saharan' ),
		"base" => "popular_category",
		"class" => "",
		"category" => esc_html__( 'saharan', 'saharan'),
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Category slug", 'saharan' ),
				"param_name" => "category",
				"value" => esc_html__( "clothes", 'saharan' ),
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Image path", 'saharan' ),
				"param_name" => "image",
				"value" => esc_html__( "clothes", 'saharan' ),
			),
		)
	) );
	
	//Brand logos
	vc_map( array(
		"name" => esc_html__( "Brand Logos", 'saharan' ),
		"base" => "ourbrands",
		"class" => "",
		"category" => esc_html__( 'saharan', 'saharan'),
		"params" => array(
			
		)
	) );
	
	//Brand logos
	vc_map( array(
		"name" => esc_html__( "Contact Map", 'saharan' ),
		"base" => "contactmap",
		"class" => "",
		"category" => esc_html__( 'saharan', 'saharan'),
		"params" => array(
			
		)
	) );
	
	//Latest posts
	vc_map( array(
		"name" => esc_html__( "Latest posts", 'saharan' ),
		"base" => "latestposts",
		"class" => "",
		"category" => esc_html__( 'saharan', 'saharan'),
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Number of posts", 'saharan' ),
				"param_name" => "posts_per_page",
				"value" => esc_html__( "5", 'saharan' ),
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Image scale", 'saharan' ),
				"param_name" => "image",
				"value" => array(
						'Wide'	=> 'wide',
						'Square'	=> 'square',
					),
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Excerpt length", 'saharan' ),
				"param_name" => "length",
				"value" => esc_html__( "20", 'saharan' ),
			),
		)
	) );
	
	//Testimonials
	vc_map( array(
		"name" => esc_html__( "Testimonials", 'saharan' ),
		"base" => "woothemes_testimonials",
		"class" => "",
		"category" => esc_html__( 'saharan', 'saharan'),
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Number of testimonial", 'saharan' ),
				"param_name" => "limit",
				"value" => esc_html__( "10", 'saharan' ),
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Image size", 'saharan' ),
				"param_name" => "size",
				"value" => esc_html__( "120", 'saharan' ),
			),
		)
	) );
	
	//Rotating tweets
	vc_map( array(
		"name" => esc_html__( "Rotating tweets", 'saharan' ),
		"base" => "rotatingtweets",
		"class" => "",
		"category" => esc_html__( 'saharan', 'saharan'),
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Twitter user name", 'saharan' ),
				"param_name" => "screen_name",
				"value" => esc_html__( 'saharan', 'saharan' ),
			),
		)
	) );
	
	//Icons
	vc_map( array(
		"name" => esc_html__( "FontAwesome Icon", 'saharan' ),
		"base" => "roadicon",
		"class" => "",
		"category" => esc_html__( 'saharan', 'saharan'),
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"heading" => esc_html__( "FontAwesome Icon", 'saharan' ),
				"description" => esc_html__( "<a href=\"http://fortawesome.github.io/Font-Awesome/cheatsheet/\" target=\"_blank\">Go here</a> to get icon class. Example: fa-search", 'saharan' ),
				"param_name" => "icon",
				"value" => esc_html__( "fa-search", 'saharan' ),
			),
		)
	) );
}
?>