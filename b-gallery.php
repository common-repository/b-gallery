<?php
/*
 * Plugin Name: Beautiful Gallery
 * Plugin URI:  https://bplugins.com/
 * Description: Easily display your images and Videos on the web.
 * Version: 1.0.2
 * Author: bPlugins
 * Author URI: http://bplugins.com
 * License: GPLv3
 * Text Domain:  bgallery
 * Domain Path:  /languages
 * @fs_premium_only /premium-files/
*/

if (!defined('ABSPATH')) {
    exit;
}

/*Some Set-up*/
define('BPGAL_PLUGIN_DIR', plugin_dir_url(__FILE__));
define('BPGAL_VER', '1.0.2');


// load text domain
function bpgal_load_textdomain()
{
    load_plugin_textdomain('bgallery', false, dirname(__FILE__) . "/languages");
}

// bGallery
class BGallery {
    function __construct() {
        // Initialize here your hook
        add_action( 'wp_enqueue_scripts', [ $this,'bpgal_bGallery_assets'] );
        add_action( 'admin_enqueue_scripts', [$this, 'bpgal_bGallery_admin_assets'] );
        add_shortcode( 'bGallery', [$this, 'bpgal_bGallery_shortcode'] );
        add_action('init', [$this, 'bpgal_bGallery_post_type'] );
    }

    // bGallery Assets
    function bpgal_bGallery_assets() {
        // Register
        wp_register_script( 'bgallery-flashy-js', BPGAL_PLUGIN_DIR .'public/assets/js/jquery.flashy.min.js', ['jquery'], BPGAL_VER, true );
        wp_register_script( 'bgallery-main-js', BPGAL_PLUGIN_DIR .'public/assets/js/main.js', ['jquery'], BPGAL_VER, true );
        wp_localize_script( 'bgallery-main-js', 'ajax_obj', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_rest'),
            
            ] );

        wp_register_style( 'bgallery-flashy-css', BPGAL_PLUGIN_DIR .'public/assets/css/flashy.min.css', null, BPGAL_VER, 'all' );
        wp_register_style( 'bgallery-effect-css', BPGAL_PLUGIN_DIR .'public/assets/css/effect.css', null, BPGAL_VER, 'all' );
        wp_register_style( 'bgallery-main-css', BPGAL_PLUGIN_DIR .'public/assets/css/main.css', null, BPGAL_VER, 'all' );

        // Enqueue
        wp_enqueue_script( 'bgallery-flashy-js' );
        wp_enqueue_script( 'bgallery-main-js' );

