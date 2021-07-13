<?php 
/*
    Plugin Name: Product Custom Table 
    Description: Product with Custom Table which will store product info. 
    Version: 1.0
    Author: Product Custom Table 
    License: GPLv2 or Later
    
    Text Domain: https://stackoverflow.com/questions/40867316/call-to-undefined-function-convert-to-screen

    **** Coding Ref: https://github.com/Veraxus/wp-list-table-example.git 

*/


    if ( ! defined('ABSPATH'))
    {
        exit; 
    }// end if 

    function product_custom_table_renderer()
    {
        add_menu_page( 
                        __('Product Custom Table', 'tutorial_product'), 
                        __('Product Custom Table', 'tutorial_product'), 
                        'activate_plugins', 
                        'tutorial_product', 
                        'product_page', 
                        'dashicons-text-page'
                    ); 
    }// end product_custom_table_renderer()

    function product_page()
    {

        include(dirname(__FILE__) . '/views/product.php'); 

    }// end product_page()

    



    //// Adding the plugin to admin menu 
    add_action('admin_menu', 'product_custom_table_renderer'); 

    //// Activating plugin 
    require (dirname(__FILE__) . '/include/ProductPluginActivate.php'); 
    register_activation_hook( __FILE__, array('ProductPluginActivate', 'activate') ); 


    require (dirname(__FILE__) . '/include/ProductPluginDeactivate.php'); 
    register_deactivation_hook( __FILE__, array('ProductPluginDeactivate', 'deactivate') ); 

?>