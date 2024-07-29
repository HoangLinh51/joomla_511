<?php
/** 
	* User
	* Dec 10, 2014
	* fileDaotaoLophocHocvien.php
**/
class Daotao_Table_DaotaoLophocHocvien extends JTable
{
	var $id   		=	null;
	var $lophoc_id   	=	null;
	var $hocvien_id   	=	null;
	var $trangthai		=	null;
	var $donvi_id		=	null;

	function __construct($db)
	{
		parent::__construct( 'daotao_lophoc_hocvien', 'id', $db );
	}

}
