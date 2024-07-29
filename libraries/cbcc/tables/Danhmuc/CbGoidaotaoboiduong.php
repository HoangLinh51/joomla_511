<?php
class Danhmuc_Table_CbGoidaotaoboiduong extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;
	function __construct($db)
	{
		parent::__construct( 'cb_goidaotaoboiduong', 'id', $db );
	}

}
