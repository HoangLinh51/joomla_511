<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class DanhmucViewVtvltrangthai extends JViewLegacy {
	function display($tpl = null) {
	  $task = JRequest::getVar('task');
		  switch($task){
	  		case 'default':
	  			$this->setLayout('default');
	  			break;
	  		case 'danhsach':
	  			$this->setLayout('danhsach');
	  			break;
	  		case 'dataFilter':
	  			$this->dataFilter();
	  			break;
	  		case 'frm':
	  			$this->setLayout('frm');
	  			$this->frm();
	  			break;
	  		default: 
	  			$this->setLayout('hoso_404');
				  break;
			case 'save':
				$this->save();
			break;
			case 'xoa':
				$this->xoa();
			break;
	  	}
	  	parent::display($tpl);
	}
	function dataFilter(){
	 	$model = Core::model('Danhmucfront/Vtvltrangthai');
	 	$data = $model->getDanhsach();
	 	Core::PrintJson($data);
	}
	function frm(){
		$id = JRequest::getVar('id', 0);
		$model = Core::model('Danhmucfront/Vtvltrangthai');
	 	$info = $model->get($id);
	 	$this->assignRef('info', $info);
	}
	function save(){
		JSession::checkToken() or die('Invalid Token');
        $form   = JRequest::get('post');
        $model = Core::model('Danhmucfront/Vtvltrangthai');
        $kq     = $model->save($form);
        Core::printJson($kq);
	}
	function xoa(){
		$id   = JRequest::getVar('id');
        $model = Core::model('Danhmucfront/Vtvltrangthai');
        $kq     = $model->xoa($id);
        Core::printJson($kq);
	}
}
