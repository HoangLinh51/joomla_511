<?php
class Danhmuc_Table_EduForm extends JTable
{
	var $id   		= null;
	var $name   	= null;
	var $status   	= null;
	var $orders		= null;

	function __construct($db)
	{
		parent::__construct( 'edu_form', 'id', $db );
	}

}
