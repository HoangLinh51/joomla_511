<?php
class Danhmuc_Table_RewFinCode extends JTable
{
	var $id   		=	null;
	var $name   	=	null;
	var $status   	=	null;
	var $type		=	null;
	var $lev		=	null;

	function __construct($db)
	{
		parent::__construct( 'rew_fin_code', 'id', $db );
	}

}
