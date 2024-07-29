<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Table\Nested;

class Tochuc_Table_InsDept extends Nested
{
	// Your properties and methods go here.
	var $id = null;
	var $parent_id = 0;
	var $name = null;
	var $s_name = null;
	var $ss_name = null;
	var $code = null;
	var $ins_loaihinh = null;
	var $ins_cap = null;
	var $ins_cap_sn = null;
	var $number_created = null;
	var $date_created = null;
	var $type_created = null;
	var $active = null;
	var $ins_created = null;
	var $chitiet = null;
	var $ghichu = null;
	var $dienthoai = null;
	var $email = null;
	var $diachi = null;
	var $goibienche = null;
	var $goiluong = null;
	var $goichucvu = null;
	var $type = null;
	var $giao_bc = null;
	var $number_bc = null;
	var $year_bc = null;
	var $sl_hoso = null;
	var $masothue = null;
	var $masotabmis = null;
	var $eng_name = null;
	var $fax = null;
	var $phucapdacthu = null;
	var $ins_level  = null;
	var $vanban_active  = null;
	var $vanban_created = null;
	var $goihinhthuchuongluong = null;
	var $goidaotao = null;
	var $chucnang = null;
	

	function __construct(&$db)
	{
		parent::__construct( 'ins_dept', 'id', $db );
	}
	/**
	 * Add the root node to an empty table.
	 *
	 * @return integer The id of the new root node.
	 */
	public function addRoot() {
		$db = Factory::getDbo ();
		$sql = "INSERT INTO ins_dept (id,parent_id,lft,rgt,level,name) VALUES (1,0,0,1,0,'Viện kiểm sát')";
		$db->setQuery ( $sql );
		$db->query ();
		return $db->insertid ();
	}
}