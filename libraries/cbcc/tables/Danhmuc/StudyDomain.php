<?php
class Danhmuc_Table_StudyDomain extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'study_domain', 'id', $db );
	}

}
