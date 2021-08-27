<?php 

class ProductPluginActivate
{
    public static function activate()
    {
        global $wpdb; 

        $createTable = $wpdb->prepare("CREATE TABLE IF NOT EXISTS wp_custom_inventory 
                                        (
                                            Id int NOT NULL AUTO_INCREMENT primary key, 
                                            Title TEXT, 
                                            ProductDescription TEXT, 
                                            FilePath TEXT,
                                            ImageName_1 TEXT,
                                            StoreDate DATETIME
                                        )"
                                    ); 

        $wpdb->query($createTable);                                     

        flush_rewrite_rules( ); 
    }// end  activate()




}// end ProductPluginActivate()

?>