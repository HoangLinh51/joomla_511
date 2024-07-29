<?php
class Danhmuchethong_Model_Ketquathidua {
    function luu_ketquathidua() {
        $jinput = JFactory::getApplication()->input;
		$formData = $jinput->get('frm',array(), 'array');
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('ten') . ' = ' . $db->quote($formData['ten']),
            $db->quoteName('thidua_hinhthuc_id') . ' = ' . $db->quote($formData['thidua_hinhthuc_id']),
            $db->quoteName('trangthai') . ' = ' . $db->quote($formData['trangthai']),
        );
        if (isset($formData['id']) && $formData['id'] > 0) {
            $conditions = array(
                $db->quoteName('id') . '=' . $db->quote($formData['id'])
            );
            $query->update($db->quoteName('danhmuc_thidua_ketqua'))->set($fields)->where($conditions);
            $db->setQuery($query);
        } else {
            $query->insert($db->quoteName('danhmuc_thidua_ketqua'));
            $query->set($fields);
            $db->setQuery($query);
        }
        return $db->query();
    }

    function xoa_ketquathidua() {
        $jinput = JFactory::getApplication()->input;
		$id = $jinput->getInt('id',0);
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('id') . ' = ' . $db->quote($id)
        );
        $query->delete($db->quoteName('danhmuc_thidua_ketqua'));
        $query->where($conditions);
        $db->setQuery($query);
        return $db->query();
    }

}
