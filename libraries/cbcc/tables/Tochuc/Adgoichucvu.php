<?php
class Tochuc_Table_Adgoichucvu extends JTableNested{
	// Your properties and methods go here.
	var $id = null;
	var $name = null;
	var $parent_id = null;
	var $status = null;
	var $ins_level_id = null;
	var $level = null;
	var $lft = null;
	var $rgt = null;
	var $path = null;
	var $alias = null;

	function __construct(&$db)
	{
		parent::__construct( 'cb_goichucvu', 'id', $db );
	}
	public function addRoot() {
		$db = JFactory::getDbo ();
		$sql = 'INSERT INTO cb_goichucvu' . ' SET id = 1'
				.', parent_id = 0'
				. ', lft = 0'
						. ', rgt = 1'
								. ', level = 0'
										. ', name = '. $db->quote ( 'Hệ thống Gói chức vụ' )
										.''
												;
												$db->setQuery ( $sql );
												$db->query ();
												return $db->insertid ();
	}
}