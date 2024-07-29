<?php
class Danhmuc_Table_Dmcvd extends JTable
{
    var $code   = null;
    var $name   = null;
    var $level   = null;
    var $status   = null;      
    
    function __construct($db)
    {
    	parent::__construct( 'party_pos_code', 'code', $db );
    }

}

