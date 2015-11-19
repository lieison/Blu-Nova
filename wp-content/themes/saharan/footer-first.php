<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Road_Themes
 * @since Road Themes 1.0
 */
?>
<?php global $road_opt; ?>

			<div class="footer">
				<div class="f-breadcrumb">
					<div class="container">
						<?php if(function_exists('is_woocommerce') && is_woocommerce()){ 
							woocommerce_breadcrumb(); 
						} else {
							RoadThemes::road_breadcrumb();
						} ?>
					</div>
				</div>	
				
				<div class="footer-top">
					<div class="container">
						<div class="row">
							<?php
							if( isset($road_opt['footer_menu1']) && $road_opt['footer_menu1']!='' ) {
								$menu1_object = wp_get_nav_menu_object( $road_opt['footer_menu1'] );
								$menu1_args = array(
									'menu_class'      => 'nav_menu',
									'menu'         => $road_opt['footer_menu1'],
								); ?>
								<div class="col-xs-12 col-md-3 col-sm-3">
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
								<div class="col-xs-12 col-md-3 col-sm-3">
									<div class="widget widget_menu">
										<h3 class="widget-title"><?php echo esc_html($menu2_object->name); ?></h3>
										<?php wp_nav_menu( $menu2_args ); ?>
									</div>
								</div>
							<?php } ?>
							
							<?php if(isset($road_opt['ft_shortcode']) && $road_opt['ft_shortcode']!=''){ ?>
								<div class="col-xs-12 col-md-3 col-sm-3">
									<div class="widget widget_ftproducts">
										<h3 class="widget-title"><?php echo esc_html($road_opt['ft_shortcode_title']); ?></h3>
										<?php echo do_shortcode($road_opt['ft_shortcode']); ?>
									</div>
								</div>
								<?php } ?>
							
							<div class="col-xs-12 col-md-3 col-sm-3">
								<div class="widget ft-newsletter">
									<?php
									if ( isset($road_opt['newsletter_form']) ) {
										if(class_exists( 'WYSIJA_NL_Widget' )){
											the_widget('WYSIJA_NL_Widget', array(
												'title' => esc_html($road_opt['newsletter_title']),
												'form' => (int)$road_opt['newsletter_form'],
												'id_form' => 'newsletter1',
												'success' => '',
											));
										}
									}
									?>
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
				</div>
				
				<div class="footer-bottom">
					<div class="container">
						<div class="footer-bottom-inner">
							<div class="row">
								<div class="col-xs-12 col-md-6 col-sm-6">
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
											));
										} else {
											echo 'Copyright <a href="'.home_url().'">'.get_bloginfo('name').'</a> '.date('Y').'. All Rights Reserved';
										}
										?>
									</div>
								</div>
								<div class="col-xs-12 col-md-6 col-sm-6">
									<div class="bottom-right">
										<?php if(isset($road_opt['payment_icons'])) {
											echo wp_kses($road_opt['payment_icons'], array(
												'a' => array(
													'href' => array(),
													'title' => array()
												),
												'img' => array(
													'src' => array(),
													'alt' => array()
												),
											)); 
										} ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>