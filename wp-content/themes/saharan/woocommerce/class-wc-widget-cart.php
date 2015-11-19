<?php
/**
 * Shopping Cart Widget
 *
 * Displays shopping cart widget
 *
 * @author 		WooThemes
 * @category 	Widgets
 * @package 	WooCommerce/Widgets
 * @version 	2.0.1
 * @extends 	WC_Widget
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Custom_WC_Widget_Cart extends WC_Widget_Cart {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_shopping_cart';
		$this->widget_description = esc_html__( "Display the user's Cart in the sidebar.", 'saharan' );
		$this->widget_id          = 'woocommerce_widget_cart';
		$this->widget_name        = esc_html__( 'WooCommerce Cart', 'saharan' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Cart', 'saharan' ),
				'label' => esc_html__( 'Title', 'saharan' )
			),
			'hide_if_empty' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => esc_html__( 'Hide if cart is empty', 'saharan' )
			)
		);
		parent::__construct();
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	public function widget( $args, $instance ) {

		extract( $args );

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? esc_html__( 'Cart', 'saharan' ) : $instance['title'], $instance, $this->id_base );
		$hide_if_empty = empty( $instance['hide_if_empty'] ) ? 0 : 1;

		echo wp_kses($before_widget, array(
			'div'=>array(
				'class'=>array()
			)
		));

		if ( $title )
			echo wp_kses($before_title . $title . $after_title, array(
				'h2'=>array(
					'class'=>array()
				)
			));

		if ( $hide_if_empty )
			echo '<div class="hide_cart_widget_if_empty">';

		// Insert cart widget placeholder - code in woocommerce.js will update this on page load
		echo '<div class="widget_shopping_cart_content"></div>';

		if ( $hide_if_empty )
			echo '</div>';
		
		echo wp_kses($after_widget, array(
			'div'=>array(
				'class'=>array()
			)
		));
	}
}

register_widget( 'WC_Widget_Cart' );