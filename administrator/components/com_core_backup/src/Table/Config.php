<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_fields
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Core\Administrator\Table;

use Joomla\CMS\Access\Rules;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Table\Nested;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;
use Joomla\Registry\Registry;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Groups Table
 *
 * @since  3.7.0
 */
class Config extends Nested
{
    // Your properties and methods go here.	
	var $id = null;
	var $lvl = null;
	var $title = '';
	var $path = '';
	var $type = '';
	var $model = '';
	var $description = '';

    /**
     * Class constructor.
     *
     * @param   DatabaseDriver  $db  DatabaseDriver object.
     *
     * @since   3.7.0
     */
    public function __construct($db = null)
    {
        parent::__construct('core_config_field', 'id', $db);
    }

    /**
     * Method to bind an associative array or object to the JTable instance.This
     * method only binds properties that are publicly accessible and optionally
     * takes an array of properties to ignore when binding.
     *
     * @param   mixed  $src     An associative array or object to bind to the JTable instance.
     * @param   mixed  $ignore  An optional array or space separated list of properties to ignore while binding.
     *
     * @return  boolean  True on success.
     *
     * @since   3.7.0
     * @throws  \InvalidArgumentException
     */
    public function bind($src, $ignore = '')
    {
        if (isset($src['params']) && is_array($src['params'])) {
            $registry = new Registry();
            $registry->loadArray($src['params']);
            $src['params'] = (string) $registry;
        }

        // Bind the rules.
        if (isset($src['rules']) && is_array($src['rules'])) {
            $rules = new Rules($src['rules']);
            $this->setRules($rules);
        }

        return parent::bind($src, $ignore);
    }


}
