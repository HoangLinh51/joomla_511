<?php
class Tochuc_Table_Adsapnhap extends JTable
{
	var $dept_chinh_id = null;
	var $dept_phu_id = null;
	var $quatrinh_id = null;
	var $dept_chinh_name = null;
	var $dept_phu_name = null;

	function __construct(&$db)
	{
		parent::__construct( 'ins_dept_sapnhap', array('dept_chinh_id','dept_phu_id','quatrinh_id'), $db );
	}
}
