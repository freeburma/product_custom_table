<?php 

class ProductPluginActivate
{
    public static function activate()
    {
        flush_rewrite_rules( ); 
    }// end  activate()




}// end ProductPluginActivate()

?>