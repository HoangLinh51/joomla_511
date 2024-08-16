<?php

use Joomla\CMS\Table\Table;

class Tochuc_Table_Adquatrinhbienchechitiet extends Table{
	// Your properties and methods go here.
	var $quatrinh_id = null;
	var $hinhthuc_id = null;
	var $bienche = null;

	function __construct(&$db)
	{
		parent::__construct( 'ins_dept_quatrinh_bienche_chitiet', array('quatrinh_id','hinhthuc_id'), $db );
	}
}