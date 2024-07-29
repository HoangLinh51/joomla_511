<?php

/**
* @file: ajax.php
* @author: nguyennpb@danang.gov.vn
* @date: 01-08-2012
* @company : http://dnict.vn
**/
namespace Joomla\Component\Core\Site\Controller;

use Core;
use CoresController;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Uri\Uri;

// defined('_JEXEC') or die;

class AjaxController extends BaseController{


	public function getTree() {

        $app = Factory::getApplication();
        $act = $app->getInput()->getCmd('act', null);
        $act = ($act == null) ? 'default' : strtoupper($act);
        $id_parent = Factory::getApplication()->input->getInt('id_parent');
        $data = array();
        switch ($act) {
            case 'SEARCHTOCHUC':
                $db = Factory::getDbo();
                $search_str = Factory::getApplication()->input->getString('search_str', '');
                $rows = array();
                $where = array();
                if ($search_str != '') {
                    $where[] = "a.name LIKE '%" . $db->q($search_str) . "%'";
                }
                $where[] = "a.active = 1";
                $result = array();
                $where = ( count($where) ? ' WHERE ' . implode(' AND ', $where) : '' );
                $query = 'SELECT a.id,a.parent_id AS parent,a.name AS text,a.type, (SELECT COUNT(id) FROM ins_dept WHERE parent_id = a.id) AS children  FROM ins_dept a' . $where . ' ORDER BY a.lft';
                //echo $query;exit;
                $db->setQuery($query);
                $rows = $db->loadAssocList();
                for ($i = 0; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    $children = (($row['children'] > 0 ) ? true : false);
                    $data[] = array(
                        "attr" => array("data-type" => $rows[$i]['type'], "id" => "node_" . $rows[$i]['id'], "rel" => (($rows[$i]['type'] == 1) ? 'root' : (($rows[$i]['type'] == 2) ? 'folder' : 'file'))),
                        "data" => $rows[$i]['text'],
                        "state" => ($children) ? "closed" : ""
                    );
                }
                break;
            case 'CAPTOCHUC':
                $db = Factory::getDbo();
                $parent = Factory::getApplication()->input->getInt('id', 0);
                $data = $this->_buildTree($parent, 'ins_cap');
                break;
            case 'THUHANG':
                $db = Factory::getDbo();
                $parent = Factory::getApplication()->input->getInt('id', 0);
                $data = $this->_buildTree($parent, 'ins_level');
                break;
            case 'CHUCVU':
                $db = Factory::getDbo();
                $parent = Factory::getApplication()->input->getInt('id', 0);
                $data = $this->_buildTree($parent, 'pos_system');
                break;
            case 'TOCHUC':
                $db = Factory::getDbo();
                $user_id = Factory::getUser()->id;
                $exceptionUnits = Core::getUnManageDonvi($user_id, 'com_hoso', 'treeview', 'treeview');
                $exception_condition = ($exceptionUnits) ? 'a.id NOT IN (' . $exceptionUnits . ')' : '';
                $parent = Factory::getApplication()->input->getInt('id', 0);
                $rows = array();
                $where = array();
                if ($parent == 0) {
                    $where[] = '(a.parent_id = ' . (int) $parent . ' OR a.parent_id IS NULL)';
                } else {
                    $where[] = 'a.parent_id = ' . (int) $parent;
                }
                if ($exception_condition != '') {
                    $where[] = $exception_condition;
                }
                if(Core::_checkPerActionArr($user_id, 'com_tochuc', 'tochuc', array('task'=>'au_tochuc_hienthitrangthai', 'location'=>'site','non_action'=>'false'))){
                    $active_tong = Factory::getApplication()->input->getInt('active');
                    if($active_tong>0){
                        $where[] = 'a.active = '.(int)$active_tong;
                    }
                }else{
                    $where[] = 'a.active = 1';
                }
                $result = array();
                $where = ( count($where) ? ' WHERE ' . implode(' AND ', $where) : '' );

                $query = 'SELECT a.id,a.parent_id AS parent,a.name AS text,a.type,a.active,
                                    (SELECT COUNT(id) FROM ins_dept WHERE parent_id = a.id) AS children
                                FROM ins_dept a' . $where . '
                                ORDER BY a.lft'; 
                $db->setQuery($query);
                $rows = $db->loadAssocList();
                for ($i = 0; $i < count($rows); $i++) {
                    $children_node = []; 
                    $row = $rows[$i];
                    $children = (($row['children'] > 0 ) ? true : false);
                    // if($children > 0){
                    //     //if($row['parent'] == $parent){
                    //         $query = 'SELECT a.id,a.parent_id AS parent,a.name AS text,a.type,a.active
                    //         FROM ins_dept a WHERE a.parent_id = ' .$rows[$i]['id']  . '
                    //         ORDER BY a.lft';
                    //         $db->setQuery($query);
                    //         $rows_child = $db->loadAssocList();
                            
                    //         for ($ii=0; $ii < count($rows_child); $ii++) { 
                    //             $child = array(
                    //                 'text' => $rows_child[$ii]['text'],
                    //                 'id' => $rows_child[$ii]['id']
                    //             );                              
                    //             array_push($children_node, $child);                               
                    //         } 
                    //     //}
                           

                    // }
                    if($row['active']!=1) $rel='remove';
                    else{
                        $rel = $rows[$i]['type'] == 1 ? 'folder' : (($rows[$i]['type'] == 2) ? 'root' : 'file');
                    }
                    //$result[] = array('id'=>$row['id'],'parent'=>((int)$row['parent']==0)?'#':$row['parent'],'text'=>$row['text'],'children'=>$children,'icon'=>(($children == true)?'icon-folder-open blue':'icon-file-text green'));
                    $data[] = array(
                        "li_attr" => array(
                            "data-type" => $rows[$i]['type'], 
                            "id" => "node_" . $rows[$i]['id'], 
                            "type" => $rel
                        ),
                        'id' => $rows[$i]['id'],
                        "text" => $rows[$i]['text'],
                        "state" => ($children) ? "closed" : "",
                        "type" => $rel,
                        "children" => $children
                    );
                    // $data[] = array(
                    //     "attr" => array(
                    //         "data-type" => $rows[$i]['type'], 
                    //         "id" => "node_" . $rows[$i]['id'], 
                    //         "rel" => $rel
                    //     ),
                    //     "data" => $rows[$i]['text'],
                    //     "state" => ($children) ? "closed" : ""
                    // );
                }
                break;
            case 'VOBOC':
                $db = Factory::getDbo();
                $parent = Factory::getApplication()->input->getInt('id', 0);
                $rows = array();
                $where = array();
                if ($parent == 0) {
                    $where[] = '(a.parent_id = ' . (int) $parent . ' OR a.parent_id IS NULL)';
                } else {
                    $where[] = 'a.parent_id = ' . (int) $parent;
                }
                $where[] = 'a.type = 2';
                $result = array();
                $where = ( count($where) ? ' WHERE ' . implode(' AND ', $where) : '' );
                $query = 'SELECT a.id,a.parent_id AS parent,a.name AS text,a.type, (SELECT COUNT(id) FROM ins_dept WHERE parent_id = a.id) AS children  FROM ins_dept a' . $where . ' ORDER BY a.lft';
                //echo $query;exit;
                $db->setQuery($query);
                $rows = $db->loadAssocList();
                for ($i = 0; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    $children = (($row['children'] > 0 ) ? true : false);
                    //$result[] = array('id'=>$row['id'],'parent'=>((int)$row['parent']==0)?'#':$row['parent'],'text'=>$row['text'],'children'=>$children,'icon'=>(($children == true)?'icon-folder-open blue':'icon-file-text green'));
                    $data[] = array(
                        "attr" => array("data-type" => $rows[$i]['type'], "id" => "node_" . $rows[$i]['id'], "rel" => (($rows[$i]['type'] == 1) ? 'root' : (($rows[$i]['type'] == 2) ? 'folder' : 'file'))),
                        "text" => $rows[$i]['text'],
                        "state" => ($children) ? "closed" : ""
                    );
                }
                break;
            case 'LINHVUCTOCHUC':
                $db = Factory::getDbo();
                $parent = Factory::getApplication()->input->getInt('id', 0);
                $rows = array();
                $where = array();
                $where[] = 'a.type = 2';

                if ($parent == 0) {
                    $where[] = '(a.parent_id = ' . (int) $parent . ' OR a.parent_id IS NULL)';
                } else {
                    $where[] = 'a.parent_id = ' . (int) $parent;
                }

                $result = array();
                $where = ( count($where) ? ' WHERE ' . implode(' AND ', $where) : '' );
                $query = 'SELECT a.id,a.parent_id AS parent,a.tenlinhvuc AS text, (SELECT COUNT(id) FROM cb_type_linhvuc WHERE parent_id = a.id) AS children  FROM cb_type_linhvuc a' . $where;
                //echo $query;exit;
                $db->setQuery($query);
                $rows = $db->loadAssocList();
                for ($i = 0; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    $children = (($row['children'] > 0 ) ? true : false);
                    $data[] = array(
                        "attr" => array("id" => "node_" . $rows[$i]['id'], "rel" => (($children) ? 'folder' : 'file')),
                        "data" => $rows[$i]['text'],
                        "state" => ($children) ? "closed" : ""
                    );
                }
                break;
            case 'LOAIHINHDONVI':
                $db = Factory::getDbo();
                $parent = Factory::getApplication()->input->getInt('id', 0);
                $data = $this->_buildTree($parent, 'ins_dept_loaihinh');
                break;
            case 'COREMENU':
                $parent = Factory::getApplication()->input->getInt('id', 0);
                $data = $this->_buildTree($parent, 'core_menu');
                break;
            case 'LINHVUC':
                $parent = Factory::getApplication()->input->getInt('id', 0);
                $data = $this->_buildTree($parent, 'cb_type_linhvuc');
                break;
            case 'GOICHUCVU':
                $db = Factory::getDbo();
                $parent = Factory::getApplication()->input->getInt('id', 0);
                $rows = array();
                $where = array();
                //$where[] = 'a.status = 1';
                //$where[] = 'a.type = 2';

                if ($parent == 0) {
                    $where[] = '(a.parent_id = ' . (int) $parent . ' OR a.parent_id IS NULL)';
                } else {
                    $where[] = 'a.parent_id = ' . (int) $parent;
                }

                $result = array();
                $where = ( count($where) ? ' WHERE ' . implode(' AND ', $where) : '' );
                $query = 'SELECT a.id,a.parent_id AS parent,a.name AS text, (SELECT COUNT(id) FROM cb_goichucvu WHERE parent_id = a.id) AS children  FROM cb_goichucvu a' . $where;
                $db->setQuery($query);
                $rows = $db->loadAssocList();
                for ($i = 0; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    $children = (($row['children'] > 0 ) ? true : false);
                    $data[] = array(
                        "attr" => array("id" => "node_" . $rows[$i]['id'], "rel" => (($rows[$i]['children'] != 1) ? 'folder' : 'file')),
                        "data" => $rows[$i]['text'],
                        "state" => ($children) ? "closed" : ""
                    );
                }
                break;
            case 'GOILUONG':
                $db = Factory::getDbo();
                $parent = Factory::getApplication()->input->getInt('id', 0);
                $rows = array();
                $where = array();
                //$where[] = 'a.status = 1';
                //$where[] = 'a.type = 2';

                if ($parent == 0) {
                    $where[] = '(a.parent_id = ' . (int) $parent . ' OR a.parent_id IS NULL)';
                } else {
                    $where[] = 'a.parent_id = ' . (int) $parent;
                }

                $result = array();
                $where = ( count($where) ? ' WHERE ' . implode(' AND ', $where) : '' );
                $query = 'SELECT a.id,a.parent_id AS parent,a.name AS text, (SELECT COUNT(id) FROM cb_goiluong WHERE parent_id = a.id) AS children  FROM cb_goiluong a' . $where;
                $db->setQuery($query);
                $rows = $db->loadAssocList();
                for ($i = 0; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    $children = (($row['children'] > 0 ) ? true : false);
                    $data[] = array(
                        "attr" => array("id" => "node_" . $rows[$i]['id'], "rel" => (($children) ? 'folder' : 'file')),
                        "data" => $rows[$i]['text'],
                        "state" => ($children) ? "closed" : ""
                    );
                }
                break;
            // Thịnh bổ sung
            case 'GOIVITRIVIECLAM':
                $db = Factory::getDbo();
                $parent = Factory::getApplication()->input->getInt('id', 0);
                $rows = array();
                $where = array();
                //$where[] = 'a.status = 1';
                //$where[] = 'a.type = 2';

                if ($parent == 0) {
                    $where[] = '(a.parent_id = ' . (int) $parent . ' OR a.parent_id IS NULL)';
                } else {
                    $where[] = 'a.parent_id = ' . (int) $parent;
                }

                $result = array();
                $where = ( count($where) ? ' WHERE ' . implode(' AND ', $where) : '' );
                $query = 'SELECT a.id,a.parent_id AS parent,a.name AS text, (SELECT COUNT(id) FROM cb_goivitrivieclam WHERE parent_id = a.id) AS children  FROM cb_goivitrivieclam a' . $where;
                $db->setQuery($query);
                $rows = $db->loadAssocList();
                for ($i = 0; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    $children = (($row['children'] > 0 ) ? true : false);
                    $data[] = array(
                        "attr" => array("id" => "node_" . $rows[$i]['id'], "rel" => (($children) ? 'folder' : 'file')),
                        "data" => $rows[$i]['text'],
                        "state" => ($children) ? "closed" : ""
                    );
                }
                break;

            case 'CAYBAOCAO': // Dùng trong câu hình cây báo cáo
                $parent = Factory::getApplication()->input->getInt('id', 0);
                $data = $this->_buildTree($parent, 'config_donvi_bc');
                break;
            case 'HIENTHIBAOCAO': // Dùng để hiển thị cây đơn vị trên báo cáo
                $parent = Factory::getApplication()->input->getInt('id', 0);
                $db = Factory::getDbo();
                $rows = array();
                $where = array();
                $data = array();
                $arrTypes = array('file', 'folder', 'root');
                $table = 'config_donvi_bc';
                //$where[] = 'a.status = 1';
                //$where[] = 'a.type = 2';

                if ($parent == 0) {
                    $where[] = '(a.parent_id = ' . (int) $parent . ' OR a.parent_id IS NULL)';
                } else {
                    $where[] = 'a.parent_id = ' . (int) $parent;
                }

                $result = array();
                $where = ( count($where) ? ' WHERE ' . implode(' AND ', $where) : '' );
                $order = ' ORDER BY a.lft';
                $query = 'SELECT a.id,a.parent_id AS parent,a.name,a.level, b.type, a.ins_dept, (SELECT COUNT(id) FROM ' . $db->quoteName($table) . ' WHERE parent_id = a.id) AS children
									FROM ' . $db->quoteName($table, 'a') .
                        ' INNER JOIN ins_dept as b on a.ins_dept = b.id ' . $where . $order;
                $db->setQuery($query);
                $rows = $db->loadAssocList();
                for ($i = 0; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    $children = (($row['children'] > 0 ) ? true : false);
                    $data[] = array(
                        "attr" => array(
                            "id" => "node_" . $row['id'],
                            "rel" => $arrTypes[(int) $row['type']],
                            // 							"loaihinh" => $dt->ins_loaihinh,
                            "ins_dept" => $row['ins_dept'],
                            "name" => $row['name'],
                            "type" => $row['type'],
                            "exp_level" => $row['level']    // Mới thêm để test level
                        ),
                        "data" => $row['name'], //.' '.$dt->id,
                        "state" => "closed"
                    );
                }

                break;
            case 'CHUCVUCHUAN':
                $db = Factory::getDbo();
                $parent = Factory::getApplication()->input->getInt('id', 0);
                $rows = array();
                $where = array();
                //$where[] = 'a.status = 1';
                //$where[] = 'a.type = 2';

                if ($parent == 0) {
                    $where[] = '(a.parent_id = ' . (int) $parent . ' OR a.parent_id IS NULL)';
                } else {
                    $where[] = 'a.parent_id = ' . (int) $parent;
                }

                $result = array();
                $where = ( count($where) ? ' WHERE ' . implode(' AND ', $where) : '' );
                // 						$query = 'SELECT a.id,a.parent_id AS parent,a.name AS text, (SELECT COUNT(id) FROM cb_goichucvu WHERE parent_id = a.id) AS children  FROM cb_goichucvu a'.$where;
                $query = 'SELECT a.id,a.parent_id AS parent,a.name AS text, a.chucvu, (SELECT COUNT(id) FROM pos_system WHERE parent_id = a.id) AS children  FROM pos_system a' . $where;

                $db->setQuery($query);
                $rows = $db->loadAssocList();
                for ($i = 0; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    $children = (($row['children'] > 0 ) ? true : false);
                    $data[] = array(
                        "attr" => array("id" => "node_" . $rows[$i]['id'], "rel" => (((int) $rows[$i]['chucvu'] != 1) ? 'folder' : 'file')),
                        "data" => $rows[$i]['text'],
                        "state" => ($children) ? "closed" : ""
                    );
                }
                break;
            // End Thịnh
            default:
                break;
        }
        Core::printJson($data);
    }
}