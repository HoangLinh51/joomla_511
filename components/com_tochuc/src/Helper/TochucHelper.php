<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   (C) 2017 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Tochuc\Site\Helper;

use Joomla\CMS\Categories\CategoryNode;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Log\Log;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Contact Component Route Helper
 *
 * @static
 * @package     Joomla.Site
 * @subpackage  com_contact
 * @since       1.5
 */
abstract class TochucHelper
{
    static public function getRootGoiLuong(){
		return 2;
	}
	static public function getRootGoichucvu(){
		return 0;
	}	
	static public function getRootLoaihinh(){
		return 3;
	}
	static public function getRootCapTochuc(){
		return 5;
	}

	static public function getRootLinhvucTochuc(){
		return 2;
	}
	
	static public function getRootLinhvucPhong(){
		return 3;
	}
	static public function getRoot(){
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('id','name'))->from('ins_dept')->order('lft');	
		$db->setQuery($query,0,1);
		return $db->loadAssoc();
	}
	static public function getOneNodeJsTree($dept_id){
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('id','name','type'))->from('ins_dept')->where('id = '.$db->quote($dept_id));
		$db->setQuery($query);
		$row = $db->loadAssoc(); 
		//$data = array();
		// $data = array(
		// 		"attr" => array("data-type"=>$row['type'],"id" => "node_".$row['id'],"type" => (($row['type'] == 1)?'folder':(($row['type'] == 2)?'root':'file'))),
		// 		"data" => $row['name'],
		// 		"id" => $row['id'],
		// 		"type" => ($row['type'] == 1) ? 'folder':(($row['type'] == 2)?'root':'file'),
		// 		"state" => "closed"
		// );
		$data = array(
			"li_attr" => array("data-type"=>$row['type'],"id" => $row['id'],"type" => (($row['type'] == 1)?'folder':(($row['type'] == 2)?'root':'file'))),
			"text" => $row['name'],
			"id" => $row['id'],
			"type" => ($row['type'] == 1) ? 'folder':(($row['type'] == 2)?'root':'file'),
			"state" => "closed"
		);
		return json_encode($data);
	} 

	static public function getAllVoboc(){
		$db = Factory::getDbo();
		$query = "SELECT a.id,a.name,a.parent_id,IF(((SELECT COUNT(id) FROM ins_dept WHERE type = 2 AND parent_id = a.id) > 0 ),'folder','item') AS type
	FROM ins_dept a
	WHERE a.type = 2 ORDER BY a.lft";
		$db->setQuery($query);
		return $db->loadAssocList();
	}

	static public function getQuatrinhBiencheChiTietByQuatrinhId($quatrinh_id){
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('a.hinhthuc_id','a.bienche','b.name as name'))->from($db->quoteName('ins_dept_quatrinh_bienche_chitiet','a'))
				->join('INNER', 'bc_hinhthuc b ON a.hinhthuc_id = b.ID')
					->where('a.quatrinh_id = '.$db->q($quatrinh_id));
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	static public function collect($table,$colums,$where = null,$order = null,$isCache = true){	
		$db = Factory::getDbo();
		$query = $db->getQuery(true)
					->select($colums)
					->from($table);
		if ($order != null && is_string($order)) {
			$query->order($order);
		}
		if ($where != null && is_array($where)) {
			$query->where($where);
		}
		//echo  $query->__toString();
		$db->setQuery($query);
		return $db->loadAssocList();				
	}


	static public function createChk($name,$inArray,$value = null){
	
		$string = str_replace(' ', '-', $name); // Replaces all spaces with hyphens.
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.	
		$id = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
		$result = '';
		for ($i = 0; $i < count($inArray); $i++) {
			$space = '';
			$checked = '';
			if (is_array($value) && in_array($inArray[$i]['value'], $value) ) {
				$checked = 'checked = "checked"';
			}elseif ($inArray[$i]['value'] == $value){
				$checked = 'checked = "checked"';
			}
			if ((int)$inArray[$i]['level'] > 0 ) {
				$space = 'style="padding-left:'.($inArray[$i]['level']*10).'px"';
			}
			$result .='<div class="icheck-primary d-inline"><label><input '.$checked.' id="'.$id.'_'.$inArray[$i]['value'].'" name="'.$name.'" type="checkbox" value="'.$inArray[$i]['value'].'"><span class="" '.$space.'> '.$inArray[$i]['text'].'</span></label></div>';
		}
		return $result;
	}
	/**
	 * 
	 * @param string $dateVN
	 */
	static public function strDateVntoMySql($dateVN){
		if (empty($dateVN)) {
			return '';
		}
		$dateVN = explode('/', $dateVN);
		return $dateVN[2].'-'.$dateVN[1].'-'.$dateVN[0];
	}
	/**
	 *
	 * @param string $dateMysql
	 */
	static public function strDateMySqltoVN($dateMysql){
		if (empty($dateMysql) || $dateMysql == '0000-00-00') {
			return '';
		}
		$dateMysql = explode('-', $dateMysql);
		return $dateMysql[2].'/'.$dateMysql[1].'/'.$dateMysql[0];
	}
	static public function getVanBanById($id){
		$db = Factory::getDbo();
		$rows = array();
		$query = $db->getQuery(true);
		$query->select('*')
				->from($db->quoteName('ins_vanban'))				
				->where($db->quoteName('id').' = '.$db->q($id));
		$db->setQuery($query);
		return $db->loadAssoc();
	}
	static public function getLinhvucById($id){
		$db = Factory::getDbo();
			$query = 'SELECT n.id,n.name
					    FROM cb_type_linhvuc n,
					         cb_type_linhvuc p
					   WHERE n.lft BETWEEN p.lft AND p.rgt AND p.id = '.(int)$id.'
					GROUP BY n.id
					ORDER BY n.lft;';
			$db->setQuery($query);
		return  $db->loadAssocList();
		
	}
	static  public function getNameLoaihinh($id){
		$str = '';
		if ($id == 1) {
			$str = 'Hành chính';
		}elseif ($id == 2){
			$str = 'Sự nghiệp';
		}
		return $str;		
	}
	static  public function getCapDonviBreadcrumb($id){
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('lft','rgt')))
				->from($db->quoteName('ins_cap'))
				->where($db->quoteName('id').' = '.$db->q($id));
		$db->setQuery($query);
		$node = $db->loadAssoc();
		$rows = array();
		if ($node != null) {
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('name')))
			->from($db->quoteName('ins_cap'))
			->where($db->quoteName('lft').' <= '.$db->q($node['lft']))
			->where($db->quoteName('rgt').' >= '.$db->q($node['rgt']))
			->where('lft > 0 ')
			->order('lft ASC');
			$db->setQuery($query);
			$rows = $db->loadColumn();
			return implode(' <i class="icon-double-angle-right"></i> ', $rows);
		}else{
			return '<span class="text-error">Chưa phân cấp</span>';
		}
		
		//echo $query->__toString();
		
	}
	static public function getNameById($id,$table,$columns = 'name',$key='id'){
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName($columns))->from($db->quoteName($table))
		->where($db->quoteName($key).' = '.$db->q($id));
	
			
		$db->setQuery($query);
		//echo $query->__toString();
		return $db->loadResult();
	}
	static public function getInsLoaihinhByInsCap($INS_CAP){
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('lft','rgt'))
				->from('ins_cap')
				->where('id = '.$db->q($INS_CAP));
		
		$db->setQuery($query);
		$ins_cap = $db->loadAssoc();
		$query = $db->getQuery(true);
		$query->select(array('id'))
			->from('ins_cap')
			->where('lft <= '.$db->q($ins_cap['lft']))
			->where('rgt >= '.$db->q($ins_cap['rgt']))		
			->where('level = 1')			
		;
		$db->setQuery($query);
		// 1 hanh chinh, 2 su nghiep, khi khong dung thi kiem tra lai database
		return $db->loadResult();				
	}
	static function checkFiles($file)
	{
		jimport('joomla.filesystem.file');
		//var_dump($file['name']);
		//var_dump(JFile::makeSafe($file['name']));exit;
		$params = &ComponentHelper::getParams('com_tochuc');
		$type = $params->get('typefile','txt,doc,jpg,jpeg,png,gif,xls,ppt');
		$arrtype=explode(",", $type);
		$file['name'] = File::makeSafe($file['name']);
		if (!$file['name']) {
			//header('HTTP/1.0 415 Unsupported Media Type');
			//die('Error. Unsupported Media Type!');
			$msg =  'Error. Unsupported Media Type!';
			//die($msg);
			Factory::getApplication()->enqueueMessage($msg, 'error');
			return false;
		}
		$allowedExtensions = $arrtype;
		$convert_file = TochucHelper::strtolower_utf8($file['name']);
		if (!in_array(end(explode(".",
				$convert_file)),
				$allowedExtensions)) {		
			/** Alternatively you may use chaining */
			Factory::getApplication()->enqueueMessage('Tập tin không đúng định dạng:'. $file['name'], 'error');
			Log::add('Tập tin không đúng định dạng:'.$file['name'], Log::WARNING, 'com_helloworld');
			return false;
		}
		return true;
	}
	static public function strtolower_utf8($string){
		$convert_to = array(
				"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u",
				"v", "w", "x", "y", "z", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
				"a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "d", "d", "e", "e", "e", "e", "e", "e", "e", "e",
				"e", "e","e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "i", "i",
				"i", "i", "i", "o", "o", "o", "o", "o","o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o","o","o",
				"o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
				"u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u","u", "y", "y", "y", "y", "y", "y", "y", "y"," "
		);
		$convert_from = array(
				"A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U",
				"V", "W", "X", "Y", "Z", "À","à", "Ả","ả", "Ã","ã", "Á","á", "Ạ","ạ", "Ă","ă", "Ằ","ằ", "Ắ","ắ", "Ặ","ặ",
				"Â","â", "Ấ","ấ", "Ầ","ầ", "Ẩ","ẩ", "Ẫ","ẫ", "Ậ","ậ", "Đ","đ", "È","è", "Ẻ","ẻ", "Ẽ","ẽ", "É","é", "Ẹ","ẹ",
				"Ê","ê", "Ề","ề", "Ể","ể", "Ễ","ễ", "Ế","ế", "Ệ","ệ", "Ì","ì", "Í","í", "Ỉ","ỉ", "Ĩ","ĩ", "Ị","ị", "Ò","ò",
				"Ỏ","ỏ", "Õ","õ", "Ó","ó", "Ọ","ọ",	"Ô","ô", "Ồ","ồ", "Ổ","ổ", "Ỗ","ỗ", "Ộ","ộ", "Ơ","ơ", "Ờ","ờ", "Ớ","ớ",
				"Ở","ở", "Ỡ","ỡ", "Ợ","ợ", "Ù","ù", "Ủ","ủ", "Ũ","ũ", "Ú","ú", "Ụ","ụ", "Ư","ư", "Ừ","ừ", "Ử","ử", "Ữ","ữ",
				"Ứ","ứ", "Ự","ự", "Ỳ","ỳ", "Ỷ","ỷ", "Ỹ","ỹ", "Ý","ý","_"
		);
		$string_cv = str_replace($convert_from, $convert_to, $string);
		return str_replace(" ", "_", $string_cv);
	}
	static public function treeGoiChucvu($parentid = 0,$level = 0, &$result){
		
	}
	static public function treeLinhvucTochuc($parentid = 0,$level = 0, &$result) {
		$db = Factory::getDbo();		
		if(!$result) $result = array();//khoi tao 1 array co ten la arr
		//var_dump($colums['parentid']);exit;		
		//var_dump($colums['parentid'].' = '.$parentid);exit;
		$query = $db->getQuery(true)
				->select(array('id','tenlinhvuc AS name','parent_id','level AS lv'))
				->from('cb_type_linhvuc');
		if ($parentid == 0) {
			$query->where('parent_id IS NULL');
		}else{
			$query->where('parent_id = '.$parentid);
		}
		$query->where('type = 2');
		//var_dump($query->__toString());
		$db->setQuery($query);
		$rows = $db->loadAssocList();
		//
		for ($i = 0; $i < count($rows); $i++) {
			$row = $rows[$i];			
			$result[] = array('id'=>$row['id'],'name'=>$row['name'],'parent'=>$row['parent_id'],'lv'=>$row['lv'],'level'=>$level);
			$result = TochucHelper::treeLinhvucTochuc($row['id'],($level+1),$result);
		}		
		return $result;
	}
	static public function treeLinhvucPhong($parentid = 0,$level = 0, &$result) {
		$db = Factory::getDbo();
		if(!$result) $result = array();//khoi tao 1 array co ten la arr
		//var_dump($colums['parentid']);exit;
		//var_dump($colums['parentid'].' = '.$parentid);exit;
		$query = $db->getQuery(true)
		->select(array('id','tenlinhvuc AS name','parent_id'))
		->from('cb_type_linhvuc');
		if ($parentid == 0) {
			$query->where('parent_id IS NULL');
		}else{
			$query->where('parent_id = '.$parentid);
		}
		$query->where('type = 1');
		//var_dump($query->__toString());
		$db->setQuery($query);
		$rows = $db->loadAssocList();
		//
		for ($i = 0; $i < count($rows); $i++) {
			$row = $rows[$i];
			$result[] = array('id'=>$row['id'],'name'=>$row['name'],'parent'=>$row['parent_id'],'level'=>$level);
			$result = TochucHelper::treeLinhvucTochuc($row['id'],($level+1),$result);
		}
		return $result;
	}
	static public function recursive($table,$colums = array('id'=>'id','parent'=>'parentid','text'=>'name'),$where,$parentid = 0,$level = 0, &$result) {
		$db = Factory::getDbo();
		if(!$result) $result = array();//khoi tao 1 array co ten la arr
		//var_dump($colums['parentid']);exit;
		$cols = array_values($colums);
		//var_dump($colums['parentid'].' = '.$parentid);exit;
		$query = $db->getQuery(true)
		->select($cols)
		->from($table);
		if ('NULL' == strtoupper($parentid)) {
			$query->where($colums['parent'].' IS NULL ');
		}else{
			$query->where($colums['parent'].' = '.$parentid);
		}
		if ($where != null && is_array($where)) {
			$query->where($where);
		}
		$db->setQuery($query);
		$rows = $db->loadAssocList();
		for ($i = 0; $i < count($rows); $i++) {
			$row = $rows[$i];
			$result[] = array('id'=>$row['id'],'text'=>$row[$colums['text']],'parent'=>(($row[$colums['parent']]== null)?'#':$row[$colums['parent']]),'level'=>$level);
			$result = TochucHelper::recursive($table,$colums,$where,$row[$colums['id']],($level+1),$result);
		}
	
		return $result;
	}
	static function getDataForSelectGoichucvu(){
		$result = array();
		TochucHelper::recursive('cb_captochuc',  array('id'=>'id','parent'=>'parentid','text'=>'name'),array('status = 1'),0,0, $result);
		$list = array();
		for ($i = 0; $i < count($result); $i++) {
			$list[] = array('value'=>$result[$i]['id'],'text'=>str_repeat('--',  $result[$i]['level']).$result[$i]['text']);
		}
		$option = array("value"=>'',"text"=>'');
		array_unshift($list, $option);
		unset($result);
		return $list;
		
	}
	static function makeParentChildRelationsForTree(&$inArray, &$outArray, $currentParentId = 0) {		
    
		if(!is_array($inArray)) {
        return;
    }

    if(!is_array($outArray)) {
        return;
    }
        foreach($inArray as $key => $tuple) {	        	        	        
	        if($tuple['parent'] == $currentParentId) {
	            $tuple['children'] = array();
	            TochucHelper::makeParentChildRelationsForTree($inArray, $tuple['children'], $tuple['id']);
	            $outArray[] = $tuple;
	        }
	    }
	}
	static function makeDataForTree(&$inArray, &$outArray, $currentParentId = 0) {
	
		if(!is_array($inArray)) {
			return;
		}
	
		if(!is_array($outArray)) {
			return;
		}
		foreach($inArray as $key => $tuple) {
			if($tuple['parent_id'] == $currentParentId) {
				$tuple['additionalParameters']['children'][] = array();
				TochucHelper::makeDataForTree($inArray, $tuple['additionalParameters']['children'], $tuple['id']);
				$outArray[] = $tuple;
				//unset($inArray[$key]);
			}
		}
	}
	static public function collectGetName($table,$colums,$where = null,$order = null){
		$db = Factory::getDbo();
		$query = $db->getQuery(true)
		->select($colums)
		->from($table);
		if ($order != null && is_string($order)) {
			$query->order($order);
		}
		if ($where != null) {
			$query->where($where);
		}
		 
		$db->setQuery($query);
		return $db->loadResult();
	}

	static public function selectBoxNotOptionNull($value,$attrs,$table,$colums,$where = null,$order = null){
		//var_dump($colums[0]);
		if (count($colums) >= 2) {
			
			if (isset($table) && is_array($table)) {
				$rows = $table;
			}else{
				$rows = TochucHelper::collect($table, $colums, $where);
			}	        
	        //var_dump($rows);exit;	
	        if (is_array($attrs)) {
	        	$controlName = $attrs['name'];
	        	if ($controlName) {
	        		$controlAttrs = " ng-model=\"".$controlName."\"";
	        	}
	        	unset($attrs['name']);
	        	unset($attrs['value']);
	        	foreach ($attrs as $key=>$val){
	        		if (is_array($val)) {
	        			$controlAttrs .=" ".$key.'="'.implode(" ", $val).'"';
	        		}else{
	        			$controlAttrs .=" ".$key.'="'.$val.'"';
	        		}        		
	        	}
	        }else{
	        	$controlAttrs = $attrs;
	        }
	        if (isset($attrs['hasEmpty']) && $attrs['hasEmpty'] == true) {
	        	$option = array("$colums[0]"=>'',"$colums[1]"=>'');
	        	array_unshift($rows, $option);
	        }
	        	      
	        return HTMLHelper::_('select.genericlist',$rows,$controlName, $controlAttrs, $colums[0],$colums[1],$value);
	      //  return JHTML::_('select.genericlist',$options,$controlName, $controlAttrs, 'value','text',$value);
		}
		return '';
	}

	static public function selectBox($value,$attrs,$table,$colums,$where = null,$order = null,$optAdd = null){
		if (count($colums) >= 2) {		
	        $rows = TochucHelper::collect($table, $colums, $where);
	        if (is_array($attrs)) {
				$controlAttrs = '';
	        	$controlName = $attrs['name'];
	        	unset($attrs['name']);
	        	unset($attrs['value']);
	        	foreach ($attrs as $key=>$val){
	        		if (is_array($val)) {
	        			$controlAttrs .=" ".$key.'="'.implode(" ", $val).'"';
	        		}else{
	        			$controlAttrs .=" ".$key.'="'.$val.'"';
	        		}        		
	        	}
	        }else{
	        	$controlAttrs = $attrs;
	        }
	        if (isset($attrs['hasEmpty']) && $attrs['hasEmpty'] == true) {
	        	$option = array("$colums[0]"=>'',"$colums[1]"=>'');
	        	array_unshift($rows, $option);
	        }
			$optNull[] = HTMLHelper::_('select.option','','',$colums[0],$colums[1]);
	        if(is_array($optAdd)){
	        	foreach($optAdd as $key=>$val){
	        		$optNull[] = HTMLHelper::_('select.option',$key,$val,$colums[0],$colums[1]);
	        	}	
	        }
	        return HTMLHelper::_('select.genericlist',array_merge($optNull,$rows),$controlName, $controlAttrs, $colums[0],$colums[1],$value);
		}
		return '';
	}
	static public function buildTreeHtmlDeQui($parent_id,$table,$colums,$where = null,$order=null){
		$rows = array();	
		TochucHelper::recursive($table,$colums, $where,$parent_id,1, $rows);
		$current_depth = 1;
		$counter = 0;
		$result = '<ul>';
		foreach ( $rows as $node ) {
			$node_depth = $node ['level'];
			$node_name = $node ['text'];
			$node_id = $node ['id'];
				
			if ($node_depth == $current_depth) {
				if ($counter > 0)
					$result .= '</li>';
			} elseif ($node_depth > $current_depth) {
				$result .= '<ul>';
				$current_depth = $current_depth + ($node_depth - $current_depth);
			} elseif ($node_depth < $current_depth) {
				$result .= str_repeat ( '</li></ul>', $current_depth - $node_depth ) . '</li>';
				$current_depth = $current_depth - ($current_depth - $node_depth);
			}
			$result .= '<li id="c' . $node_id . '"';
			$result .= $node_depth < 2 ? ' class="open"' : '';
			$result .= '><a href="#"><ins>&nbsp;</ins>' . $node_name . '</a>';
			++ $counter;
		}
		$result .= str_repeat ( '</li></ul>', $node_depth ) . '</li>';
		$result .= '</ul>';
		return $result;
	
	}
	static public function treeDonviHtml(){
		$db = Factory::getDbo();
		$colums = array('id','name','level');
		$query = $db->getQuery(true)
		->select($db->quoteName($colums))
		->from('ins_dept')
		->order('lft');		
		//$query->where('parent_id > 0');
		$db->setQuery($query);
		//var_dump($query->__toString());exit;
		$rows = $db->loadAssocList();
		$current_depth = 1;
		$counter = 0;
		$result = '<ul>';
		foreach ( $rows as $node ) {
			$node_depth = $node ['level'];
			$node_name = $node ['name'];
			$node_id = $node ['id'];
				
			if ($node_depth == $current_depth) {
				if ($counter > 0)
					$result .= '</li>';
			} elseif ($node_depth > $current_depth) {
				$result .= '<ul>';
				$current_depth = $current_depth + ($node_depth - $current_depth);
			} elseif ($node_depth < $current_depth) {
				$result .= str_repeat ( '</li></ul>', $current_depth - $node_depth ) . '</li>';
				$current_depth = $current_depth - ($current_depth - $node_depth);
			}
			$result .= '<li id="c' . $node_id . '"';
			$result .= $node_depth < 2 ? ' class="open"' : '';
			$result .= '><a href="#"><ins>&nbsp;</ins>' . $node_name . '</a>';
			++ $counter;
		}
		$result .= str_repeat ( '</li></ul>', $node_depth ) . '</li>';
		$result .= '</ul>';
		return $result;
	
	}
	
	static public function buildTreeHtml($values,$table,$colums,$where = null,$order=null,$current_depth = 1){
		$db = Factory::getDbo();		
		$query = $db->getQuery(true)
				->select($db->quoteName($colums))
				->from($table);
		if ($order != null && is_string($order)) {
			$query->order($order);
		}else{
			$query->order('lft');
		}
		if ($where != null) {
			$query->where($where);
		}
		$query->where('parent_id > 0');
		$db->setQuery($query);
		// var_dump($query->__toString());exit;
		$rows = $db->loadAssocList();		
		//$current_depth = 1;
		$counter = 0;
		$result = '<ul>';
		foreach ( $rows as $node ) {
			$node_depth = $node ['level'];
			$node_name = $node ['name'];
			$node_id = $node ['id'];
			
			if ($node_depth == $current_depth) {
				if ($counter > 0)
					$result .= '</li>';
			} elseif ($node_depth > $current_depth) {
				$result .= '<ul>';
				$current_depth = $current_depth + ($node_depth - $current_depth);
			} elseif ($node_depth < $current_depth) {
				$result .= str_repeat ( '</li></ul>', $current_depth - $node_depth ) . '</li>';
				$current_depth = $current_depth - ($current_depth - $node_depth);
			}
			$result .= '<li id="c' . $node_id . '"';
			$result .= $node_depth < 2 ? ' class="open"' : '';
			$result .= '><a href="#"><ins>&nbsp;</ins>' . $node_name . '</a>';
			++ $counter;
		}
		$result .= str_repeat ( '</li></ul>', $node_depth ) . '</li>';
		$result .= '</ul>';
		return $result;
		
	}
	static public function selectBoxComparing($value,$attrs){
		//var_dump($colums[0]);
		if (!isset($attrs['preitem']) && is_array($attrs['preitem'])) {
			foreach ($attrs['preitem'] as $key => $value) {
				$options[] = HTMLHelper::_('select.option',$key,$value);
			}
		}
		$options[] = HTMLHelper::_('select.option','EQ','=');
		$options[] = HTMLHelper::_('select.option','GE','>=');
		$options[] = HTMLHelper::_('select.option','GT','>');
		$options[] = HTMLHelper::_('select.option','LE','<=');
		$options[] = HTMLHelper::_('select.option','LT','<');
		if (is_array($attrs)) {
			$controlName = $attrs['name'];
            $controlAttrs = '';
			unset($attrs['name']);
			unset($attrs['value']);
			foreach ($attrs as $key=>$val){
				if (is_array($val)) {
					$controlAttrs .=" ".$key.'="'.implode(" ", $val).'"';
				}else{
					$controlAttrs .=" ".$key.'="'.$val.'"';
					if ('ng-model' == $key) {
						$controlAttrs .=' ng-init="'.$val.'=\''.$value.'\'"';
						//$controlAttrs .=' ng-value="'.$value.'"';
					}
				}
			}
		}else{
			$controlAttrs = $attrs;
		}
		//$value = 'EQ';
		return HTMLHelper::_('select.genericlist',$options,$controlName, $controlAttrs,'value','text',$value);
	}
	static public function notifyTochuc($key=null){
		$db = Factory::getDbo();
		$key = ($key==null)?'default':$key;
		$result = null;
		switch (strtoupper($key)) {
			case 'CHUABIENCHE':
				$query = 'SELECT COUNT(a.id) AS total FROM ins_dept a WHERE (a.type = 1) AND (a.active = 1) AND (id NOT IN (SELECT dept_id FROM ins_dept_quatrinh_bienche))';
				$db->setQuery($query);
				$result = $db->loadResult();
			break;
			case 'CHUACOQUATRINH':
				$query = 'SELECT COUNT(a.id) AS total FROM ins_dept a WHERE (a.type = 1) AND (a.active = 1) AND (id NOT IN (SELECT dept_id FROM ins_dept_quatrinh))';
				$db->setQuery($query);
				$result = $db->loadResult();
				break;
			default:
				$query = 'SELECT COUNT(a.id) AS total FROM ins_dept a WHERE (a.type = 1) AND (a.active = 1)';
				$db->setQuery($query);
				$result = $db->loadResult();
			break;
		}
		return $result;
	}


	public static function buildTree(array $elements, $parentId = 2)
    {
		
        $branch = array();
        foreach ($elements as $element) {
			
            if ($element['parent_id'] == $parentId) {
                $children = self::buildTree($elements, $element['id']);
				
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

	public static function convertToJsTreeFormat($tree)
    {
        $result = [];
        foreach ($tree as $element) {
            $node = [
                'id' => $element['id'],
                'text' => $element['name'],
            ];
            if (!empty($element['children'])) {
                $node['children'] = self::convertToJsTreeFormat($element['children']);
            }
            $result[] = $node;
        }
        return $result;
    }

    public static function printTree(array $tree, $level = 0)
    {
        echo '<ul>';
		//var_dump(str_repeat('&nbsp;', $level * 4));exit;

        foreach ($tree as $element) {
            echo '<li>' . str_repeat('&nbsp;', $level * 4) . $element['name'];
            if (!empty($element['children'])) {
                self::printTree($element['children'], $level + 1);
            }
            echo '</li>';
        }
        echo '</ul>';
    }



}
