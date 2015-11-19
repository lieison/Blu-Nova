<?php
/**
 * The template for displaying project content within loops.
 *
 * Override this template by copying it to yourtheme/projects/content-project.php
 *
 * @author 		WooThemes
 * @package 	Projects/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $projects_loop, $road_opt, $road_projectrows, $road_projectsfound;

// Store loop count we're currently on
if ( empty( $projects_loop['loop'] ) )
	$projects_loop['loop'] = 0;
// Store column count for displaying the grid
if ( empty( $projects_loop['columns'] ) ) {
	$projects_loop['columns'] = apply_filters( 'projects_loop_columns', 4 );
}

$projects_loop['columns'] = $road_opt['portfolio_columns'];

if (isset($_GET['columns'])) {
	$projects_loop['columns'] = (int)$_GET['columns'];
}

// Increase loop count
$projects_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $projects_loop['loop'] - 1 ) % $projects_loop['columns'] && $projects_loop['loop'] > 1 )
	$classes[] = 'first';
if ( 0 == $projects_loop['loop'] % $projects_loop['columns'] )
	$classes[] = 'last';

$colwidth = 12/$projects_loop['columns'];
$classes[] = 'item-col col-xs-12 col-sm-'.$colwidth;

$prcates = get_the_terms($post->ID, 'project-category' );
$datagroup = array();
if($prcates){
	foreach ($prcates as $category ) {
		$datagroup[] = '"'.$category->slug.'"';
	}
}
$datagroup = implode(", ", $datagroup);
?>
<?php
if ( ( 0 == ( $projects_loop['loop'] - 1 ) % 2 ) && ( $projects_loop['columns'] == 2 ) ) {
	if($road_projectrows!=1) {
		echo '<div class="group">';
	}
}
?>
<div <?php post_class( $classes ); ?> data-groups='[<?php echo esc_attr($datagroup); ?>]'>

	<?php do_action( 'projects_before_loop_item' ); ?>

	<a href="<?php the_permalink(); ?>" class="project-permalink">
		
		<?php
			/**
			 * projects_loop_item hook
			 *
			 * @hooked projects_template_loop_project_thumbnail - 10
			 * @hooked projects_template_loop_project_title - 20
			 */
			do_action( 'projects_loop_item' );
		?>
		
		<span class="project-info">
			<span class="project-date"><?php echo get_the_date(); ?></span>
			<span class="project-title"><?php the_title(); ?></span>
		</span>
	</a>

	<?php
		/**
		 * projects_after_loop_item hook
		 *
		 * @hooked projects_template_short_description - 10
		 */
		//do_action( 'projects_after_loop_item' );
	?>

</div>
<?php if ( ( 0 == $projects_loop['loop'] % 2 || $road_projectsfound == $projects_loop['loop'] ) && ( $projects_loop['columns'] == 2 ) ) { /* for odd case: $road_projectsfound == $projects_loop['loop'] */
	if($road_projectrows!=1) {
		echo '</div>';
	}
} ?>