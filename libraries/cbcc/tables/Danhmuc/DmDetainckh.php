<?php
/*
Khai báo một lớp ánh xạ của bảng dm_detainckh.
*/
// no direct access
defined('_JEXEC') or die('Truy nhập không hợp lệ');

class Danhmuc_Table_DmDetainckh extends JTable
{
    var $id   = null;
    var $name   = null; 
    var $status   = null;
    var $order	= null;
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(& $db)
    {
// Tạo ánh xạ vào DB
        parent::__construct('dm_detainckh', 'id', $db);
    }
}
