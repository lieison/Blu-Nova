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
        <div class="dg-box width-100 div-layers no-active">
        <div class="dg-box width-100">
            <div class="accordion">

                <h3><i class="fa fa-user"></i> <?php echo lang('designer_menu_choose_product'); ?></h3>

                <!-- dropdown list -->
                <div id="dg-layers">
                    <div class="col-sm-12" id="list-categories">
                        <?php if (isset($product->categories) && count($product->categories)) { ?>
                            <div class="col-xs-4 col-md-12">
                                <select data-level="1" id="parent-categories-1" class="form-control input-sm" onchange="design.products.changeCategory(this)">
                                    <option value="0"> - <?php echo lang('designer_product_select_category'); ?> - </option>
                                    <?php
                                     
                                    foreach ($product->categories as $category) {
                                        if ($category->parent_id > 0)
                                            continue;
                                        ?>
                                        <option value="<?php echo $category->id; ?>"><?php echo $category->title; ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        <?php } ?>
                    </div>
                    
                    <!-- show products -->
                    <div class="row">
                        <!-- list product category -->
                        <div class="product-list col-sm-12">
                          
                        </div>

                        <!-- product detail -->
                        <div class="products-detail col-sm-12">
                           <!-- <button type="button" class="btn btn-danger btn-sm" id="close-product-detail">Close</button> -->
                        </div>
                    </div>
                    
                   <!-- <button type="button" class="btn btn-primary" id="loading-change-product" data-loading-text="<?php echo lang('designer_loading_btn'); ?>..." onclick="design.products.changeDesign(this)"><?php echo lang('designer_product_change_product'); ?>
                    </button> -->
                    
                </div>

                <h3 onclick="javascript:void(0)" class="add_item_text" >
                    <i class="fa fa-text-height"></i> <?php echo lang('designer_menu_add_text'); ?>
                </h3>

                <div id="dg-layers">
                    <!-- --------------------CLASS dg-options-content-------------------------- -->
                    <div  class="">
                        <!-- edit text -->
                        <div class="row toolbar-action-text">
                            <div class="col-xs-12">
                                <textarea maxlength="25" class="form-control text-update" data-event="keyup" data-label="text" id="enter-text"></textarea>
                            </div>
                        </div>

                        <div class="row toolbar-action-fonts">
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <small><?php echo lang('designer_clipart_edit_choose_a_font'); ?></small>
                                    <div class="dropdown" data-target="#dg-fonts" data-toggle="modal">
                                        <a id="txt-fontfamily" class="pull-left" href="javascript:void(0)">
                                            <?php echo lang('designer_clipart_edit_arial'); ?>
                                        </a>
                                        <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s pull-right"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4 position-static">
                                <div class="form-group">
                                    <small><?php echo lang('designer_clipart_edit_text_color'); ?></small>
                                    <div class="list-colors">
                                        <a class="dropdown-color" id="txt-color" href="javascript:void(0)" data-color="black" data-label="color" style="background-color:black">
                                            <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear-line"></div>
                        <div class="clear"></div>

                        <div class="row toolbar-action-style">
                            <div class="col-xs-6">
                                <small><?php echo lang('designer_clipart_edit_text_style'); ?></small>
                                <div id="text-style">
                                    <span id="text-style-i" class="text-update btn btn-default btn-xs glyphicons italic glyphicons-12" data-event="click" data-label="styleI"></span>
                                    <span id="text-style-b" class="text-update btn btn-default btn-xs glyphicons bold glyphicons-12" data-event="click" data-label="styleB"></span>							
                                    <span id="text-style-u" class="text-update btn btn-default btn-xs glyphicons text_underline glyphicons-12" data-event="click" data-label="styleU"></span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <small><?php echo lang('designer_clipart_edit_text_align'); ?></small>
                                <div id="text-align">
                                    <span id="text-align-left" class="text-update btn btn-default btn-xs glyphicons align_left glyphicons-12" data-event="click" data-label="alignL"></span>
                                    <span id="text-align-center" class="text-update btn btn-default btn-xs glyphicons align_center glyphicons-12" data-event="click" data-label="alignC"></span>
                                    <span id="text-align-right" class="text-update btn btn-default btn-xs glyphicons align_right glyphicons-12" data-event="click" data-label="alignR"></span>
                                </div>
                            </div>
                        </div>

                        <div class="clear"></div>

                        <div class="row toolbar-action-size">
                            <div class="col-xs-3 col-lg-3 align-center">
                                <div class="form-group">
                                    <small><?php echo lang('designer_clipart_edit_width'); ?></small>
                                    <input type="text" size="2" id="text-width" readonly disabled>
                                </div>
                            </div>
                            <div class="col-xs-3 col-lg-3 align-center">
                                <div class="form-group">
                                    <small><?php echo lang('designer_clipart_edit_height'); ?></small>
                                    <input type="text" size="2" id="text-height" readonly disabled>
                                </div>
                            </div>
                            <div class="col-xs-6 col-lg-6 align-left">
                                <div class="form-group">
                                    <small><?php echo lang('designer_clipart_edit_unlock_proportion'); ?></small><br />
                                    <input type="checkbox" class="ui-lock" id="text-lock" />
                                </div>
                            </div>
                        </div>

                        <div class="row toolbar-action-rotate">					
                            <div class="form-group col-xs-12">
                                <small><?php echo lang('designer_clipart_edit_rotate'); ?></small>
                                <div class="">
                                    <span class="rotate-values"><input type="text" value="0" class="input-small rotate-value" id="text-rotate-value" />&deg;</span>
                                    <span class="rotate-refresh glyphicons refresh"></span>
                                </div>								
                            </div>
                        </div>

                        <div class="row toolbar-action-outline">				
                            <div class="form-group col-xs-12">
                                <small><?php echo lang('designer_clipart_edit_out_line'); ?></small>
                                <div class="option-outline">							
                                    <div class="list-colors">
                                        <a class="dropdown-color bg-none" data-label="outline" data-placement="top" href="javascript:void(0)" data-color="none">
                                            <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
                                        </a>
                                    </div>
                                    <div class="dropdown-outline">
                                        <a data-toggle="dropdown" class="dg-outline-value" href="javascript:void(0)"><span class="outline-value pull-left">0</span> <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s pull-right"></span></a>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                            <li><div id="dg-outline-width"></div></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php $addons->text(); ?>		
                    </div>
                    <!-- ---------------------------------------------- -->

                    <!-- BOTON PARA AGREGAR TEXTO -->
                    <ul class="menu-left">
                   
                        <li <?php echo cssShow($settings, 'show_add_text'); ?>>
                            <a href="javascript:void(0)" style="background-color:#601466;color:white;" class="add_item_text btn " title="">
                                <h6><?php echo lang('designer_menu_add_text'); ?></h6>
                            </a>
                           
                        </li>
                    </ul>
                    <!-- FINAL BOTON -->
                   
                </div>

                <!-- AGREGANDO ARTES -->
                
                <h3 onclick="clip_part();" id="clipart_design_1">
                     <i class="fa fa-image"></i> <?php echo lang('designer_menu_add_art'); ?>
                </h3>
                <div   id="dg-layers">
                    <ul    class="menu-left">
                        <div class="col-md-12">
                              <div class="input-group">
                                    <input type="text" id="art-keyword" autocomplete="off" class="form-control input-sm" placeholder="<?php echo lang('designer_clipart_search_for'); ?>">
                                    <span class="input-group-btn">
                                            <button class="btn btn-default btn-sm" onclick="design.designer.art.arts(0)" type="button"><?php echo lang('designer_clipart_search'); ?></button>
                                    </span>
                               </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row align-center">
					<div id="dag-art-panel">
						<a href="javascript:void(0)" title="<?php echo lang('designer_show_categories'); ?>">
							<?php echo lang('designer_clipart_shop_library'); ?> <span class="caret"></span>
						</a>
						<a href="javascript:void(0)" title="<?php echo lang('designer_show_categories'); ?>">
							<?php echo lang('designer_clipart_store_design'); ?> <span class="caret"></span>
						</a>
					</div>
				</div>						
				
				<div class="row">
                                    <div style="display:none;" id="dag-art-categories" class="row col-xs-4 col-md-3"></div>
                                    <div style="padding:5px;" class="col-xs-8 col-md-12">
                                            <div style="overflow:scroll;height:200px;width:100%" id="dag-list-arts"></div>
						<div id="dag-art-detail">
                                                    
                                                    
                                                        
                                                 
						</div>
                                            <div align="center">
                                                <button style="display:none;" id="art_close" onclick="void(0)"  type="button" class="btn btn-danger">
                                                        <?php echo lang('designer_close_btn'); ?>
                                                </button>
                                            </div>
					</div>								
				</div>
                        </div>
                        <div class="col-md-12">
                            <div class="align-right" id="arts-pagination" style="display:none">
					<ul class="pagination"></ul>
					<input type="hidden" value="0" autocomplete="off" id="art-number-page">
				</div>
				<div class="align-right" id="arts-add" style="display:none">
					<div class="art-detail-price"></div>
					<button type="button" class="btn btn-primary"><?php echo lang('designer_add_design_btn'); ?></button>
				</div>
                        </div>
                    </ul>
                </div>
            </div>

            <ul class="menu-left">                            
                <li style="display:none;" <?php echo cssShow($settings, 'show_product'); ?>>
                    <a href="javascript:void(0)" class="view_change_products" title="" data-toggle="modal" data-target="#dg-products">
                        <i class="glyphicons t-shirt"></i> <?php echo lang('designer_menu_choose_product'); ?>
                    </a>
                </li>			

                <!-- OCULTA enter text -->
                <li style="display:none;" style="display:none;" <?php echo cssShow($settings, 'show_add_text'); ?>>
                    <a href="javascript:void(0)" class="add_item_text" title="">
                        <i class="glyphicons text_bigger"></i> <?php echo lang('designer_menu_add_text'); ?>
                    </a>
                </li>
                <!--  -->

                <li  style="display:none;" <?php echo cssShow($settings, 'show_add_art'); ?>>
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

        
            <div class="layers-toolbar">
                <button type="button" class="btn btn-default">
                    <i class="fa fa-angle-right"></i>
                   
                </button>
                <button type="button" class="btn btn-default btn-sm">
                    <i class="fa fa-angle-left"></i>						
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