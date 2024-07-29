<?php

class Danhmuc_Table_FunctionCode extends JTable
{
    var $id  = null;
    var $name   = null; 
    var $status   = null;     
    
    function __construct($db)
    {
    	parent::__construct( 'function_code', 'id', $db );
    }

}
