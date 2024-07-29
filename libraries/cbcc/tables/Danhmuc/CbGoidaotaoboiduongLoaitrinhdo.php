<?php
class Danhmuc_Table_CbGoidaotaoboiduongLoaitrinhdo extends JTable
{	
	var $type_sca_code_id  = null;
	var $goidaotaoboiduong_id   = null;
	function __construct($db)
	{
		parent::__construct( 'cb_goidaotaoboiduong_loaitrinhdo',array('type_sca_code_id','goidaotaoboiduong_id'), $db );
	}

}
