<?php
class Dtdb_Table_DoituongLoai extends JTable{
	var $id = null;
	var $doituong_id = null;
	var $name = null;
	var $s_name = null;
	var $text_ngay_cudihoc = null;
	var $text_soqd_cudihoc = null;
	var $text_ngay_botri = null;
	var $text_soqd_botri = null;
	var $valid_ngay_cudihoc = null;
	var $valid_soqd_cudihoc = null;
	var $valid_ngay_botri = null;
	var $valid_soqd_botri = null;
	var $is_delete = null;
	function __construct(&$db)
	{
		parent::__construct( 'dtdb_doituongloai', 'id', $db );
	}

}