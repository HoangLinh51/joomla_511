<?php
class Danhmuc_Model_Phucapthamnienngach extends JModelLegacy {
	function __construct() {
		parent::__construct ();
	}
	public function getPhucapthamnien($select=null){
		//lấy dropdown list các phụ cấp
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query	->select(array('id,name'))
		->from($db->quoteName('phucapthamnien'))
		->where('id NOT IN (select phucapthamnien_id from phucapthamnien_ngach)');
		$db->setQuery($query);
		$arrPhucap = $db->loadObjectList();
		$data=array();
		array_push($data, array('value' => "",'text' => "--Chọn phụ cấp thâm niên--"));
		for($i=0;$i<sizeof($arrPhucap);$i++){
			array_push($data, array('value' => $arrPhucap[$i]->id,'text' => $arrPhucap[$i]->name));
		}
		$options = array(
				'id' => 'phucapthamnien_id',
				'option.key'=>'value',
				'option.text'=>'text',
				'option.attr'=>'attr',
				'list.select'=>$select
		);
		return JHTML::_('select.genericlist',$data,'phucapthamnien_id',$options);
	}
	public function getCb_bac_heso(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query	->select(array('id,name,mangach'))
		->from($db->quoteName('cb_bac_heso'))
		->where('has_phucapthamnien =1')
		->order('name asc');
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	public function thongtinPhucap($id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query	->select(array('phucapthamnien_id,mangach'))
		->from($db->quoteName('phucapthamnien_ngach'))
		->where('phucapthamnien_id ='.$id);
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	public function getTenphucap($phucapthamnien_id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query	->select(array('name'))
		->from($db->quoteName('phucapthamnien'))
		->where('id ='.$phucapthamnien_id);
		$db->setQuery($query);
		return $db->loadResult();
	}
	public function danhsachPhucapthamnienngach(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query	->select(array('a.phucapthamnien_id,b.name,a.mangach'))
		->from($db->quoteName('phucapthamnien_ngach','a'))
		->join('inner', 'phucapthamnien as b on a.phucapthamnien_id = b.id');
		$query->group('a.phucapthamnien_id');
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	public function savePhucapthamnienngach($formData){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->insert($db->quoteName('phucapthamnien_ngach'));
		$query->columns($db->quoteName(array('phucapthamnien_id','mangach')));
		for($i=0;$i<sizeof($formData['arrMangach']);$i++)
		{
			$values= $db->quote($formData['phucapthamnien_id']).',"'. $formData['arrMangach'][$i].'"';
			$query->values($values);
		}
		$db->setQuery($query);
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} else {
			return true;
		}
	} 
	public function deletePhucapthamnienngach($phucapthamnien_id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$conditions = array(
				$db->quoteName('phucapthamnien_id').' IN ('.$phucapthamnien_id.')'
		);
		$query->delete($db->quoteName('phucapthamnien_ngach'));
		$query->where($conditions);
		$db->setQuery($query);
		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} else {
			return true;
		}
	}
}