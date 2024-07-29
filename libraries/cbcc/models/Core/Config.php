<?php

use Joomla\CMS\Factory;
// use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class Core_Model_Config{
	/**
	 * Lay gia tri
	 * @param string $path
	 * @return Ambigous <>
	 */
	public function getValue($path){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('a.path', 'a.model','b.value'))
				->from('core_config_field AS a')
				->join('INNER','core_config_value AS b ON b.config_field_id = a.id')
				->where('a.path = '.$db->quote($path));
		$db->setQuery($query);		
		$row = $db->loadAssoc();
		//echo $query;
		//var_dump($row);
		return $row['value'];
	}
	/**
	 *  Tạo Tree menu
	 * @param int $id
	 * @return multitype:multitype:NULL multitype:string  string
	 */
	public function treemenu($id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('id','title','lvl'))
				->from('core_config_field');
		if ((int)$id == 0) {
			$query->where('lvl = 1');
		}else{
			$path = $this->getPathById($id);
			$query->where('lvl = 2')
					->where("path LIKE '{$path}/%'");
		}
		$db->setQuery($query);
		$rows = $db->loadAssocList();
		$result = array();
		for ($i = 0; $i < count($rows); $i++) {
			$result[] = array(
					"attr" => array("id" => "node_".$rows[$i]['id'], "rel" => "folder"),
					"data" => $rows[$i]['title'],
					"state" => ((int)$rows[$i]['lvl'] < 3) ? "closed" : ""
			);
		}
		return $result;
	}
	/**
	 * Lấy đường dẫn path
	 * @param int $id
	 * @return Ambigous <mixed, NULL>
	 */
	public function getPathById($id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('path'))
			->from('core_config_field')
			->where('id = '.$db->quote($id));
		$db->setQuery($query);
		return $db->loadResult();
	}
	/**
	 * Lấy một hồ sơ
	 * @param int $id
	 * @return Ambigous <mixed, NULL>
	 */
	public function read($id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('*'))
			  ->from('core_config_field')
			  ->where('id = '.$db->quote($id))
		;
		$db->setQuery($query);
		return $db->loadAssoc();
	}
	/**
	 * Láy một row value
	 * @param int $config_field_id
	 * @return Ambigous <mixed, NULL>
	 */
	public function readValue($config_field_id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('*'))
			->from('core_config_value')
			->where('config_field_id = '.$db->quote($config_field_id));
		
		$db->setQuery($query);
		return $db->loadAssoc();
	}
	/**
	 * Tạo một giá trị
	 * @param array $formData
	 * @return boolean
	 */
	public function createValue($formData){
		$data = new stdClass();
		$data->config_field_id = $formData['config_field_id'];
		$data->path=$formData['path'];
		$data->value=$formData['value'];	
		foreach ($data as $key => $value) {
			if ($value===null || $value ==='') {
				unset($data->$key);
			}
		}
		// Insert the object into the user profile table.
		$flag = JFactory::getDbo()->insertObject('core_config_value', $data);
		if ($flag) {
			$this->deleteCache();
		}
		return $flag;
	}
	/**
	 * Hiệu chỉnh giá trị
	 * @param array $formData
	 * @return Ambigous <boolean, mixed>
	 */
	public function updateValue($formData){
		$data = new stdClass();
		$data->config_field_id = $formData['config_field_id'];
		$data->path=$formData['path'];
		$data->value=$formData['value'];
		$data->id=$formData['id'];
		// Insert the object into the user profile table.
		$flag = JFactory::getDbo()->updateObject('core_config_value', $data,'id',true);
		if ($flag) {
			$this->deleteCache();
		}
		return $flag;
	}
	/**
	 * Lấy danh sách 
	 * @param int $id
	 * @return Ambigous <mixed, NULL, multitype:unknown Ambigous <unknown, mixed> >
	 */
	public function getList($id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('a.path','a.id','a.title','b.value','a.type'))->from('core_config_field AS a');
		if ((int)$id > 0) {			
			$path = $this->getPathById($id);
			$query->where('a.path LIKE '.$db->quote($path.'/%'));
		}
		$query->join('LEFT', 'core_config_value AS b ON b.config_field_id = a.id');
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	/**
	 * Tạo config
	 * @param array $formData
	 * @return boolean
	 */
	public function create($formData){
		$data = new stdClass();
		$data->lvl = $formData['lvl'];
		$data->path=$formData['path'];
		$data->title=$formData['title'];
		$data->type=$formData['type'];
		$data->model = $formData['model'];
		$data->description=$formData['description'];
		$data->lvl = count(explode('/', $data->path));		
		if ($data->lvl <= 2) {
			$data->type = null;
		}
		foreach ($data as $key => $value) {
			if ($value===null || $value ==='') {
				unset($data->$key);
			}
		}
		// Insert the object into the user profile table.
		return JFactory::getDbo()->insertObject('core_config_field', $data);
	}
	/**
	 * Hiệu chỉnh config
	 * @param array $formData
	 * @return Ambigous <boolean, mixed>
	 */
	public function update($formData){
		$data = new stdClass();
		$data->id = $formData['id'];
		$data->lvl = $formData['lvl'];
		$data->path=$formData['path'];
		$data->title=$formData['title'];
		$data->type=$formData['type'];
		$data->model = $formData['model'];
		$data->description=$formData['description'];
		$data->lvl = count(explode('/', $data->path));
		if ($data->lvl <= 2) {
			$data->type = null;
		}
		// Insert the object into the user profile table.
		return JFactory::getDbo()->updateObject('core_config_field', $data,'id');
	}
	/**
	 * Xóa config 
	 * @param string $path
	 * @return mixed
	 */
	public function remove($path){
		$db  = JFactory::getDbo();
		$query = $db->getQuery(true);
		$conditions = array(		 
		    $db->quoteName('path') . ' LIKE ' . $db->quote($path.'%')
		);		 
		$query->delete($db->quoteName('core_config_field'));
		$query->where($conditions);		 
		$db->setQuery($query);
		$flag = $db->execute();
		if ($flag) {
			$this->removeValue($path);
		}
		return $flag;
		
	}
	/**
	 * Xóa giá trị
	 * @param string $path
	 * @return mixed
	 */
	public function removeValue($path){
		$db  = JFactory::getDbo();
		$query = $db->getQuery(true);
		$conditions = array(
				$db->quoteName('path') . ' LIKE ' . $db->quote($path.'%')
		);
		$query->delete($db->quoteName('core_config_value'));
		$query->where($conditions);
		$db->setQuery($query);
		$flag = $db->execute();
		if ($flag) {
			$this->deleteCache();
		}
		return $flag;		
	}
	/**
	 * Lấy tất cả giá trị
	 * @return array
	 */
	public function getAllData(){
		$result = null;
		$db = Factory::getDbo();
		$query = "SELECT a.path,a.value FROM core_config_value a";
		$db->setQuery($query);
		echo $query;exit;
		$rows = $db->loadAssocList();
		$result = array();
		for ($i = 0; $i < count($rows); $i++) {
			$result[$rows[$i]['path']] = $rows[$i]['value'];
		}
		return $result;
	}
	/**
	 * Xóa cache config
	 */
	public function deleteCache(){
		$files = glob(JPATH_ROOT.'/cache/*'); // get all file names
		//var_dump(JPATH_ROOT,$files);exit;
		foreach($files as $file){ // iterate files
			$ext = (end(explode('/', $file)));
			if(is_file($file)){
				if(!($ext == 'index.html')){
					unlink($file); // delete file
				}
			}
		}
	}
}