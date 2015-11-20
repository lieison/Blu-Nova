<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>
<?php
global $road_viewmode, $road_opt, $road_shopclass, $road_productrows, $wp_query, $woocommerce_loop;

$road_productrows = 1;

$shoplayout = 'sidebar';
if(isset($road_opt['shop_layout']) && $road_opt['shop_layout']!=''){
	$shoplayout = $road_opt['shop_layout'];
}
if(isset($_GET['layout']) && $_GET['layout']!=''){
	$shoplayout = $_GET['layout'];
}
$shopsidebar = 'left';
if(isset($road_opt['sidebar_pos']) && $road_opt['sidebar_pos']!=''){
	$shopsidebar = $road_opt['sidebar_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$shopsidebar = $_GET['sidebar'];
}
switch($shoplayout) {
	case 'fullwidth':
		$road_shopclass = 'shop-fullwidth';
		$shopcolclass = 12;
		$shopsidebar = 'none';
		$productcols = 4;
		break;
	default:
		$road_shopclass = 'shop-sidebar';
		$shopcolclass = 9;
		$productcols = 3;
}
$road_viewmode = 'grid-view';
if(isset($road_opt['default_view'])) {
	if($road_opt['default_view']=='list-view'){
		$road_viewmode = 'list-view';
	}
}
if(isset($_GET['view']) && $_GET['view']=='list-view'){
	$road_viewmode = $_GET['view'];
}
?>
<div class="main-container">
	<div class="page-content">
		
		<div class="shop_content"> 
				
			<div class="container">
				
				
				<?php if (is_product_category()) { ?>
					<div class="category_header">
						<?php do_action( 'woocommerce_archive_description' ); ?>
					</div>
				<?php } ?>
				<?php
					/**
					 * woocommerce_before_main_content hook
					 *
					 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
					 * @hooked woocommerce_breadcrumb - 20
					 */
					do_action( 'woocommerce_before_main_content' );
				?> 
				<div class="row">
				
					<?php if( $shopsidebar == 'left' ) :?>
						<?php get_sidebar('category'); ?>
					<?php endif; ?>
					
					<div id="archive-product" class="col-xs-12 <?php echo 'col-md-'.$shopcolclass; ?>">
						
						<div class="archive-border <?php echo esc_attr($road_shopclass); if($shopsidebar=='left') {echo ' left-sidebar'; } if($shopsidebar=='right') {echo ' right-sidebar'; } ?>">
							<?php if ( have_posts() ) : ?>
							<div class="toolbar">
								<div class="view-mode">
									<a href="#" class="grid <?php if($road_viewmode=='grid-view'){ echo ' active';} ?>" title="<?php echo esc_attr__( 'Grid' ); ?>"><i class="fa fa-th-large"></i><span><?php _e('Grid', 'roadthemes'); ?></span></a>
									<a href="#" class="list <?php if($road_viewmode=='list-view'){ echo ' active';} ?>" title="<?php echo esc_attr__( 'List' ); ?>"><i class="fa fa-th-list"></i><span><?php _e('List', 'roadthemes'); ?></span></a>
								</div>
								<?php
									/**
									 * woocommerce_before_shop_loop hook
									 *
									 * @hooked woocommerce_result_count - 20
									 * @hooked woocommerce_catalog_ordering - 30
									 */
									do_action( 'woocommerce_before_shop_loop' );
									do_action( 'woocommerce_after_shop_loop' );
									
								?>
								<div class="clearfix"></div>
							</div>
							<?php endif; ?>
							<?php if ( have_posts() ) : ?>
								
								<?php
									/**
									* remove message from 'woocommerce_before_shop_loop' and show here
									*/
									do_action( 'woocommerce_show_message' );
								?>
								<div class="row">
								<?php
								woocommerce_product_subcategories();
								//reset loop
								$woocommerce_loop['loop'] = 0;
								?>
								</div>
								
							<?php endif; ?>	
								
							<?php if ( have_posts() ) : ?>	
							
								<?php //woocommerce_product_loop_start(); ?>
								<div class="shop-products row <?php echo esc_attr($road_viewmode);?>">
									
									<?php $woocommerce_loop['columns'] = $productcols; ?>
									
									<?php while ( have_posts() ) : the_post(); ?>

										<?php wc_get_template_part( 'content', 'product-archive' ); ?>

									<?php endwhile; // end of the loop. ?>

								<?php woocommerce_product_loop_end(); ?>

								<div class="toolbar tb-bottom">
									<div class="view-mode">
										<a href="#" class="grid <?php if($road_viewmode=='grid-view'){ echo ' active';} ?>" title="<?php echo esc_attr__( 'Grid' ); ?>"><i class="fa fa-th-large"></i><span><?php _e('Grid', 'roadthemes'); ?></span></a>
										<a href="#" class="list <?php if($road_viewmode=='list-view'){ echo ' active';} ?>" title="<?php echo esc_attr__( 'List' ); ?>"><i class="fa fa-th-list"></i><span><?php _e('List', 'roadthemes'); ?></span></a>
									</div>
									<?php
										/**
										 * woocommerce_before_shop_loop hook
										 *
										 * @hooked woocommerce_result_count - 20
										 * @hooked woocommerce_catalog_ordering - 30
										 */
										do_action( 'woocommerce_before_shop_loop' );
										do_action( 'woocommerce_after_shop_loop' );
										
									?>
									<div class="clearfix"></div>
								</div>
								
							<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

								<?php wc_get_template( 'loop/no-products-found.php' ); ?>

							<?php endif; ?>

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
					</div>
					<?php if($shopsidebar == 'right') :?>
						<?php get_sidebar('category'); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
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
<?php get_footer( 'shop' ); ?>