<?php
class Danhmuc_Table_QualityLevel extends JTable
{
    var $id   = null;
    var $name   = null;
    var $status   = null;      
    
    function __construct($db)
    {
    	parent::__construct( 'quality_level', 'id', $db );
    }

}

