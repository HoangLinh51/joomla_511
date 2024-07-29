<?php
class Danhmuc_Model_PosLevel extends JModelLegacy
{
	/**
	 * @param mixed $formData
	 * @return boolean True on success
	 */
	public function create($formData){
		$table = Core::table('Danhmuc/PosLevel');
		$src['level'] = $formData['level'];
		$src['position'] = $formData['position'];
		$src['type_org'] = $formData['type_org'];
		$src['active'] = $formData['active'];
		$src['position2'] = $formData['position2'];
		$src['position3'] = $formData['position3'];
		return $table->save($src);
	}
	public function update($formData){
		$table = Core::table('Danhmuc/PosLevel');
		$src['id'] = $formData['id'];
		$src['level'] = $formData['level'];
		$src['position'] = $formData['position'];
		$src['type_org'] = $formData['type_org'];
		$src['active'] = $formData['active'];
		$src['position2'] = $formData['position2'];
		$src['position3'] = $formData['position3'];
		
		return $table->save($src);
	}
	public function read($id){
		$table = Core::table('Danhmuc/PosLevel');
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
		$table = Core::table('Danhmuc/PosLevel');
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
		$table = Core::table('Danhmuc/PosLevel');
		$db = $table->getDbo();
		$query = $db->getQuery(true);
		$query->select(array('*'))
			->from($table->getTableName())
		;
		if (isset($params['name']) && !empty($params['name'])) {
			$query->where('name LIKE ('.$db->quote('%'.$params['name'].'%').')');
		}
		if ($order == null) {
			$query->order('id');
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
	public function selectCb(){
		$db	=	JFactory::getDbo();
		$query	=	$db->getQuery(true);
		$query->select('id, position')
			->from('pos_level')
		;
		$db->setQuery($query);
		$data = $db->loadAssocList();
		//array(array('id'=>'value'))
		return $data;
	}
	public function selectObj(){
		$db	=	JFactory::getDbo();
		$query	=	$db->getQuery(true);
		$query->select('id, position')
		->from('pos_level')
		;
		$db->setQuery($query);
		$data = $db->loadObjectList();
		return $data;
	}
	public function getLevelById($id){
		$db	=	JFactory::getDbo();
		$query	=	$db->getQuery(true);
		$query->select('level')
		->from('pos_level')
		->where('id = '. $id)
		;
		$db->setQuery($query);
		return  $db->loadResult();
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
			$table = Core::table('Danhmuc/PosLevel');
			$src['status'] = $publish;
			for ($i = 0; $i < count($cid); $i++) {
				$src['id']	=	$cid[$i];
				$flag = $table->save($src);
			}
		}
		return $flag;
	}
}