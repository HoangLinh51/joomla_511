<?php
class Danhmuc_Table_ObCode extends JTable
{
    var $id   = null;
    var $name   = null;
    var $status   = null;      
    
    function __construct($db)
    {
    	parent::__construct( 'ob_code', 'id', $db );
    }

}

