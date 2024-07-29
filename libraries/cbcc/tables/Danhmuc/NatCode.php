<?php
class Danhmuc_Table_NatCode extends JTable
{
	var $id   	=	null;
	var $name   =	null;
	var $status =	null;
	var $parent	=	null;

	function __construct($db)
	{
		parent::__construct( 'nat_code', 'id', $db );
	}

}
