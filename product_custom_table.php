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


    if ( ! class_exists('WP_List_Table'))
    {
        require_once(ABSPATH .  '/wp-admin/includes/class-wp-list-table.php'); 
    }// end if 

    require(dirname(__FILE__) . '/include/InventoryList.php'); 

    wp_enqueue_style( 'BootstrapCSS', '//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');

    wp_enqueue_script( 'JQuery', '//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'); 
    wp_enqueue_script( 'Propper', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js'); 
    wp_enqueue_script( 'BootstrapJS', '//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'); 

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


        add_submenu_page( 
                'tutorial_product', 
                'Inventory', 
                'Inventory', 
                'manage_options', 
                'tutorial_product_crud', 
                'Inventory_CRUD_page' 
        ); 

        add_submenu_page( 
            'tutorial_product', 
            'Test Image Upload', 
            'Test Image Upload', 
            'manage_options', 
            'testfileupload', 
            'Test_File_Upload_page' 
    ); 
    }// end product_custom_table_renderer()

    function product_page()
    {
        $inventoryList = new InventoryList(); 
        $inventoryList->prepare_items(); 



        include(dirname(__FILE__) . '/views/InventoryView.php'); 

    }// end product_page()

    function Inventory_CRUD_page()
    {
        include(dirname(__FILE__) . '/views/InventoryCRUDViews.php'); 
    }// end Inventory_CRUD_page()

    function Test_File_Upload_page()
    {
        include(dirname(__FILE__) . '/views/TestFileupload.php'); 
    }// end Inventory_CRUD_page()

    



    //// Adding the plugin to admin menu 
    add_action('admin_menu', 'product_custom_table_renderer'); 

    //// Activating plugin 
    require (dirname(__FILE__) . '/include/ProductPluginActivate.php'); 
    register_activation_hook( __FILE__, array('ProductPluginActivate', 'activate') ); 


    require (dirname(__FILE__) . '/include/ProductPluginDeactivate.php'); 
    register_deactivation_hook( __FILE__, array('ProductPluginDeactivate', 'deactivate') ); 

?>