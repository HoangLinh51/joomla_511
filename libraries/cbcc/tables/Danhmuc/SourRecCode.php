<?php
class Danhmuc_Table_SourRecCode extends JTable
{
    var $id  = null;
    var $name   = null; 
    var $status   = null;     
    
    function __construct($db)
    {
    	parent::__construct( 'sour_rec_code', 'id', $db );
    }

}

