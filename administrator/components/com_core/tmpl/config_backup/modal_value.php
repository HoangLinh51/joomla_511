<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_menus
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;

defined('_JEXEC') or die;

?>
<button id="saveBtn" type="button" class="visually-hidden" onclick="Joomla.submitbutton('config.addValue');"></button>
<button id="closeBtn" type="button" class="visually-hidden" onclick="Joomla.submitbutton('config.cancel');"></button>
<div class="container-popup">
    <?php $this->setLayout('edit_value'); ?>
    <?php echo $this->loadTemplate(); ?>
</div>

