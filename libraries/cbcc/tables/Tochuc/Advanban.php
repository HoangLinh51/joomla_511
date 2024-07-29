<?php
class Tochuc_Table_Advanban extends JTable
{
	var $id = null;
	var $mahieu = null;
	var $tieude = null;
	var $trichdan = null;
	var $ngaybanhanh = null;
	var $nguoiky = null;
	var $ordering = null;
	var $coquan_banhanh_id = null;
	var $coquan_banhanh = null;
	var $ngaytao = null;
	var $nguoitao = 0;
	
	function __construct(&$db)
	{
		parent::__construct( 'ins_vanban', 'id', $db );
	}
}
