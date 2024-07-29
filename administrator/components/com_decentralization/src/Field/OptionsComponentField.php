<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Decentralization\Administrator\Field;

use Joomla\CMS\Form\Field\ListField;
use Joomla\Component\Decentralization\Administrator\Helper\DecentralizationHelper;
use Joomla\Component\Users\Administrator\Helper\DebugHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Access Levels field.
 *
 * @since  3.6.0
 */
class OptionsComponentField extends ListField
{
    /**
     * The form field type.
     *
     * @var     string
     * @since   3.6.0
     */
    protected $type = 'OptionsComponent';

    /**
     * Method to get the field options.
     *
     * @return  array  The field option objects.
     *
     * @since   3.4.2
     */
    public function getOptions()
    {
        $options  = DecentralizationHelper::getComponents();
        return array_merge(parent::getOptions(), $options);
    }
}
