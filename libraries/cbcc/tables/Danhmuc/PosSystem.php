<?php
class Danhmuc_Table_PosSystem extends JTableNested
{
	var $id 		= null;
	var $name 		= null;
	var $parent_id	= null;
	var $coef 		= null;
	var $muctuongduong = null;
	var $chucvu 	= null;
	var $status 	= null;
	var $level 		= null;
	var $lft 		= null;
	var $rgt 		= null;
	var $path 		= null;
	var $alias 		= null;
	var $id_chucvutuongduong	=	null;

	function __construct(&$db)
	{
		parent::__construct( 'pos_system', 'id', $db );
	}
	public function addRoot() {
		$db = JFactory::getDbo ();
		$sql = 'INSERT INTO pos_system' . ' SET id = 5'
				.', parent_id = 0'
				. ', lft = 0'
						. ', rgt = 1'
								. ', level = 0'
										. ', name = '. $db->quote ( 'Hệ thống tổ chức' )
										.''
												;
												$db->setQuery ( $sql );
												$db->query ();
												return $db->insertid ();
	}
}
