<?php
class Kekhaitaisan_Table_KktsLoainha extends JTable
{
    var $id   	=	null;
    var $name   =	null;
    var $status =	null;
    var $orders	=	null;     
    
    function __construct($db)
    {
    	parent::__construct( 'kkts_loainha', 'id', $db );
    }

}

