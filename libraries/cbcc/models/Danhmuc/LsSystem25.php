<?php
class Danhmuc_Model_LsSystem25 extends JModelLegacy
{
	/**
	 * @param mixed $formData
	 * @return boolean True on success
	 */
	public function create($formData){
		$table = Core::table('Danhmuc/LsSystem25');
		$src['name'] = $formData['name'];
		$src['httc_code'] = $formData['httc_code'];
		$src['status'] = $formData['status'];
		return $table->save($src);
	}
	public function update($formData){
		$table = Core::table('Danhmuc/LsSystem25');
		$src['id'] = $formData['id'];
		$src['name'] = $formData['name'];
		$src['httc_code'] = $formData['httc_code'];
		$src['status'] = $formData['status'];
		return $table->save($src);
	}
	public function read($id){
		$table = Core::table('Danhmuc/LsSystem25');
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
	//getDataByIDNgach lay ngach tu bang LYSTEM_25 theo code bang ORG_SYSTEM25
	public function getDataByIDNhomNgach($id)
	{
		// Load the data
		$db = JFactory::getDBO();
		$where = array();
		if((int)$id != 0){
			$where[] = "httc_code=".$id;
		}
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		$orderby = " ORDER BY id";
		$query='select * from ls_system25'
		.$where
		.$orderby
		;
		$db->setQuery( $query );
		//  echo $query;
		return $db->loadObjectList();
	}
	//getDataByIDNhomNgach lay ngach tu bang GRADE25 theo code bang LYSTEM_25
	function getDataByIDNgach($id)
	{
		// Load the data
		$db = JFactory::getDBO();
		$where = array();
		if((int)$id != 0){
			$where[] = "ngach=".$id;
		}
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		$orderby = " ORDER BY id ASC";
		$query='select * from grade25'
		.$where
		.$orderby
		;
		$db->setQuery( $query );
		//  echo 'truy van' .$query;
		return $db->loadObjectList();
	}
	function getDataCmdList($query=null)
	{
		// Load the data
		$db = JFactory::getDbo();
		$db->setQuery( $query );
		return $db->loadObjectList();
	}
	public function delete($cid){
		$table = Core::table('Danhmuc/LsSystem25');
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
		$table = Core::table('Danhmuc/LsSystem25');
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
			$table = Core::table('Danhmuc/LsSystem25');
			$src['status'] = $publish;
			for ($i = 0; $i < count($cid); $i++) {
				$src['id']	=	$cid[$i];
				$flag = $table->save($src);
			}
		}
		return $flag;
	}
}