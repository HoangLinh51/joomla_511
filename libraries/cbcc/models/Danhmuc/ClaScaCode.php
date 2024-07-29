<?php
class Danhmuc_Model_ClaScaCode extends JModelLegacy
{
	/**
	 * @param mixed $formData
	 * @return boolean True on success
	 */
	/* public function create($formData){
		$table 				= Core::table('Danhmuc/ClaScaCode');
		$src['tosc_code'] 	= $formData['tosc_code'];
		$src['code']		= $formData['code'];
		$src['name'] 		= $formData['name'];
		$src['s_name'] 		= $formData['s_name'];
		$src['step_2'] 		= $formData['step_2'];
		$src['tosc_code'] 	= $formData['tosc_code'];
		$src['step_name'] 	= $formData['step_name'];
		$src['step'] 		= $formData['step'];
		$src['step_name2'] 	= $formData['step_name2'];
		$src['istext'] 		= $formData['istext'];
		$src['is_core'] 	= $formData['is_core'];
		return $table->save($src);
	}
	public function update($formData){
		$table 				= Core::table('Danhmuc/ClaScaCode');
		$src['id'] 			= $formData['id'];
		$src['tosc_code'] 	= $formData['tosc_code'];
		$src['code']		= $formData['code'];
		$src['name'] 		= $formData['name'];
		$src['s_name'] 		= $formData['s_name'];
		$src['step_2'] 		= $formData['step_2'];
		$src['tosc_code'] 	= $formData['tosc_code'];
		$src['step_name'] 	= $formData['step_name'];
		$src['step'] 		= $formData['step'];
		$src['step_name2'] 	= $formData['step_name2'];
		$src['istext'] 		= $formData['istext'];
		$src['is_core'] 	= $formData['is_core'];
		return $table->save($src);
	}
	public function read($id){
		$table = Core::table('Danhmuc/ClaScaCode');
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
		$table = Core::table('Danhmuc/ClaScaCode');
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
		$table = Core::table('Danhmuc/ClaScaCode');
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
	 */
	var $_data = null;
	var $_total = null;
	var $_pagination = null;
	public function __construct(){
		parent::__construct();
		$this->mainframe = JFactory::getApplication();
		$this->option = JRequest::getWord('option');
	
		// Get the pagination request variables
		$limit = $this->mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $this->mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $this->mainframe->getUserStateFromRequest( $this->option.'.limitstart', 'limitstart', 0, 'int' );
	
		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
	
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}
	
	function getTotal(){
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}
	
