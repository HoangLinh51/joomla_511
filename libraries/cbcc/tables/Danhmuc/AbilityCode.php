<?php
class Danhmuc_Table_AbilityCode extends JTable
{
    var $id   = null;
    var $name   = null;
    var $status   = null;      
    
    function __construct($db)
    {
    	parent::__construct( 'ability_code', 'id', $db );
    }

}

