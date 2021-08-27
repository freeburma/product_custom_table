<?php 

class ProductPluginDeactivate
{
    public static function deactivate()
    {
        global $wpdb; 

        $deleteTable = "DROP TABLE IF EXISTS wp_custom_inventory"; 

        $wpdb->query($deleteTable); 

        flush_rewrite_rules( ); 
    }// end  activate()




}// end ProductPluginDeactivate()

?>