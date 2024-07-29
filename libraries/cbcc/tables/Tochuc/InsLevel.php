<?php
class Tochuc_Table_InsLevel extends JTableNested
{
	// Your properties and methods go here.
	var $id = null;
	var $parent_id = 0;
	var $name = null;
	var $thuhang = null;
	var $status = 1;
	var $level = null;	
	var $lft = null;
	var $rgt = null;
	var $alias = null;
	var $path = null;
	function __construct(&$db)
	{
		parent::__construct( 'ins_level', 'id', $db );
	}
	/**
	 * Add the root node to an empty table.
	 *
	 * @return integer The id of the new root node.
	 */
	public function addRoot() {
		$db = JFactory::getDbo ();
		$sql = 'INSERT INTO ins_level' . ' SET id = 1'
				.', parent_id = 0'
						. ', lft = 0'
								. ', rgt = 1'										
										. ', level = 0, thuhang = 0'												
												. ', name = '. $db->quote ( 'Hệ thống thứ hạng đơn vị' )
												.', status = 1';
		$db->setQuery ( $sql );
		$db->query ();
		return $db->insertid ();																													
		
	}
}