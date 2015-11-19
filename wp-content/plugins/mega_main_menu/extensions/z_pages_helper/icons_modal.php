<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */
global $mega_main_menu;
$current_class = $mega_main_menu;
if ( isset( $_GET[ 'mm_page' ] ) && !empty( $_GET[ 'mm_page' ] ) ) {
//	header("Content-type: text/css", true);
	if ( $_GET[ 'mm_page' ] == 'icons_list' ) {
		$input_name = ( isset( $_GET['input_name'] ) ? $_GET['input_name'] : '');
		$modal_id = ( isset( $_GET['modal_id'] ) ? $_GET['modal_id'] : '');
		$current_icon = ( isset( $_GET['current_icon'] ) ? $_GET['current_icon'] : '');
		echo mm_common::ntab(1) . '
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery(\'.all_icons_search_input.'. $modal_id .'\').keyup(function(){
				setTimeout(function () {
					search_query = jQuery(\'.all_icons_search_input.'. $modal_id .'\').val();
					if ( search_query != \'\' ) {
						jQuery(\'.all_icons_container label\').css({\'display\' : \'none\'});
						jQuery(\'.all_icons_container label[for*="\' + search_query + \'"]\').css({\'display\' : \'block\'});
					} else {
						jQuery(\'.all_icons_container label\').removeAttr(\'style\');
					}
				}, 1200 );
			});
		});
	</script>';
		echo mm_common::ntab(3) . '<div class="modal-header">';
		echo mm_common::ntab(3) . '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> <h4 class="modal-title">' . __( 'Select Icon', $current_class->constant[ 'MM_TEXTDOMAIN_ADMIN'] ) . '</h4>';
		echo mm_common::ntab(3) . '</div><!-- class="modal-header" -->';
		echo mm_common::ntab(3) . '<div class="modal-body">';
		echo mm_common::ntab(4) . '<div class="holder">';
		echo mm_common::ntab(5) . '<div class="all_icons_control_panel">';
		echo mm_common::ntab(6) . '<input type="text" class="all_icons_search_input '. $modal_id .'" placeholder="'.__( 'Search icon', $current_class->constant[ 'MM_TEXTDOMAIN_ADMIN'] ).'">';
		echo mm_common::ntab(6) . '<span class="ok_button btn-primary" onclick="mm_icon_selector(\'' . $input_name . '\', \'' . $modal_id . '\' );">'.__( 'OK', $current_class->constant[ 'MM_TEXTDOMAIN_ADMIN'] ).'</span>';
		echo mm_common::ntab(5) . '</div><!-- class="all_icons_control_panel" -->';
		echo mm_common::ntab(5) . '<div class="all_icons_container">';
		$set_of_custom_icons = $current_class->get_option( 'set_of_custom_icons', array() );
		if ( is_array( $set_of_custom_icons ) && count( $set_of_custom_icons ) >= 1 ) {
			foreach ( $set_of_custom_icons as $value ) {
				$icon_name = str_replace( array( '/', strrchr( $value[ 'custom_icon' ], '.' ) ), '', strrchr( $value[ 'custom_icon' ], '/' ) );
				echo '<label for="ci-icon-' . $icon_name . '-' . $input_name . '"><input name="icon" id="ci-icon-' . $icon_name . '-' . $input_name . '" type="radio" value="ci-icon-' . $icon_name . '"><i class="ci-icon-' . $icon_name . '"></i></label>';
			}
		}
		$icon_sets = $current_class->get_option( 'icon_sets', array( 'icomoon' ) );
		if ( in_array( 'icomoon', $icon_sets ) ) {
			foreach ( mm_datastore::get_list_icomoon() as $key => $value ) {
				echo '<label for="' . $value . '-' . $input_name . '"><input name="icon" id="' . $value . '-' . $input_name . '" type="radio" value="' . $value . '"' . ( ( $value ==  $current_icon ) ? ' checked="checked"' : '') . '><i class="' . $value . '"></i></label>';
			}
		}
		if ( in_array( 'fontawesome', $icon_sets ) ) {
			foreach ( mm_datastore::get_list_fontawesome() as $key => $value ) {
				echo '<label for="' . $value . '-' . $input_name . '"><input name="icon" id="' . $value . '-' . $input_name . '" type="radio" value="' . $value . '"' . ( ( $value ==  $current_icon ) ? ' checked="checked"' : '') . '><i class="' . $value . '"></i></label>';
			}
		}
		if ( in_array( 'glyphicons', $icon_sets ) ) {
			foreach ( mm_datastore::get_list_glyphicons() as $key => $value ) {
				echo '<label for="' . $value . '-' . $input_name . '"><input name="icon" id="' . $value . '-' . $input_name . '" type="radio" value="' . $value . '"' . ( ( $value ==  $current_icon ) ? ' checked="checked"' : '') . '><i class="' . $value . '"></i></label>';
			}
		}
		echo mm_common::ntab(5) . '</div><!-- class="all_icons_container" -->';
		echo mm_common::ntab(4) . '</div><!-- class="holder" -->';
		echo mm_common::ntab(3) . '</div><!-- class="modal-body" -->';
		die();
	}
}
?>