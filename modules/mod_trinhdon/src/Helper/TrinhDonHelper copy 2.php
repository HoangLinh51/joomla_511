<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_trinhdon
 *
 * @since       1.5
 */

namespace Joomla\Module\Trinhdon\Site\Helper;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

/**
 * Helper for mod_trinhdon
 *
 * @since  1.5
 */
class TrinhdonHelper
{
    /**
     * Get a list of the menu items.
     *
     * @param   \Joomla\Registry\Registry  $params  The module options.
     *
     * @return  string
     *
     * @since   1.5
     */
    public static function getMenu($params)
    {
        $user = Factory::getUser();
        if ($user->id == null) {
            return '';
        }

        $jinput = Factory::getApplication()->input;
        $option = $jinput->getCmd('option', 'default');
		$controller = $jinput->getCmd('controller', '');
        $view = $jinput->getCmd('view', 'default');
        $task = $jinput->getCmd('task', 'default');
        $db = Factory::getDbo();
        $trinhdon = $params->get('trinhdon');
        $menu_ids = (array) $trinhdon;
        $query = $db->getQuery(true)
            ->select('a.lft, a.rgt')
            ->from($db->quoteName('core_menu', 'a'))
            ->where('a.id IN (' . implode(',', $menu_ids) . ')');
        $db->setQuery($query);
        $parent_nodes = $db->loadAssocList();
		if($controller == ''){
			$controller = $view;
		}
        $conditions = [];
        foreach ($parent_nodes as $parent_node) {
            $conditions[] = '(a.lft BETWEEN ' . $db->quote($parent_node['lft']) . ' AND ' . $db->quote($parent_node['rgt']) . ' AND a.published = 1 AND b.published = 1)';
        }

        $query = $db->getQuery(true)
            ->select('a.icon, a.id, a.link, a.is_system, a.name AS name, a.params, a.lft, a.rgt, a.published, a.component, a.controller, a.task, a.level')
            ->from($db->quoteName('core_menu', 'a'))
            ->join('LEFT', 'core_menu AS b ON a.parent_id = b.id')
            ->where('(a.published = 1 AND a.id <> 1 AND b.published = 1)')
            ->where(implode(' OR ', $conditions))
            ->order('a.lft');
        $db->setQuery($query);
        $rows = $db->loadAssocList();

        $query = $db->getQuery(true)
            ->select('parent.id')
            ->from('core_menu AS node, core_menu AS parent')
            ->where('node.lft BETWEEN parent.lft AND parent.rgt')
            ->where('node.id = (SELECT id FROM core_menu WHERE (component = ' . $db->quote($option) . ') AND (controller = ' . $db->quote($controller) . ') LIMIT 1)')
            ->where('parent.id != 1')
            ->order('parent.lft');
        $db->setQuery($query);
        $actives = $db->loadColumn();
        $active = count($actives) > 0 ? end($actives) : 0;

        return self::buildMenuHtml($rows, $active, $actives, $user);
    }

    private static function buildMenuHtml($rows, $active, $actives, $user)
    {
        $result = '<ul class="nav nav-pills nav-sidebar flex-column">';
        $current_depth = 1;
        $counter = 0;
        $is_visibled = 0;
        $index = 0;

        foreach ($rows as $node) {
            $index++;
            $flag = false;
            if ($user->id != null && $node['is_system'] == 1) {
                if (!self::checkPermission($user->id, $node['component'], $node['controller'], $node['task'])) {
                    continue;
                    $flag = true;
                }
            }

            if ($node['is_system'] == 1 && empty($node['link'])) {
                $node['link'] = 'index.php?option=' . $node['component'] . '&view=' . $node['controller'] . '&task=' . $node['task'] . '&' . $node['params'] . '#';
            }

            $child = false;
            $node_depth = $node['level'];
            $node_name = $node['name'];
            $node_id = $node['id'];
            $hasChild = isset($rows[$index]) && $node['lft'] < $rows[$index]['lft'] && $node['rgt'] > $rows[$index]['rgt'];

            if ($node_depth == $current_depth) {
                if ($counter > 0) {
                    $result .= '</li>';
                }
            } elseif ($node_depth > $current_depth) {
                $result .= '<ul class="nav nav-treeview submenu">';
                $child = true;
                $current_depth++;
            } elseif ($node_depth < $current_depth) {
                $result .= str_repeat('</li></ul>', $current_depth - $node_depth) . '</li>';
                $current_depth--;
            }

            $icon = empty($node['icon']) ? '' : '<i class="' . $node['icon'] . '"></i>';
            $result .= '<li id="c' . $node_id . '" class="nav-item">';
            $result .= $child ? '<a class="nav-link '.(($node['id'] == $active)? 'active' : '').'  '.(((int)$node['is_system'] == 0)? 'menu-open' : '').'" href="' . $node['link'] . '">' : '<a href="' . $node['link'] . '" class="nav-link '.(($node['id'] == $active)? 'active' : '').''.(((int)$node['is_system'] == 0)? 'menu-open' : '').'">' . $icon . '<p class="menu-text"> ' . $node_name . '</p></a>';

            $is_visibled = 1;
            $counter++;
        }

        $result .= str_repeat('</li></ul>', $current_depth) . '</li>';
        $result .= '</ul>';

        return $is_visibled ? $result : '';
    }

    private static function checkPermission($userId, $component, $controller, $task)
    {
        // Implement your permission check logic here
        return true;
    }
}
