<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Dmluong\Administrator\Service\HTML;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\LanguageHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Dmluong\Administrator\Helper\DmluongHelper;
use Joomla\Database\ParameterType;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Extended Utility class for the Users component.
 *
 * @since  2.5
 */
class Dmluong
{
    /**
     * Display an image.
     *
     * @param   string  $src  The source of the image
     *
     * @return  string  A <img> element if the specified file exists, otherwise, a null string
     *
     * @since   2.5
     * @throws  \Exception
     */
    public function image($src)
    {
        $src  = preg_replace('#[^A-Z0-9\-_\./]#i', '', $src);
        $file = JPATH_SITE . '/' . $src;

        Path::check($file);

        if (!file_exists($file)) {
            return '';
        }

        return '<img src="' . Uri::root() . $src . '" alt="">';
    }

    /**
     * Displays an icon to add a note for this user.
     *
     * @param   integer  $userId  The user ID
     *
     * @return  string  A link to add a note
     *
     * @since   2.5
     */
    public function addNote($userId)
    {
        $title = Text::_('COM_USERS_ADD_NOTE');

        return '<a href="' . Route::_('index.php?option=com_users&task=note.add&u_id=' . (int) $userId)
            . '" class="btn btn-secondary btn-sm"><span class="icon-plus pe-1" aria-hidden="true">'
            . '</span>' . $title . '</a>';
    }

    /**
     * Displays an icon to filter the notes list on this user.
     *
     * @param   integer  $count   The number of notes for the user
     * @param   integer  $userId  The user ID
     *
     * @return  string  A link to apply a filter
     *
     * @since   2.5
     */
    public function filterNotes($count, $userId)
    {
        if (empty($count)) {
            return '';
        }

        $title = Text::_('COM_USERS_FILTER_NOTES');

        return '<a href="' . Route::_('index.php?option=com_users&view=notes&filter[search]=uid:' . (int) $userId)
            . '" class="dropdown-item"><span class="icon-list pe-1" aria-hidden="true"></span>' . $title . '</a>';
    }

    /**
     * Displays a note icon.
     *
     * @param   integer  $count   The number of notes for the user
     * @param   integer  $userId  The user ID
     *
     * @return  string  A link to a modal window with the user notes
     *
     * @since   2.5
     */
    public function notes($count, $userId)
    {
        if (empty($count)) {
            return '';
        }

        $title = Text::plural('COM_USERS_N_USER_NOTES', $count);

        return '<button  type="button" data-bs-target="#userModal_' . (int) $userId . '" id="modal-' . (int) $userId
            . '" data-bs-toggle="modal" class="dropdown-item"><span class="icon-eye pe-1" aria-hidden="true"></span>' . $title . '</button>';
    }

    /**
     * Renders the modal html.
     *
     * @param   integer  $count   The number of notes for the user
     * @param   integer  $userId  The user ID
     *
     * @return  string   The html for the rendered modal
     *
     * @since   3.4.1
     */
    public function notesModal($count, $userId)
    {
        if (empty($count)) {
            return '';
        }

        $title  = Text::plural('COM_USERS_N_USER_NOTES', $count);
        $footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">'
            . Text::_('JTOOLBAR_CLOSE') . '</button>';

        return HTMLHelper::_(
            'bootstrap.renderModal',
            'userModal_' . (int) $userId,
            [
                'title'       => $title,
                'backdrop'    => 'static',
                'keyboard'    => true,
                'closeButton' => true,
                'footer'      => $footer,
                'url'         => Route::_('index.php?option=com_users&view=notes&tmpl=component&layout=modal&filter[user_id]=' . (int) $userId),
                'height'      => '300px',
                'width'       => '800px',
            ]
        );
    }

