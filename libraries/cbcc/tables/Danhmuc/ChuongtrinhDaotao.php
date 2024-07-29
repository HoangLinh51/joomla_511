<?php
class Danhmuc_Table_ChuongtrinhDaotao extends JTable
{
	var $id   = null;
    var $name   = null; 
    var $status   = null;     
    
    
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(& $db)
    {
// Tạo ánh xạ vào DB
        parent::__construct('danhmuc_chuongtrinhdaotao', 'id', $db);
    }
}
