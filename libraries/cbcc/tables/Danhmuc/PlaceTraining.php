<?php
class Danhmuc_Table_PlaceTraining extends JTable
{
	var $code   = null;
    var $name   = null; 
    var $parent = null;
    var $status   = null;     
    
    
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(& $db)
    {
// Tạo ánh xạ vào DB
        parent::__construct('place_training', 'code', $db);
    }
}
