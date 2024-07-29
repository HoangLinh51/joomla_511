<?php
class Danhmuchethong_Model_Khenthuongkyluat {
    function luu_khenthuongkyluat() {
        $jinput = JFactory::getApplication()->input;
		$formData = $jinput->get('frm',array(), 'array');
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('name') . ' = ' . $db->quote($formData['name']),
            $db->quoteName('hinhthuc_id') . ' = ' . $db->quote($formData['hinhthuc_id']),
            $db->quoteName('type') . ' = ' . $db->quote($formData['type']),
            $db->quoteName('lev') . ' = ' . $db->quote($formData['lev']),
            $db->quoteName('months_nangluongtruoc') . ' = ' . $db->quote($formData['months_nangluongtruoc']),
            $db->quoteName('status') . ' = ' . $db->quote($formData['status']),
            // $db->quoteName('parent_id') . ' = ' . $db->quote($formData['parent_id']),
            $db->quoteName('ordering') . ' = ' . $db->quote($formData['ordering']),
            $db->quoteName('solantoidatrongnam') . ' = ' . $db->quote($formData['solantoidatrongnam']),
        );
        if (isset($formData['id']) && $formData['id'] > 0) {
            $conditions = array(
                $db->quoteName('id') . '=' . $db->quote($formData['id'])
            );
            $query->update($db->quoteName('rew_fin_code'))->set($fields)->where($conditions);
            $db->setQuery($query);
        } else {
            $query->insert($db->quoteName('rew_fin_code'));
            $query->set($fields);
            $db->setQuery($query);
        }
        return $db->query();
    }

    function xoa_khenthuongkyluat() {
        $jinput = JFactory::getApplication()->input;
		$id = $jinput->getInt('id',0);
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('id') . ' = ' . $db->quote($id)
        );
        $query->delete($db->quoteName('rew_fin_code'));
        $query->where($conditions);
        $db->setQuery($query);
        return $db->query();
    }

}
