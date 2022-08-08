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
 
 function lr_admin_menu_page(){
     add_menu_page(
        'Contact Management Plugin',
        'Contact Management',
        'manage_options',
        'list',
        'lr_admin_page_content',
        'dashicons-plugins-checked',
        1
     );
     
     add_submenu_page( 
         'list', 
         'Person - Create', 
         'Person - Create', 
         'manage_options', 
         'create', 
         'wps_person_func_add'
     );
     
     add_submenu_page( 
         'list', 
         'Person - Update', 
         'Person - Update', 
         'manage_options', 
         'atualizar', 
         'wps_person_func_edit'
     );
     
     add_submenu_page( 
         'list', 
         'Person - Delete', 
         'Person - Delete', 
         'manage_options', 
         'apagar', 
         'wps_person_func_del'
     );
     
     add_submenu_page( 
         'list', 
         'Contact - List', 
         'Contact - List', 
         'manage_options', 
         'list-contact', 
         'wps_contact_func_list'
     );
     
     add_submenu_page( 
         'list', 
         'Contact - Create', 
         'Contact - Create', 
         'manage_options', 
         'create-contact', 
         'wps_contact_func_add'
     );
     
     add_submenu_page( 
         'list', 
         'Contact - Update', 
         'Contact - Update', 
         'manage_options', 
         'atualizar-contact', 
         'wps_contact_func_edit'
     );
     
     add_submenu_page( 
         'list', 
         'Contact - Delete', 
         'Contact - Delete', 
         'manage_options', 
         'apagar-contact', 
         'wps_contact_func_del'
     );
 }
 add_action('admin_menu','lr_admin_menu_page');
 
function lr_admin_page_content(){
    require('crud_person/list.php');
}
function wps_person_func_add(){
    require('crud_person/create.php');
}
function wps_person_func_edit(){
    require('crud_person/atualizar.php');
}
function wps_person_func_del(){
    require('crud_person/apagar.php');
}
function wps_contact_func_list(){
    require('crud_contact/list.php');
}
function wps_contact_func_add(){
    require('crud_contact/create.php');
}
function wps_contact_func_edit(){
    require('crud_contact/atualizar.php');
}
function wps_contact_func_del(){
    require('crud_contact/apagar.php');
}
 
 