<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_core
 *
 * @copyright   (C) 2012 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Core\Administrator\Helper;

use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Fields\FieldsServiceInterface;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Text;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Components helper for com_config
 *
 * @since  3.0
 */
class CoreHelper 
{
    /**
     * Get an array of all enabled components.
     *
     * @return  array
     *
     * @since   3.0
     */
    public static function getName($id)
    {
        if ($id == null) {
			return '';
		}
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('name'))
			->from('core_menu')
			->where('id = '.$db->q($id))
		;
		$db->setQuery($query);
		return $db->loadResult();
    }

    public static function extract($contextString, $item = null)
    {
        if ($contextString === null) {
            return null;
        }

        $parts = explode('.', $contextString, 2);

        if (count($parts) < 2) {
            return null;
        }

        $newSection = '';

        $component = Factory::getApplication()->bootComponent($parts[0]);

        if ($component instanceof FieldsServiceInterface) {
            $newSection = $component->validateSection($parts[1], $item);
        }

        if ($newSection) {
            $parts[1] = $newSection;
        }

        return $parts;
    }

    static public function printJson($data){
		$callback = Factory::getApplication()->getInput()->getString('callback');
		$data=json_encode($data);
		header("HTTP/1.0 200 OK");
		header('Content-type: application/json; charset=utf-8');
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Pragma: no-cache");
		if (!empty($callback)){
			echo $callback . '(',$data, ');';
		}else{
			echo $data;
		}
		die;
	}

}
