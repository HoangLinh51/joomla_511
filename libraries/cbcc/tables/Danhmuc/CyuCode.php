<?php
class Danhmuc_Table_CyuCode extends JTable
{
    var $id   = null;
    var $name   = null;
    var $level   = null;
    var $status   = null;      
    
    function __construct($db)
    {
    	parent::__construct( 'cyu_code', 'id', $db );
    }

}

