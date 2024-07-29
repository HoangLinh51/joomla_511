<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_decentralization
 *
 * @copyright   (C) 2017 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Decentralization\Administrator\Field;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\Language\Text;
use Joomla\Utilities\ArrayHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Components Category field.
 *
 * @since  1.6
 */
class OptionsGroupField extends ListField
{
    /**
     * The form field type.
     *
     * @var     string
     * @since   3.7.0
     */
    protected $type = 'OptionsGroup';

    /**
     * Method to get a list of options for a list input.
     *
     * @return  array  An array of JHtml options.
     *
     * @since   3.7.0
     */
    protected function getOptions($id_user = null)
    {
        // Initialise variable.
        $db      = $this->getDatabase();
        $options = [];

        if ((int)$id_user > 0) {
			$query = 'SELECT gr.id, gr.title, ug.user_id as `check` FROM jos_usergroups as gr
			LEFT JOIN jos_user_usergroup_map as ug ON ug.group_id = gr.id and ug.user_id = '.(int)$id_user.'
			ORDER BY gr.id'
			;
		}else {
			$query	= 'SELECT id, title FROM jos_usergroups 
						ORDER BY id';
		}
		$db->setQuery($query);

        $groupTypes = $db->loadAssocList();
       
        foreach ($groupTypes as $groupType) {
            $option        = new \stdClass();
            $option->value = $groupType['id'];
            $option->text = Text::_(($groupType['title']));
            $options[] = $option;
        }

        // Sort by name
        $options = ArrayHelper::sortObjects($options, 'text', 1, true, true);

        // Merge any additional options in the XML definition.
        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}
