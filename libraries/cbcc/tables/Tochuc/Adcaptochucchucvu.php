<?php
class Tochuc_Table_Adcaptochucchucvu extends JTable{
	// Your properties and methods go here.
	var $idchucvu = null;
	var $idcap = null;
	var $mangach = null;
	var $tencap = null;
	var $heso = null;
	
	function __construct(&$db)
	{
		parent::__construct( 'cb_captochuc_chucvu', 'idchucvu', $db );
	}
}