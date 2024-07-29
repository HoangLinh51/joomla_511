<?php
class Danhmuc_Table_StatusCode extends JTable
{
    var $id   		=	null;
    var $name   	=	null; 
    var $status   	=	null;     
    
    function __construct($db)
    {
    	parent::__construct( 'status_code', 'id', $db );
    }

}

