<?php
class Tochuc_Table_Adgoibienchehinhthuc extends JTable{
	// Your properties and methods go here.
	var $goibienche_id = null;
	var $hinhthuc_id = null;
	var $hinhthucdieudong_id = null;
	function __construct(&$db)
	{
		parent::__construct( 'bc_goibienche_hinhthuc', array('goibienche_id','hinhthuc_id'), $db );
	}
}