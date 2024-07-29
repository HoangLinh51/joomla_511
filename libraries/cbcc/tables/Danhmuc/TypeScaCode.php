<?php
class Danhmuc_Table_TypeScaCode extends JTable
{
	var $code		= null;
    var $name   	= null; 
    var $iscn 		= null;
    var $status 	= null;
    
    var $is_nghiepvu  = null;
    var $key   		= null;
    var $lim_code 	= null;
    
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(& $db)
    {
// Tạo ánh xạ vào DB
        parent::__construct('type_sca_code', 'code', $db);
    }

}
