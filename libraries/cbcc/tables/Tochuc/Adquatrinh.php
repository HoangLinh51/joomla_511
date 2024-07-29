<?php
class Tochuc_Table_Adquatrinh extends JTable
{
	var $id = null;
	var $quyetdinh_so = null;
	var $quyetdinh_ngay = null;
	var $hieuluc_ngay = null;
	var $user_id = null;
	var $ghichu = null;
	var $chitiet = null;
	var $name = null;
	var $dept_id = null;
	var $cachthuc_id = null;
	var $ngay_tao = null;
	var $vanban_id = null;
	var $ordering = null;

	function __construct(&$db)
	{
		parent::__construct( 'ins_dept_quatrinh', 'id', $db );
	}
}
