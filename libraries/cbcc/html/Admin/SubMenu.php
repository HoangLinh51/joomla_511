<?php
/**
* @file: AdminSubMenu.php
* @author: huuthanh3108@gmaill.com
* @date: 06-04-2015
* @company : http://dnict.vn
* 
**/
class Admin_Html_SubMenu{
    public function build($component){
        // Reading file
        $xmlfile = JPATH_COMPONENT_ADMINISTRATOR.'/submenu.xml';
        $xml = JFactory::getXML($xmlfile,true);
    	foreach($xml->children() as $item){
    	    var_dump($item);
    	}    
    }
}