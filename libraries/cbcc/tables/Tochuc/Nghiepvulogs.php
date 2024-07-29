<?php
class Tochuc_Table_Nghiepvulogs extends JTable
{
	var $id = null;

	var $quatrinh_id = null;
	var $noidung = null;
	var $nghiepvu_id = null;
	var $nghiepvu_ten = null;
	var $donvi_id_input = null;
	var $donvi_id_output = null;

	
	function __construct(&$db)
	{
		parent::__construct( 'ins_dept_nghiepvu_logs', 'id', $db );
	}
}
