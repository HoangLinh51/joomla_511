<?php
class Tochuc_Table_InsCap extends JTableNested{
	var $id = null;
	var $parent_id = 0;
	var $name = null;
	var $status = 1;
	var $level = null;
	var $lft = null;
	var $rgt = null;
		
	function __construct(&$db){
		parent::__construct( 'ins_cap', 'id', $db );
	}
	public function addRoot() {
		$db = JFactory::getDbo ();
		$sql = 'INSERT INTO ins_cap' . ' SET id = 5'
					.', parent_id = 0'
					. ', lft = 0'
					. ', rgt = 1'
					. ', level = 0'
					. ', name = '. $db->quote ( 'Root' )
					.', status = 1';
		$db->setQuery ( $sql );
		$db->query ();
		$root_id =  $db->insertid ();
		$sql = 'INSERT INTO ins_cap' . ' SET id = 1'
					.', parent_id = 5'
					. ', lft = 1'
					. ', rgt = 2'
					. ', level = 1'
					. ', name = '. $db->quote ( 'Hành chính' )
					.', status = 1';
		$db->setQuery ( $sql );
		$db->query ();
		$sql = 'INSERT INTO ins_cap' . ' SET id = 2'
					.', parent_id = 5'
					. ', lft = 3'
					. ', rgt = 4'
					. ', level = 1'
					. ', name = '. $db->quote ( 'Sự nghiệp' )
					.', status = 1';
		$db->setQuery ( $sql );
		$db->query ();
		return $root_id;
	}
}