<?php
class Caicachhanhchinh_Table_Quytrinhdoituong extends JTable
{
    var $id   = null;
    var $ten   = null;
    var $alias   = null;
    var $havemulti   = null;      
    
    function __construct($db)
    {
    	parent::__construct( 'cchc_quytrinh_doituong', 'id', $db );
    }

}

