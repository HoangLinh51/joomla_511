<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_tochuc
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
 */

use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Tochuc Component Tochuc Helper
 *
 * @static
 * @package     Joomla.Site
 * @subpackage  com_contact
 * @since       1.5
 *
 * @deprecated  4.3 will be removed in 6.0
 *              Use \Joomla\Component\Tochuc\Site\Helper\TochucHelper instead
 *              Example: TochucHelper::method();
 */
abstract class TochucHelperRoute extends TochucHelper
{
}