        wp_enqueue_style( 'bgallery-flashy-css' );
        wp_enqueue_style( 'bgallery-effect-css' );
        wp_enqueue_style( 'bgallery-main-css' );

    }

    // Admin Style for bGallery
    function bpgal_bGallery_admin_assets() {
        wp_register_style( 'bgallery-admin-css', BPGAL_PLUGIN_DIR .'public/assets/css/admin-style.css', null, BPGAL_VER, 'all' );

        wp_enqueue_style( 'bgallery-admin-css' );
    }

    // bGallery Shortcode
    function bpgal_bGallery_shortcode( $atts ) {
        extract(shortcode_atts( array(
            'id'    => '223'
        ), $atts, 'bGallery' )); ob_start(); 
        
        // bGallery Meta
        $bGallery_datas = get_post_meta( $id, '_bGallery_', true );

        // echo "<pre>";

        $bGallery_type = isset( $bGallery_datas ['bgallery_type'] ) ? $bGallery_datas ['bgallery_type'] : 'image';

        $bgallery_col  = isset( $bGallery_datas ['bgallery_col'] ) ? $bGallery_datas ['bgallery_col'] : '';
        $bgallery_col_tablet  = isset( $bGallery_datas ['bgallery_col_tablet'] ) ? $bGallery_datas ['bgallery_col_tablet'] : '';
        $bgallery_col_mobile  = isset( $bGallery_datas ['bgallery_col_mobile'] ) ? $bGallery_datas ['bgallery_col_mobile'] : '';
        $column_gap    = isset( $bGallery_datas ['bgallery_col_gap'] ) ? $bGallery_datas ['bgallery_col_gap'] : '';
        $row_gap   = isset( $bGallery_datas ['bgallery_row_gap'] ) ? $bGallery_datas ['bgallery_row_gap'] : '';
         
        $overlay_hover = isset( $bGallery_datas ['video_hover_color'] ) ? $bGallery_datas ['video_hover_color'] : '';
        $btn_bg = isset( $bGallery_datas ['video_btn_bg'] ) ? $bGallery_datas ['video_btn_bg'] : '';
        $btn_hover = isset( $bGallery_datas ['video_btn_hover'] ) ? $bGallery_datas ['video_btn_hover'] : '';

        // LoadMOre
        $loadMore_text = isset( $bGallery_datas ['loadMore_btn_text'] ) ? $bGallery_datas ['loadMore_btn_text'] : '';
        $loadMore_textColor = isset( $bGallery_datas ['loadMore_text_color'] ) ? $bGallery_datas ['loadMore_text_color'] : '';
        $loadMore_bg = isset( $bGallery_datas ['loadMore_btn_bg'] ) ? $bGallery_datas ['loadMore_btn_bg'] : '';
        $loadMore_hover = isset( $bGallery_datas ['loadMore_hover_bg'] ) ? $bGallery_datas ['loadMore_hover_bg'] : '';

        // Item limit per page
        $limit = isset( $bGallery_datas['bgallery_item_limit'] ) ? $bGallery_datas['bgallery_item_limit'] : 8;
        $load_item  = isset( $bGallery_datas ['bgallery_item_load'] ) ? $bGallery_datas ['bgallery_item_load'] : '';

        // Initialize Class for control wrapper class
        $wrapper_class = 'bGallery'; // Default Class

        if($bGallery_type == 'video'){
            $wrapper_class .= ' vGallery-container';
        }else {
            $wrapper_class .=" bGallery-container";
        }

        ?>

        <!-- ShortCode Content Goes Here -->
        <div class="<?php echo esc_attr($wrapper_class);  ?>" data-load="<?php echo esc_attr($load_item) ?>" data-id='<?php echo esc_attr($id); ?>' data-limit='<?php echo esc_attr($limit) ?>'>
        <?php 


        $images = NULL;
        $videos = NULL;

        if( isset( $bGallery_datas ) && is_array( $bGallery_datas ) ): 

            $images = $bGallery_datas['bgallery_images'] ? explode(',', $bGallery_datas['bgallery_images']) : array();
            $videos = $bGallery_datas['bgallery_video'];
            $mixContent = $bGallery_datas['bgallery_mix_gallery'];
            $bgallery_height = $bGallery_datas['bgallery_item_height'];
            $bgallery_title_typo = $bGallery_datas['bgallery_title_typo'];
            $bgallery_images = is_array($images) ? array_slice($images, 0, $limit) : [];
            $bgallery_videos = is_array($videos) ? array_slice($videos, 0, $limit) : [];
            $bgallery_mix_content = is_array($mixContent) ? array_slice($mixContent, 0, $limit) : []; 
            // Include Templates
            require_once("templates/gallery-{$bGallery_type}.php");

         endif;

        ?>
        </div> <!-- End Main Wrapper -->

        <?php
            $loadMore_btn = '<div class="bGallery_button_area">
                <div id="bGal_btn">
                    <div id="bGal_moreMore">'. $loadMore_text. '</div>
                    <div class="loadingMain"><div id="loading">Loading</div> </div>
                </div>
            </div>';
            
            if( ($bGallery_type === 'image' && is_array($images) && count($images) > $limit) ){
                echo wp_kses( $loadMore_btn, array('div' => ['id' => [], 'class' => []]) ) ;
            }
            if ( ($bGallery_type === 'video' && is_array($videos) && count($videos) > $limit ) ) {
                echo wp_kses( $loadMore_btn, array('div' => ['id' => [], 'class' => []]) ) ;
            }
            if(($bGallery_type === 'mix' && is_array($mixContent) && count($mixContent) > $limit)) {
                echo wp_kses( $loadMore_btn, array('div' => ['id' => [], 'class' => []]) ) ;
            }
         ?>

        <!-- ShortCode Content End Here -->

        <style>

        /* Video Item css */
        .bGallery { 
            display:grid;
        }

        .bGallery {
            grid-template-columns: repeat(<?php echo esc_attr($bgallery_col); ?>, 1fr);
            grid-gap: <?php echo esc_attr($row_gap); ?>px <?php echo esc_attr($column_gap); ?>px;
        }

        @media all and (max-width: 767px) {
            .bGallery {
                grid-template-columns: repeat(<?php echo esc_attr($bgallery_col_tablet); ?>, 1fr);
            }
        }

        @media all and (max-width: 575px) {
            .bGallery {
                grid-template-columns: repeat(<?php echo esc_attr($bgallery_col_mobile); ?>, 1fr);
            }
        }

        .plyr_btn {
            background: <?php echo esc_attr($btn_bg); ?>
        }

        /* .bGallery .gallery-item .gallery {
            height:<?php //echo esc_attr($bgallery_height); ?>px;
        } */

        .gallery:hover .vOverlay {
            background: <?php echo esc_attr($overlay_hover); ?>
        }

        .gallery:hover .plyr_btn {
            background: <?php echo esc_attr($btn_hover); ?>;
        }

        .bGallery_title {
            font-family: <?php echo esc_attr($bgallery_title_typo['font-family'] );?>;
            text-transform: <?php echo esc_attr($bgallery_title_typo['text-transform']); ?>;
            font-weight: <?php echo esc_attr($bgallery_title_typo['font-weight']); ?>;
            font-size: <?php echo esc_attr($bgallery_title_typo['font-size']); ?><?php echo esc_attr($bgallery_title_typo['unit']); ?>;
            line-height: <?php echo esc_attr($bgallery_title_typo['line-height']); ?>;
            letter-spacing: <?php echo esc_attr($bgallery_title_typo['letter-spacing']); ?>;
            color: <?php echo esc_attr($bgallery_title_typo['color']); ?>;
        }

        /* Load More */
        #bGal_moreMore {
            background: <?php echo esc_attr($loadMore_bg); ?>;
            color: <?php echo esc_attr($loadMore_textColor); ?>;;
        }

        #bGal_moreMore:hover {
            background: <?php echo esc_attr($loadMore_hover); ?>;
        }
        </style>


    <?php
        return ob_get_clean();
    }

