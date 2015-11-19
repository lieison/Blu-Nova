<?php
/**
 * Tools Functions
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */
if ( !class_exists( 'mm_common' ) ) {
	class mm_common {

		/** 
		 * The function return a newline (set any value in second argument to block newline) 
		 * and the number of tabs specified in the first argument.
		 * Function has a small name and is available in any theme file.
		 * @return $ntab - newline and tabs sumbols (example:\n\t\t).
		 */
		public static function ntab( $number_of_tabs = 0, $newline = 'true' ) {
			$ntab = ( $newline === 'true' ) ? "\n" : "";
			for ($i = 0; $number_of_tabs > $i; $i++) {
				$ntab .= "\t";
			}
			return $ntab;
		}

		/** 
		 * The function return empty string (required for some other functions with "preg_replace_callback").
		 */
		public static function return_empty_string( $variable ) {
			return '';
		}

		/** 
		 * The function return a vareable where only numbers.
		 * @return $only_numbers - vareable where only numbers.
		 */
		public static function get_only_numbers( $variable = false ) {
			$only_numbers = preg_replace_callback( '([^0-9,.]{1,})', array( 'mm_common', 'return_empty_string' ), $variable );
			return $only_numbers;
		}

		/** 
		 * The function return url if url is valid or return false if url is no valid.
		 * @return $url.
		 */
		public static function is_url( $variable = false ) { 
			if( filter_var( $variable, FILTER_VALIDATE_URL ) === FALSE ) {
				return false;
			} else {
				return true;
			}
		}

		/** 
		 * The function return true if url exist or return false if url no exist.
		 * @return boolean value.
		 */
		public static function url_exist( $url = false ) { 
			if ( !( $url = @parse_url( $url ) ) ) {
				return false;
			}
			$url['port'] = ( !isset( $url['port'] ) ) ? 80 : (int) $url['port'];
			$url['path'] = ( !empty( $url['path'] ) ) ? $url['path'] : '/';
			$url['path'] .= ( isset( $url['query'] ) ) ? "?$url[query]" : '';
			if ( isset( $url['host'] ) && $url['host'] != @gethostbyname( $url['host'] ) ) {
				if ( PHP_VERSION >= 5 ) {
					$headers = @implode( '', @get_headers( "$url[scheme]://$url[host]:$url[port]$url[path]" ) );
				} else {
					if ( !( $fp = @fsockopen( $url['host'], $url['port'], $errno, $errstr, 10 ) ) ) {
						return false;
					}
					fputs( $fp, "HEAD $url[path] HTTP/1.1\r\nHost: $url[host]\r\n\r\n" );
					$headers = fread( $fp, 4096 );
					fclose( $fp );
				}
				return (bool)preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers);
			}
			return false;
		}

		/** 
		 * The function return new unique script id on page.
		 * @return integer value.
		 */
		public static function script_id ( $name_space = 'mm_script_id', $reset = false ) { 
			global $$name_space;
			if ( $reset === true || !isset( $$name_space ) || $$name_space === false ) {
				$GLOBALS[ $name_space ] = 0;
			}
			$GLOBALS[ $name_space ] ++;
			return $GLOBALS[ $name_space ];
		}

		/** 
		 * The function return excerpted text.
		 * @return integer value.
		 */
		public static function excerpt( $text = '', $length = 200, $ellipsis = '...' ) {
			$out = $text;
			if ( is_string( $text ) && strlen( $text ) > (int)$length ) {
				$snip = substr( strip_tags( preg_replace_callback ( "/\[(.*)\]/i", array( 'mm_common', 'return_empty_string' ), $text ) ), 0, $length );
				$out = substr( $snip, 0, strrpos( $snip, ' ' ) ) . $ellipsis;
			}
			return $out;
		}

		/** 
		 * The function return full content of the file from URL.
		 * @return integer value.
		 */
		public static function get_url_content( $url ) {
			$out = false;
			// cURL
			if ( ( $out == false ) ) {
				if ( function_exists( 'curl_init' ) ) {
					$ch = curl_init();
					curl_setopt( $ch, CURLOPT_URL, $url );
					curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
					$curl_info = curl_getinfo( $ch );
					if ( ( $curl_info[ 'http_code' ] == 400 ) || ( $curl_info[ 'http_code' ] == 302 ) || ( $curl_info[ 'http_code' ] == 303 ) ) {
						$out = false;
					} else {
						$out = curl_exec( $ch );
					}
					curl_close( $ch );
				} else {
					$out = false;
				}
			}
			// file_get_contents
			if ( ( $out == false ) ) {
				if ( ini_get( 'allow_url_fopen' ) && function_exists( 'file_get_contents' ) ) {
					$out = file_get_contents( $url );
				} else {
					$out = false;
				}
			}
			// fopen, fread, fclose
			if ( ( $out == false ) ) {
				if ( ( ini_get( 'allow_url_fopen' ) && function_exists('fopen') && function_exists('fread') ) || ( is_readable( $url ) ) ) {
					$handle = fopen( $url, "rb" );
					if ( $handle !== false ) {
						$out = fread( $handle, filesize( $url ) );
						fclose( $handle );
					} else {
						$out = false;
					}
				} else {
					$out = false;
				}
			}

			if ( empty( $out ) ) {
				$out = false;
			}
			return $out;
		}

		/** 
		 * The function return array with full list of the post types and their taxonomies.
		 * @return integer value.
		 */
		public static function get_all_taxonomies () {
			global $mm_get_all_taxonomies;
			$out = array();
			if ( isset( $mm_get_all_taxonomies ) && $mm_get_all_taxonomies !== false ) {
				$out = $mm_get_all_taxonomies;
			} else {
				$post_types = get_post_types( $args = array( 'public' => true ), 'names' );
				unset( $post_types['attachment'] );
				foreach ( $post_types as $post_types_key => $single_post_type ) {
					$out[ ucfirst( $single_post_type ) ] = $single_post_type;
				}
				foreach ( $out as $post_types_key => $single_post_type ) {
					$tax_obj[ $single_post_type ] = get_object_taxonomies( $single_post_type );
					$tax = $tax_obj;
					foreach ( $tax[ $single_post_type ] as $tax_type_key => $tax_type ) {
						$terms_obj[ $single_post_type ] = get_terms( $tax_type, '&orderby=name&hide_empty=0' );
						$terms = $terms_obj;
						foreach ( $terms[ $single_post_type ] as $terms_key => $terms_value ) {
							$out[ ucfirst( $single_post_type ) . ' &nbsp; -&gt; &nbsp; ' . $terms_value->name ] = $single_post_type . '/' . $terms_value->taxonomy . '=' . $terms_value->slug;
						}
					}
				}
				asort( $out );
				$GLOBALS['mm_get_all_taxonomies'] = $out;
			}
			return $out;
		}

		/** 
		 * The function return CSS font properties in a string.
		 * @return string value.
		 */
		public static function css_font( $args = array() ) {
			$args = wp_parse_args($args, $defaults = array( 'font_family' => '', 'font_color' => '', 'font_size' => '', 'font_weight' => '' ) );
			extract( $args );

			$font = '';
			if ( $font_family != '' && $font_family != false ) {
				if ( $font_family == 'Inherit' ) {
					$font .= "font-family: inherit;\n";
				} else {
					$font .= "font-family: " . $font_family . ", '" . $font_family . "';\n";
				}
			}
			if ( $font_color != '' && $font_color != false ) {
				$font .= "color: " . $font_color . ";\n";
			}
			if ( $font_size != '' && $font_size != false ) {
				$font .= "font-size: " . $font_size . "px;\n";
			}
			if ( $font_weight != '' && $font_weight != false ) {
				$font .= "font-weight: " . $font_weight . ";\n";
			}
			return $font;
		}

		/** 
		 * The function return CSS gradient properties in a string.
		 * @return string value.
		 */
		public static function css_gradient( $args = array() ) {
			$args = wp_parse_args($args, $defaults = array( 'color1' => 'transparent', 'color2' => 'transparent', 'start' => '0', 'end' => '100', 'orientation' => 'top' ) );
			extract( $args );
			$color1 = ( $color1 == '' || $color1 == false ) ? 'transparent' : $color1;
			$color2 = ( $color2 == '' || $color2 == false ) ? 'transparent' : $color2;
			$gradient = '';
			if ( ( $color1 == $color2 ) || ( $color2 != 'transparent' ) ) {
				$gradient .= 'background: ' . $color1 . ';';
			}
			if ( ( $color1 != 'transparent' ) || ( $color2 != 'transparent' ) ) {
				if ( $color1 != $color2 ) {
					if ( $orientation == 'radial' ) {
						$orient1 = 'radial-gradient(center, ellipse cover';
						$orient2 = 'radial, center center, 0px, center center, 100%';
						$orient3 = 'radial-gradient(ellipse at center';
					} else if ( $orientation == 'left' ||  $orientation == 'horizontal' ) {
						$orient1 = 'linear-gradient(left';
						$orient2 = 'linear, left top, right top';
						$orient3 = 'linear-gradient(to right';
					} else {
						$orient1 = 'linear-gradient(top';
						$orient2 = 'linear, left top, left bottom';
						$orient3 = 'linear-gradient(to bottom';
					}
					$gradient .= "background: -moz-" . $orient1 . ", " . $color1 . " " . $start . "%, " . $color2 . " " . $end . "%);\n";
					$gradient .= "background: -webkit-" . $orient1 . ", " . $color1 . " " . $start . "%, " . $color2 . " " . $end . "%);\n";
					$gradient .= "background: -o-" . $orient1 . ", " . $color1 . " " . $start . "%, " . $color2 . " " . $end . "%);\n";
					$gradient .= "background: -ms-" . $orient1 . ", " . $color1 . " " . $start . "%, " . $color2 . " " . $end . "%);\n";
					$gradient .= "background: -webkit-gradient(" . $orient2 . ", color-stop(" . $start . "%, " . $color1 . "), color-stop(" . $end . "%," . $color2 . "));\n";
					$gradient .= "background: " . $orient3 . ", " . $color1 . " " . $start . "%, " . $color2 . " " . $end . "%);\n";
					$gradient .= "-ms-filter: \"progid:DXImageTransform.Microsoft.gradient( startColorstr='" . $color1 . "', endColorstr='" . $color2 . "',GradientType=0 )\";\n";
				}
			}
			return $gradient;
		}

		/** 
		 * The function return CSS bg_image properties in a string.
		 * @return string value.
		 */
		public static function css_bg_image( $args = array() ) {
			$args = wp_parse_args($args, $defaults = array( 'background_image' => '', 'background_repeat' => 'repeat-x', 'background_position' => 'center right', 'background_attachment' => 'fixed', 'background_size' => '' ) );
			extract( $args );

			$bg_image = '';
			if ( $background_image != '' && $background_image != false ) {
				$bg_image .= "background-image: url('" . $background_image . "');\n";
				$bg_image .= "background-repeat: " . $background_repeat . ";\n";
				$bg_image .= "background-position: " . $background_position . ";\n";
				$bg_image .= "background-attachment: " . $background_attachment . ";\n";
				$bg_image .= "background-size: " . $background_size . ";\n";
			}
			return $bg_image;
		}

		/** 
		 * The function convert any color type to RGB(A) value.
		 * @return string value.
		 */
		public static function hex2rgba( $color = '#000000', $transparency = 1 ) {
			if( strlen( $color ) == 4 ) {
				$color = str_replace( "#", "", $color );
				$r = hexdec( substr( $color,0,1 ).substr( $color,0,1 ) );
				$g = hexdec( substr( $color,1,1 ).substr( $color,1,1 ) );
				$b = hexdec( substr( $color,2,1 ).substr( $color,2,1 ) );
				$rgba = ( $transparency == 1 ? 'rgb' : 'rgba' ) . '(' . $r . ', ' . $g . ', ' . $b . ( $transparency == 1 ? '' : ', ' . $transparency ) . ')';
			} elseif ( strlen( $color ) == 7 ) {
				$color = str_replace( "#", "", $color );
				$r = hexdec( substr( $color,0,2 ) );
				$g = hexdec( substr( $color,2,2 ) );
				$b = hexdec( substr( $color,4,2 ) );
				$rgba = ( $transparency == 1 ? 'rgb' : 'rgba' ) . '(' . $r . ', ' . $g . ', ' . $b . ( $transparency == 1 ? '' : ', ' . $transparency ) . ')';
			} elseif ( strripos( $color, 'rgb' ) !== false ) {
				$color = str_replace( array( ' ', 'rgba', 'rgb', '(', ')', ), array( '', '', '', '', '', ), $color );
				$rgba_array = explode( ',', $color );
				$r = $rgba_array[ 0 ];
				$g = $rgba_array[ 1 ];
				$b = $rgba_array[ 2 ];
				$rgba = ( $transparency == 1 ? 'rgb' : 'rgba' ) . '(' . $r . ', ' . $g . ', ' . $b . ( $transparency == 1 ? '' : ', ' . $transparency ) . ')';
			} else {
				$rgba = $color;
			}
			return $rgba; // returns an array with the rgb values
		}

		/** 
		 * The function convert RGB(A) color type to HEX value.
		 * @return string value.
		 */
		public static function rgba2hex( $color = 'rgba(0,0,0,0)' ) {
			$out = "";
			$only_numbers = str_replace( 
				array( 'rgb', 'a', '(', ')', ';', ' ' ), 
				array( '', '', '', '', '', '' ), 
				$color
			);
			$rgb_array = explode( ',', $only_numbers );
			if ( isset( $rgb_array[ 0 ] ) && isset( $rgb_array[ 1 ] ) && isset( $rgb_array[ 2 ] ) ) {
				$temp = base_convert( $rgb_array[ 0 ], 10, 16 );
				$out .= ( $rgb_array[ 0 ] < 16) ? ( "0" . $temp ) : $temp;
				$temp = base_convert( $rgb_array[ 1 ], 10, 16 );
				$out .= ( $rgb_array[ 1 ] < 16) ? ( "0" . $temp ) : $temp;
				$temp = base_convert( $rgb_array[ 2 ], 10, 16 );
				$out .= ( $rgb_array[ 2 ] < 16) ? ( "0" . $temp ) : $temp;
				// Package and away we go!
				return '#' . $out;
			} else {
				return $color;
			}
		}

		/** 
		 * The function do transpose of array.
		 * @return string value.
		 */
		function transpose_array( $array = array() ) {
			$transposed_array = array();
			if ( is_array( $array ) ) {
				// Find maximum number of cells among all rows. $max_columns
				$max_columns = 0;
				foreach ( $array as $row_key => $row ) {
					if ( is_object( $row ) ) {
						$row = get_object_vars( $row );
					}
					if ( is_array( $row ) ) {
						$columns_number_in_row = count( $row );
						if ( $max_columns < $columns_number_in_row ) {
							$max_columns = $columns_number_in_row;
						}
					}
				}
				// Add null value for each empty cell.
				foreach ( $array as $row_key => $row ) {
					if ( is_object( $row ) ) {
						$row = get_object_vars( $row );
					}
					if ( is_array( $row ) ) {
						$columns_number_in_row = count( $row );
					} else {
						$columns_number_in_row = 0;
					}
					if ( $max_columns > $columns_number_in_row ) {
//						$difference = $max_columns - $columns_number_in_row;
						for ( $i = $columns_number_in_row; $i <= $columns_number_in_row; $i++ ) { 
							$row[ $i ] = null;
						}
						$array[ $row_key ] = $row;
					}
				}
				// Transpose.
				foreach ( $array as $row_key => $row ) {
					foreach ( $row as $column_key => $cell ) {
						if ( empty( $cell ) ) {
							$cell = null;
						}
						$transposed_array[ $column_key ][ $row_key ] = $cell;
					}
				}
				return $transposed_array;
			}
		}

	}
}
?>