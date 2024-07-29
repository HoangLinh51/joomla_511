<?php
class Danhmuc_Model_TypeScaCode extends JModelLegacy
{
	/**
	 * @param mixed $formData
	 * @return boolean True on success
	 */
	public function create($formData){
		$table = Core::table('Danhmuc/TypeScaCode');
		$src['name'] 		=	$formData['name'];
		$src['status'] 		=	$formData['status'];
		$src['iscn'] 		=	$formData['iscn'];
		$src['is_nghiepvu'] =	$formData['is_nghiepvu'];
		$src['key'] 		=	$formData['key'];
		$src['lim_code'] 	=	$formData['lim_code'];
		
		return $table->save($src);
	}
	public function update($formData){
		$table = Core::table('Danhmuc/TypeScaCode');
		$src['code'] 		=	$formData['code'];
		$src['name'] 		=	$formData['name'];
		$src['status'] 		=	$formData['status'];
		$src['iscn'] 		=	$formData['iscn'];
		$src['is_nghiepvu'] =	$formData['is_nghiepvu'];
		$src['key'] 		=	$formData['key'];
		$src['lim_code'] 	=	$formData['lim_code'];
		return $table->save($src);
	}
	public function read($id){
		$table = Core::table('Danhmuc/TypeScaCode');
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
	public function delete($cid){
		$table = Core::table('Danhmuc/TypeScaCode');
		if(!is_array($cid)||count($cid)==0){
			$flag	=	false;
		}else {
			for ($i = 0; $i < count($cid); $i++) {
				$flag	=	$table->delete($cid[$i]);
			}
		}
		return $flag;
	}
	
	public function findAll($params = null,$order = null,$offset = null,$limit = null){
		$table = Core::table('Danhmuc/TypeScaCode');
		$db = $table->getDbo();
		$query = $db->getQuery(true);
		$query->select(array('*'))
			->from($table->getTableName())
		;
		if (isset($params['name']) && !empty($params['name'])) {
			$query->where('name LIKE ('.$db->quote('%'.$params['name'].'%').')');
		}
		if (isset($params['is_nghiepvu']) && !empty($params['is_nghiepvu'])) {
			$query->where('is_nghiepvu = '.$db->quote($params['is_nghiepvu']));
		}
		if (isset($params['iscn']) && !empty($params['iscn'])) {
			$query->where('iscn = '.$db->quote($params['iscn']));
		}
		if ($order == null) {
			$query->order('code');
		}else{
			$query->order($order);
		}
		
		if($offset != null && $limit != null){
			$db->setQuery($query,$offset,$limit);
		}else{
			$db->setQuery($query);
		}
		return $db->loadObjectList();
	
	}
	function getChuyennganh($query = null){
		$db = JFactory::getDbo();
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	/* public function deleteData($id=null,$cid = array())
    {
        $db = JFactory::getDbo();
		if(!is_array($cid)||count($cid)==0){
			return false;
		}
		$ids = implode(",", $cid);
		$sql="DELETE FROM ".$table." WHERE id IN ($ids)";
		$db->setQuery($sql);
		if (! $db->query()){
			return false;
		}
		return true;
    } */
	function publish($cid = array(), $publish = 1)
	{
		$flag = false;
		if (count( $cid ))
		{
			JArrayHelper::toInteger($cid);
			$table = Core::table('Danhmuc/TypeScaCode');
			$src['status'] = $publish;
			for ($i = 0; $i < count($cid); $i++) {
				$src['code']	=	$cid[$i];
				$flag = $table->save($src);
			}
		}
		return $flag;
	}
}