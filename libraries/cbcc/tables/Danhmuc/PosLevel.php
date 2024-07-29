<?php
class Danhmuc_Table_PosLevel extends JTable
{
	var $id			=	null;
	var $level		=	null;
	var $position	=	null;
	var $type_org	=	null;
	var $active		=	null;
	var $position2	=	null;
	var $position3	=	null;
	
    function __construct($db)
    {
    	parent::__construct( 'pos_level', 'id', $db );
    }

}

