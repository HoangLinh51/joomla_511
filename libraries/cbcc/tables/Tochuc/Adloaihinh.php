<?php
class Tochuc_Table_Adloaihinh extends JTableNested
{
	// Your properties and methods go here.
	var $id = null;
	var $parent_id = 0;
	var $code = 0;
	var $level = 0;
	var $name = null;
	var $lft = null;
	var $rgt = null;

	function __construct(&$db)
	{
		parent::__construct( 'ins_dept_loaihinh', 'id', $db );
	}
	/**
	 * Add the root node to an empty table.
	 *
	 * @return integer The id of the new root node.
	 */
	public function addRoot() {
		$db = JFactory::getDbo ();
		$sql = 'INSERT INTO ins_dept_loaihinh' . ' SET id = 3'
				.', parent_id = 0'
						. ', lft = 0'
								. ', rgt = 5'
										. ', level = 0'
												. ', name = '. $db->quote ( 'Root' );
		$db->setQuery ( $sql );
		$db->query ();
		$root_id =  $db->insertid ();
		$sql = 'INSERT INTO ins_dept_loaihinh' . ' SET id = 1'
				.', parent_id = 3'
						. ', lft = 1'
								. ', rgt = 2'
										. ', level = 1'
												. ', name = '. $db->quote ( 'Hành chính' );
		$db->setQuery ( $sql );
		$db->query ();
		$sql = 'INSERT INTO ins_dept_loaihinh' . ' SET id = 2'
				.', parent_id = 3'
						. ', lft = 3'
								. ', rgt = 4'
										. ', level = 1'
												. ', name = '. $db->quote ( 'Sự nghiệp' );
		$db->setQuery ( $sql );
		$db->query();
		return $root_id;
	}
}