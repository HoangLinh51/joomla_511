<?php
/**
* @file: AttachmentTmp.php
* @author: huuthanh3108@gmaill.com
* @date: 01-04-2015
* @company : http://dnict.vn
* 
**/
class Core_Table_AttachmentTmp extends JTable{
    var $id = null;

    function __construct(&$db){
        parent::__construct( 'core_attachment_tmp', 'id', $db );
    }

}