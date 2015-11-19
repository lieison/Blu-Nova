<?php
/**
 * The template for displaying posts in the Video post format
 *
 * @package WordPress
 * @subpackage Road_Themes
 * @since Road Themes 1.0
 */
global $road_opt, $road_postthumb;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php if ( ! post_password_required() && ! is_attachment() ) : ?>
	<?php 
		if ( is_single() ) { ?>
			
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
			
			<div class="entry-meta">
				<?php RoadThemes::road_entry_meta(); ?>
			</div>
			
		<?php }
		endif;
	?>
	
	<div class="player"><?php echo do_shortcode(get_post_meta( $post->ID, '_road_meta_value_key', true )); ?></div>
	
	<div class="postinfo-wrapper <?php if ( !has_post_thumbnail() ) { echo 'no-thumbnail';} ?>">
		<div class="post-info">
			<?php if ( !is_single() ) : ?>
				<header class="entry-header">
					<h1 class="entry-title">
						<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h1>
				</header>
				<footer class="entry-meta-small">
					<?php RoadThemes::road_entry_meta_small(); ?>
				</footer>
			<?php endif; ?>
			
			<?php if ( is_single() ) : ?>
				<div class="entry-content">
					<?php the_content( esc_html__( 'Continue reading <span class="meta-nav">&rarr;</span>', 'saharan' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'saharan' ), 'after' => '</div>', 'pagelink' => '<span>%</span>' ) ); ?>
				</div>
				<div class="blog-tags"><?php the_tags(); ?></div>
			<?php else : ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div>
				<a class="readmore" href="<?php the_permalink(); ?>"><?php if(isset($road_opt)){ echo esc_html($road_opt['readmore_text']); } else { esc_html_e('Read more', 'saharan');}  ?><i class="fa fa-arrow-right"></i></a>
			<?php endif; ?>
			
			<?php if ( is_single() ) : ?>

				
				<?php if( function_exists('road_blog_sharing') ) { ?>
					<div class="social-sharing"><?php road_blog_sharing(); ?></div>
				<?php } ?>
				<div class="author-info">
					<div class="author-avatar">
						<?php
						$author_bio_avatar_size = apply_filters( 'roadthemes_author_bio_avatar_size', 68 );
						echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
						?>
					</div>
					<div class="author-description">
						<h2><?php printf( wp_kses(__( 'About the Author: <a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ).'" rel="author">%s</a>', 'saharan' ), array('a'=>array('href'=>array(), 'rel'=>array()))), get_the_author() ); ?></h2>
						<p><?php the_author_meta( 'description' ); ?></p>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</article>