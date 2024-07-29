<?php
class Danhmuc_Table_WhoisPosMgr extends JTable
{
    var $id			    =	null;
    var $name		    =	null; 
    var $status		    =	null; 
    var $type		    =	null;
    var $is_dieudong	=	null;
    
    
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(& $db)
    {
// Tạo ánh xạ vào DB
        parent::__construct('whois_pos_mgr', 'id', $db);
    }
    /* function bind($array, $ignore = '')
    {
        if (key_exists( 'params', $array ) && is_array( $array['params'] ))
        {
                $registry = new JRegistry();
                $registry->loadArray($array['params']);
                $array['params'] = $registry->toString();
        }
        return parent::bind($array, $ignore);
    } */
}
