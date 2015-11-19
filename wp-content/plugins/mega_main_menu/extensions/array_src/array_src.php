<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */

	if ( !function_exists( 'mega_main_menu__array_src' ) ) {
		function mega_main_menu__array_src( $current_class ){
			$array_src = array(
				'frontend' => array(
					'css' => array(
						'mm_icomoon' => 'framework/src/css/icomoon.css',
						'mm_font-awesome' => 'framework/src/css/font-awesome.css',
						'mm_glyphicons' => 'framework/src/css/glyphicons.css',
					),
					'js' => array(
						$current_class->constant[ 'MM_WARE_PREFIX' ] . '_menu_functions' => 'src/js/frontend.js',
					),
				),
				'backend' => array(
					'css' => array(
						'mm_icomoon' => 'framework/src/css/icomoon.css',
						'mm_font-awesome' => 'framework/src/css/font-awesome.css',
						'mm_glyphicons' => 'framework/src/css/glyphicons.css',
						'mm_bootstrap' => 'framework/src/css/bootstrap.css',
						'mm_bootstrap_colorpicker' => 'framework/src/css/colorpicker.css',
						'mm_option_generator' => 'framework/src/css/mm_option_generator.css',
						$current_class->constant[ 'MM_WARE_PREFIX' ] . '_backend_general' => 'src/css/backend.css',
					),
					'js' => array(
						'jquery-ui-sortable' => '',
						'jquery-ui-draggable' => '',
						'mm_bootstrap' => 'framework/src/js/bootstrap.js',
						'mm_bootstrap_colorpicker' => 'framework/src/js/colorpicker.js',
						'mm_option_generator' => 'framework/src/js/mm_option_generator.js',
					),
					'supported_pages' => array(
						'toplevel_page_' . $current_class->constant[ 'MM_OPTIONS_NAME' ], 
						'post.php', 
						'post-new.php', 
						'nav-menus.php'
					),
				),
			);
			$option_status = $current_class->get_option( 'icon_sets', array( 'icomoon' ) );
			if ( !in_array( 'icomoon', $option_status ) ) {
				unset( $array_src[ 'backend' ][ 'css' ][ 'mm_icomoon' ] );
				unset( $array_src[ 'frontend' ][ 'css' ][ 'mm_icomoon' ] );
			}
			if ( !in_array( 'fontawesome', $option_status ) ) {
				unset( $array_src[ 'backend' ][ 'css' ][ 'mm_font-awesome' ] );
				unset( $array_src[ 'frontend' ][ 'css' ][ 'mm_font-awesome' ] );
			}
			if ( !in_array( 'glyphicons', $option_status ) ) {
				unset( $array_src[ 'backend' ][ 'css' ][ 'mm_glyphicons' ] );
				unset( $array_src[ 'frontend' ][ 'css' ][ 'mm_glyphicons' ] );
			}
			return $array_src;
		}
	}
?>