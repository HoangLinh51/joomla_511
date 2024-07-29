<?php
class Danhmuc_Model_CbNhomngach extends JModelLegacy
{
	/**
	 * @param mixed $formData
	 * @return boolean True on success
	 */
	public function create($formData){
		$table = Core::table('Danhmuc/CbNhomngach');
		$src['name'] 		= $formData['name'];
		$src['idbangluong'] = $formData['idbangluong'];
		$src['cap'] 		= $formData['cap'];
		$src['bacdau'] 		= $formData['bacdau'];
		$src['hesodau'] 	= $formData['hesodau'];
		$src['baccuoi'] 	= $formData['baccuoi'];
		$src['hesocuoi'] 	= $formData['hesocuoi'];
		$src['sonamluong']	= $formData['sonamluong'];
		$src['parentid'] 	= $formData['parentid'];
		$src['code'] 		= $formData['code'];
		$src['htcn_code'] 	= $formData['htcn_code'];
		$src['status'] 		= $formData['status'];
		return $table->save($src);
	}
	
	public function update($formData){
		$table = Core::table('Danhmuc/CbNhomngach');
		$src['id'] = $formData['id'];
		$src['name'] 		= $formData['name'];
		$src['idbangluong'] = $formData['idbangluong'];
		$src['cap'] 		= $formData['cap'];
		$src['bacdau'] 		= $formData['bacdau'];
		$src['hesodau'] 	= $formData['hesodau'];
		$src['baccuoi'] 	= $formData['baccuoi'];
		$src['hesocuoi'] 	= $formData['hesocuoi'];
		$src['sonamluong']	= $formData['sonamluong'];
		$src['parentid'] 	= $formData['parentid'];
		$src['code'] 		= $formData['code'];
		$src['htcn_code'] 	= $formData['htcn_code'];
		$src['status'] 		= $formData['status'];
		return $table->save($src);
	}
	public function read($id){
		$table = Core::table('Danhmuc/CbNhomngach');
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
	function getDataCmdList($query=null)
	{
		// Load the data
		$db = JFactory::getDbo();
		$db->setQuery( $query );
		return $db->loadObjectList();
	}
	function getDataByField($query = null){
		$db = JFactory::getDbo();
		$db->setQuery($query);
		return $db->loadResult();
		
	}
	function exeQueryNoReturn($query = null){
		$db = JFactory::getDbo();
		$db->setQuery($query);
		return $db->execute();
	}
	function getDataCmdArray($query = null) {
		// Load the data
		$db = JFactory::getDbo();
		$db->setQuery( $query );
		return $db->loadAssocList();
	}
	function getDataTable($tb, $id='id', $name='name', $where='') {
		$query = "SELECT DISTINCT " . $id . " value," . $name . " text FROM " . $tb . " WHERE status=1 " . $where;
		return $this->getDataCmdArray ( $query );
	}
	public function delete($cid){
		$table = Core::table('Danhmuc/CbNhomngach');
		if(!is_array($cid)||count($cid)==0){
			$flag	=	false;
		}else {
			for ($i = 0; $i < count($cid); $i++) {
				$flag	=	$table->delete($cid[$i]);
			}
		}
		return $flag;
	}
	function deleteBac($tb, $idval, $manhom = null) {
		$ids=implode( ',', $idval );
		$db = JFactory::getDbo();
		$query = "delete from ".$tb." where id in(".$ids.") and manhom = ".$manhom;
		$db->setQuery($query);
		if ($db->query()) {
			$query='delete from cb_goiluong_ngach where ngach in (select mangach from cb_bac_heso where  id in ('.$ids.') and manhom ='.$manhom.')';
			echo $query; 
			$db->setQuery($query);
			if($db->query())
			{
				echo true;
			}
			else{echo false;}
		} else {
			echo false;
		}
	}
	//ham tim theo id trong bang cb_nhomngach
	function getDataByIDCbNhomNgach($tb,$id)
	{
		// Load the data
		$db = JFactory::getDBO();
		$where = array();
		if((int)$id != 0){
			$where[] = "httc_code=".$id;
		}
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		$orderby = " ORDER BY id";
		$query='select distinct id value, name text from '.$tb
		.$where
		.$orderby
		;
		$db->setQuery( $query );
		// echo $query;
		return $db->loadAssocList();
	}
	public function findAll($params = null,$order = null,$offset = null,$limit = null){
		$table = Core::table('Danhmuc/CbNhomngach');
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
			$table = Core::table('Danhmuc/CbNhomngach');
			$src['status'] = $publish;
			for ($i = 0; $i < count($cid); $i++) {
				$src['id']	=	$cid[$i];
				$flag = $table->save($src);
			}
		}
		return $flag;
	}
	function getNgachByPrentId($id)
	{
		$query="select mangach as value, name as text from cb_bac_heso where manhom=".(int)$id;
		$ngach=$this->getDataCmdArray($query);
		return $ngach;
	}
	function getNgachByNhom($manhom)
	{
		$query	=	"select mangach as value, name as text from cb_bac_heso where manhom=".(int)$manhom;
		$ngach	=	$this->getDataCmdArray($query);
		return  $ngach;
	}
	
}