    /**
     * Build an array of block/unblock user states to be used by jgrid.state,
     * State options will be different for any user
     * and for currently logged in user
     *
     * @param   boolean  $self  True if state array is for currently logged in user
     *
     * @return  array  a list of possible states to display
     *
     * @since  3.0
     */
    public function blockStates($self = false)
    {
        if ($self) {
            $states = [
                1 => [
                    'task'           => 'unblock',
                    'text'           => '',
                    'active_title'   => 'COM_Dmluong_TOOLBAR_BLOCK',
                    'inactive_title' => '',
                    'tip'            => true,
                    'active_class'   => 'unpublish',
                    'inactive_class' => 'unpublish',
                ],
                0 => [
                    'task'           => 'block',
                    'text'           => '',
                    'active_title'   => '',
                    'inactive_title' => 'COM_USERS_USERS_ERROR_CANNOT_BLOCK_SELF',
                    'tip'            => true,
                    'active_class'   => 'publish',
                    'inactive_class' => 'publish',
                ],
            ];
        } else {
            $states = [
                1 => [
                    'task'           => 'unblock',
                    'text'           => '',
                    'active_title'   => 'COM_Dmluong_TOOLBAR_UNBLOCK',
                    'inactive_title' => '',
                    'tip'            => true,
                    'active_class'   => 'unpublish',
                    'inactive_class' => 'unpublish',
                ],
                0 => [
                    'task'           => 'block',
                    'text'           => '',
                    'active_title'   => 'COM_Dmluong_TOOLBAR_BLOCK',
                    'inactive_title' => '',
                    'tip'            => true,
                    'active_class'   => 'publish',
                    'inactive_class' => 'publish',
                ],
            ];
        }

        return $states;
    }

    /**
     * Build an array of activate states to be used by jgrid.state,
     *
     * @return  array  a list of possible states to display
     *
     * @since  3.0
     */
    public function activateStates()
    {
        $states = [
            1 => [
                'task'           => 'activate',
                'text'           => '',
                'active_title'   => 'COM_USERS_TOOLBAR_ACTIVATE',
                'inactive_title' => '',
                'tip'            => false,
                'active_class'   => 'unpublish',
                'inactive_class' => 'unpublish',
            ],
            0 => [
                'task'           => '',
                'text'           => '',
                'active_title'   => '',
                'inactive_title' => 'COM_USERS_ACTIVATED',
                'tip'            => false,
                'active_class'   => 'publish',
                'inactive_class' => 'publish',
            ],
        ];

        return $states;
    }



    /**
     * Get the sanitized value
     *
     * @param   mixed  $value  Value of the field
     *
     * @return  mixed  String/void
     *
     * @since   1.6
     */
    public function value($value)
    {
        if (is_string($value)) {
            $value = trim($value);
        }

        if (empty($value)) {
            return Text::_('COM_USERS_PROFILE_VALUE_NOT_FOUND');
        } elseif (!is_array($value)) {
            return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
        }
    }

    public function donvi($donvi_id){
        $tree_donvi = array();
        $inArray = Core::loadAssocList('ins_dept', array('id','level','name','parent_id',"IF(type=1,'file',IF(type=2,'folder',IF(type=0,'file','folder'))) AS type"),null,'lft');
        DmluongHelper::makeParentChildRelationsForTree($inArray, $tree_donvi);
        unset($inArray);

        $db = Factory::getDbo();
		$query = 'SELECT name, id FROM ins_dept WHERE id ='.$db->quote($donvi_id);
		$db->setQuery($query);   
        $row = $db->loadAssoc();  
       
        $html = [];
        $html[] = "<input type='hidden' name='jform[id_donvi]' id='' value='".$donvi_id."' class='form-control comboTreeInputBox' placeholder='Chọn tổ chức thuộc về' autocomplete='off'>"; 
        $html[] = "<input type='text' name='' id='jform_id_donvi' value='34543534' class='form-control comboTreeInputBox' placeholder='Chọn tổ chức thuộc về' autocomplete='off'>"; 
        $html[] = "<script>";
        $html[] = "jQuery(document).ready(function($) {";
       
        $html[] = "var tree_donvi = ".json_encode($tree_donvi).";";
        $html[] = "var instance = $('#jform_id_donvi').comboTree({";
        $html[] = "source : tree_donvi, isMultiple: false,cascadeSelect: true,collapse:true";

        $html[] = "})"; 
        $html[] = "})";
        $html[] = "</script>";
        return implode('', $html);
    }

