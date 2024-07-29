<?php
/* HueNN
 *
 * Created on Sat Jul 08 2023
 *
 * Copyright (c) 2023 (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Decentralization\Administrator\Helper;
use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\Database\ParameterType;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Components helper for com_config
 *
 * @since  3.0
 */
class DecentralizationHelper{
	public static function makeParentChildRelationsForTree(&$inArray, &$outArray, $currentParentId = 0) {
		if(!is_array($inArray)) {
			return;
		}
		if(!is_array($outArray)) {
			return;
		}
		
		
		foreach($inArray as $key => $tuple) {
			if($tuple['parent_id'] == $currentParentId) {
				$tuple['id'] = $tuple['id'];
				if($tuple['type'] == 'folder'){
					$tuple['title'] = '<i class="jstree-icon jstree-themeicon fa fa-folder text-primary jstree-themeicon-custom" role="presentation"></i> '.$tuple['name'];

				}else{
					$tuple['title'] = '<i style="color: #218bff !important" class="jstree-icon jstree-themeicon fa fa-file text-primary jstree-themeicon-custom" role="presentation"></i> '.$tuple['name'];
				}
				$tuple['subs'] = array();
				DecentralizationHelper::makeParentChildRelationsForTree($inArray, $tuple['subs'], $tuple['id'], $tuple['type']);
				$outArray[] = $tuple;
			}
		}
	}

	/**
     * Get a list of modules positions
     *
     * @param   integer  $clientId       Client ID
     * @param   boolean  $editPositions  Allow to edit the positions
     *
     * @return  array  A list of positions
     */
    public static function getComponents()
    {
        $db       = Factory::getDbo();
        $query    = $db->getQuery(true)
            ->select('extension_id, element, type' )
            ->from($db->quoteName('jos_extensions'))
			->where($db->quoteName('type') .'= "component"');
        $db->setQuery($query);
// echo $query;exit;
        try {
            $components = $db->loadAssocList();
            $components = is_array($components) ? $components : [];
        } catch (\RuntimeException $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');

            return;
        }

        // Build the list
        $options = [];
		foreach ($components as $component) {
            $option        = new \stdClass();
            $option->value = $component['element'];
            $option->text = Text::_(($component['element']));
            $options[] = $option;
        }
        return $options;
    }

}