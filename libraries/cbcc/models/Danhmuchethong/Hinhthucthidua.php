<?php
class Danhmuchethong_Model_Hinhthucthidua {
    function luu_hinhthucthidua() {
        $jinput = JFactory::getApplication()->input;
		$formData = $jinput->get('frm',array(), 'array');
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('ten') . ' = ' . $db->quote($formData['ten']),
            $db->quoteName('sapxep') . ' = ' . $db->quote($formData['sapxep']),
            $db->quoteName('trangthai') . ' = ' . $db->quote($formData['trangthai']),
        );
        if (isset($formData['id']) && $formData['id'] > 0) {
            $conditions = array(
                $db->quoteName('id') . '=' . $db->quote($formData['id'])
            );
            $query->update($db->quoteName('danhmuc_thidua_hinhthuc'))->set($fields)->where($conditions);
            $db->setQuery($query);
        } else {
            $query->insert($db->quoteName('danhmuc_thidua_hinhthuc'));
            $query->set($fields);
            $db->setQuery($query);
        }
        return $db->query();
    }

    function xoa_hinhthucthidua() {
        $jinput = JFactory::getApplication()->input;
		$id = $jinput->getInt('id',0);
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('daxoa') . ' = 1',
        );
        $conditions = array(
            $db->quoteName('id') . ' = ' . $db->quote($id)
        );
        $query->update($db->quoteName('danhmuc_thidua_hinhthuc'))->set($fields)->where($conditions);
        $db->setQuery($query);
        return $db->query();
    }

}
