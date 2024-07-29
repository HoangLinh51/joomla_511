<?php

class Danhmuc_Model_PosSystem extends JModelLegacy {

    public function delete($node_id) {
        $table = Core::table('Danhmuc/PosSystem');
        return $table->delete($node_id);
    }
    public function rebuild() {
        $table = Core::table('Danhmuc/PosSystem');
        return $table->rebuild();
    }
    public function save($formData) {
        $table = Core::table('Danhmuc/PosSystem');
        $reference_id = (int) $formData['parent_id'];
// 		var_dump($reference_id); exit;
        if ($reference_id == 0) {
            $reference_id = $table->getRootId();
        }
        if ($reference_id === false) {
            $reference_id = $table->addRoot();
        }
        // Bind data to the table object.
        if (count($formData) > 0) {
            foreach ($formData as $key => $value) {
                if ($value == '') {
                    unset($formData[$key]);
                }
            }
        }
        //check new or edit
        if ((int) $formData['id'] > 0) {
            $table->load($formData['id']);
            if ($table->parent_id == $reference_id) {
                unset($formData['parent_id']);
                $table->bind($formData);
                $table->store();
            } else {
                $table->setLocation($reference_id, 'last-child');
                $table->bind($formData);
                $table->check();
                $table->store();
            }
        } else {
            $table->setLocation($reference_id, 'last-child');
            $table->bind($formData);
            // Force a new node to be created.
            $table->id = 0;
            // Check that the node data is valid.
            $table->check();
            // Store the node in the database table.
            $table->store(true);
        }
        return $table->id;
    }
    public function read($id) {
        $table = Core::table('Danhmuc/PosSystem');
        if (!$table->load($id)) {
            return array();
        }
        $fields = array_keys($table->getFields());
        $data = array();
        for ($i = 0; $i < count($fields); $i++) {
            $tmp_field =$fields[$i];
            $data[$fields[$i]] = $table-> $tmp_field;
        }
        return $data;
    }
    public function moveNode($id, $parent_id) {
        $table = Core::table('Danhmuc/PosSystem');
        $table->load($id);
        $table->parent_id = $parent_id;
        return $table->store();
    }
    public function collect($params = null, $order = null, $offset = null, $limit = null) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select(array('a.pos_system_id AS id', 'a.name AS value', 'b.coef AS heso', 'b.danhdaunhiemky', 'a.thoihanbonhiem', 'b.muctuongduong'))
                ->from($db->quoteName('cb_goichucvu_chucvu', 'a'))
                ->join('LEFT', ' pos_system AS b ON a.pos_system_id = b.id')
                ->where('a.goichucvu_id = (SELECT goichucvu FROM ins_dept WHERE id = ' . $db->quote($params['inst_code']) . ')')
                ->order('a.sapxep ASC,b.coef DESC');
        if (isset($params['name']) && !empty($params['name'])) {
            if (strpos($params['name'], 'button-ajax') === false) {
                $query->where('a.name LIKE (' . $db->quote('%' . $params['name'] . '%') . ')');
            }
        }
        if ($order == null) {
            $query->order('a.pos_system_id');
        } else {
            $query->order($order);
        }

        if ($offset != null && $limit != null) {
            $db->setQuery($query, $offset, $limit);
        } else {
            $db->setQuery($query);
        }
        return $db->loadAssocList();
    }
}
