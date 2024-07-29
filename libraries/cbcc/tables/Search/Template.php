<?php
/**
* @file: SearchTemplate.php
* @author: huuthanh3108@gmaill.com
* @date: 02-04-2015
* @company : http://dnict.vn
* 
**/
class Search_Table_Template extends JTable{
    var $id = null;
    var $user_id = null;
    var $user_share = null;
    var $attachment_code = null;
    var $start = null;
    function __construct(&$db){
        parent::__construct( 'search_template', 'id', $db );
    }
    
}