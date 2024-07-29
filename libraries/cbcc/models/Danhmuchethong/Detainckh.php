<?php
class Danhmuchethong_Model_Detainckh {
    public function luu_detainckh() {
        $jinput = JFactory::getApplication()->input;
		$formData = $jinput->get('frm',array(), 'array');
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('name') . ' = ' . $db->quote($formData['name']),
            $db->quoteName('status') . ' = ' . $db->quote($formData['status']),
            $db->quoteName('order') . ' = ' . $db->quote($formData['order']),
        );
        if (isset($formData['id']) && $formData['id'] > 0) {
            $conditions = array(
                $db->quoteName('id') . '=' . $db->quote($formData['id'])
            );
            $query->update($db->quoteName('dm_detainckh'))->set($fields)->where($conditions);
            $db->setQuery($query);
        } else {
            $query->insert($db->quoteName('dm_detainckh'));
            $query->set($fields);
            $db->setQuery($query);
        }
        return $db->query();
    }

    public function xoa_detainckh() {
        $jinput = JFactory::getApplication()->input;
		$id = $jinput->getInt('id',0);
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('id') . ' = ' . $db->quote($id)
        );
        $query->delete($db->quoteName('dm_detainckh'));
        $query->where($conditions);
        $db->setQuery($query);
        return $db->query();
    }

}
