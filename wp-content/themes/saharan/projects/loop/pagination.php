<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author 		WooThemes
 * @package 	Projects/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wp_query, $road_opt;

/* $paged = get_query_var( 'paged', 1 );
if(!isset($wp_query->query["project-category"])){ //if is not the category page
	if( isset($road_opt['portfolio_per_page']) ) {
		query_posts( 'posts_per_page='.$road_opt['portfolio_per_page'].'&post_type=project&paged='.$paged );
	}
} */

$projects_per_page = 10;
if( isset($road_opt['portfolio_per_page']) ) {
	$projects_per_page = $road_opt['portfolio_per_page'];
}

$projects_args = $wp_query->query_vars;

$paged = get_query_var( 'paged', 1 );

$projects_args['post_type'] = 'project';
$projects_args['posts_per_page'] = $projects_per_page;
$projects_args['paged'] = $paged;

if(!isset($wp_query->query["project-category"])){ //if is not the category page
	$projects_args = array(
		'posts_per_page' => $projects_per_page,
		'post_type' => 'project',
		'paged' => $paged
	);
}
$projects_query = new WP_Query( $projects_args );

if ( $projects_query->max_num_pages <= 1 )
	return;
?>
<nav class="projects-pagination pagination">
	<?php
		echo paginate_links( apply_filters( 'projects_pagination_args', array(
			'base' 			=> str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
			'format' 		=> '',
			'current' 		=> max( 1, get_query_var('paged') ),
			'total' 		=> $projects_query->max_num_pages, //'total' 		=> $wp_query->max_num_pages,
			'prev_text' 	=> '&larr;',
			'next_text' 	=> '&rarr;',
			'type'			=> 'list',
			'end_size'		=> 3,
			'mid_size'		=> 3
		) ) );
	?>
</nav>