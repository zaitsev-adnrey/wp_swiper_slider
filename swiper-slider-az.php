<?php
/**
 * Plugin Name:     Swiper slider
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     at use https://swiperjs.com/
 * Author:          az
 * Author URI:      YOUR SITE HERE
 * Text Domain:     swiper-slider-az
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Swiper_Slider_Az
 */
 
/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/
 
if ( ! defined( 'RC_TC_BASE_FILE' ) )
    define( 'RC_TC_BASE_FILE', __FILE__ );
if ( ! defined( 'RC_TC_BASE_DIR' ) )
    define( 'RC_TC_BASE_DIR', dirname( RC_TC_BASE_FILE ) );
if ( ! defined( 'RC_TC_PLUGIN_URL' ) )
    define( 'RC_TC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

add_action( 'wp_enqueue_scripts', 'swiper_scripts' );
function swiper_scripts() {
    wp_enqueue_script('swiper-js', RC_TC_PLUGIN_URL .'/swiper/package/js/swiper.min.js');
    wp_enqueue_style('swiper-css', RC_TC_PLUGIN_URL .'/swiper/package/css/swiper.min.css');
    wp_enqueue_style( 'front-slideraz', RC_TC_PLUGIN_URL .'/css/style.css');
}

function true_include_myuploadscript() {
    wp_enqueue_script('jquery');
    // дальше у нас идут скрипты и стили загрузчика изображений WordPress
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
    wp_enqueue_script( 'myuploadscript', RC_TC_PLUGIN_URL .'/js/uploader.js', array('jquery'), null, false );
    wp_enqueue_script( 'slideraz-jquery-ui', RC_TC_PLUGIN_URL .'/js/jquery-ui.js', array('jquery'), null, false );
    wp_enqueue_style( 'slideraz-style', RC_TC_PLUGIN_URL .'/css/admin-style.css');
}
 
add_action( 'admin_enqueue_scripts', 'true_include_myuploadscript' ); 


include "post-types/slideraz.php";
include "metaboxs/meta.php";
include "metaboxs/options.php";
include "metaboxs/custom_param.php";
include "lib/functions.php";


add_shortcode( 'slideraz', 'slideraz_short_func' );
function slideraz_short_func( $atts ){
	$atts = shortcode_atts( array(
		'id' 		=> '',
		//'effect'  => 'default',
		'pager' 	=> '0',
		//'height' 	=> '',
		'rtl' 		=> 'off',
		'text'		=>  'bottom',
	), $atts );
	$out = template_return($atts['id'],$atts["pager"],$atts["rtl"],$atts["text"]);//,$atts["height"]
	return $out;
}
function slider_footer_js(){
		$sliders = get_posts( array('numberposts' => -1,'post_type'   => 'slideraz',) );
		foreach( $sliders as $slider ){
			$ID= $slider->ID;
			$options = get_post_meta( $ID, 'options', true );
			create_slider_js($ID,$options);
		}
	}
add_action('wp_footer','slider_footer_js');
