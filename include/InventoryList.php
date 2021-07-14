<?php 
class InventoryList extends WP_List_Table
{
    public function __construct()
    {
        //// Assign the names to super class
        parent::__construct(array(
            'singular' => 'inventory', 
            'plural'   => 'inventory', 
            'ajax'     => false,
        )); 
    }

    public function get_columns()
    {
        $columns = array(
            'cb'            => '<input type="checkbox" />', // Multiple select
            'Id'            => _x('Id', 'Column label', 'inventory'),
            'Title'         => _x('Title', 'Column label', 'inventory'),
            'Description'    => _x('Description', 'Column label', 'inventory'),
        ); 

        return $columns; 

    }// end get_columns()

    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'Id'            => array('Id', false),
            'Title'         => array('Title', false),
            'Description'    => array('Description', false),
            
        ); 

        return $sortable_columns; 

    }// end get_sortable_columns()

    /*
        Must use the same name as "get_columns()" function/method (case sensitive). 
        *** Important to add if you are not using the default property
    */
    protected function column_default($item, $column_name) 
    {
        switch ($column_name) 
        {
            case 'Id':
            case 'Title':
            case 'Description':
                return $item[$column_name]; 
            
            default: 
                return print_r($item, true); // Showing the entire array for troubleshooting. 

        }// end switch

    }// end column_default()

    /*
        Input Checkbox
    */
    protected function column_cb( $item ) 
    {
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            $this->_args['singular'],  // Let's simply re-purpose the table's singular label ("movie").
            $item['Id']                // The value of the checkbox should be the record's Id.
        );

    }

    /** 
     * Note: Important =>function column_{<your_defined_column_name>} ()
     * Example: "column_Id" => is applied to ID column in the list 
     * If you want to apply in "Min_Km" col, the column name must be "column_Min_Km"
    */
    protected function column_Id($item)
    {
        $page = wp_unslash($_REQUEST['page']); // WPCS: Input var ok 

         // Detail Info
         $detail_query_args = array(
            'page'  => "Add_Edit_SaleData", // Must Be "PHP view file"
            'action' => 'detail', 
            'Id' => $item['Id'], // Passing as the routing parameter
        ); 

        // Edit Info
        $edit_query_args = array(
            'page'  => "Add_Edit_SaleData", // Must Be "PHP view file"
            'action' => 'edit', 
            'Id' => $item['Id'], // Passing as the routing parameter
        ); 

        // Delete Info
        $delete_query_args = array(
            'page'  => "Add_Edit_SaleData", // Must Be "PHP view file"
            'action' => 'delete', 
            'Id' => $item['Id'], // Passing as the routing parameter
        ); 

        $actions['detail'] = sprintf(
            '<a href="%1$s">%2$s</a>', 
            esc_url( wp_nonce_url( add_query_arg($detail_query_args, 'admin.php'), '', "myplugin_nonce" )), 
            _x('Detail', 'List table row action', 'sale-data')
        ); 

        $actions['edit'] = sprintf(
            '<a href="%1$s">%2$s</a>', 
            esc_url( wp_nonce_url( add_query_arg($edit_query_args, 'admin.php'), '', "myplugin_nonce" )), 
            _x('Edit', 'List table row action', 'sale-data')
        ); 

        $actions['delete'] = sprintf(
            '<a href="%1$s">%2$s</a>', 
            esc_url( wp_nonce_url( add_query_arg($delete_query_args, 'admin.php'), '', "myplugin_nonce" )), 
            _x('Delete', 'List table row action', 'sale-data')
        ); 


        // Return the title contents 
        return sprintf('%1$s <span style="color:silver;">(id:%2$s)</span>%3$s', 
        $item['Id'], 
        $item['Id'], 
        $this->row_actions($actions) 
        ); 


    }

    protected function get_bulk_actions() 
    {
        $actions = array(); 
        // $actions = array(
        //     'delete' => _x( 'Delete', 'List table bulk action', 'delivery-fee' ),
        // );

        return $actions;
    }


    /* 
        Bulk Action Delete
        TODO: Still hasn't implemented yet. 
    */
    protected function process_bulk_action()
    {
       
    }// end process_bulk_action()

    protected function usort_reorder($a, $b)
    {
        // If no sort, default to Id.
        $orderby = ! empty( $_REQUEST['orderby'] ) ? wp_unslash( $_REQUEST['orderby'] ) : 'Id'; // WPCS: Input var ok.

        // If no order, default to asc.
        $order = ! empty( $_REQUEST['order'] ) ? wp_unslash( $_REQUEST['order'] ) : 'dsc'; // WPCS: Input var ok.

        // Determine sort order.
        $result = strcmp( $a[ $orderby ], $b[ $orderby ] );

        return ( 'asc' === $order ) ? $result : - $result;
    }



    function prepare_items() 
    {
        


        /* Required: */
        $columns  = $this->get_columns(); 
        $hidden   = array(); 
        $sortable = $this->get_sortable_columns(); 

        $this->_column_headers = array( $columns, $hidden, $sortable);

        global $wpdb; 

        // $saleDataFromDb = $wpdb->get_results(
        //     $wpdb->prepare("SELECT * FROM wp_Custom_SaleData")
        // ); 

        // $saleDataFromDb = $wpdb->get_results(
        //     "SELECT * FROM wp_Custom_SaleData"
        // ); 

        $data = array(); 


        // foreach ($saleDataFromDb as $saleData) 
        // {
        //     $saleDataDetail = array(
        //         'Id' =>  $saleData->Id, 
        //         'Title' => $saleData->Title, 
        //         'Description' => $saleData->Description, 

        //     ); 

        //     //// Adding the data to array
        //     array_push($data, $saleDataDetail); 

        // }// end foreach

        // print_r($data); 

        // usort($data, array($this, 'usort_reorder')); // usort_reorder: is a callback function

        $per_page = 10; // Number of items per page 
        $current_page = $this->get_pagenum(); 
        $total_items = count($data); 

        $data = array_slice($data, (($current_page - 1) * $per_page), $per_page); 


        /*
        * REQUIRED. Now we can add our *sorted* data to the items property, where
        * it can be used by the rest of the class.
        */
        $this->items = $data;


        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items'   => $total_items, 
            'per_page'      => $per_page, 
            'total_pages'   => ceil($total_items / $per_page),
        ));




    }// end prepare_items()

}// end class InventoryList

?>