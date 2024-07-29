<?php
class Caicachhanhchinh_Table_Quytrinhhanhdong extends JTable
{
    var $id   = null;
    var $ten   = null;
    var $alias   = null;
    var $duongdan   = null;
    var $quytrinh_doituong_id   = null;
    var $havemulti   = null; 
    var $is_popup   = null;
    var $icon   = null;
    
    function __construct($db)
    {
    	parent::__construct( 'cchc_quytrinh_hanhdong', 'id', $db );
    }

}

