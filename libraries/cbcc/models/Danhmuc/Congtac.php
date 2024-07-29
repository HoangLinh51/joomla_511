<?php
class Danhmuc_Model_Congtac extends JModelLegacy
{
	/** @var object JTable object */
	//var $_table = 'ability_code';
	var $_id;
	function __construct()
    {
        parent::__construct();

        $array = JRequest::getVar('cid',  0, '', 'array');
        $this->setId((int)$array[0]);

    }
        /**
     * Method to set the softpin identifier
     *
     * @access    public
     * @param    int Hello identifier
     * @return    void
     */
    function setId($id)
    {
        // Set id and wipe data
        $this->_id    = $id;
        $this->_data    = null;
    }
	/**
	 * Returns the internal table object
	 * @return JTable
	 */

	 function _buildQuery($tb=null,$order='id')
    {
        $query = 'select * from '.$tb.' order by '.$order;
        return $query;
    }
 	function _buildQueryById($tb=null,$id=null)
    {
        $query = 'select * from '.$tb.' where '.$id.'='.(int)$this->_id;
      
        return $query;
    }
	function _buildQueryByIdVar($tb=null,$id=null)
    {
        $query = 'select * from '.$tb.' where '.$id.'='.$this->_id;
        return $query;
    }
    /**
     * Method to get a data
     * @return object with data
     */
	function getDataByID($tb=null,$id=null)
    {
        // Load the data
            $query=$this->_buildQueryById($tb,$id);
            $this->_db->setQuery( $query );
            $this->_data = $this->_db->loadObject();

        return $this->_data;
    }
	/**
     * Method to get a data
     * @return object with data
     */
	function getDataByIDVar($tb=null,$id=null)
    {
        // Load the data
            $query=$this->_buildQueryByIdVar($tb,$id);
            $this->_db->setQuery( $query );
            $this->_data = $this->_db->loadObject();

        return $this->_data;
    }
	function getData($tb=null,$order='id')
    {
        // Load the data
        if (empty( $this->_data )) {
            //$query = 'select * from ABILITY_CODE';
            $query =$this->_buildQuery($tb,$order);
            $this->_db->setQuery( $query );
            $this->_data = $this->_db->loadObjectList();
        }
        return $this->_data;
    }
	function getDataCmd($query=null)
    {
        // Load the data
        if (empty( $this->_data )) {
            $this->_db->setQuery( $query );
            $this->_data = $this->_db->loadObject();
        }
        return $this->_data;
    }
	function getDataCmdList($query=null)
    {
        // Load the data
        $this->_db->setQuery( $query );
        $this->_data = $this->_db->loadObjectList();
        return $this->_data;
    }
    function getDataField($query=null)
    {
    	$db =& JFactory::getDBO();
		$db->setQuery($query);
		$count = $db->loadResult();
		return $count;
    }
  /**
 * Method to store a record
 *
 * @access    public
 * @return    boolean    True on success
 */
    function storeData($tb=null)
    {
        $row =& $this->getTable($tb);
        $data = JRequest::get( 'post' );

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
	function deleteData($tb=null,$id=null,$cid = array())
    {
        $result = false;

        if (count( $cid ))
        {
            JArrayHelper::toInteger($cid);
            $cids = implode( ',', $cid );
            $query = 'DELETE FROM '.$tb
                . ' WHERE '.$id.' IN ( '.$cids.' )';                
            $this->_db->setQuery( $query );
            if(!$this->_db->query()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
        }

        return true;
    }
    /*
     * ham insert vao database boi cau lenh insert
     * 
     * */
    function storeDatabase($tb=null,$arrCol=array(),$val='',$id='id',$idVal=0)
    {
    	//$db = JFactory::getDbo();
    	//$db->quoteName($name)
    	if(count($arrCol))
    	{
    		$arrCols = implode( ',', $arrCol );
    		$result=$this->getDataCmd('select count(*) count from '.$tb.' where '.$id.'='.$idVal);
    		$rowcount=$result->count;
    		if((int)$rowcount<1)
    		{
    			$query='INSERT INTO '.$tb.'('.$id.','.$arrCols.') VALUES('.$idVal.','.$val.')';
    		}
    		else {
    			
    			$arrVal=split(',',$val);
//     			var_dump($arrVal,$arrCol);exit;
    			if(count($arrVal)==count($arrCol))
    			{
    				$query='UPDATE '.$tb.' SET ';	
    				for($index=0;$index<count($arrVal)-1;$index++)
    				{
    					$query.=$this->_db->quoteName($arrCol[$index]).'='.$this->_db->quote($arrVal[$index]).',';
    				}
    				//gan gia tri cuoi cung cho $query
    				$query.=$this->_db->quoteName($arrCol[count($arrVal)-1]).'='.$this->_db->quote($arrVal[count($arrVal)-1]);
    				$query.=' WHERE '.$this->_db->quoteName($id).'='.$this->_db->quote($idVal);
    			}
    			else {$query='';}
    		}
    		
   		//var_dump($query);
    	//	exit();
    		$this->_db->setQuery( $query );
            if(!$this->_db->query()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
            return  true;
    	}
    	return  false;
    }
    /*ham get gia tri lon nhat*/
    function getIdMax($tb=null,$field='id')
    {
    	// Load the data
        //if (empty( $this->_data )) {
            $query = 'select max('.$field.') max from '.$tb;
            
            $this->_db->setQuery( $query );
            $this->_data = $this->_db->loadObject();
        //}

        return $this->_data;
    }
	function publish($tb=null,$cid = array(), $publish = 1)
    {
        if (count( $cid ))
        {
            JArrayHelper::toInteger($cid);
            $cids = implode( ',', $cid );
			if($tb!=null)
			{
	            $query = 'UPDATE '.$tb
	                . ' SET status = '.(int) $publish
	                . ' WHERE id IN ( '.$cids.' )'                
	            ;
	            $this->_db->setQuery( $query );
	            if (!$this->_db->query()) {
	                $this->setError($this->_db->getErrorMsg());
	                return false;
	            }
			}
			else 
				return false;
        }

        return true;
    }
// Bổ sung  thay cho getdatabyID
/**
	 * @param mixed $formData
	 * @return boolean True on success
	 */
	public function create($table, $formData){
		$flag = false;
		$table = Core::table($table);
		$flag = $table->save($formData);
// 		$doituong_id = $table->id; retun id
		return $flag;
	}
	public function update($table, $formData){
		$table = Core::table($table);
		
		$flag = $table->save($formData);
		return $flag;
	}
	public function read($table, $id){
		$table = Core::table($table);
		//$table->load($id);
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
	public function delete($tb, $cid){
// 		var_dump($cid); exit;
		$table = Core::table($tb);
		return $table->delete($cid);
	}
	public function findAll($tb, $params = null,$order = null,$offset = null,$limit = null){
		$table = Core::table($tb);
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
// 		var_dump($db->loadAssocList()); exit;
		//return $table->delete($id);
	}
}