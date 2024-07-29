<?php
class Danhmuc_Table_Nhomdoituong extends JTable{
	var $id = null;
	var $name = null;
	var $captochuc_id = null;	
	var $ghinhantrinhdo = null;
	var $active = null;	
	
	function __construct(&$db)
	{
		parent::__construct( 'dm_doituong', 'id', $db );
	}
	
}