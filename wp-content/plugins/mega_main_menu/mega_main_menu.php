<?php
/**
 * @package Mega Main Menu
 * @version 2.1.1
 * Plugin Name: Mega Main Menu
 * Plugin URI: http://menu.megamain.com
 * Description: Multifunctional and responsive menu. Features: icons, dropdowns, sticky menu, custom styles, images, google fonts. All in one... To unlock "Automatic updates" - enter your purchase code on the "Plugin Configuration Page".
 * Version: 2.1.1
 * Author: MegaMain.com
 * Author URI: http://megamain.com
 */

	include_once( 'framework/init.php' );
	$mm_config = array(
		'MM_WARE_NAME' => 'Mega Main Menu',
		'MM_WARE_SLUG' => 'mega_main_menu',
		'MM_WARE_PREFIX' => 'mmm',
		'MM_WARE_VERSION' => '2.1.1',
		'MM_WARE_INIT_FILE' => __FILE__,
	);
	new mega_main_init( $mm_config );
?>
