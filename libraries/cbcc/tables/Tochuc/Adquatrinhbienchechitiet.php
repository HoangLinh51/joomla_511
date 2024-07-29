<?php
class Tochuc_Table_Adquatrinhbienchechitiet extends JTable{
	// Your properties and methods go here.
	var $quatrinh_id = null;
	var $hinhthuc_id = null;
	var $bienche = null;

	function __construct(&$db)
	{
		parent::__construct( 'ins_dept_quatrinh_bienche_chitiet', array('quatrinh_id','hinhthuc_id'), $db );
	}
}