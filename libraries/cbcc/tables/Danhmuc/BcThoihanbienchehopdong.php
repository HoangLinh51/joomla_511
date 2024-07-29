<?php
class Danhmuc_Table_BcThoihanbienchehopdong extends JTable
{
    var $id  = null;
    var $name   = null; 
    var $status   = null; 
    var $month   = null;
    var $deadline   = null;
    
    
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(& $db)
    {
// Tạo ánh xạ vào DB
        parent::__construct('bc_thoihanbienchehopdong', 'id', $db);
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
