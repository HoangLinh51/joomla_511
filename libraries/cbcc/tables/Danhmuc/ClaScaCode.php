<?php
class Danhmuc_Table_ClaScaCode extends JTable
{
	var $id			=	null;
	var $tosc_code	=	null;
	var $code		=	null;
	var $name		=	null;
	var $s_name		=	null;
	var $step_2		=	null;
	var $step		=	null;
	var $step_name	=	null;
	var $step_name2	=	null;
	var $istext		=	null;
	var $is_core	=	0;
	var $ls_code	=	null;

	function __construct(& $db) {
		parent::__construct('cla_sca_code', 'id', $db);
	}

}
