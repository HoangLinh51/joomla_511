<?php
class Danhmuc_Table_DependStatus extends JTable
{
    var $id   = null;
    var $name   = null;
    var $status   = null;      
    
    function __construct($db)
    {
    	parent::__construct( 'depend_status', 'id', $db );
    }

}

