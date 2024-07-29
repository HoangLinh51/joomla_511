<?php
class Danhmuc_Table_Grade25 extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;
	var $sta_level   = null;
	var $upgrade   = null;
	var $ngach   = null;
	var $code_parent   = null;
	var $nhomngach   = null;
	var $nganh   = null;
	
	function __construct($db)
	{
		parent::__construct( 'grade25', 'id', $db );
	}

}
