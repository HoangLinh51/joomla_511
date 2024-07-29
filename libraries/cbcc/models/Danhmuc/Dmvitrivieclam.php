<?php
/**
 * Author: Phucnh
 * Date created: May 12, 2015
 * Company: DNICT
 */
class Danhmuc_Model_Dmvitrivieclam extends JModelLegacy{
	var $_data = null;
	var $_total = null;
	var $_pagination = null;
	public function __construct(){
		parent::__construct();
		$this->mainframe = JFactory::getApplication();
		$this->option = JRequest::getWord('option');
	
		$limit = $this->mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $this->mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $this->mainframe->getUserStateFromRequest( $this->option.'.limitstart', 'limitstart', 0, 'int' );
	
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
	
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}
	
	public function getTotal($table){
		if (empty($this->_total)){
			$query = $this->_buildQuery($table);
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}
	
	public function getPagination($table){
		if (empty($this->_pagination)){
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal($table), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	
	public function _buildQuery($table){
		$where		= $this->_buildContentWhere();
		$orderby	= $this->_buildContentOrderBy();
		$query = 'select a.*, b.name as function_name from  '.$table.' a'.
				' LEFT JOIN function_code b ON b.id = a.function_code'
				.$where.$orderby;
		return $query;
	}
	
	public function _buildContentWhere(){
		$this->mainframe = JFactory::getApplication();
		$this->option = JRequest::getWord('option');
			
		$function_code = $this->mainframe->getUserStateFromRequest( $this->option.'function_code','function_code', '', 'string' );
		$status = $this->mainframe->getUserStateFromRequest( $this->option.'trangthai','trangthai', '', 'string' );
		$filter_order = $this->mainframe->getUserStateFromRequest( $this->option.'filter_order', 'filter_order', 'ten', 'cmd' );
		$filter_order_Dir = $this->mainframe->getUserStateFromRequest( $this->option.'filter_order_Dir', 'filter_order_Dir', '', 'word' );
	
		$search	= $this->mainframe->getUserStateFromRequest( $this->option.'search', 'search', '', 'string');
		if (strpos($search, '"') !== false) {
			$search = str_replace(array('=', '<'), '', $search);
		}
		$search = JString::strtolower($search);
		$location = JString::strtolower($location);
	
		$where = array();
	
		if ($search) {
			$where[] = 'LOWER(ten) LIKE '.$this->_db->Quote( '%'.$search.'%');
		}
		if($status != ''){
			$where[] = 'trangthai = '.(int) $status;
		}
		if($function_code != ''){
			$where[] = 'function_code = '.(int) $function_code;
		}
	
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
	
		return $where;
	}
	
	public function _buildContentOrderBy(){
		$this->mainframe = JFactory::getApplication();
		$this->option = JRequest::getWord('option');
		$filter_order		= $this->mainframe->getUserStateFromRequest( $this->option.'filter_order','filter_order','','ten','cmd' );
		$filter_order_Dir	= $this->mainframe->getUserStateFromRequest( $this->option.'filter_order_Dir','filter_order_Dir',	'',	'word' );
		if (!in_array($filter_order, array('function_code', 'id'))){
			$filter_order = 'function_code';
		}
	
		if (!in_array(strtoupper($filter_order_Dir), array('ASC', 'DESC'))) {
			$filter_order_Dir = '';
		}
	
		if ($filter_order != 'function_code'){
			$orderby 	= ' ORDER BY  id '.$filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir.',id ';
		}
		return $orderby;
	}
	
	public function listDanhsach($table){
		if (empty($this->_data)){
			$query = $this->_buildQuery($table);
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
		return $this->_data;
	}
	
	public function getEditItem($table, $id){
		$db = JFactory::getDbo();
		$query = 'SELECT * FROM '.$table.' WHERE id ='.$id;
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	public function checkmavtvl($ma, $id=null){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('count(id)')
		->from('danhmuc_vitrivieclam')
		->where('LOWER(mavtvl) ='.$db->quote(strtolower($ma)));
		if($id>0) $query->where('id != '.$db->quote($id));
		$db->setQuery($query);
		return $db->loadResult();
	}
	
	public function storeData(){
		$flag = true;
		$data = JRequest::get('post');
		$db= JFactory::getDbo();
		$object = new stdClass();
		$object->ten = $data['ten'];
		$object->mota = $data['mota'];
		$object->function_code = $data['function_code'];
		$object->trangthai = $data['trangthai'];
		$object->mavtvl = $data['mavtvl'];
		if((int)$data['id'] == 0){
			$flag = $flag&&$db->insertObject($data['dbtable'], $object);
		}
		else{
			$object->id = (int)$data['id'];
			$flag = $flag&&$db->updateObject($data['dbtable'], $object,'id');
		}
		return $flag;
	}
	
	public function remove($table, $cid){
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
	}
	
	public function publish($table, $cid){
		$db = JFactory::getDbo();
		if(!is_array($cid)||count($cid)==0){
			return false;
		}
		$ids = implode(",", $cid);
		$sql="UPDATE ".$table." SET trangthai = 1 WHERE id IN ($ids)";
		$db->setQuery($sql);
		if (! $db->query()){
			return false;
		}
		return true;
	}
	
	public function unpublish($table, $cid){
		$db = JFactory::getDbo();
		if(!is_array($cid)||count($cid)==0){
			return false;
		}
		$ids = implode(",", $cid);
		$sql="UPDATE ".$table." SET trangthai = 0 WHERE id IN ($ids)";
		$db->setQuery($sql);
		if (! $db->query()){
			return false;
		}
		return true;
	}
	
	public function getCbo($table,$field,$where=null,$order=null,$value,$text,$code,$name,$selected=null,$idname=null,$class=null,$attrArray=null){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query	->select(array($field))
		->from($table);
		if($where != null || $where != "")
			$query->where($where);
		$query->order($order);
		$db->setQuery($query);
		$tmp = $db->loadObjectList();
		$data=array();
		array_push($data, array('value'=>$value,'text' => $text));
		for($i=0;$i<count($tmp);$i++){
			$attr=array();
			if(isset($attrArray) && is_array($attrArray))
			foreach ($attrArray as $k=>$v){
				$attr+=array($k=>$tmp[$i]->$v);
			}
			if (!isset($attr) && !is_array($attr))
				array_push($data, array('value' => $tmp[$i]->$code,'text' => $tmp[$i]->$name));
			else {
				array_push($data, array('value' => $tmp[$i]->$code,'text' => $tmp[$i]->$name,'attr'=>$attr));
			}
		}
		$options = array(
				'id' => $idname,
				'list.attr' => array(
						'class'=>$class,
				),
				'option.key'=>'value',
				'option.text'=>'text',
				'option.attr'=>'attr',
				'list.select'=>$selected
		);
		return $result = JHtmlSelect::genericlist($data,$idname,$options);
	}
	/**
	 * Hàm lấy thông tin từ 1 table, có thể join thêm bảng và điều kiện, trả về 1 list đối tượng
	 * @param array $field
	 * @param string $table
	 * @param array $arrJoin array(key => value)
	 * @param array $where array(where1, where2)
	 * @param string $order
	 * @return objectlist
	 */
	function getThongtin($field, $table, $arrJoin=null, $where=null, $order=null){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($field)
		->from($table);
		if (count($arrJoin)>0)
		foreach ($arrJoin as $key=>$val){
			$query->join($key, $val);
		}
		for($i=0;$i<count($where);$i++)
		if ($where[$i]!='')
		$query->where($where);
		if($order!=null)$query->order($order);
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}