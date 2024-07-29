<?php
class Tochuc_Table_Adgoiluongngach extends JTable{
	// Your properties and methods go here.
	var $ID = null;
	var $ID_GOI = null;
	var $NGACH = null;	

	function __construct(&$db)
	{
		parent::__construct( 'cb_goiluong_ngach', 'ID', $db );
	}
}