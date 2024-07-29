<?php
class Kekhaitaisan_Table_KktsCapcongtrinh extends JTable
{
    var $id   	=	null;
    var $name   =	null;
    var $status =	null;
    var $orders	=	null;     
    
    function __construct($db)
    {
    	parent::__construct( 'kkts_capcongtrinh', 'id', $db );
    }

}

