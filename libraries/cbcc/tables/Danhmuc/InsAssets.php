<?php
class Danhmuc_Table_InsAssets extends JTable
{
    var $id   = null;
    var $name   = null;
    var $status   = null;      
    
    function __construct($db)
    {
    	parent::__construct( 'ins_assets', 'id', $db );
    }

}

