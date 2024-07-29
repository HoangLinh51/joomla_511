<?php
class Danhmuc_Table_AreaCode extends JTable
{
    var $id   = null;
    var $name   = null;
    var $status   = null;      
    
    function __construct($db)
    {
    	parent::__construct( 'area_code', 'id', $db );
    }

}

