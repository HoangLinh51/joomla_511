<?php

use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;

class Tochuc_Table_Advanban extends Table
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
	
	function __construct(DatabaseDriver $db)
	{
		parent::__construct( 'ins_vanban', 'id', $db );
	}
}