	function getPagination(){
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	
	function _buildQuery(){
		$orderby	= $this->_buildContentOrderBy();
		$where		= $this->_buildContentWhere();
	
		$query = 'select cl.*, ts.`name` as tosc_name from cla_sca_code as cl
				INNER JOIN type_sca_code as ts on ts.code = cl.tosc_code'
				.$where
				.$orderby
				;
				return $query;
	}
	public function _buildContentWhere(){
		$this->mainframe = JFactory::getApplication();
		$this->option = JRequest::getWord('option');
			
		$status = $this->mainframe->getUserStateFromRequest( $this->option.'status','status', '', 'string' );
		$filter_order = $this->mainframe->getUserStateFromRequest( $this->option.'filter_order', 'filter_order', 'name', 'cmd' );
		$filter_order_Dir = $this->mainframe->getUserStateFromRequest( $this->option.'filter_order_Dir', 'filter_order_Dir', '', 'word' );
	
		$search	= $this->mainframe->getUserStateFromRequest( $this->option.'search', 'search', '', 'string');
		$location	= $this->mainframe->getUserStateFromRequest( $this->option.'location', 'location', '', 'string');
		$tosc_code	= $this->mainframe->getUserStateFromRequest( $this->option.'tosc_code', 'tosc_code', '', 'string');
		$step	= $this->mainframe->getUserStateFromRequest( $this->option.'step', 'step', '', 'string');
		$step_2	= $this->mainframe->getUserStateFromRequest( $this->option.'step_2', 'step_2', '', 'string');
		if (strpos($search, '"') !== false) {
			$search = str_replace(array('=', '<'), '', $search);
		}
		$search = JString::strtolower($search);
		$location = JString::strtolower($location);
	
		$where = array();
	
		if ($search) {
			$where[] = 'LOWER(a.name) LIKE '.$this->_db->Quote( '%'.$search.'%');
		}
		if ($location) {
			$where[] = 'LOWER(a.location) = '.$this->_db->Quote( $location);
		}
	
		if ($tosc_code) {
			$where[] = 'cl.tosc_code = '.$this->_db->Quote( $tosc_code);
		}
		if ($step) {
			$where[] = 'cl.step = '.$this->_db->Quote( $step);
		}
	
		if ($step_2) {
			$where[] = 'cl.step_2 = '.$this->_db->Quote( $step_2);
		}
	
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
	
		return $where;
	}
	function _buildContentOrderBy(){
		$this->mainframe = JFactory::getApplication();
		$this->option = JRequest::getWord('option');
	
		$filter_order = $this->mainframe->getUserStateFromRequest( $this->option.'filter_order','filter_order','orders','cmd');
		$filter_order_Dir = $this->mainframe->getUserStateFromRequest( $this->option.'filter_order_Dir','filter_order_Dir','','word');
		// sanitize $filter_order
		if (!in_array($filter_order, array('id', 'tosc_name', 'code', 'name', 's_name', 'step_2', 'step',	'step_name', 'step_name2'))) {
			$filter_order = 'tosc_code';
		}
	
		if (!in_array(strtoupper($filter_order_Dir), array('ASC', 'DESC'))) {
			$filter_order_Dir = '';
		}
	
		if ($filter_order == 'orders'){
			$orderby 	= ' ORDER BY  tosc_code '.$filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
		}
	
		return $orderby;
	}
	
	function listTrinhdodaotao(){
		if (empty($this->_data))
		{
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
	
		return $this->_data;
	}
	
	function getEdittrinhdodaotao(){
		$id = JRequest::getVar('id');
		if (!empty($id)){
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query = 'SELECT * FROM cla_sca_code WHERE id = '.$id;
			$db->setQuery($query);
			$result = $db->loadAssocList();
		}
		return $result;
	}
	function getCbo($table = '', $field = array('*'), $where = ''){
		if ($table != '') {
			$field	=	implode(', ', $field);
			$db		=	JFactory::getDBO();
			$sql	=	'select '.$field.' from '.$table.' '.$where;
			$db->setQuery($sql);
			$result	=	$db->loadAssocList();
		}
		return $result;
	}
	function getInfo($table = '', $field = array('*'), $where = ''){
		if ($table != '') {
			$field	=	implode(', ', $field);
			$db		=	JFactory::getDBO();
			$sql	=	'select '.$field.' from '.$table.' '.$where;
			$db->setQuery($sql);
			$result	=	$db->loadAssoc();
		}
		return $result;
	}
	function storeData(){
		$data = JRequest::get( 'post' );
		$db = JFactory::getDBO();
		$data['ls_code'] = isset($data['ls_code']) ? $data['ls_code'] : '';
		if($data["id"]==""){
			$sql="insert into cla_sca_code (id, tosc_code, code, name, s_name, step_2, step, step_name, step_name2, istext, ls_code, is_core)
		          values (".
			          "'".$data['id']."',".
			          "'".$data['tosc_code']."',".
			          "'".$data['code']."',".
			          "'".$data['name']."',".
			          "'".$data['s_name']."',".
			          "'".$data['step_2']."',".
			          "'".$data['step']."',".
			          "'".$data['step_name']."',".
			          "'".$data['step_name2']."',".
			          "'".$data['istext']."',".
			          "'".$data['ls_code']."',".
			          "'".$data['is_core']."'".
			          ")";
		}
		else if(is_numeric($data['id'])){
			$sql="update cla_sca_code set id='".$data['id']."',".
					"tosc_code='".$data['tosc_code']."',".
					"code='".$data['code']."',".
					"name='".$data['name']."',".
					"s_name='".$data['s_name']."',".
					"step_2='".$data['step_2']."',".
					"step='".$data['step']."',".
					"step_name='".$data['step_name']."',".
					"step_name2='".$data['step_name2']."',".
					"istext='".$data['istext']."',".
					"ls_code='".$data['ls_code']."',".
					"is_core='".$data['is_core']."'".
					" where id=".$data['id'];
		}
		// 		echo $sql; exit;
		$db->setQuery($sql);
		return $db->query();
	}
	function getNganh($dline = 1){
		$query		=	'select ls.code, ls.name from ls_code as ls
		INNER JOIN type_sca_code as ts ON ts.lim_code = ls.lim_code
		WHERE ts.code = '.$dline;
		$this->_db->setQuery($query);
		return $this->_db->loadAssocList();
	}
	public function collect($params = null,$order = null,$offset = null,$limit = null){
	    $table = Core::table('Danhmuc/ClaScaCode');
	    $db = $table->getDbo();
	    $query = $db->getQuery(true);
	    $query->select('a.*')
	    ->from($db->quoteName($table->getTableName(),'a'));
	    if (isset($params['tosc_code']) && !empty($params['tosc_code'])) {
	        $query->where('a.tosc_code = '.$db->quote($params['tosc_code']));
    	    if (isset($params['code']) && !empty($params['code'])) {
    	        $query->where('a.code = '.$db->quote($params['code']));
    	    }
	    }
	    if ($order == null) {
	        $query->order('tosc_code,step,step_2');
	    }else{
	        $query->order($order);
	    }
	    if($offset != null && $limit != null){
	        $db->setQuery($query,$offset,$limit);
	    }else{
	        $db->setQuery($query);
	    }
	    return $db->loadAssocList();
	}
}