// CUSTOM POST TYPE
function bpgal_bGallery_post_type()
{
    $labels = array(
        'name'                  => __('B Gallery', 'bgallery'),
        'menu_name'             => __('B Gallery', 'bgallery'),
        'name_admin_bar'        => __('B Gallery', 'bgallery'),
        'add_new'               => __('Add New', 'bgallery'),
        'add_new_item'          => __('Add New ', 'bgallery'),
        'new_item'              => __('New Gallery ', 'bgallery'),
        'edit_item'             => __('Edit Gallery ', 'bgallery'),
        'view_item'             => __('View Gallery ', 'bgallery'),
        'all_items'             => __('All Galleries', 'bgallery'),
        'not_found'             => __('Sorry, we couldn\'t find the entry you are looking for.')
    );
    $args = array(
        'labels'             => $labels,
        'description'        => __('Gallery Options.', 'bgallery'),
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-format-image',
        'query_var'          => true,
        'rewrite'            => array('slug' => 'gallery'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'publicly_queryable' => true,
        'hierarchical'       => true,
        'menu_position'      => 20,
        'supports'           => array('title'),
    );
    register_post_type('bgallery', $args);

}

}
new BGallery(); // End of BGallery Class

// Function for loadMore Data fetch 
function bpgal_more_post_ajax(){

    if (!wp_verify_nonce(sanitize_text_field($_GET['nonce']), 'wp_rest')) {
        wp_send_json_error("Error");
    }

    
    // bGallery Meta
    $id = sanitize_text_field( $_GET['id']);
    $offset = sanitize_text_field($_GET['offset']);
     
    
    $bGallery_datas = get_post_meta( $id, '_bGallery_', true );
    
    $bGallery_type = isset( $bGallery_datas ['bgallery_type'] ) ? $bGallery_datas ['bgallery_type'] : 'image';
    $loadItem  = isset( $bGallery_datas ['bgallery_item_load'] ) ? $bGallery_datas ['bgallery_item_load'] : '';
    $column_gap    = isset( $bGallery_datas ['bgallery_col_gap'] ) ? $bGallery_datas ['bgallery_col_gap'] : '';
    $overlay_hover = isset( $bGallery_datas ['video_hover_color'] ) ? $bGallery_datas ['video_hover_color'] : '';
    $btn_bg = isset( $bGallery_datas ['video_btn_bg'] ) ? $bGallery_datas ['video_btn_bg'] : '';
    $btn_hover = isset( $bGallery_datas ['video_btn_hover'] ) ? $bGallery_datas ['video_btn_hover'] : '';
    
    // Take limit values according to column count
    $limit = $loadItem;
    
    ob_start();
    if( isset( $bGallery_datas ) && is_array( $bGallery_datas ) ): 
        
        $images = explode( ',', $bGallery_datas['bgallery_images']);
        $videos = $bGallery_datas['bgallery_video'];
        $mixContent = $bGallery_datas['bgallery_mix_gallery'];
        
        // Control Content Type
        if( 'image' === $bGallery_type ) : 
            $bgallery_images = array_slice($images, $offset, $limit);
            require_once 'Elements/Image.php';
            ?>
        <?php endif; ?>
        
        <?php if( 'video' === $bGallery_type ) :
            $bgallery_videos = array_slice($videos, $offset, $limit);
            require_once 'Elements/Video.php'; ?>
        <?php endif;?>
        
        <!-- Mix content  -->
        <?php if( 'mix' === $bGallery_type ) :
            $bgallery_mix_content = array_slice($mixContent, $offset, $limit);
            require_once 'Elements/Mix.php';
        endif;
    endif;
    
    $content = ob_get_contents();
    ob_get_clean();
    
    $item = true;
    if($bGallery_type == 'image'){
        $item = count(array_slice($images, $offset + $limit, $limit)) > 0 ? true :  false;
    }else if($bGallery_type == 'video'){
        $item = count(array_slice($videos, $offset + $limit, $limit)) > 0 ? true : false;
    }else if($bGallery_type == 'mix'){
        $item = count(array_slice($mixContent, $offset + $limit, $limit)) > 0 ? true : false;
    }
    
    // wp_send_json_success(compact('content', 'item'));
    echo wp_json_encode([
        'item' => $item,
        'content' => $content,
    ]);
    wp_reset_postdata();

    die(); // use die instead of exit 
  }
add_action('wp_ajax_load_more_post_ajax', 'bpgal_more_post_ajax'); 
add_action('wp_ajax_nopriv_load_more_post_ajax', 'bpgal_more_post_ajax');


// Inclusion External lib

// Option panel
require_once 'inc/codestar/csf-config.php';
if( class_exists( 'CSF' )) {
    require_once 'inc/bgallery-options.php';
}

// Additional Customize Feature
require_once 'inc/additional-customize.php';