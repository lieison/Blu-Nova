<?php
$_SESSION["preset"] = 1;
/**
 * Template Name: Demo Second
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<?php global $road_opt; ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php 
if(isset($road_opt['opt-favicon']) && $road_opt['opt-favicon']!="") { 
	if(is_ssl()){
		$road_opt['opt-favicon'] = str_replace('http', 'https', $road_opt['opt-favicon']);
	}
?>
	<link rel="icon" type="image/png" href="<?php echo esc_url($road_opt['opt-favicon']['url']);?>">
<?php } ?>
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<script type="text/javascript">
var road_brandnumber = <?php if(isset($road_opt['brandnumber'])) { echo esc_js($road_opt['brandnumber']); } else { echo '6'; } ?>,
	road_brandscroll = <?php echo esc_js($road_opt['brandscroll'])==1 ? 'true': 'false'; ?>,
	road_brandscrollnumber = <?php if(isset($road_opt['brandscrollnumber'])) { echo esc_js($road_opt['brandscrollnumber']); } else { echo '2';} ?>,
	road_brandpause = <?php if(isset($road_opt['brandpause'])) { echo esc_js($road_opt['brandpause']); } else { echo '3000'; } ?>,
	road_brandanimate = <?php if(isset($road_opt['brandanimate'])) { echo esc_js($road_opt['brandanimate']); } else { echo '700';} ?>;
var road_blogscroll = <?php echo esc_js($road_opt['blogscroll'])==1 ? 'true': 'false'; ?>,
	road_blogpause = <?php if(isset($road_opt['blogpause'])) { echo esc_js($road_opt['blogpause']); } else { echo '3000'; } ?>,
	road_bloganimate = <?php if(isset($road_opt['bloganimate'])) { echo esc_js($road_opt['bloganimate']); } else { echo '700'; } ?>;
var road_testiscroll = <?php echo esc_js($road_opt['testiscroll'])==1 ? 'true': 'false'; ?>,
	road_testipause = <?php if(isset($road_opt['testipause'])) { echo esc_js($road_opt['testipause']); } else { echo '3000'; } ?>,
	road_testianimate = <?php if(isset($road_opt['testianimate'])) { echo esc_js($road_opt['testianimate']); } else { echo '700'; } ?>;
</script>
<?php wp_head(); ?>
</head>

<body <?php body_class('home'); ?>>
<div id="yith-wcwl-popup-message" style="display:none;"><div id="yith-wcwl-message"></div></div>
<div class="wrapper <?php if($road_opt['page_layout']=='box'){echo 'box-layout';}?>">
	<div class="page-wrapper">
		<div class="header-container layout1">
			<?php if(isset($road_opt)) { ?>
				<div class="top-bar">
					<div class="container">
						<div class="language">
						<label><?php _e('Language:', 'roadthemes'); ?></label>
							<?php do_action('icl_language_selector'); ?>
						</div> 
						<div class="currency-switcher">
						<label><?php _e('Currency:', 'roadthemes'); ?></label>
						<?php do_action('currency_switcher'); ?></div> 
						<?php if( isset($road_opt['top_menu']) ) {
							$menu_object = wp_get_nav_menu_object( $road_opt['top_menu'] );
							$menu_args = array(
								'menu_class'      => 'nav_menu',
								'menu'         => $road_opt['top_menu'],
							); ?>
							<div class="top-menu widget"> 
								<?php wp_nav_menu( $menu_args ); ?>
							</div>
						<?php } ?>

					</div>
				</div>
			<?php } ?>
			<div class="header">
				<div class="container">
					<div class="header-inner">
						<div class="row">
							<div class="col-xs-12 col-lg-4 col-md-6">
								<?php if( class_exists('WC_Widget_Product_Categories') && class_exists('WC_Widget_Product_Search') ) { ?>
									<div class="header-search">
										<div class="cate-toggler"><?php _e('All Categories', 'roadthemes');?></div>
										<?php the_widget('WC_Widget_Product_Categories', array('hierarchical' => true, 'title' => 'Categories', 'orderby' => 'order')); ?>
										<?php the_widget('WC_Widget_Product_Search', array('title' => 'Search')); ?>
									</div>
								<?php } ?> 
							</div>
							<div class="col-xs-12 col-lg-4 col-md-3">
								<?php if( isset($road_opt['logo_main']['url']) ){ ?>
									<div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url($road_opt['logo_main']['url']); ?>" alt="" /></a></div>
								<?php
								} else { ?>
									<h1 class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								} ?>
							</div>
							<div class="col-xs-12 col-lg-4 col-md-3"> 
								<?php if ( class_exists( 'WC_Widget_Cart' ) ) {
										the_widget('Custom_WC_Widget_Cart'); 
								} ?>
							  
							</div>
						</div>
						<?php if((isset($road_opt['follow_us']) && $road_opt['follow_us']!=''))
						{ ?>
							<div class="follow-us">
								<label><?php _e('Follow Us On:', 'roadthemes'); ?></label>
								<?php echo wp_kses($road_opt['follow_us'], array(
									'a' => array(
										'href' => array(),
										'title' => array()
									),
									'img' => array(
										'src' => array(),
										'alt' => array()
									),
									'ul' => array(),
									'li' => array(),
									'i' => array(
										'class' => array()
									),
									'br' => array(),
									'em' => array(),
									'strong' => array(),
									'p' => array(),
								)); ?>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="nav-container">
					<div class="container">
						<div class="horizontal-menu">
							<div class="visible-large">
								<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'primary-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
							</div>
							<div class="visible-small mobile-menu">
								<div class="nav-container">
									<div class="mbmenu-toggler"><?php echo esc_html($road_opt['mobile_menu_label']);?><span class="mbmenu-icon"></span></div>
									<?php wp_nav_menu( array( 'theme_location' => 'mobilemenu', 'container_class' => 'mobile-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- .header -->
			<div class="clearfix"></div>
		</div>
		<div class="main-container">
			<div class="page-content front-page">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					</article>
				<?php endwhile; ?>
				
			</div>
		</div>
	</div><!-- .wrapper -->
	<div class="footer"> 
		<?php if(isset($road_opt)) { ?> 
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-md-9">
						<div class="row">
							<?php
							if( isset($road_opt['footer_menu1']) && $road_opt['footer_menu1']!='' ) {
								$menu1_object = wp_get_nav_menu_object( $road_opt['footer_menu1'] );
								$menu1_args = array(
									'menu_class'      => 'nav_menu',
									'menu'         => $road_opt['footer_menu1'],
								); ?>
								<div class="col-xs-12 col-sm-4">
									<div class="widget widget_menu">
										<h3 class="widget-title"><?php echo esc_html($menu1_object->name); ?></h3>
										<?php wp_nav_menu( $menu1_args ); ?>
									</div>
								</div>
							<?php }
							if( isset($road_opt['footer_menu2']) && $road_opt['footer_menu2']!='' ) {
								$menu2_object = wp_get_nav_menu_object( $road_opt['footer_menu2'] );
								$menu2_args = array(
									'menu_class'      => 'nav_menu',
									'menu'         => $road_opt['footer_menu2'],
								); ?>
								<div class="col-xs-12 col-sm-4">
									<div class="widget widget_menu">
										<h3 class="widget-title"><?php echo esc_html($menu2_object->name); ?></h3>
										<?php wp_nav_menu( $menu2_args ); ?>
									</div>
								</div>
							<?php } 
							if( isset($road_opt['footer_menu3']) && $road_opt['footer_menu3']!='' ) {
								$menu3_object = wp_get_nav_menu_object( $road_opt['footer_menu3'] );
								$menu3_args = array(
									'menu_class'      => 'nav_menu',
									'menu'         => $road_opt['footer_menu3'],
								); ?>
								<div class="col-xs-12 col-sm-4">
									<div class="widget widget_menu">
										<h3 class="widget-title"><?php echo esc_html($menu3_object->name); ?></h3>
										<?php wp_nav_menu( $menu3_args ); ?>
									</div>
								</div>
							<?php } ?>
							
						</div>  
							<div class="copyright-info">
								<?php 
								if( isset($road_opt['copyright']) && $road_opt['copyright']!='' ) {
									echo wp_kses($road_opt['copyright'], array(
										'a' => array(
											'href' => array(),
											'title' => array()
										),
										'br' => array(),
										'em' => array(),
										'strong' => array(),
										'span' => array(),
									));
								} else {
									echo 'Copyright <a href="http://www.roadthemes.com/">Roadthemes</a> 2014. All Rights Reserved';
								}
								?>
							</div>    
					</div>
					 
					<div class="col-xs-12 col-md-3">
						<div class="widget widget_contact_us">
							<h3 class="widget-title"><?php echo esc_html($road_opt['contact_title']);?></h3>
							<?php echo wp_kses($road_opt['contact_us'], array(
								'a' => array(
									'href' => array(),
									'title' => array()
								),
								'img' => array(
									'src' => array(),
									'alt' => array()
								),
								'ul' => array(),
								'li' => array(),
								'i' => array(
									'class' => array()
								),
								'br' => array(),
								'em' => array(),
								'strong' => array(),
								'p' => array(),
							)); ?>
						</div>
						<?php if(isset($road_opt['social_icons'])) { ?>
							<div class="widget widget_social">
								<h3 class="widget-title"><?php echo esc_html($road_opt['follow_title']);?></h3>
									<?php echo '<ul class="social-icons">';
									foreach($road_opt['social_icons'] as $key=>$value ) {
										if($value!=''){
											echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-'.esc_attr($key).'"></i></a></li>';
										}
									}
									echo '</ul>'; ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div> 
		<?php } ?>
	</div>
		</div><!-- .page -->
	</div><!-- .wrapper -->
	<!--<div class="road_loading"></div>-->
	<div id="back-top" class="hidden-xs hidden-sm hidden-md"></div>
	<?php
	if ( isset($road_opt['newsletter_form']) && $road_opt['newsletter_form']!="" ) {
		if(class_exists( 'WYSIJA_NL_Widget' )){ ?>
			<div class="popupshadow"></div>
			<div class="newsletterpopup">
				<span class="close-popup"></span>
				<div class="nl-bg">
					<?php
					the_widget('WYSIJA_NL_Widget', array(
						'title' => esc_html($road_opt['newsletter_title']),
						'form' => (int)$road_opt['newsletter_form'],
						'id_form' => 'newsletter1_popup',
						'success' => '',
					));
					?>
					<?php if(isset($road_opt['social_icons'])) { ?>
						<div class="nl-follow">
							<h3><?php _e('Follow Us', 'roadthemes'); ?></h3>
							<?php
								echo '<ul class="social-icons">';
								foreach($road_opt['social_icons'] as $key=>$value ) {
									if($value!=''){
										if($key=='vimeo'){
											echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>';
										} else {
											echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-'.esc_attr($key).'"></i></a></li>';
										}
									}
								}
								echo '</ul>'; ?>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php }
	}
	?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/ie8.js" type="text/javascript"></script>
	<![endif]-->
	<?php wp_footer(); ?>
</body>
</html>
<?php unset($_SESSION["preset"]); ?>