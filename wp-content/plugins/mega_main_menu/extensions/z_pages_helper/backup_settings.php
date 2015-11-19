<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */
	
	$current_class = $this; // important line
	/* 
	 * Functions get array of the all setting from DB and create file to download.
	 */
	if ( isset( $_GET[ $current_class->constant[ 'MM_WARE_PREFIX' ] . '_page' ] ) && !empty( $_GET[ $current_class->constant[ 'MM_WARE_PREFIX' ] . '_page' ] ) ) {
		if ( $_GET[ $current_class->constant[ 'MM_WARE_PREFIX' ] . '_page' ] == 'backup_file' ) {
			// Urge file to download instead of opening in the browser window.
			header('Content-type: application/txt');
			header('Content-Disposition: attachment; filename="mega-main-menu-backup-' . date("Y-m-d-H-i") . '.txt"');
			$enc = json_encode( $current_class->saved_options );
			echo $enc;
			die();
		}
	}

	/* 
	 * Functions restore backup data using hook.
	 */
	if ( has_filter( 'mmm_set_configuration' ) ) {
		if ( isset( $current_class->saved_options ) && !empty( $current_class->saved_options ) ) {
			$db_options = $current_class->saved_options;
			$db_options['last_modified'] = time() + 30;
		} else {
			$ware_options_array = $this->constant[ 'MM_WARE_SLUG' ] . '__array_theme_options';
			$db_options['last_modified'] = time() + 30;
			foreach ( $ware_options_array( $this->constant ) as $section ) {
				foreach ( $section[ 'options' ] as $option ) {
					if ( !in_array( $option[ 'type' ], array( 'caption', 'collapse_start', 'collapse_end', 'devider', 'just_html' ) ) ) {
						if ( isset( $option[ 'default' ] ) && ( $option[ 'type' ] == 'radio' ) ) {
							$values = array_values( $option[ 'values' ] );
							$db_options[ $option[ 'key' ] ] = $values[ 0 ];
						} elseif ( isset( $option[ 'default' ] ) ) {
							$db_options[ $option[ 'key' ] ] = $option[ 'default' ];
						} elseif ( isset( $option[ 'values' ] ) ) {
							$values = array_values( $option[ 'values' ] );
							$db_options[ $option[ 'key' ] ] = array( $values[ 0 ] );
						}
					}
				}
			}
		}
		$options_backup = apply_filters( 'mmm_set_configuration', $db_options, $db_options );
		if ( $options_backup !== false && is_array( $options_backup ) ) {
			if ( isset( $options_backup['last_modified'] ) ) {
				$options_backup['last_modified'] = time() + 30;
				update_option( $current_class->constant[ 'MM_OPTIONS_NAME' ], $options_backup );
			}
		}
	}

	/* 
	 * Functions restore backup data.
	 */
	if ( !function_exists( 'mmm_options_backup' ) ) {
		function mmm_options_backup() {
			global $mega_main_menu;
			if ( isset( $_FILES[ $mega_main_menu->constant[ 'MM_OPTIONS_NAME' ] . '_backup' ] ) && $_FILES[ $mega_main_menu->constant[ 'MM_OPTIONS_NAME' ] . '_backup' ]['error'] == 0 ) {
				$backup_file_content = mm_common::get_url_content( $_FILES[ $mega_main_menu->constant[ 'MM_OPTIONS_NAME' ] . '_backup' ]['tmp_name'] );
				if ( $backup_file_content !== false && ( $options_backup = json_decode( $backup_file_content, true ) ) ) {
					if ( isset( $options_backup['last_modified'] ) ) {
						$options_backup['last_modified'] = time() + 30;
						update_option( $mega_main_menu->constant[ 'MM_OPTIONS_NAME' ], $options_backup );
					}
				}
			}
		}
	}
	add_action( 'updated_option', 'mmm_options_backup', 20 );
?>