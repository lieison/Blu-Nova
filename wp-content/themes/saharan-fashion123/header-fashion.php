<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Road_Themes
 * @since Road Themes 1.0
 */
?>
<?php global $road_opt; ?>
<div class="header-container layout1">	

    <!-- SE quito el header primero -->
    <?php if (!isset($road_opt)) { ?>
        <div class="top-bar">
            <div class="container">
                <div class="language">
                    <label><?php _e('Language:', 'roadthemes'); ?></label>
                    <?php do_action('icl_language_selector'); ?>
                </div> 
                <div class="currency-switcher">
                    <label><?php _e('Currency:', 'roadthemes'); ?></label>
                    <?php do_action('currency_switcher'); ?></div> 
                <?php
                if (isset($road_opt['top_menu'])) {
                    $menu_object = wp_get_nav_menu_object($road_opt['top_menu']);
                    $menu_args = array(
                        'menu_class' => 'nav_menu',
                        'menu' => $road_opt['top_menu'],
                    );
                    ?>
                    <div class="top-menu widget"> 
                    <?php wp_nav_menu($menu_args); ?>
                    </div>
    <?php } ?>

            </div>
        </div>
<?php } ?>
    <!-- SE quito el header primero -->
    
    <div style="background:#000000;" class="header">
        <div class="container">
            <div class="header-inner">
                <div class="row">
                    <div class="col-xs-12 col-lg-4 col-md-6">
                            <?php if (class_exists('WC_Widget_Product_Categories') && class_exists('WC_Widget_Product_Search')) { ?>
                            <div class="header-search">
                                <div class="cate-toggler"><?php _e('All Categories', 'roadthemes'); ?></div>
                            <?php the_widget('WC_Widget_Product_Categories', array('hierarchical' => true, 'title' => 'Categories', 'orderby' => 'order')); ?>
                            <?php the_widget('WC_Widget_Product_Search', array('title' => 'Search')); ?>
                            </div>
                        <?php } ?> 
                    </div>
                    <div class="col-xs-12 col-lg-4 col-md-3">
                        <?php if (isset($road_opt['logo_main']['url'])) { ?>
                            <div class="logo"><a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><img src="<?php echo esc_url($road_opt['logo_main']['url']); ?>" alt="" /></a></div>
                            <?php } else {
                            ?>
                            <h1 class="logo"><a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
    <?php }
?>
                    </div>
                    <div class="col-xs-12 col-lg-4 col-md-3"> 
                        <?php
                        if (class_exists('WC_Widget_Cart')) {
                            the_widget('Custom_WC_Widget_Cart');
                        }
                        ?>

                    </div>
                </div>
                    <?php if ((isset($road_opt['follow_us']) && $road_opt['follow_us'] != '')) {
                        ?>
                    <div class="follow-us">
                        <label><?php _e('Follow Us On:', 'roadthemes'); ?></label>
                        <?php
                        echo wp_kses($road_opt['follow_us'], array(
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
                        ));
                        ?>
                    </div>
                        <?php } ?>
            </div>
        </div>
        <style>
           
            
        </style>
        <div style="background:#282828;" class="nav-container">
            <div class="container">
                <div class="horizontal-menu">
                    <div class="visible-large">
<?php  wp_nav_menu(array('theme_location' => 'primary', 'container_class' => 'primary-menu-container', 'menu_class' => 'nav-menu' )); ?>
                    </div>
                    <div class="visible-small mobile-menu">
                        <div class="nav-container">
                            <div class="mbmenu-toggler"><?php echo esc_html($road_opt['mobile_menu_label']); ?><span class="mbmenu-icon"></span></div>
<?php wp_nav_menu(array('theme_location' => 'mobilemenu', 'container_class' => 'mobile-menu-container', 'menu_class' => 'nav-menu')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .header -->
    <div class="clearfix"></div>
</div>