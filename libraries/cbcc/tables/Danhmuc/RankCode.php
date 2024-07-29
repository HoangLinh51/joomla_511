<?php
class Danhmuc_Table_RankCode extends JTable
{
    var $id   = null;
    var $name   = null;
    var $status   = null;      
    
    function __construct($db)
    {
    	parent::__construct( 'rank_code', 'id', $db );
    }

}

