<?php
// namespace Joomla\Libraries\Cbcc\Tables\Tochuc;

use Joomla\CMS\Access\Rules;
use Joomla\CMS\Table\Nested;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;
use Registry;

class QuatrinhbiencheTable extends Table{
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
		
	public function __construct(DatabaseDriver $db)
    {
        parent::__construct('ins_dept_quatrinh_bienche', 'id', $db);
    }


	public function bind($src, $ignore = '')
    {
        if (isset($src['params']) && is_array($src['params'])) {
            $registry = new Registry();
            $registry->loadArray($src['params']);
            $src['params'] = (string) $registry;
        }

        // Bind the rules.
        if (isset($src['rules']) && is_array($src['rules'])) {
            $rules = new Rules($src['rules']);
            $this->setRules($rules);
        }

        return parent::bind($src, $ignore);
    }

}