    /**
     * Get the space symbol
     *
     * @param   mixed  $value  Value of the field
     *
     * @return  string
     *
     * @since   1.6
     */
    public function spacer($value)
    {
        return '';
    }

    /**
     * Get the sanitized template style
     *
     * @param   mixed  $value  Value of the field
     *
     * @return  mixed  String/void
     *
     * @since   1.6
     */
    public function templatestyle($value)
    {
        if (empty($value)) {
            return static::value($value);
        } else {
            $db    = Factory::getDbo();
            $query = $db->getQuery(true)
                ->select($db->quoteName('title'))
                ->from($db->quoteName('#__template_styles'))
                ->where($db->quoteName('id') . ' = :id')
                ->bind(':id', $value, ParameterType::INTEGER);
            $db->setQuery($query);
            $title = $db->loadResult();

            if ($title) {
                return htmlspecialchars($title, ENT_COMPAT, 'UTF-8');
            } else {
                return static::value('');
            }
        }
    }

    /**
     * Get the sanitized language
     *
     * @param   mixed  $value  Value of the field
     *
     * @return  mixed  String/void
     *
     * @since   1.6
     */
    public function admin_language($value)
    {
        if (!$value) {
            return static::value($value);
        }

        $path   = LanguageHelper::getLanguagePath(JPATH_ADMINISTRATOR, $value);
        $file   = $path . '/langmetadata.xml';

        if (!is_file($file)) {
            // For language packs from before 4.0.
            $file = $path . '/' . $value . '.xml';

            if (!is_file($file)) {
                return static::value($value);
            }
        }

        $result = LanguageHelper::parseXMLLanguageFile($file);

        if ($result) {
            return htmlspecialchars($result['name'], ENT_COMPAT, 'UTF-8');
        }

        return static::value($value);
    }

    /**
     * Get the sanitized language
     *
     * @param   mixed  $value  Value of the field
     *
     * @return  mixed  String/void
     *
     * @since   1.6
     */
    public function language($value)
    {
        if (!$value) {
            return static::value($value);
        }

        $path   = LanguageHelper::getLanguagePath(JPATH_SITE, $value);
        $file   = $path . '/langmetadata.xml';

        if (!is_file($file)) {
            // For language packs from before 4.0.
            $file = $path . '/' . $value . '.xml';

            if (!is_file($file)) {
                return static::value($value);
            }
        }

        $result = LanguageHelper::parseXMLLanguageFile($file);

        if ($result) {
            return htmlspecialchars($result['name'], ENT_COMPAT, 'UTF-8');
        }

        return static::value($value);
    }

    /**
     * Get the sanitized editor name
     *
     * @param   mixed  $value  Value of the field
     *
     * @return  mixed  String/void
     *
     * @since   1.6
     */
    public function editor($value)
    {
        if (empty($value)) {
            return static::value($value);
        } else {
            $db    = Factory::getDbo();
            $lang  = Factory::getLanguage();
            $query = $db->getQuery(true)
                ->select($db->quoteName('name'))
                ->from($db->quoteName('#__extensions'))
                ->where($db->quoteName('element') . ' = :element')
                ->where($db->quoteName('folder') . ' = ' . $db->quote('editors'))
                ->bind(':element', $value);
            $db->setQuery($query);
            $title = $db->loadResult();

            if ($title) {
                $lang->load("plg_editors_$value.sys", JPATH_ADMINISTRATOR)
                || $lang->load("plg_editors_$value.sys", JPATH_PLUGINS . '/editors/' . $value);
                $lang->load($title . '.sys');

                return Text::_($title);
            } else {
                return static::value('');
            }
        }
    }
    
    public function getAllAction_Core_Group($id_group = null){
		$result = array();
		$db = Factory::getDbo();
		if ((int)$id_group > 0) {
			$query = 'SELECT a.id_module as id_module,  ga.action_id as id_action, ga.type as type  
			FROM core_action AS a
			LEFT JOIN core_group_action as ga ON ga.action_id = a.id AND ga.group_id = '.(int)$id_group.'
			WHERE a.`status` = 1
			ORDER BY a.id_module, ga.type, ga.action_id ';
		}else{
            return null;
        }
        // echo $query;exit;
		$db->setQuery($query);
       
		$rows = $db->loadAssocList();
        
		for($i = 0; $i < count ( $rows ); $i ++) {
			$result[$rows [$i] ['id_module']] [$rows [$i] ['type']] [$rows [$i] ['id_action']] = $id_group;
		}
		return $result; 
	}

