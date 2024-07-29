<?php
class Danhmuc_Table_LsCode extends JTable
{
    var $code   = null;
    var $name   = null; 
    var $lim_code = null;
    var $status   = null;        
    
    function __construct($db)
    {
    	parent::__construct( 'ls_code', 'code', $db );
    }

}

