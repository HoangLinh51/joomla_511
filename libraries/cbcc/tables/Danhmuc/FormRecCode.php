<?php
class Danhmuc_Table_FormRecCode extends JTable
{
    var $id   		=	null;
    var $name   	=	null; 
    var $whois_fk	=	null;
    var $status   	=	null;     
    
    function __construct($db)
    {
    	parent::__construct( 'form_rec_code', 'id', $db );
    }

}


