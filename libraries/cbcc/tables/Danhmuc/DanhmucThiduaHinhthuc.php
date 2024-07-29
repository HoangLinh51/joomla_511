<?php
class Danhmuc_Table_DanhmucThiduaHinhthuc extends JTable
{
	var $id   	       =	null;
	var $ten           =	null;
	var $trangthai     =	null;
// 	var $thidua_hinhthuc_id   =	null;

	function __construct($db)
	{
		parent::__construct( 'danhmuc_thidua_hinhthuc', 'id', $db );
	}

}