    public function nhomchucnang(){
        $arr_quanly		=	array(2=>'Tất cả tổ chức', 0=>'Tổ chức của người dùng', 1=>'Tổ chức cấp dưới' );
		$id_group = Factory::getApplication()->getInput()->get('id');
        $data_gr_a = $this->getAllAction_Core_Group($id_group);

		$i = 1;
        $result = array();
        $db = Factory::getDbo();
        $query = 'SELECT a.`name` as action_name , a.id as id_action, m.id as id_module, m.`name` as module_name FROM core_action AS a
        LEFT JOIN core_module AS m ON a.id_module = m.id
        WHERE a.`status` = 1 and m.`status` = 1';
        // echo $query;exit;
        $db->setQuery($query);   
        $rows = $db->loadAssocList();  
        for($i = 0; $i < count ( $rows ); $i ++) {
			$result[$rows [$i] ['module_name']] [] = $rows [$i];
		}

        $html = [];
        $html[] = '<table class="table table-bordered table-condensed table-striped">';
		$html[] = '	<thead>';
		$html[] = '		<tr>';
		$html[] = '			<th nowrap="nowrap" style="text-align:center">Nhóm chức năng</th>';
		$html[] = '			<th nowrap="nowrap" style="text-align:center">Cấp quản lý</th>';
		$html[] = '			<th width="100%" style="text-align:center">Tên chức năng</th>';
		$html[] = '		</tr>';
		$html[] = '	</thead>';
		$html[] = '	<tbody>';
        foreach ( $result as $key => $values ) {
            // var_dump($values);exit;
        $html[] = '<tr>';
        $html[] = '<td nowrap="nowrap" rowspan="3" style="vertical-align: inherit;">'. $key . '</td>';
        
            for ($j = 0; $j < count($arr_quanly); $j++) {
                # Tổ chức của người dùng
                if ($j == 0) {  
                    $html[] = '<td width="18%" style="vertical-align: inherit;"><input type="checkbox" id ="modname-'.$i.'"  onclick="Joomla.checkAll(this, \'modname-acname'.$j.'-'.$i.'\')"  name="jform[modname[]]"> '.$arr_quanly[$j].'</td><td>';
                }
                # $j = 1 Tổ chức cấp dưới
                elseif ($j == 1){ 
                    $html[] = '<tr><td style="vertical-align: inherit;"><input type="checkbox" id ="modname-'.$i.'"  onclick="Joomla.checkAll(this, \'modname-acname'.$j.'-'.$i.'\')"  name="jform[modname[]]"> '.$arr_quanly[$j].'</td><td>';
                }
                # $j = 2 Tất cả tổ chức người dùng
                else { 
                    $html[] = '<tr><td style="vertical-align: inherit;"><input type="checkbox" id ="modname-'.$i.'"  onclick="Joomla.checkAll(this, \'modname-acname'.$j.'-'.$i.'\')"  name="jform[modname[]]"> '.$arr_quanly[$j].'</td><td>';
                }
                foreach ( $values as $k => $v ) {
                    if (isset($data_gr_a[$v ['id_module']][$j][$v ['id_action']])) {
                        $html[] = '<div style="float:left;width:33%;"><input checked="checked" id="modname-acname'.$j.'-'.$i.'"  type="checkbox" value="' . $v ['id_action'] . '" name="jform[acname'.$j.'][]" > ' . $v ['action_name']. '</div>';
                    } else {
                        $html[] = '<div style="float:left;width:33%;"><input id="modname-acname'.$j.'-'.$i.'"  type="checkbox" value="' . $v ['id_action'] . '" name="jform[acname'.$j.'][]" > ' . $v ['action_name'] . '</div>';
                    }
                }
            }
        }
        $html[] = '</tr>';
        $html[] = '	</tbody>';
        $html[] = '<table>';
       
        return implode('', $html);
    }
}
