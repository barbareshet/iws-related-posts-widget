<?php

/**
 * Plugin name: Ido related posts widget
 * Description: related posts widget for my personal site
 * Version: 1.0
 * Author: Ido Barnea
 * Author URI: http://www.barbareshet.co.il
 * Plugin Site: http://www.barbareshet.co.il
 * Text Domain: iws_rpp
 *
 **/
//Exit if accessed directly
if (!defined('ABSPATH')){
    exit;
}

define('TEXT_DOMAIN', 'iws_rpp');

require_once ( plugin_dir_path(__FILE__) . '/inc/iws-related-posts-class.php' );

/**
 * Register the Widget
 *
 * since 1.0
 */

function iws_related_posts_register_widget(){

    //Class name
    register_widget('iws_related_posts');
}

add_action('widgets_init', 'iws_related_posts_register_widget');