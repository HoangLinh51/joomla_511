<?php
class Danhmuc_Table_StudyLevel extends JTable
{
	var $id   = null;
	var $name   = null;
	var $status   = null;

	function __construct($db)
	{
		parent::__construct( 'study_level', 'id', $db );
	}

}
