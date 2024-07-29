<?php
class Danhmuc_Table_DanhmucThiduaKetqua extends JTable
{
	var $id   	       =	null;
	var $ten           =	null;
	var $trangthai     =	null;
	var $thidua_hinhthuc_id   =	null;

	function __construct($db)
	{
		parent::__construct( 'danhmuc_thidua_ketqua', 'id', $db );
	}

}
