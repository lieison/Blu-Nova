<?php
$settings = $GLOBALS['settings'];
$addons = $GLOBALS['addons'];
?>
<div class="col-left">

    <!-- BOTONES OCULTOS (product info & size chart) -->
    <div style="display:none;" class="text-center product-btn-info">		
        <a href="#none" <?php echo cssShow($settings, 'show_product_info'); ?> data-target="#modal-product-info" data-toggle="modal" class="btn btn-default pull-left btn-sm"><i class="fa fa-info"></i> <span><?php echo lang('design_product_info'); ?></span></a>
        <a href="#none" <?php echo cssShow($settings, 'show_product_size'); ?> data-target="#modal-product-size" data-toggle="modal" class="btn btn-default pull-right btn-sm"><i class="fa fa-male"></i> <span><?php echo lang('design_size_chart'); ?></span></a>
    </div>
    <!-- -->

    <div id="dg-left" class="width-100">
        <div class="dg-box width-100">
            <div class="accordion">
                <h3><i class="fa fa-user"></i> <?php echo lang('designer_menu_choose_product'); ?></h3>
                <div id="dg-layers">
                    <ul>hola
                    </ul>
                </div>
                <h3><i class="fa fa-text-height"></i> <?php echo lang('designer_menu_add_text'); ?></h3>
                <div id="dg-layers">
                    <ul>hola
                    </ul>
                </div>
                <h3><i class="fa fa-image"></i> <?php echo lang('designer_menu_add_art'); ?></h3>
                <div id="dg-layers">
                    <ul>hola
                    </ul>
                </div>
            </div>

            <ul class="menu-left">                            
                <li <?php echo cssShow($settings, 'show_product'); ?>>
                    <a href="javascript:void(0)" class="view_change_products" title="" data-toggle="modal" data-target="#dg-products">
                        <i class="glyphicons t-shirt"></i> <?php echo lang('designer_menu_choose_product'); ?>
                    </a>
                </li>			
                <li <?php echo cssShow($settings, 'show_add_text'); ?>>
                    <a href="javascript:void(0)" class="add_item_text" title="">
                        <i class="glyphicons text_bigger"></i> <?php echo lang('designer_menu_add_text'); ?>
                    </a>
                </li>

                <li <?php echo cssShow($settings, 'show_add_art'); ?>>
                    <a href="javascript:void(0)" class="add_item_clipart" title="" data-toggle="modal" data-target="#dg-cliparts">
                        <i class="glyphicons picture"></i> <?php echo lang('designer_menu_add_art'); ?>
                    </a>
                </li>

                <!-- OCULTA upload image, name and number, my design & Add Qr-->
                <li style="display:none;" <?php echo cssShow($settings, 'show_add_upload'); ?>>
                    <a href="javascript:void(0)" title="" data-toggle="modal" data-target="#dg-myclipart">
                        <i class="glyphicons cloud-upload"></i> <?php echo lang('designer_menu_upload_image'); ?>
                    </a>
                </li>				
                <li style="display:none;" <?php echo cssShow($settings, 'show_add_team'); ?>>
                    <a href="javascript:void(0)" class="add_item_team" title="">
                        <i class="glyphicons soccer_ball"></i> <?php echo lang('designer_menu_name_number'); ?>
                    </a>
                </li>
                <li style="display:none;">
                    <a href="javascript:void(0)" class="add_item_mydesign">
                        <i class="glyphicons user"></i> <?php echo lang('designer_menu_my_design'); ?>
                    </a>
                </li>				
                <li style="display:none;" <?php echo cssShow($settings, 'show_add_qrcode'); ?>>
                    <a href="javascript:void(0)" class="add_item_qrcode" title="">
                        <i class="glyphicons qrcode"></i> <?php echo lang('designer_menu_add_qrcode'); ?>
                    </a>
                </li>
                <!-- -->

                <?php $addons->view('menu-left'); ?>
            </ul>
        </div>

        <div class="dg-box width-100 div-layers no-active">
            <div class="layers-toolbar">
                <button type="button" class="btn btn-default">
                    <i class="fa fa-long-arrow-down"></i>
                    <i class="fa fa-long-arrow-up"></i>
                </button>
                <button type="button" class="btn btn-default btn-sm">
                    <i class="fa fa-angle-right"></i>						
                </button>
            </div>

            <div class="accordion">
                <h3><?php echo lang('designer_menu_login_layers'); ?></h3>
                <div id="dg-layers">
                    <ul id="layers">									
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>