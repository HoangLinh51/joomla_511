<?php
class Danhmuc_Table_ApprovType extends JTable
{
    var $id   = null;
    var $name   = null;
    var $status   = null;      
    
    function __construct($db)
    {
    	parent::__construct( 'approv_type', 'id', $db );
    }

}

