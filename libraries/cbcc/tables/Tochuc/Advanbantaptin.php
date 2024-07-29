<?php
class Tochuc_Table_Advanbantaptin extends JTable
{

	var $id = null;
	var $filename = null;
	var $content = null;
	var $vanban_id = null;
	var $date_created = null;
	

	function __construct(&$db)
	{
		parent::__construct( 'ins_vanban_taptin', 'id', $db );
	}
}
