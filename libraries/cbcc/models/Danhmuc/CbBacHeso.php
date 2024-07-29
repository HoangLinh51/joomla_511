<?php
class Danhmuc_Model_CbBacHeso extends JModelLegacy
{
	/**
	 * @param mixed $formData
	 * @param int $type 
	 * @return boolean True on success
	 */
	public function create($formData, $type=null){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
			$db->quoteName('manhom') . ' = ' . $db->quote($formData['manhom']),
			$db->quoteName('mangach') . ' = ' . $db->quote($formData['mangach']),
			$db->quoteName('name') . ' = ' . $db->quote($formData['name']),
			$db->quoteName('idnganh') . ' = ' . $db->quote($formData['idnganh']),
			$db->quoteName('mangachtiep') . ' = ' . $db->quote($formData['mangachtiep']),
			$db->quoteName('is_vuotkhung') . ' = ' . $db->quote($formData['is_vuotkhung']),
		);
		$query->insert($db->quoteName('cb_bac_heso'))->set($fields);
		$db->setQuery($query);
		$rs = $db->query();
		if($type==null)
		return $rs;
		else return $db->insertId();
	}
	
	public function update($formData){
		$table = Core::table('Danhmuc/CbBacHeso');
		$src['id'] 			= $formData['id'];
		$src['manhom'] 		= $formData['manhom'];
		$src['mangach'] 	= $formData['mangach'];
		$src['name'] 		= $formData['name'];
		$src['idnganh'] 	= $formData['idnganh'];
		$src['mangachtiep']	= $formData['mangachtiep'];
		$src['is_vuotkhung']= $formData['is_vuotkhung'];
		return $table->save($src);
	}
	public function read($id){
		$table = Core::table('Danhmuc/CbBacHeso');
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
	function exeQueryNoReturn($query = null){
		$db = JFactory::getDbo();
		$db->setQuery($query);
		return $db->execute();
	}
	public function delete($cid){
		$table = Core::table('Danhmuc/CbBacHeso');
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
		$table = Core::table('Danhmuc/CbBacHeso');
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
	
}