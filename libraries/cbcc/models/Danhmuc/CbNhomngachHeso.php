<?php
class Danhmuc_Model_CbNhomngachHeso extends JModelLegacy
{
	/**
	 * @param mixed $formData
	 * @return boolean True on success
	 */
	public function create($formData){
		$table = Core::table('Danhmuc/CbNhomngachHeso');
		$src['idbac'] 		= $formData['idbac'];
		$src['heso'] 		= $formData['heso'];
		$src['sta_code'] 	= $formData['sta_code'];
		$src['id_ngach'] 	= $formData['id_ngach'];
// 		var_dump ($src); exit;
		return $table->save($src);
	}
	
	public function update($formData){
		$table = Core::table('Danhmuc/CbNhomngachHeso');
		$src['id'] 			= $formData['id'];
		$src['idbac'] 		= $formData['idbac'];
		$src['heso'] 		= $formData['heso'];
		$src['sta_code'] 	= $formData['sta_code'];
		return $table->save($src);
	}
	public function read($id){
		$table = Core::table('Danhmuc/CbNhomngachHeso');
		if (!$table->load($id)) {
			return null;
		}
		$fields = array_keys($table->getFields());
		$data = array();
		for ($i = 0; $i < count($fields); $i++) {
			$data[$fields[$i]] = $table->$fields[$i];
		}
		return $data;
	}
	
	public function delete($cid){
		$table = Core::table('Danhmuc/CbNhomngachHeso');
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
		$table = Core::table('Danhmuc/CbNhomngachHeso');
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
	public function getIdbacHeso($manhom){
		$db	=	JFactory::getDbo();
		$query	=	'select b.idbac, b.heso from cb_nhomngach as a
				INNER JOIN cb_nhomngach_heso as b ON a.`code` = b.sta_code
				WHERE a.id = '.$db->quote($manhom);
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	public function delIdbacHesoByStacode($sta_code){
// 		$str_stacode	=	implode(', ', $sta_code);
		$db	=	JFactory::getDbo();
		if (count($sta_code)) {
			for ($i = 0; $i < count($sta_code); $i++) {
				$query	=	'DELETE FROM cb_nhomngach_heso WHERE sta_code = '.$db->quote($sta_code[$i]);
				$db->setQuery($query);
				$flag	= $db->query();
			}
		}
		return $flag;
	}
	
}