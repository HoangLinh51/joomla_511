<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_trinhdon
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Module\Trinhdon\Site\Helper;

use Core;
use Joomla\CMS\Factory;

\defined('_JEXEC') or die;

/**
 * Helper for mod_trinhdon
 *
 * @since  1.5
 */
class TrinhdonHelper{
	/**
     * Get a list of the menu items.
     *
     * @param   \Joomla\Registry\Registry  &$params  The module options.
     *
     * @return  array
     *
     * @since   1.5
     */
    public static function getMenu(&$params){
		$user = Factory::getUser();
		if ($user->id == null) {
			return '';
		}
		$jinput = Factory::getApplication()->input;
		$option = $jinput->getCmd('option','default');
		$controller = $jinput->getCmd('controller','default');
		$task = $jinput->getCmd('task','default');
		$db = Factory::getDbo();
		$trinhdon = $params->get('trinhdon');
		$n = count($trinhdon);
		if($n > 1){
    		for($i = 0; $i < $n; $i++){
    		    $menu_id[] = $db->quote($trinhdon[$i]);
    		}
		}else{
		    $menu_id[] = $trinhdon[0];
		}
	    $query = $db->getQuery(true);
	    $query->select('a.lft,a.rgt')
	      ->from($db->quoteName('core_menu','a'))
	      ->where('a.id IN ('.implode(',', $menu_id).')');
	    $db->setQuery($query);
	    $parent_node = $db->loadAssocList();
	    for($i = 0, $n = count($parent_node); $i < $n; $i++){
	        $condition[] = '(a.lft BETWEEN '.$db->quote($parent_node[$i]['lft']).' AND '.$db->quote($parent_node[$i]['rgt']).' AND a.published = 1 AND b.published = 1)'; 
	    }
		
	    $query = $db->getQuery(true); 
	    $query->select('a.icon,a.id,a.link,a.is_system,a.name,a.params,a.lft,a.rgt,a.published,a.component,a.controller,a.task,a.level')
	      ->from($db->quoteName('core_menu','a'))
	      ->join('LEFT', 'core_menu AS b ON a.parent_id = b.id')
	      ->where('(a.published = 1 AND a.id <> 1 AND b.published = 1)')
	      ->where(implode(' OR ', $condition))
	      ->order('a.lft');
		$db->setQuery($query);
		$rows = $db->loadAssocList();
		$sql = $db->getQuery(true);
		$sql->select('parent.id')
		  ->from('core_menu AS node,core_menu AS parent')
		  ->where('node.lft BETWEEN parent.lft AND parent.rgt')
		  ->where('node.id = (SELECT id FROM core_menu WHERE (component = '.$db->q($option).') AND (controller = '.$db->q($controller).') AND (task = '.$db->q($task).') LIMIT 1)')
		  ->where('parent.id != 1')
		  ->order('parent.lft');
		$db->setQuery($sql);
		$actives = $db->loadColumn();
		if (count($actives) > 0 ) {
			$active = end($actives);
		}else{
			$active = 0;
		}
		$counter = 0;
		
		$result = '<ul class="sidebar-menu tree">';
		
		$current_depth = 1;
		$index = 0;
		$is_visibled = 0;
		// echo "<pre>";
		// var_dump($rows);exit;
		foreach ( $rows as $node ) {

			$index ++;
			$flag = false;
			if ($user->id != null && $node ['is_system'] == 1) {
				if (false == Core::_checkPerAction ( $user->id, $node ['component'], $node ['controller'], $node ['task'] )) {
					continue;
					$flag = true;
				}
			}
			if($node ['is_system'] == 1){
			    if($node['link'] == ''){
				    $node['link'] = 'index.php?option='.$node['component'].'&view='.$node['controller'].'&task='.$node['task'].'&'.$node['params'].'#';
			    }
			}
			$child = false;
			$node_depth = $node ['level'];
			$node_name = $node ['name'];
			$node_id = $node ['id'];
			if ((int)$rows[$index]['lft'] > 0) {
				$hasChild = (($node ['lft'] < (int)$rows[$index]['lft']) && ($node ['rgt'] > (int)$rows[$index]['rgt']) )?true:false;
			}
			else{
				$hasChild = false;
			}
			if ($node_depth == $current_depth) {
				if ($counter > 0)
					$result .= '</li>';
			} elseif ($node_depth > $current_depth) {
				$result .= '<ul class="submenu">';
				$child = true;
				$current_depth = $current_depth + ($node_depth - $current_depth);
			} elseif ($node_depth < $current_depth) {
				$result .= str_repeat ( '</li></ul>', $current_depth - $node_depth ) . '</li>';
				$current_depth = $current_depth - ($current_depth - $node_depth);
			}
			$liKlass = '';
			if ($flag == false) {				
				$result .= '<li id="c' . $node_id . '"';
				$result .= (in_array($node['id'], $actives))? ' class="open active"' : '';
				$icon = ($node['icon']==null)?'':'<i class="'.$node['icon'].'"></i>';	
				if ($child == true) {
					$result .= '><a href="'.$node['link'].'">'.(($node['id'] == $active)? '<i class="icon-double-angle-right"></i>' : '').$node_name . '</a>';
				}else{
					if ($hasChild == true) {	
						$result .= '><a href="'.$node['link'].'" class="dropdown-toggle">'.$icon.'<span class="menu-text">' . $node_name . '</span><b class="arrow icon-angle-down"></b></a>';
					}else{	
						$result .= '><a href="'.$node['link'].'">'.$icon.(($node['id'] == $active)? '<i class="icon-double-angle-right"></i>' : '').'<span class="menu-text">' . $node_name . '</span></a>';
					}
				}
	            $is_visibled = 1;
			}
			++ $counter;
		}
		$result .= str_repeat ( '</li></ul>', $node_depth ) . '</li>';
		$result .= '</ul>';
		if($is_visibled == 1){
		  return $result;
		}else{
		    return '';
		}
	}
}
