<?php
class Core_Table_IgnoreUser extends JTable
{
	var $id   = null;
	var $user_id   = null;	

	function __construct($db)
	{
		parent::__construct( 'core_ignore_user', 'id', $db );
	}

}
