<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Core\Administrator\Model;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Filter\InputFilter;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormFactoryInterface;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Table\Table;
use Joomla\Database\ParameterType;
use Joomla\Utilities\ArrayHelper;
use stdClass;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;


class ConfigModel extends AdminModel{

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
                'a.title', 'title',
            ];
        }
        parent::__construct($config);
    }

    public function getForm($data = [], $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_core.config', 'config', ['control' => 'jform', 'load_data' => $loadData]);
        if (empty($form)) {
            return false;
        }

        return $form;
    }

    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = Factory::getApplication()->getUserState('com_core.config', []);
        if (empty($data)) {
            $data = $this->getItem();
        }
        $this->preprocessData('com_core.config', $data);

        return $data;
    }

    /**
     * Method to preprocess the form
     *
     * @param   Form    $form   A form object.
     * @param   mixed   $data   The data expected for the form.
     * @param   string  $group  The name of the plugin group to import (defaults to "content").
     *
     * @return  void
     *
     * @since   1.6
     * @throws  \Exception if there is an error loading the form.
     */
    protected function preprocessForm(Form $form, $data, $group = '')
    {
        // TO DO warning!
        parent::preprocessForm($form, $data, 'config');

    }

    /**
     * Method to save the form data.
     *
     * @param   array  $data  The form data.
     *
     * @return  boolean  True on success.
     *
     * @since   1.6
     */
    public function save($formData)
    {
        $data = new stdClass();
		$data->path = $formData['path'];
		$data->title = $formData['title'];
		$data->type = $formData['type'];
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
        // Clean the cache
        $this->cleanCache();
        return Factory::getDbo()->insertObject('core_config_field', $data);
    }

    public function update($formData)
    {
        $data = new stdClass();
        $data->id =  $formData['id'];
		$data->path = $formData['path'];
		$data->title = $formData['title'];
		$data->type = $formData['type'];
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
        // Clean the cache
        $this->cleanCache();
        return Factory::getDbo()->updateObject('core_config_field', $data,'id');
    }

    /**
	 * Tạo một giá trị
	 * @param array $formData
	 * @return boolean
	 */
	public function saveValue($formData){
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
		$flag = Factory::getDbo()->insertObject('core_config_value', $data);
        if ($flag) {
			$this->deleteCache();
		}
		return $flag;
	}

    public function updateValue($formData){

		$data = new stdClass();
		$data->config_field_id = $formData['config_field_id'];
		$data->path=$formData['path'];
		$data->value=$formData['value'];
		$data->id=$formData['id'];
		// Insert the object into the user profile table.
		$flag = Factory::getDbo()->updateObject('core_config_value', $data,'id',true);
		if ($flag) {
			$this->deleteCache();
		}
		return $flag;
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
    /**
	 * Xóa giá trị
	 * @param string $path
	 * @return mixed
	 */
	public function removeValue($path){
		$db  = Factory::getDbo();
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

    public function delete(&$pks)
    {
        $db  = Factory::getDbo();
		$query = $db->getQuery(true);
		$conditions = array(		 
            $db->quoteName('id') . ' = ' . $db->quote($pks)
		);		 
		$query->delete($db->quoteName('core_config_field'));
		$query->where($conditions);		 
		$db->setQuery($query);
		$flag = $db->execute();
		if ($flag) {
			$this->removeValue($pks);
		}
		return $flag;
    }
   

    /**
     * Auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function populateState()
    {
        $app = Factory::getApplication();

        // Load the User state.
        $id = $app->getInput()->getInt('id');

        $this->setState('config.id', $id);

        // Load the parameters.
        $params = ComponentHelper::getParams('com_core');
        $this->setState('params', $params);

        // Load the clientId.
        $clientId = $app->getUserStateFromRequest('com_core.configs.client_id', 'client_id', 0, 'int');
        $this->setState('client_id', $clientId);
    }

    /**
     * Method to get a menu item.
     *
     * @param   integer  $itemId  The id of the menu item to get.
     *
     * @return  mixed  Menu item data object on success, false on failure.
     *
     * @since   1.6
     */
    public function &getItem($itemId = null)
    {
       
        $itemId = (!empty($itemId)) ? $itemId : (int) $this->getState('config.id');

        // Get a menu item row instance.
        $table = $this->getTable();

        // Attempt to load the row.
        $return = $table->load($itemId);

        // Check for a table object error.
        if ($return === false && $table->getError()) {
            $this->setError($table->getError());

            return false;
        }

        $properties = $table->getProperties(1);
        $value      = ArrayHelper::toObject($properties, CMSObject::class);

        return $value;
    }


    public function &getValue($itemId = null)
    {
       
        $itemId = (!empty($itemId)) ? $itemId : (int) $this->getState('config.id');

        // Get a menu item row instance.
        $table = $this->getTable('Value', 'Joomla\\Component\\Core\\Administrator\\Table\\', array());

        // Attempt to load the row.
        $return = $table->load($itemId);

        // Check for a table object error.
        if ($return === false && $table->getError()) {
            $this->setError($table->getError());

            return false;
        }

        $properties = $table->getProperties(1);
        $value      = ArrayHelper::toObject($properties, CMSObject::class);

        return $value;
    }
   

}