<?php
class Danhmuc_Model_BcHinhthuc extends JModelLegacy
{
/** @var object JTable object */
	function __construct()
    {
        parent::__construct();
    }

	/**
	 * Returns the internal table object
	 * @return JTable
	 */

	 function _buildQuery()
    {
    	$db = & JFactory::getDBO ();
    	$post = JRequest::get('post');
    	$query = 'SELECT a.id, a.`name`, a.status, b.`name` as loaihinhbc, GROUP_CONCAT(d.`name` ) as thoihan, a.text_ngaybatdau, a.text_ngayketthuc, 
			    a.`STATUS` FROM bc_hinhthuc as a
			    LEFT JOIN bc_loaihinh as b ON a.loaihinh_id = b.id
			    LEFT JOIN bc_hinhthuc_thoihan as c ON c.hinhthuc_id = a.id
			    LEFT JOIN bc_thoihanbienchehopdong AS d ON d.id = c.thoihan_id';
    	$where = array();
    	if(!empty($post['name_search'])){
    		$where [] = 'name LIKE '.$db->Quote ( '%' . $db->getEscaped ( $post['name_search'], true ) . '%', false );
    	}
    	if(!empty($post['loaihinh_id'])){
    		$where [] = 'a.loaihinh_id = '.(int)$post['loaihinh_id'];
    	}
//     	if(!empty($post['bienche'])){
//     		$where [] = 'bienche = '.(int)$post['bienche'];
//     	}
    	$where = (count($where))?implode(' AND ',$where):'';
    	if(!empty($where)){
        	$query .= ' WHERE '.$where;
        }
        $query .= ' GROUP BY a.id  order by name';
        return $query;
    }
   
