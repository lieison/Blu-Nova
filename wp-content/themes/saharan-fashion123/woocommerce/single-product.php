<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>
<?php global $road_opt; ?>
<div class="main-container">

	<div class="page-content">
	
		<div class="product-page">
			<div class="container">
				<?php do_action( 'woocommerce_before_main_content' ); ?>
			</div>
			<div class="product-view">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'single-product' ); ?>

				<?php endwhile; // end of the loop. ?>

				<?php
					/**
					 * woocommerce_after_main_content hook
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action( 'woocommerce_after_main_content' );
				?>

				<?php
					/**
					 * woocommerce_sidebar hook
					 *
					 * @hooked woocommerce_get_sidebar - 10
					 */
					//do_action( 'woocommerce_sidebar' );
				?>
			</div>
			<div class="banner-home-content2">
				<div class="container"> 
					<?php if(isset($road_opt['home_services'])) {
					 echo wp_kses($road_opt['home_services'], array(
					  'a' => array(
					  'class' => array(), 
					  'href' => array(),
					  'title' => array()
					  ),
					  'img' => array(
					  'src' => array(),
					  'alt' => array()
					  ),
					  'div'=> array(
					   'class' => array()
					  ),
					  'h2' => array(),
					  'ul' => array(),
					  'li' => array(),
					  'p' => array(),
					  'i' => array(),
					 )); 
					} ?> 
				</div>
			</div>
			<div class="group-modul">
				<div class="container">
					<div class="row">
						<div class="newsletter-container col-md-4 col-sm-12">
							<h2><?php _e('SIGN UP FOR OUR WEEKLY NEWSLETTER !', 'roadthemes'); ?></h2>
							<?php echo do_shortcode('[wysija_form id="1"]'); ?>
						</div>
						<div class="brand-container col-md-8 col-sm-12">
							<?php echo do_shortcode('[ourbrands]'); ?> 
						</div>
					</div> 
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer( 'shop' ); ?>