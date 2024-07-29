<?php
class Danhmuc_Model_WhoisSalMgr extends JModelLegacy
{
	/**
	 * @param mixed $formData
	 * @return boolean True on success
	 */
	public function create($formData){
		$table = Core::table('Danhmuc/WhoisSalMgr');
		$src['name'] 				= $formData['name'];
		$src['status'] 				= $formData['status'];
		$src['is_nangluonglansau']	= $formData['is_nangluonglansau'];
		$src['is_nhaptien'] 		= $formData['is_nhaptien'];
		$src['is_nhapngaynangluong']= $formData['is_nhapngaynangluong'];
		$src['phantramsotienhuong']	= $formData['phantramsotienhuong'];
		return $table->save($src);
	}
	public function update($formData){
		$table = Core::table('Danhmuc/WhoisSalMgr');
		$src['id'] 					= $formData['id'];
		$src['name'] 				= $formData['name'];
		$src['status'] 				= $formData['status'];
		$src['is_nangluonglansau']	= $formData['is_nangluonglansau'];
		$src['is_nhaptien'] 		= $formData['is_nhaptien'];
		$src['is_nhapngaynangluong']= $formData['is_nhapngaynangluong'];
		$src['phantramsotienhuong']	= $formData['phantramsotienhuong'];
		return $table->save($src);
	}
	public function read($id){
		$table = Core::table('Danhmuc/WhoisSalMgr');
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
		$table = Core::table('Danhmuc/WhoisSalMgr');
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
		$table = Core::table('Danhmuc/WhoisSalMgr');
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
	
	
	function publish($cid = array(), $publish = 1)
	{
		$flag = false;
		if (count( $cid ))
		{
			JArrayHelper::toInteger($cid);
			$table = Core::table('Danhmuc/WhoisSalMgr');
			$src['status'] = $publish;
			for ($i = 0; $i < count($cid); $i++) {
				$src['id']	=	$cid[$i];
				$flag = $table->save($src);
			}
		}
		return $flag;
	}
}