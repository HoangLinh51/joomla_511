<?php
class Danhmuc_Table_MilCode extends JTable
{
    var $id   = null;
    var $name   = null;
    var $status   = null;      
    
    function __construct($db)
    {
    	parent::__construct( 'mil_code', 'id', $db );
    }

}

