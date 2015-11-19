<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce_loop, $road_opt;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Increase loop count
$woocommerce_loop['loop'] ++;
if($road_shopclass=='shop-fullwidth') {
	if(isset($road_opt)){
		$woocommerce_loop['columns'] = $road_opt['product_per_row_fw'];
		$colwidth = round(12/$woocommerce_loop['columns']);
	}
	$col_classes = ' item-col col-xs-12 col-sm-4 col-md-'.$colwidth ;
} else {
	if(isset($road_opt)){
		$woocommerce_loop['columns'] = $road_opt['product_per_row'];
		$colwidth = round(12/$woocommerce_loop['columns']);
	}
	$col_classes = ' item-col col-xs-12 col-sm-'.$colwidth ;
}
?>
<div <?php wc_product_cat_class($col_classes); ?>>
	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

	<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">

		<?php
			/**
			 * woocommerce_before_subcategory_title hook
			 *
			 * @hooked woocommerce_subcategory_thumbnail - 10
			 */
			do_action( 'woocommerce_before_subcategory_title', $category );
		?>

		<span>
			<?php
				echo esc_html($category->name);

				if ( $category->count > 0 )
					echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
			?>
		</span>

		<?php
			/**
			 * woocommerce_after_subcategory_title hook
			 */
			do_action( 'woocommerce_after_subcategory_title', $category );
		?>

	</a>

	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>
</div>
