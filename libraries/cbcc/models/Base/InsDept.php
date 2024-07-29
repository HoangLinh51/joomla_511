<?php
class Base_Model_InsDept{
	public function getAllDeptManagerByUser($id_user,$type_id = null){
		$root = Core::getManageUnit($id_user);
		
		if ($root == null) {
			return null;
		}
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('node.id','node.name'))
			  ->from('ins_dept AS node, ins_dept AS parent')
			  ->where('node.lft BETWEEN parent.lft AND parent.rgt')
			  ->where('parent.id = '.$db->quote($root))
			  ->group('node.id')
			  ->group('node.lft')
		;
		if (is_array($type_id)) {
			$query->where('node.type IN ('.implode(',', $type_id).')');
		}elseif ($type_id != null){
			$query->where('node.type ='.$db->quote($type_id));
		}
		$db->setQuery($query);
		return $db->loadAssocList();
	}
}