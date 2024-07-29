<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.cassiopeia
 *
 * @copyright   (C) 2020 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

$module  = $displayData['module'];
$params  = $displayData['params'];
$attribs = $displayData['attribs'];

if ($module->content === null || $module->content === '') {
    return;
}

$moduleTag     = $params->get('module_tag', 'div');
$bootstrapSize = (int) $params->get('bootstrap_size');
$moduleClass   = ($bootstrapSize) ? ' span' . $bootstrapSize : '';
$headerTag     = htmlspecialchars($params->get('header_tag', 'h2'), ENT_COMPAT, 'UTF-8');

$headerClass   = $params->get('header_class');
$headerClass   = ($headerClass) ? ' ' . htmlspecialchars($headerClass, ENT_COMPAT, 'UTF-8') : '';

echo '<' . $moduleTag . ' class="sidebar-menu tree' . $moduleClass . '">';
if ($module->showtitle)
{
	echo '<' . $headerTag . ' class="module-title nav-header' . $headerClass . '">' . $module->title . '</' . $headerTag . '>';
}
echo $module->content;
echo '</' . $moduleTag . '>';
?>

