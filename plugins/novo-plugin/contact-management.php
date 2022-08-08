<?php
/**
 * Plugin Name: Contact Management
 * Plugin URI: "https://www.alfasoft.pt/"
 * Description: Plugin desenvolvido para Gerenciar Contatos
 * Version: 1.0.0
 * Author: Lucas R. Domingues
 * Author URI: "https://curriculo-lucasrdomingues.web.app/"
 */
 
 if(!defined('WPINC')){die();}
 
 if(file_exists(plugin_dir_path(__FILE__). 'core-init.php')){
     require_once(plugin_dir_path(__FILE__). 'core-init.php');
 }