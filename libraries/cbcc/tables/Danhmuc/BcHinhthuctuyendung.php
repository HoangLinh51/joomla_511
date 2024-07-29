<?php
class Danhmuc_Table_BcHinhthuctuyendung extends JTable
{
	var $code = null;
    var $id   = null;
    var $name   = null;
    var $status   = null;      
    
    function __construct($db)
    {
    	parent::__construct( 'bc_hinhthuctuyendung', 'id', $db );
    }

}

