<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Core\Administrator\Model;

use Joomla\CMS\Factory;
use Joomla\CMS\Filter\InputFilter;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormFactoryInterface;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Table\Table;
use Joomla\Database\ParameterType;
use Joomla\Utilities\ArrayHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;


class ConfigsModel extends ListModel{

    public function getTable($type = 'Config', $prefix = 'Joomla\\Component\\Core\\Administrator\\Table\\', $config = [])
    {
        $return = Table::getInstance($type, $prefix, $config);

        return $return;
    }

     /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @since   3.9.0
     *
     * @throws  Exception
     */
    public function __construct($config = [])
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = [
                'a.id', 'id',
            ];
        }
        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * @param   string  $ordering   An optional ordering field.
     * @param   string  $direction  An optional direction (asc|desc).
     *
     * @return  void
     *
     * @since   3.9.0
     *
     * @throws  Exception
     */
    protected function populateState($ordering = 'a.id', $direction = 'desc')
    {
        parent::populateState($ordering, $direction);
    }


    protected function getListQuery()
    {
        $id      = Factory::getApplication()->input->getInt('id');    
        $db    = $this->getDatabase();
        $query = $db->getQuery(true);
        $query->select(array('a.path','a.id','a.title','b.value','a.type'))->from('core_config_field AS a');
        if ((int)$id > 0) {			
			$path = $this->getPathById($id);
			$query->where('a.path LIKE '.$db->quote($path.'/%')); 
		}
        $query->join('LEFT', 'core_config_value AS b ON b.config_field_id = a.id');
        // Get ordering
        $fullorderCol = $this->state->get('list.fullordering', 'a.id DESC');
        // Apply ordering
        if (!empty($fullorderCol)) {
            $query->order($db->escape($fullorderCol));
        }
        $this->setState('list.id', $id);
        return $query;
    }

    public function listConfigById($id){
        $db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('a.path','a.id','a.title','b.value','a.type'))->from('core_config_field AS a');
		if ((int)$id > 0) {			
			$path = $this->getPathById($id);
			$query->where('a.path LIKE '.$db->quote($path.'/%'));
		}
		$query->join('LEFT', 'core_config_value AS b ON b.config_field_id = a.id');
        // Get ordering
        $fullorderCol = $this->state->get('list.fullordering', 'a.id ASC');
        // // Apply ordering
        if (!empty($fullorderCol)) {
            $query->order($db->escape($fullorderCol));
        }
        $db->setQuery($query);
		return $db->loadAssocList();
    }

	public function getPathById($id){
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('path'))
			->from('core_config_field')
			->where('id = '.$db->quote($id));
		$db->setQuery($query);
		return $db->loadResult();
	}

	public function treemenu($id){
        $db = Factory::getDbo(); 
		$query = $db->getQuery(true);
		$query->select('id,title,lvl,path')
				->from('core_config_field');
		if ((int)$id == 0) {
			$query->where('lvl = 1');
		}
        $db->setQuery($query);
		$rows = $db->loadAssocList();   
        $data = array(); 
        for ($i = 0; $i < count($rows); $i++) {
            // $children = []; 
            $children = array(); 
            if($rows[$i]['id'] == 1){                            
                $queryss = $db->getQuery(true);
                $queryss->select('path')
                ->from('core_config_field');
                $db->setQuery($queryss);
                $path = $db->loadAssocList(); 
                $pathParent = $path[$i]['path'];              
                $querys = $db->getQuery(true);
                $querys->select('id, title,lvl, LOWER((SUBSTRING_INDEX(path, "/", 1))) as path')
			        ->from('core_config_field')
                    ->where('lvl = 2')
				 	->where("path LIKE '{$pathParent}/%'"); 
                $db->setQuery($querys);
                $rowss = $db->loadAssocList();           
                for ($ii=0; $ii < count($rowss); $ii++) { 
                    $child = array(
                        'text' => $rowss[$ii]['title'],
                        'id' => $rowss[$ii]['id']
                    ); 
                    if($rowss[$ii]['path'] == $rows[$i]['path']){
                        array_push($children, $child); 
                    }
                }            
            } 
           
            $data[] = array(           
                "id" => "node_".$rows[$i]['id'],
                "text" => $rows[$i]['title'],
                "state" => ((int)$rows[$i]['lvl'] < 3) ? "closed" : "",
                //"state" => $rows[$i]['id'] == '1' ? array('selected'=>true) : "",
                "children" =>  $children
            );
           
            
        }
        return $data;
	}

}