	function getData()
    {
        // Load the data
        if (empty( $this->_data )) {
            $query = $this->_buildQuery();
            $this->_db->setQuery( $query );
            $this->_data =  $this->_db->loadObjectList();
        }
        return $this->_data;
    }
	function getDataByID($id)
    {
        // Load the data
        
        if (empty( $this->_data )) {
            $query = '
            SELECT a.*, GROUP_CONCAT(c.thoihan_id ) as thoihan_id, GROUP_CONCAT(d.hinhthuctuyendung_id ) as hinhthuctuyendung_id FROM bc_hinhthuc as a
			    LEFT JOIN bc_hinhthuc_thoihan as c ON c.hinhthuc_id = a.id
				LEFT JOIN bc_hinhthuc_hinhthuctuyendung as d ON d.hinhthuc_id = a.id
            	where a.id = '.	(int)$id.'
            	GROUP BY a.id';
            $this->_db->setQuery( $query );
            $this->_data = $this->_db->loadObject();
        }
        return $this->_data;
    }
    function getLoaihinh(){
        $query = 'select * from bc_loaihinh where status = 1';
        $this->_db->setQuery( $query );
       	return $this->_db->loadAssocList ();
    }
    function getID(){
    	$query	=	'select max(id) from bc_hinhthuc';
    	$this->_db->setQuery($query);
    	return $this->_db->loadResult();
    }
    function getThoihanhopdong($dline = 1){
    	$query		=	'SELECT id, name from bc_thoihanbienchehopdong where deadline = '.$dline.' ORDER BY name DESC';
    	$this->_db->setQuery($query);
    	return $this->_db->loadAssocList();
    }
    function getHinhthuctuyendung(){
    	$query		=	'SELECT id, name from bc_hinhthuctuyendung ';
    	$this->_db->setQuery($query);
    	return $this->_db->loadAssocList();
    }
    
//     function getHinhThucBC()
//     {
//     	$query = 'select * from bienche where status = 1';
//         $this->_db->setQuery( $query );
//        	return $this->_db->loadAssocList ();
//     }
  /**
 * Method to store a record
 *
 * @access    public
 * @return    boolean    True on success
 */
    function storeData()
    {
        $row = Core::table('Danhmuc/BcHinhthuc');
        $data = JRequest::get( 'post' );
 //var_dump($data); exit;
        // Bind the form fields to the ability_code table
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        // Make sure the softpin record is valid
        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
            
        }
        // Store the web link table to the database
        
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        return true;
    }
	
    function storeData_ht_th($thoihan_id, $hinhthuc_id){
    	$flag					=	true;
    	$db						=	JFactory::getDbo();
    	$object = new stdClass();
    	$object->hinhthuc_id	=	$hinhthuc_id;
    	$object->thoihan_id		=	$thoihan_id;
    	$flag = $flag&&$db->insertObject('bc_hinhthuc_thoihan', $object);
    	return $flag;
    }
    function storeData_ht_httd($hinhthuctuyendung_id, $hinhthuc_id){
    	$flag					=	true;
    	$db						=	JFactory::getDbo();
    	$object = new stdClass();
    	$object->hinhthuctuyendung_id	=	$hinhthuctuyendung_id;
    	$object->hinhthuc_id	=	$hinhthuc_id;
    	$flag = $flag&&$db->insertObject('bc_hinhthuc_hinhthuctuyendung', $object);
    	return $flag;
    }
    function delete_ht_th($cid = array()){
    	$result = false;
    	if (count( $cid ))
    	{
    		if (is_array($cid)) {
    			JArrayHelper::toInteger($cid);
    			$cids	=	implode( ',', $cid );
    		}else {
    			$cids	=	$cid;
    		}
    		$query = 'DELETE FROM bc_hinhthuc_thoihan '
    				. ' WHERE hinhthuc_id in ( '.$cids.' )';
    		$this->_db->setQuery( $query );
    		if(!$this->_db->query()) {
    			$this->setError($this->_db->getErrorMsg());
    			$result	=	false;
    		}
    	}
    	return $result;
    }
    function delete_ht_httd($cid = array()){
    	$result = false;
    	if (count( $cid ))
    	{
    		if (is_array($cid)) {
    			JArrayHelper::toInteger($cid);
    			$cids	=	implode( ',', $cid );
    		}else {
    			$cids	=	$cid;
    		}
    		$query = 'DELETE FROM bc_hinhthuc_hinhthuctuyendung '
    				. ' WHERE hinhthuc_id in ( '.$cids.' )';
    		$this->_db->setQuery( $query );
    		if(!$this->_db->query()) {
    			$this->setError($this->_db->getErrorMsg());
    			$result	=	false;
    		}
    	}
    	return $result;
    }
	function deleteData($cid = array())
    {
        $result = false;

        if (count( $cid ))
        {
            JArrayHelper::toInteger($cid);
            $cids = implode( ',', $cid );
            $query = 'DELETE FROM bc_hinhthuc '
                . ' WHERE id in ( '.$cids.' )';   
                            
            $this->_db->setQuery( $query );
            if(!$this->_db->query()) {
                $this->setError($this->_db->getErrorMsg());
                $result	=	false;
            }
        }

        return $result;
    }
	function publish($cid = array(), $publish = 1)
    {
    	
        if (count( $cid ))
        {
            JArrayHelper::toInteger($cid);
            $cids = implode( ',', $cid );
            $query = 'UPDATE bc_hinhthuc'
                . ' SET status = '.(int) $publish
                . ' WHERE id IN ( '.$cids.' )'                
            ;
//            echo $query;exit;
            $this->_db->setQuery( $query );
            if (!$this->_db->query()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
        }

        return true;
    }
    /**
     * Lấy danh sách loại hình biên chế, hợp đồng theo đơn vị
     *
     * @param   integer  $params['donvi_id']   Mã đơn vị. (Nếu $params['donvi_id'] = null : lấy tất cả loại hình biên chế, hợp đồng)
     * @param   integer  $params['bosung_id']  Mã loại hình biên chế phải có khi lấy danh sách
     *
     * @return  null|array  Trả về danh sách các loại hình biên chế, hợp đồng tương ứng của đơn vị.
     *
     */
	public function collect($params = null,$order = null,$offset = null,$limit = null){
	    $table = Core::table('Danhmuc/BcHinhthuc');
	    $db = $table->getDbo();
	    $query = $db->getQuery(true);
	    $query->select('a.*')
	          ->from($db->quoteName($table->getTableName(),'a'));
	    if($params['donvi_id'] != '' && $params['donvi_id'] != null){
	        $query->join('INNER', 'bc_goibienche_hinhthuc AS b ON a.id = b.hinhthuc_id')
	              ->where('b.goibienche_id = (SELECT goibienche FROM ins_dept WHERE id = '.$db->quote($params['donvi_id']).')', 'OR');
            if($params['bosung_id'] != '' && $params['bosung_id'] != null){
                $query->where('a.id = '.$db->quote($params['bosung_id']));
            }
            $query->group('a.id');
	    }
	    if ($order == null) {
	        $query->order('name');
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
?>
