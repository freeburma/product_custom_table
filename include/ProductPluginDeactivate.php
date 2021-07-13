<?php 

class ProductPluginDeactivate
{
    public static function deactivate()
    {
        flush_rewrite_rules( ); 
    }// end  activate()




}// end ProductPluginDeactivate()

?>