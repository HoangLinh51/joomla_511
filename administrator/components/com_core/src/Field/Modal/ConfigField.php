<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_categories
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Core\Administrator\Configs\Modal;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\LanguageHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Session\Session;
use Joomla\Database\ParameterType;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Supports a modal category picker.
 *
 * @since  3.1
 */
class ConfigsField extends FormField
{
    /**
     * The form field type.
     *
     * @var     string
     * @since   1.6
     */
    protected $type = 'Modal_Config';

    /**
     * Method to get the field input markup.
     *
     * @return  string  The field input markup.
     *
     * @since   1.6
     */
    protected function getInput()
    {

        $allowNew       = ((string) $this->element['new'] == 'true');
        $allowPropagate = ((string) $this->element['propagate'] == 'true');

        $languages = LanguageHelper::getContentLanguages([0, 1], false);

        // Load language.
        Factory::getLanguage()->load('com_core', JPATH_ADMINISTRATOR);

        // The active category id field.
        $value = (int) $this->value ?: '';

        // Create the modal id.
        $modalId = 'Config_' . $this->id;
      
        /** @var \Joomla\CMS\WebAsset\WebAssetManager $wa */
        $wa = Factory::getApplication()->getDocument()->getWebAssetManager();

        // Add the modal field script to the document head.
        $wa->useScript('field.modal-fields');

        

        // Setup variables for display.
        $linkConfigs  = 'index.php?option=com_core&amp;view=config&amp;layout=modal&amp;tmpl=component&amp;' . Session::getFormToken() . '=1';
        $modalTitle    = Text::_('Thêm mới');
        $urlNew    = $linkConfigs . '&amp;task=config.add';

        if ($value) {
            $db    = $this->getDatabase();
            $query = $db->getQuery(true)
                ->select($db->quoteName('title'))
                ->from($db->quoteName('core_config_field'))
                ->where($db->quoteName('id') . ' = :value')
                ->bind(':value', $value, ParameterType::INTEGER);
            $db->setQuery($query);

            try {
                $title = $db->loadResult();
            } catch (\RuntimeException $e) {
                Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            }
        }

        $title = empty($title) ? Text::_('COM_CATEGORIES_SELECT_A_CATEGORY') : htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

        // The current category display field.
        $html  = '';

        $html .= '<span class="input-group">';
        

        $html .= '<input class="form-control" id="' . $this->id . '_name" type="text" value="' . $title . '" readonly size="35">';

        
        // New category button.
        if ($allowNew) {
            $html .= '<button'
                . ' class="btn btn-secondary' . ($value ? ' hidden' : '') . '"'
                . ' id="' . $this->id . '_new"'
                . ' data-bs-toggle="modal"'
                . ' type="button"'
                . ' data-bs-target="#ModalNew' . $modalId . '">'
                . '<span class="icon-plus" aria-hidden="true"></span> ' . Text::_('JACTION_CREATE')
                . '</button>';
        }


        $html .= '</span>';
  

        

        // New category modal.
        if ($allowNew) {
            $html .= HTMLHelper::_(
                'bootstrap.renderModal',
                'ModalNew' . $modalId,
                [
                    'title'       => Text::_('COM_CATEGORIES_NEW_CATEGORY'),
                    'backdrop'    => 'static',
                    'keyboard'    => false,
                    'closeButton' => false,
                    'url'         => $linkConfigs,
                    'height'      => '400px',
                    'width'       => '800px',
                    'bodyHeight'  => 70,
                    'modalWidth'  => 80,
                    'footer'      => '<button type="button" class="btn btn-secondary"'
                            . ' onclick="window.processModalEdit(this, \'' . $this->id . '\', \'add\', \'category\', \'cancel\', \'item-form\'); return false;">'
                            . Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>'
                            . '<button type="button" class="btn btn-primary"'
                            . ' onclick="window.processModalEdit(this, \'' . $this->id . '\', \'add\', \'category\', \'save\', \'item-form\'); return false;">'
                            . Text::_('JSAVE') . '</button>'
                            . '<button type="button" class="btn btn-success"'
                            . ' onclick="window.processModalEdit(this, \'' . $this->id . '\', \'add\', \'category\', \'apply\', \'item-form\'); return false;">'
                            . Text::_('JAPPLY') . '</button>',
                ]
            );
        }


        // Note: class='required' for client side validation
        $class = $this->required ? ' class="required modal-value"' : '';

        $html .= '<input type="hidden" id="' . $this->id . '_id"' . $class . ' data-required="' . (int) $this->required . '" name="' . $this->name
            . '" data-text="' . htmlspecialchars(Text::_('COM_CATEGORIES_SELECT_A_CATEGORY', true), ENT_COMPAT, 'UTF-8') . '" value="' . $value . '">';

        return $html;
    }

    /**
     * Method to get the field label markup.
     *
     * @return  string  The field label markup.
     *
     * @since   3.7.0
     */
    protected function getLabel()
    {
        return str_replace($this->id, $this->id . '_name', parent::getLabel());
    }
}
