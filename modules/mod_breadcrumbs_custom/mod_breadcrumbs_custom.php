<?php

use Joomla\CMS\Helper\ModuleHelper;

defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$showHome = $params->get('show_home', 1);
$list = ModBreadcrumbsCustomHelper::getBreadcrumbs($params);

require ModuleHelper::getLayoutPath('mod_breadcrumbs_custom');
