<?php
/*
Khai báo một lớp ánh xạ của bảng dm_mucluongcoban.
*/
// no direct access
defined('_JEXEC') or die('Truy nhập không hợp lệ');

class Danhmuc_Table_DmMucluongcoban extends JTable
{
    var $id   = null;
    var $name   = null; 
    var $value = null;
    var $validity_date =null;
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
        parent::__construct('dm_mucluongcoban', 'id', $db);
    }
}
