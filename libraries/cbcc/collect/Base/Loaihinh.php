<?php
class Base_Collect_Loaihinh{
    public static function collect($params = array(),$option = array())
    {
        $db = JFactory::getDbo();
        $query = "SELECT code as value, name as text FROM base_loaihinh";
        $db->setQuery( $query );
        return $db->loadObjectList();
    }

        /**
         *
         * @static
         * @param int $id
         * @return string
         */
    public static function getName($id,$option = array())
    {
        $db = JFactory::getDbo();
        $query = "SELECT name FROM base_loaihinh WHERE id = ".$id;
        $db->setQuery( $query );
        return $db->loadResult();
    }
}