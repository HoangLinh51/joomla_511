<?php
/* HueNN
 *
 * Created on Wed Jun 28 2023
 *
 * Copyright (c) 2023 (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Joomla\Component\Decentralization\Administrator\Table;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Category table
 *
 * @since  1.6
 */

use Joomla\CMS\Access\Rules;
use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Table\Nested;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;
use Joomla\Registry\Registry;

class Module extends Table
{
    /**
     * Indicates that columns fully support the NULL value in the database
     *
     * @var    boolean
     * @since  4.0.0
     */
    protected $_supportNullValue = true;

    /**
     * Class constructor.
     *
     * @param   DatabaseDriver  $db  DatabaseDriver object.
     *
     * @since   3.7.0
     */
    public function __construct($db = null)
    {
        parent::__construct('core_module', 'id', $db);
        $this->setColumnAlias('published', 'status');
    }

    /**
     * Method to return the title to use for the asset table.
     *
     * @return  string
     *
     * @since   1.6
     */
    protected function _getAssetTitle()
    {
        return $this->title;
    }

    /**
     * Override check function
     *
     * @return  boolean
     *
     * @see     Table::check()
     * @since   1.5
     */
    public function check()
    {
        try {
            parent::check();
        } catch (\Exception $e) {
            $this->setError($e->getMessage());

            return false;
        }

        return true;
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

        if (isset($src['moduleparams']) && is_array($src['moduleparams'])) {
            // Make sure $registry->options contains no duplicates when the module type is subform
            if (isset($src['type']) && $src['type'] == 'subform' && isset($src['moduleparams']['options'])) {
                // Fast lookup map to check which custom module ids we have already seen
                $seen_custommodules = [];

                // Container for the new $src['moduleparams']['options']
                $options = [];

                // Iterate through the old options
                $i = 0;

                foreach ($src['moduleparams']['options'] as $option) {
                    // Check whether we have not yet seen this custom module id
                    if (!isset($seen_custommodules[$option['custommodule']])) {
                        // We haven't, so add it to the final options
                        $seen_custommodules[$option['custommodule']] = true;
                        $options['option' . $i]                    = $option;
                        $i++;
                    }
                }

                // And replace the options with the deduplicated ones.
                $src['moduleparams']['options'] = $options;
            }

            $registry = new Registry();
            $registry->loadArray($src['moduleparams']);
            $src['moduleparams'] = (string) $registry;
        }

        // Bind the rules.
        if (isset($src['rules']) && is_array($src['rules'])) {
            $rules = new Rules($src['rules']);
            $this->setRules($rules);
        }

        return parent::bind($src, $ignore);
    }

}
?>