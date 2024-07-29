<?php
/*
Khai báo một lớp ánh xạ của bảng phucapthamnien.
*/
// no direct access
defined('_JEXEC') or die('Truy nhập không hợp lệ');

class Danhmuc_Table_Phucapthamnien extends JTable
{
    var $id   				= null;
    var $name   			= null; 
    var $sonambatdau  	 	= null;
    var $phucaplandau		= null;
    var $sonamtangphucap	= null;
    var $phantramtangphucap	= null;
    var $status				= null;
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(& $db)
    {
// Tạo ánh xạ vào DB
        parent::__construct('phucapthamnien', 'id', $db);
    }
}
