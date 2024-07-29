<?php
class Danhmuc_Table_Nhiemvuduocgiao extends JTable
{
    var $id   = null;
    var $ten   = null; 
    var $mota = null;
    var $trangthai   = null;        
    
    function __construct($db)
    {
    	parent::__construct( 'danhmuc_nhiemvuduocgiao', 'id', $db );
    }

}

