<?php
class Capmathe_Table_PhoiCapmathe extends JTable{
    var $id = null;
    var $bc_hinhthuc_id = null;
    var $link = null;
    var $not_code = null;
    var $code = null;
    
    function __construct(&$db)
    {
        parent::__construct( 'phoicapmathe', 'id', $db );
    }
    public function getRowById($id){
        // Initialise the query.
        $query = $this->_db->getQuery(true)
        ->select('*')
        ->from($this->_tbl);
       // $fields = array_keys($this->getProperties());
        // Add the search tuple to the query.
        $query->where($this->_db->quoteName('id') . ' = ' . $this->_db->quote($id));
        $this->_db->setQuery($query);
        $row = $this->_db->loadAssoc();
        if(empty($row)){
            return array();
        }
        return $row;
    }

}