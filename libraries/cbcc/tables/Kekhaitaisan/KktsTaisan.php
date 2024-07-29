<?php
class Kekhaitaisan_Table_KktsTaisan extends JTable
{
    var $id   			=	null;
    var $tenloaitaisan 	=	null;
    var $parent_id		=	null;
    var $type			=	null;   
    var $orders			=	null;
    var $status 		=	null;

    function __construct($db)
    {
    	parent::__construct( 'kkts_taisan', 'id', $db );
    }

}

