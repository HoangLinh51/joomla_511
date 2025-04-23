<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class DanhmucViewVtvldieukienlamviec extends JViewLegacy {
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
	 	$model = Core::model('Danhmucfront/Vtvldieukienlamviec');
	 	$data = $model->getDanhsach();
	 	Core::PrintJson($data);
	}
	function frm(){
		$id = JRequest::getVar('id', 0);
		$model = Core::model('Danhmucfront/Vtvldieukienlamviec');
	 	$info = $model->get($id);
	 	$this->assignRef('info', $info);
	}
	function save(){
		JSession::checkToken() or die('Invalid Token');
        $form   = JRequest::get('post');
        $model = Core::model('Danhmucfront/Vtvldieukienlamviec');
        $kq     = $model->save($form);
        Core::printJson($kq);
	}
	function xoa(){
		$id   = JRequest::getVar('id');
        $model = Core::model('Danhmucfront/Vtvldieukienlamviec');
        $kq     = $model->xoa($id);
        Core::printJson($kq);
	}
}
