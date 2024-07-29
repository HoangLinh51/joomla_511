<?php

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use Joomla\Module\Trinhdon\Site\Helper\TrinhdonHelper;

defined('_JEXEC') or die;

class ModBreadcrumbsCustomHelper
{
    public static function getBreadcrumbs($params)
    {
        $app = Factory::getApplication();
        $pathway = $app->getPathway();
        $items = $pathway->getPathway();
        $menu = $app->getMenu();

        if ($params->get('show_home', 1)) {
            array_unshift($items, (object)[
                'name' => Text::_('MOD_BREADCRUMBS_CUSTOM_HOME'),
                'link' => Uri::base(),
                'component' => '', // Special case for home
                'view' => '',
                'module' => 'Home'
            ]);
        }

        foreach ($items as &$item) {
            list($item->component, $item->view, $item->module) = self::getComponentViewAndModule($item->link, $menu);
        }

        return $items;
    }

    private static function getComponentViewAndModule($link, $menu)
    {
        if (empty($link)) {
            return ['', '', ''];
        }

        $uri = new Uri($link);
        $view = $_GET['view'];
        // Get menu item
        $menuItem = Core::loadAssoc('core_menu', '*', 'controller = "'.$view.'"');
        $moduleName = '';
        if ($menuItem) {
            $moduleName = $menuItem['name'];
        }

        return [$moduleName ? $moduleName : ''];
    }
}
