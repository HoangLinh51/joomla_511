<?php
class Danhmuc_Table_CommCurrCode extends JTable
{
    var $id   = null;
    var $name   = null;
    var $status   = null;      
    
    function __construct($db)
    {
    	parent::__construct( 'comm_curr_code', 'id', $db );
    }

}

