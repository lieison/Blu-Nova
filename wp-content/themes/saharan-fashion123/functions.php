<?php
/**
 * Road Themes functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Road_Themes
 * @since Road Themes 1.0
 */
if ( class_exists( 'ReduxFramework' ) && !isset( $redux_demo ) && file_exists( get_stylesheet_directory().'/child-config.php' ) ) {
 require_once( 'child-config.php' );
}

function road_child_scripts_styles() {
	global $wp_styles, $wp_scripts, $road_opt;

	// Compile Less to CSS
	$previewpreset = (isset($_REQUEST['preset']) ? $_REQUEST['preset'] : null);
		//get preset from url (only for demo/preview)
	if($previewpreset){
		$_SESSION["preset"] = $previewpreset;
	}
	if(!isset($_SESSION["preset"])){
		$_SESSION["preset"] = 1;
	}
	if($_SESSION["preset"] != 1) {
		$presetopt = $_SESSION["preset"];
	} else { /* if no preset varialbe found in url, use from theme options */
		$presetopt = $road_opt['preset_option'];
	}
	if(!isset($presetopt)) $presetopt = 1; /* in case first time install theme, no options found */
	
	if($road_opt['enable_less']){
		$themevariables = array(
			'heading_font'=> $road_opt['headingfont']['font-family'],
			'menu_font'=> $road_opt['menufont']['font-family'],
			'font_size_menu'=> $road_opt['menufont']['font-size'],
			'body_font'=> $road_opt['bodyfont']['font-family'],
			'font_size_body'=> $road_opt['bodyfont']['font-size'],
			'heading_color'=> $road_opt['headingfont']['color'],
			'menu_color'=> $road_opt['menufont']['color'],
			'text_color'=> $road_opt['bodyfont']['color'],
			'primary_color' => $road_opt['primary_color'],
			'sale_color' => $road_opt['sale_color'],
			'saletext_color' => $road_opt['saletext_color'],
			'rate_color' => $road_opt['rate_color'],
		);
		
		switch ($presetopt) {
			case 2: 
				if(is_ssl()){ 
					wp_enqueue_style( 'gf-Robotocondensed', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' );
					wp_enqueue_style( 'gf-Rokkitt', 'https://fonts.googleapis.com/css?family=Rokkitt:400,700' );
				} else {
					wp_enqueue_style( 'gf-Robotocondensed', 'http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' );
					wp_enqueue_style( 'gf-Rokkitt', 'http://fonts.googleapis.com/css?family=Rokkitt:400,700' );
				} 
				$themevariables['heading_font'] = 'Roboto Condensed, Arial, Helvetica, sans-serif'; 
				$themevariables['body_font'] = 'Rokkitt, Arial, Helvetica, sans-serif';  
				$themevariables['menu_font'] = 'Roboto Condensed, Arial, Helvetica, sans-serif';
				$themevariables['font_size_body'] = '14px';
				$themevariables['font_size_menu'] = '15px'; 
			break;
		} 
		if(function_exists('compileChildLessFile')){
			compileChildLessFile('fashion.less', 'fashion'.$presetopt.'.css', $themevariables);
		}
	}
	
	// Load main theme css style
	wp_enqueue_style( 'fashion-css', get_stylesheet_directory_uri() . '/css/fashion'.$presetopt.'.css', array('roadthemes-css'), '1.0.0' );
	
	// Add fashion.js file
	wp_enqueue_script( 'fashion-js', get_stylesheet_directory_uri() . '/js/fashion.js', array('jquery'), '20140826', true );
}
add_action( 'wp_enqueue_scripts', 'road_child_scripts_styles' );

//remove breadcrumb on archive product
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 30 ); 
