<?php
defined('_JEXEC') or die('Restricted access');
class DanhmucViewBaucucauhinhemail extends JViewLegacy
{
	function display($tpl = null)
	{
		$tbl = 'baucu_baucucauhinhemail';
		$this->tbl = $tbl;
		$task = JRequest::getVar('task');
		switch ($task) {
			case 'default':
				$this->setLayout('default');
				break;
			case 'danhsach':
				$this->setLayout('danhsach');
				break;
			// case 'dataFilter':
			// 	$this->dataFilter();
			// 	break;
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
			case 'test_email':
				$this->test_email();
				break;
		}
		parent::display($tpl);
	}
	// function dataFilter()
	// {
		// $model = Core::model('Danhmucfront/Baucucauhinhemail');
		// $data = $model->getDanhsach();
		// Core::PrintJson($data);
	// }
	function frm()
	{
		$diadiemhanhchinh_id = JRequest::getVar('diadiemhanhchinh_id', 0);
		$this->diadiemhanhchinh_id = $diadiemhanhchinh_id;
	}
	function save()
	{
		JSession::checkToken() or die('Invalid Token');
		$form   = JRequest::get('post');
		$model = Core::model('Danhmucfront/Baucucauhinhemail');
		$kq     = $model->save($form);
		Core::printJson($kq);
	}
	function xoa()
	{
		$id   = JRequest::getVar('id');
		$model = Core::model('Danhmucfront/Baucucauhinhemail');
		$kq     = $model->xoa($id);
		Core::printJson($kq);
	}
	function test_email(){
		$diadiemhanhchinh_id = JRequest::getVar('diadiemhanhchinh_id', 0);
		$model = Core::model('Danhmucfront/Baucucauhinhemail');
		$kq     = $model->guiemail($diadiemhanhchinh_id);
		Core::printJson($kq);
	}
}
