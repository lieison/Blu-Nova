<?php

class LieisonTshirt {

    protected $path = NULL;

    public function __construct($path) {
        $this->path = $path;
    }

    /*     * *
     * @AUTHOR ROLANDO ARRIAZA 
     * @VERSION 1.0
     * @DIR      tshirtecommerce/admin/controllers/product.php 
     * ** */

    public function Save_WC($post) {


        include $this->path . "wp-config.php";

        global $current_user;  // obtiene el usuario actual logado  tipo array

        $user_id = $current_user->ID;


        $post_data = array(
            'post_author' => $user_id,
            'post_content' => $post['description'],
            'post_status' => "publish",
            'post_title' => $post['title'],
            'post_parent' => '',
            'post_type' => "product",
            'post_excerpt' => ""
        );



        //INSERCION DEL ITEM EN WOOCOMMERCES 
        $post_id = wp_insert_post($post_data);



        //ARREGLO QUE AGREGA ELPRODUCTO A WOOCOMMERCES Y SE ACTIVA SEGUN PLUGIN
        $array_data[] = array(
            "_product_id" => $post['id'],
            "_product_title_img" => $post['title'] . "::" . stripslashes($post['image'])
        );


        //ACTUALIZAMOS LA DATA EN LA EIQUETA 
        update_post_meta($post_id, 'wc_productdata_options', $array_data);


        //VERIFICAMOS SI EXISTE UN USUARIO A ASIGNARLE EL POST
        if ($current_user->ID == NULL || empty($current_user->ID)) {
            return null;
        }




        update_post_meta($post_id, '_vc_post_settings', 'a:1:{s:10:"vc_grid_id";a:0:{}}');

        //WOOCOMMERCES INFORMACION IMPORTANTE 
        update_post_meta($post_id, '_visibility', 'hidden');
        update_post_meta($post_id, '_stock_status', 'instock');


        update_post_meta($post_id, 'total_sales', '0');
        update_post_meta($post_id, '_downloadable', 'no');
        update_post_meta($post_id, '_virtual', 'no');


        update_post_meta($post_id, '_purchase_note', "");
        update_post_meta($post_id, '_featured', "no");


        update_post_meta($post_id, '_weight', "");
        update_post_meta($post_id, '_length', "");
        update_post_meta($post_id, '_width', "");
        update_post_meta($post_id, '_height', "");


        //WOOCOMMERCES PARA PLUGIN DE TSHIRT
        update_post_meta($post_id, '_product_version', "2.4.9");
        update_post_meta($post_id, '_edit_lock', rand(1000, 200000) . rand(455556, 488555) . ":" . "1");
        update_post_meta($post_id, '_edit_last', "1");
        update_post_meta($post_id, '_upsell_ids', array());
        update_post_meta($post_id, '_crosssell_ids', array());
        update_post_meta($post_id, '_edit_last', "1");


        //PRECIO DE VENTA
        update_post_meta($post_id, '_regular_price', $post['price']);
        update_post_meta($post_id, '_sale_price', $post['sale_price']);
        update_post_meta($post_id, '_price', $post['price']);


        update_post_meta($post_id, 'slide_template', "default");

        //WOOCOMMERCES NO HAY PIERDE ACA XD
        update_post_meta($post_id, '_sku', $post['sku']);

        update_post_meta($post_id, '_product_attributes', array());

        update_post_meta($post_id, '_sale_price_dates_from', "");
        update_post_meta($post_id, '_sale_price_dates_to', "");



        update_post_meta($post_id, '_sold_individually', "");
        update_post_meta($post_id, '_manage_stock', "no");

        update_post_meta($post_id, '_backorders', "no");
        update_post_meta($post_id, '_stock', "");

        //AGREGA UNA IMAGEN POR MEDIO DE URL ... 
        $image_id = $this->upload_image_from_url($post['image']);
         
        update_post_meta( $post_id, '_thumbnail_id', $image_id);
        update_post_meta( $post_id, '_product_image_gallery' , $image_id);


        //FINALIZANDO ... 
        //update_post_meta($post_id, '_visibility', 'hidden');

        return $post_id;
    }

    public function upload_image_from_url($filename) {

        
        include $this->path . "wp-config.php";

        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');


        $filetype           = wp_check_filetype(basename($filename), null);
        $wp_upload_dir      = wp_upload_dir();


        $attachment = array(
            'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
            'post_mime_type' => $filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content' => '',
            'post_status' => 'inherit',
            "post_type"  => 'attachment'
        );
        

        $post_id =  wp_insert_post($attachment);
        
        media_sideload_image($filename, $post_id  ); 
        
        $args = array(
                    'post_parent' => $post_id,
                    'post_type'   => 'attachment', 
                    'numberposts' => -1,
                    'post_status' => 'inherit' 
        ); 
        
        $data = end(get_children($args));
        
        
        return $data->ID;
    }

    /*     * *
     * @AUTHOR ROLANDO ARRIAZA 
     * @VERSION 1.0
     * @DIR      tshirtecommerce/admin/controllers/product.php 
     * ** */

    public function Update_WC($post, $post_id) {
        include $this->path . "wp-config.php";

        update_post_meta($post_id, '_price', $post['price']);
        update_post_meta($post_id, '_sku', $post['sku']);
        update_post_meta($post_id, '_product_image_gallery', $post['image']);
        update_post_meta($post_id, '_thumbnail_id', $post['image']);


        update_post_meta($post_id, '_regular_price', $post['price']);
        update_post_meta($post_id, '_sale_price', $post['sale_price']);
        update_post_meta($post_id, '_price', $post['price']);

        return;
    }

    public function Delete_WC($post_id) {

        include $this->path . "wp-config.php";

        try {

            wp_delete_post($post_id);
        } catch (Exception $ex) {
            
        }

        return;
    }

}
