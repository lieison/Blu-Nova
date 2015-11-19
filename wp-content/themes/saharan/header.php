<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Road_Themes
 * @since Road Themes 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<?php global $road_opt; ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
		if(isset($road_opt['opt-favicon']) && $road_opt['opt-favicon']!="") { 
			if(is_ssl()){
				$road_opt['opt-favicon'] = str_replace('http', 'https', $road_opt['opt-favicon']);
			}
		?>
			<link rel="icon" type="image/png" href="<?php echo esc_url($road_opt['opt-favicon']['url']);?>">
		<?php }
	}
	?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="yith-wcwl-popup-message"><div id="yith-wcwl-message"></div></div>
<div class="wrapper <?php if($road_opt['page_layout']=='box'){echo 'box-layout';}?>">
	<div class="page-wrapper">
	<?php
	if ( $road_opt['header_layout']=='default' || !isset($road_opt['header_layout'])) {
		get_header('first');
	} else {
		get_header($road_opt['header_layout']);
	}
	?>