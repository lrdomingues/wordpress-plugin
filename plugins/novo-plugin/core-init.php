<?php

if(!defined('WPINC')){die();}

define('LR_CORE_INC', dirname(__FILE__).'/inc/');
define('LR_CORE_IMG', plugins_url('img/',__FILE__));
define('LR_CORE_CSS', plugins_url('css/',__FILE__));
define('LR_CORE_JS', plugins_url('js/',__FILE__));

/**
 * Registrando CSS
 */
function lr_register_core_css(){
    wp_enqueue_style('lr_core', LR_CORE_CSS . 'core.css', null, time(), 'all');
}
add_action('wp_enqueue_scripts', 'lr_register_core_css');

/**
 * Registrando JS/jQuery
 */
function lr_register_core_js(){
    wp_enqueue_script('lr_core', LR_CORE_JS . 'core.js', 'jquery', time(), true);
}
add_action('wp_enqueue_scripts', 'lr_register_core_js');

/**
 * Registrando Includes
 */
if(file_exists(LR_CORE_INC. 'admin-functions.php')){
     require_once(LR_CORE_INC. 'admin-functions.php');
}