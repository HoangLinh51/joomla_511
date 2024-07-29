<?php
class Tochuc_Table_Adlinhvuc extends JTableNested{
	// Your properties and methods go here.
	var $id = null;
	var $name = null;
	var $parent_id = null;
	var $type = null;
	var $level = null;
	var $lft = null;
	var $rgt = null;
	var $path = null;
	var $alias = null;

	function __construct(&$db)
	{
		parent::__construct( 'cb_type_linhvuc', 'id', $db );
	}
	public function addRoot() {
		$db = JFactory::getDbo ();
		$sql = 'INSERT INTO cb_type_linhvuc' . ' SET id = 1'
				.', parent_id = 0'
				. ', lft = 0'
						. ', rgt = 1'
								. ', level = 0'
										. ', name = '. $db->quote ( 'Hệ thống lĩnh vực' )
										.', status = 1'
												;
												$db->setQuery ( $sql );
												$db->query ();
		return $db->insertid();
	}
}