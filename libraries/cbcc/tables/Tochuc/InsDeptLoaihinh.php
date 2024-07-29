<?php
class Tochuc_Table_InsDeptLoaihinh extends JTableNested{
    var $id = null;
    var $name = null;
    var $parent_id = null;
    var $level = null;
    var $lft = null;
    var $rgt = null;
    var $code = null;
    var $alias = null;
    var $path = null;
    
    function __construct(&$db){
        parent::__construct( 'ins_dept_loaihinh', 'id', $db );
    }
    public function findAll(){
        $query = $this->_db->getQuery(true);
        $query->select(array('id','name'))->from($this->_tbl);
        $this->_db->setQuery($query);
        return $this->_db->loadAssocList();
    }
    public function findAllParent(){
        $query = $this->_db->getQuery(true);
        $query->select(array('id','name'))->from($this->_tbl)->where('parent_id = '.$this->_db->quote($this->getRootId()));
        $this->_db->setQuery($query);
        return $this->_db->loadAssocList();        
    }
}