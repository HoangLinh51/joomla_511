<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_trinhdon
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Module\Trinhdon\Site\Helper\TrinhdonHelper;
require_once (dirname(__FILE__).'/src/helper/TrinhDonHelper.php');

$list       = TrinhdonHelper::getMenu($params);
$class_sfx  = htmlspecialchars($params->get('class_sfx', ''), ENT_COMPAT, 'UTF-8');
if (!$list) {
    return;
}
echo $list;
require ModuleHelper::getLayoutPath('mod_trinhdon');

// require ModuleHelper::getLayoutPath('mod_trinhdon', $params->get('layout', 'default'));
