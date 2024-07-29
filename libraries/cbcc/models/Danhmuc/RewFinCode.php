<?php
class Danhmuc_Model_RewFinCode extends JModelLegacy {
    /**
     * @param mixed $formData
     * @return boolean True on success
     */
//    public function create($formData) {
//        $idMax = $this->getDataField('select max(id) id from rew_fin_code');
//        $idMax = (int) ($idMax) + 1;
//        $data = array(
//            'id' => $idMax,
//            'name' => $formData['name'],
//            'status' => $formData['status'],
//            'months_nangluongtruoc' => $formData['months_nangluongtruoc'],
//            'solantoidatrongnam' => $formData['solantoidatrongnam'],
//            'type' => $formData['type'],
//            'lev' => $formData['lev']
//        );
//        return Core::insert('rew_fin_code', $data);
//    }
    public function create($formData) {
        $idMax = $this->getDataField('select max(id) id from rew_fin_code');
        $idMax = (int) ($idMax) + 1;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // Insert columns.
        $columns = array('id', 'name',
            'status', 'months_nangluongtruoc',
            'solantoidatrongnam', 'type',
            'lev');

        // Insert values.
        $values = array($idMax, $db->quote($formData['name']),
            $db->quote($formData['status']), $db->quote((int) $formData['months_nangluongtruoc']),
            $db->quote($formData['solantoidatrongnam']), $db->quote($formData['type']),
            $db->quote($formData['lev']));

        // Prepare the insert query.
        $query
                ->insert($db->quoteName('rew_fin_code'))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $values));

        // Set the query using our newly populated query object and execute it.
        $db->setQuery($query);
        return $db->query();
    }
    public function update($formData) {
        $db = JFactory::getDbo();
        $query = 'UPDATE rew_fin_code SET 
    			name = "' . $formData['name'] . '", status = ' . $formData['status'] .
                ', lev = ' . $formData['lev'] .
                ', months_nangluongtruoc = ' . (int) $formData['months_nangluongtruoc'] .
                ', solantoidatrongnam = ' . $formData['solantoidatrongnam'] .
                ' WHERE  id = ' . $formData['id'] . ' and type = "' . $formData['type'] . '"';
        $db->setQuery($query);
        return $db->query();
    }
    public function read($id) {
        $table = Core::table('Danhmuc/RewFinCode');
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
                $query = "DELETE FROM rew_fin_code"
                        . " WHERE id =" . (int) $cids[$index] . " and type='" . $cids[$index + 1] . "'";
                $db->setQuery($query);
                if (!$db->query()) {
                    $this->setError($this->_db->getErrorMsg());
                    return false;
                }
            }
        }
        return true;
    }
    function removeconfig_kyluat($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "DELETE FROM nangluong_kyluat"
                . " WHERE kyluat_id =" . (int) $id;
        $db->setQuery($query);
        return $db->query();
    }
    function saveconfig_kyluat($id, $bienche_id, $sothang, $tacdongdenchucvu) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('bienche_id') . '=' . $db->quote($bienche_id),
            $db->quoteName('kyluat_id') . '=' . $db->quote($id),
            $db->quoteName('sothang') . '=' . $db->quote($sothang),
            $db->quoteName('tacdongdenchucvu') . '=' . $db->quote($tacdongdenchucvu),
        );
        $query->insert($db->quoteName('nangluong_kyluat'));
        $query->set($fields);
        $db->setQuery($query);
        return $db->query();
    }
    public function getDataByID($id = null, $type = null) {
        $db = JFactory::getDbo();
        $query = 'select * from rew_fin_code where id = ' . $id . ' and type = "' . $type . '"';
        $db->setQuery($query);
        return $db->loadObject();
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
                $query = 'UPDATE rew_fin_code SET status = ' . $publish .
                        ' WHERE id = ' . (int) $cids[$index] . ' and type = "' . $cids[$index + 1] . '"';
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
            $query .= ' WHERE ' . $where;
        }
        if (!empty($order)) {
            $query .= ' ORDER BY ' . $order;
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
    public function collect($params = null, $order = null, $offset = null, $limit = null){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.name,a.lev,a.months_nangluongtruoc AS sothang,a.solantoidatrongnam AS solan')
                ->from($db->quoteName('rew_fin_code', 'a'));
        if (isset($params['type']) && !empty($params['type'])) {
            $query->where('a.type = ' . $db->quote($params['type']));
        }
        if ($order == null) {
            $query->order('a.lev ASC');
        } else {
            $query->order($order);
        }
        if ($offset != null && $limit != null) {
            $db->setQuery($query, $offset, $limit);
        } else {
            $db->setQuery($query);
        }
        if (isset($params['key']) && !empty($params['key'])) {
            return $db->loadAssocList($params['key']);
        }else{
            return $db->loadAssocList();
        }
    }
}
