<?php
class Danhmuc_Table_CbBacHeso extends JTable
{
	var $id   		= null;
	var $manhom   	= null;
	var $mangach   	= null;
	var $name  		= null;
	var $idnganh   	= null;
	var $mangachtiep 	= null;
	var $is_vuotkhung	= null;
	
	function __construct($db)
	{
		parent::__construct( 'cb_bac_heso', 'id', $db );
	}

}
