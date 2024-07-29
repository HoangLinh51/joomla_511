<?php
/* HueNN
 *
 * Created on Wed Jul 12 2023
 *
 * Copyright (c) 2023 (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Joomla\Component\Tochuc\Site\Model;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\ListModel;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Groups Model
 *
 * @since  3.7.0
 */
class TreeviewModel extends ListModel
{
    public function treeViewTochuc($id_parent, $option=array()){
		$db = Factory::getDbo();
		$exceptionUnits = Core::getUnManageDonvi(Factory::getUser()->id, $option['component'], $option['controller'], $option['task']);
		$exception_condition = ($exceptionUnits)?' AND a.id NOT IN ('.$exceptionUnits.')':'';
		$where = ($option['condition'])?' AND '.$option['condition']:'';
		$checked = ((int)$option['checked'])>0?$this->getParent($option['checked']):$option['parent_id'];
		$query = 'SELECT a.id,a.parent_id,a.type,a.name,a.level,a.lft,a.rgt,a.active, (if(a.id = '.(int)$checked.', "jstree-checked","jstree-unchecked")) as class,
                    (SELECT COUNT(id) FROM ins_dept WHERE parent_id = a.id) AS children
					FROM ins_dept AS a
					WHERE a.active = 1 and a.type!=0 AND a.parent_id = '.$db->quote($id_parent).$exception_condition.$where.'
					ORDER BY a.lft'; //echo $query;
		$db->setQuery($query);
		$rows = $db->loadAssocList();
		$arrTypes = array('file','folder','root');
        if(count($rows) > 0){
            for ($i=0,$n=count($rows);$i<$n;$i++){
                $children = (($rows[$i]['children'] > 0 ) ? true : false);
              
                $types = '';
                $result[] = array(
                        "li_attr" => array("id" => "node_".$rows[$i]['id'], "type" => $arrTypes[$rows[$i]['type']], "showlist" => $rows[$i]['type'],"class" => $rows[$i]['class']),
                        "text" => $rows[$i]['name'],
                        'id' => "node_".$rows[$i]['id'],
                        'type' => $arrTypes[$rows[$i]['type']],
                        "showlist" => $rows[$i]['type'],
                        "class" => $rows[$i]['class'],
                        "state" => ((int)$rows[$i]['rgt'] - (int)$rows[$i]['left'] > 1) ? "closed" : "",
                        'children' =>  $children 
    
                );
    
            }
        }else{
            $result = array();
        }
		
		return json_encode($result);
	}
    public function getParent($checked){
		$db = Factory::getDbo();
		$query = "select parent_id from ins_dept where id=". $checked;
		$db->setQuery($query);
		return $db->loadResult();
	}
}