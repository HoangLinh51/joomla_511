<?php
class Core_Model_IgnoreUser{
	/**
	 * lay tat ca ignore user
	 * @return Ambigous <mixed, NULL, multitype:unknown Ambigous <unknown, mixed> >
	 */
	public function getAll(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select("a.id,a.user_id,b.name,b.username,b.email")
			->from('core_ignore_user a')
			->join('INNER','#__users b ON a.user_id = b.id')		
		;
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	/**
	 * Tao ignore user
	 * @param array $formData
	 * @return boolean
	 */
	public function create($formData){
		$table = Core::table('Core/IgnoreUser');
		$src = array(
			'user_id'=>$formData['user_id']
		);
		return $table->save($src);
	}
	/**
	 * Xoa ignore user
	 * @param int $id
	 * @return boolean
	 */
	public function delete($id){
		$table = Core::table('Core/IgnoreUser');
		return $table->delete($id);
	}
	/**
	 * Lay tat ca user group
	 * @return Ambigous <mixed, NULL, multitype:unknown Ambigous <unknown, mixed> >
	 */
	public function getUserGroups(){
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id AS value,title AS text')
				 ->from('#__usergroups')
		;
		//echo $query;
		//exit;
		$db->setQuery($query);
		return $db->loadAssocList();
		//$db->select('id AS value,title AS text')
		
	}
	/**
	 * User by group
	 * @return Ambigous <mixed, NULL, multitype:unknown Ambigous <unknown, mixed> >
	 */
	public function getUserByGroupId($group_id){
	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select("a.id AS value,CONCAT(a.name,' (',a.username,')') AS text")
		->from('#__users a')
		->join('INNER','#__user_usergroup_map b ON b.user_id = a.id')
		->where('b.group_id = '.$db->quote($group_id,'INTEGER'))
		;
		$db->setQuery($query);
		return $db->loadAssocList();
		//$db->select('id AS value,title AS text')
	
	}
}