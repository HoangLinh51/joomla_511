<?php

class Danhmuc_Model_DanhmucThiduaHinhthuc extends JModelLegacy {

    public function create($formData) {
        $idMax = $this->getDataField('select max(id) id from danhmuc_thidua_hinhthuc');
        $idMax = (int) ($idMax) + 1;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
 
        // Insert columns.
        $columns = array('id', 'ten', 'trangthai');
        // Insert values.
        $values = array($idMax, $db->quote($formData['ten']),
            $db->quote($formData['trangthai']));
        // Prepare the insert query.
        $query
            ->insert($db->quoteName('danhmuc_thidua_hinhthuc'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
        // Set the query using our newly populated query object and execute it.
        $db->setQuery($query);
        return $db->query();
    }

    public function update($formData) {
        $db = JFactory::getDbo();
        $query = 'UPDATE danhmuc_thidua_hinhthuc SET 
    			ten = "' . $formData['ten'] . '", trangthai = ' . $formData['trangthai'] .
                ' WHERE  id = ' . $formData['id'];
        $db->setQuery($query);
        return $db->query();
    }

    public function read($id) {
        $table = Core::table('Danhmuc/DanhmucThiduaHinhthuc');
        if (!$table->load($id)) {
            return null;
        }
        $fields = array_keys($table->getFields());
        $data = array();
        $count = count($fields);
		for ($i = 0; $i < $count ; $i++) {
			$tmp = $fields[$i];
			$data[$fields[$i]] = $table->$tmp;
		}
        return $data;
    }

    public function delete($cid) {
        $result = false;
        if (count($cid)) {
            $db = JFactory::getDbo();
            $cids = implode(',', $cid);
            $cids = split(',', $cids);
            $count = count($cids);
            for ($index = 0; $index < $count; $index = $index + 2) {
                $query = "DELETE FROM danhmuc_thidua_hinhthuc"
                        . " WHERE id =" . (int) $cids[$index] ;
                $db->setQuery($query);
                if (!$db->query()) {
                    $this->setError($this->_db->getErrorMsg());
                    return false;
                }
            }
        }
        return true;
    }

    public function getDataByID($id = null, $type = null) {
        $db = JFactory::getDbo();
        $query = 'select * from danhmuc_thidua_hinhthuc where id = ' . $id;
        $db->setQuery($query);
        return $db->loadObject();
    }

    public function getDataSlect() {
        $db = JFactory::getDbo();
        $query = 'select id, ten from danhmuc_thidua_hinhthuc where trangthai = 1';
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    
    function getDataField($query = null) {
        $db = & JFactory::getDBO();
        $db->setQuery($query);
        $count = $db->loadResult();
        return $count;
    }

    function publish($cid = array(), $publish = 1) {
        $result = false;
        if (count($cid)) {
            $db = JFactory::getDbo();
            $cids = implode(',', $cid);
            $cids = split(',', $cids);
            $count = count($cids);
            for ($index = 0; $index < $count; $index = $index + 2) {
                $query = 'UPDATE danhmuc_thidua_hinhthuc SET trangthai = ' . $publish .
                        ' WHERE id = ' . (int) $cids[$index];
                $db->setQuery($query);
                if (!$db->query()) {
                    $this->setError($this->_db->getErrorMsg());
                    return false;
                }
            }
        }
        return true;
    }

    function __construct() {
        parent::__construct();

        $array = JRequest::getVar('cid', 0, '', 'array');
        global $mainframe, $option;
        $mainframe = &JFactory::getApplication();

        // Get the pagination request variables
        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart = $mainframe->getUserStateFromRequest($option . '.limitstart', 'limitstart', 0, 'int');
        // In case limit has been changed, adjust limitstart accordingly
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
    }

    function _buildQuery($tb = null, $order = null) {
        $db = &JFactory::getDbo();
        $post = JRequest::get('post');

        $query = 'SELECT * FROM ' . $tb;
        if (!empty($post['name_search'])) {
            $where [] = 'name LIKE ' . $db->quote('%' . $db->escape($post['name_search'], true) . '%', false);
        }
        if (!empty($post['cadc_code'])) {
            $where [] = 'cadc_code =' . $post['cadc_code'];
        }
        if (!empty($post['dc_cadc_code'])) {
            $where [] = 'dc_cadc_code =' . $post['dc_cadc_code'];
        }
        if (!empty($post['dc_code'])) {
            $where [] = 'dc_code =' . $post['dc_code'];
        }
        $where = (count($where)) ? implode(' AND ', $where) : '';
        if (!empty($where)) {
            $query .=' WHERE ' . $where;
        }
        if (!empty($order)) {
            $query .=' ORDER BY ' . $order;
        }

        return $query;
    }

    function getData($tb = null, $order = null) {
        // Load the data
        $db = &JFactory::getDbo();
        if (empty($this->_data)) {
            $query = $this->_buildQuery($tb, $order);
            $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
        }
        return $this->_data;
    }

    function getTotal($tb = null, $order = null) {
        // Lets load the content if it doesn't already exist
        if (empty($this->_total)) {
            $query = $this->_buildQuery($tb, $order);
            $this->_total = $this->_getListCount($query);
        }
        return $this->_total;
    }

    function getPagination($tb = null, $order = null) {

        // Lets load the content if it doesn't already exist
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal($tb, $order), $this->getState('limitstart'), $this->getState('limit'));
        }
        return $this->_pagination;
    }

}
