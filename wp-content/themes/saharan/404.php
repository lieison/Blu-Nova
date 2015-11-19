<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Road_Themes
 * @since Road Themes 1.0
 */

get_header();
global $road_opt;
?>
	<div class="main-container error404">
		<div class="entry-header">
			<h1><?php esc_html_e( "Oops ! That Page Can't Be Found.", 'saharan' ); ?></h2>
		</div>
		<?php if( isset($road_opt['image_404']['url']) ){ ?>
			<div class="image-404"><img src="<?php echo esc_url($road_opt['image_404']['url']); ?>" alt="" /></div>
		<?php } ?>
		<div class="form404-wrapper">
			<div class="container">
				<h2><?php esc_html_e("The page you are looking for is not found!", 'saharan');?></h2>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_html_e( 'Back to homepage', 'saharan' ); ?>"><?php esc_html_e( 'Back to homepage', 'saharan' ); ?></a>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>