<?php
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseModel;

class WhoisSalMgr  extends BaseModel

{
    /**
     * @param mixed $formData
     * @return boolean True on success
     */
    public function getTable($type = 'Bangluong', $prefix = 'Joomla\\Component\\Dmluong\\Administrator\\Table\\', $config = [])
    {
        return Table::getInstance($type, $prefix, $config);
    }
    public function getModel($name = 'Bangluong', $prefix = 'Danhmuc', $config = ['ignore_request' => true])
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function create($data)
    {
        $table = $this->getTable();
        var_dump($table);exit;
        // Prepare the data array
        $src = [
            'name' => $data['name'],
            'status' => $data['status'],
           
        ];

        // Save the new record
        return $table->save($src);
    }

    public function update($formData)
    {
        // Get the table instance
        $table = $this->getTable();

        // Load the existing record based on the ID
        if (!$table->load($formData['id'])) {
            throw new \RuntimeException(Text::_('Record not found'));
        }

        // Prepare the data array
        $src = [
            'id' => $formData['id'],
            'name' => $formData['name'],
            'status' => $formData['status'],
            'is_nangluonglansau' => $formData['is_nangluonglansau'],
            'is_nhaptien' => $formData['is_nhaptien'],
            'is_nhapngaynangluong' => $formData['is_nhapngaynangluong'],
            'phantramsotienhuong' => $formData['phantramsotienhuong']
        ];

        // Update and save the existing record
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