<?php
class Danhmuchethong_Model_Chucdanhcongtac {
    function luu_chucdanhcongtac() {
        $jinput = JFactory::getApplication()->input;
		$formData = $jinput->get('frm',array(), 'array');
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('name') . ' = ' . $db->quote($formData['name']),
            $db->quoteName('nangtu_chucdanh_id') . ' = ' . $db->quote($formData['nangtu_chucdanh_id']),
            $db->quoteName('sothanglandau') . ' = ' . $db->quote($formData['sothanglandau']),
            $db->quoteName('sothanglansau') . ' = ' . $db->quote($formData['sothanglansau']),
            $db->quoteName('phantram') . ' = ' . $db->quote($formData['phantram']),
            $db->quoteName('sapxep') . ' = ' . $db->quote($formData['sapxep']),
            $db->quoteName('trangthai') . ' = ' . $db->quote($formData['trangthai']),
            $db->quoteName('ngach_id') . ' = ' . $db->quote($formData['ngach_id']),
            $db->quoteName('muctuongduong') . ' = ' . $db->quote($formData['muctuongduong']),
        );
        if (isset($formData['id']) && $formData['id'] > 0) {
            $conditions = array(
                $db->quoteName('id') . '=' . $db->quote($formData['id'])
            );
            $query->update($db->quoteName('danhmuc_chucdanhcongtac'))->set($fields)->where($conditions);
            $db->setQuery($query);
        } else {
            $query->insert($db->quoteName('danhmuc_chucdanhcongtac'));
            $query->set($fields);
            $db->setQuery($query);
        }
        return $db->query();
    }

    function xoa_chucdanhcongtac() {
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
        $query->update($db->quoteName('danhmuc_chucdanhcongtac'))->set($fields)->where($conditions);
        $db->setQuery($query);
        return $db->query();
    }

}
