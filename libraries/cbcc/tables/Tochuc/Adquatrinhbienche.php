<?php

use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;

class Tochuc_Table_Adquatrinhbienche extends Table{
	// Your properties and methods go here.
	var $id = null;
	var $quyetdinh_so = null;
	var $quyetdinh_ngay = null;
	var $hieuluc_ngay = null;
	var $user_id = null;
	var $ghichu = null;	
	var $dept_id = null;
	var $nghiepvu_id = null;
	var $ngay_tao = null;
	var $vanban_id = null;
	var $ordering = null;
	var $nam = null;
		

	function __construct(DatabaseDriver $db)
	{
		parent::__construct( 'ins_dept_quatrinh_bienche', 'id', $db );
	}
}