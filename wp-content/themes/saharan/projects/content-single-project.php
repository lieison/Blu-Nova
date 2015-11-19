<?php
/**
 * The template for displaying project content in the single-project.php template
 *
 * Override this template by copying it to yourtheme/projects/content-single-project.php
 *
 * @author 		WooThemes
 * @package 	Projects/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $wpdb, $road_opt;

?>
<div class="main-container full-width">
	<div class="portfolio_header"><?php esc_html_e('Portfolio', 'saharan');?></div>
	<div class="container">
		<?php
			/**
			 * projects_before_single_project hook
			 *
			 */
			 do_action( 'projects_before_single_project' );
		?>

		<div id="project-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<div class="row">
				<?php $attachment_ids = projects_get_gallery_attachment_ids(); ?>
				
				<div class="col-xs-12 col-sm-9 col-md-5">
					<?php
						/**
						 * projects_before_single_project_summary hook
						 * @hooked projects_template_single_title - 10
						 * @hooked projects_template_single_short_description - 20
						 * @hooked projects_template_single_feature - 30
						 * @hooked projects_template_single_gallery - 40
						 */
						do_action( 'projects_before_single_project_summary' );
					?>
				</div>
				<?php if ( $attachment_ids ) { ?>
				<div class="col-xs-12 col-sm-3 col-md-1">
					<?php do_action( 'projects_single_project_gallery' ); ?>
				</div>
				<?php } ?>
				<div class="col-xs-12 col-md-<?php if ( $attachment_ids ) { echo '6';} else {echo '7';} ?>">
					<div class="project_date">
						<span class="day"><?php echo get_the_date('d'); ?></span>
						<span class="separator">/</span>
						<span class="month"><?php echo get_the_date('M'); ?></span>
						<div class="social-sharing"><?php road_blog_sharing(); ?></div>
					</div>
					<div class="summary entry-summary">
						<?php
							/**
							 * projects_single_project_summary hook
							 *
							 * @hooked projects_template_single_description - 10
							 * @hooked projects_template_single_meta - 20
							 */
							do_action( 'projects_single_project_summary' );
						?>

					</div><!-- .summary -->
				</div>
			</div>
			<?php
				/**
				 * projects_after_single_project_summary hook
				 *
				 */
				do_action( 'projects_after_single_project_summary' );
			?>
		</div><!-- #project-<?php the_ID(); ?> -->

		<?php
			/**
			 * projects_after_single_project hook
			 *
			 * @hooked projects_single_pagination - 10
			 */
			//do_action( 'projects_after_single_project' );
		?>
		<?php
		$include_categories = array();
		
		$terms = get_the_terms($post->ID, 'project-category' );
		
		if($terms){ ?>
		<div class="related_projects">
			<h3 class="related-title"><?php echo esc_html($road_opt['related_project_title']); ?></h3>
			<?php
			foreach ($terms as $term) {
				$include_categories[] = $term->term_id;
			}
			
			$args = array(
				'post_type'				=> 'project',
				'post_status' 			=> 'publish',
				'post__not_in'			=> array($post->ID),
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' 		=> 4,
				'orderby' 				=> 'date',
				'order' 				=> 'DESC',
				'tax_query' 			=> array(
											array(
												'taxonomy' 	=> 'project-category',
												'field' 	=> 'id',
												'terms' 	=> $include_categories,
												'operator' 	=> 'IN'
											)
										)
			);

			ob_start();

			$projects = new WP_Query( $args );

			if ( $projects->have_posts() ) : ?>

				<div class="row">
				<?php while ( $projects->have_posts() ) : $projects->the_post(); ?>

					<div class="col-xs-12 col-sm-3">
						<div class="single-featured">
							<?php if ( has_post_thumbnail() ) {
								$image       		= get_the_post_thumbnail( $post->ID, 'project-thumbnail' );
								$image_title 		= get_the_title( get_post_thumbnail_id() );
							?>
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $image_title); ?>">
								<?php echo ''.$image; ?>
								<span class="project-info">
									<span class="project-date"><?php echo get_the_date(); ?></span>
									<span class="project-title"><?php the_title(); ?></span>
								</span>
							</a>
							<?php } ?>
						</div>
					</div>

				<?php endwhile; // end of the loop. ?>
				</div>

			<?php endif;

			wp_reset_postdata(); ?>
			</div>
		<?php } ?>		
	</div>
</div>