<?php
class Traodoi_Table_Noidung extends JTable{
	var $id = null;
	var $chude_id = null;
	var $thongtinlienquan = null;
	var $nguoitao = null;
	var $tieude = null;
	var $noidung = null;
	var $ngaytao = null;
	var $fw_or_re = null;
	var $hienthi = null;
	var $draft = null;
	function __construct(&$db)
	{
		parent::__construct( 'traodoi_noidung', 'id', $db );
	}

}