<?php
defined('_JEXEC') or die('Restricted access');
class DanhmucViewBaucunguoiungcu extends JViewLegacy
{
	function display($tpl = null)
	{
		$tbl = 'baucu_nguoiungcu';
		$this->tbl = $tbl;
		$task = JRequest::getVar('task');
		switch ($task) {
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
			case 'frm_upload':
				$this->setLayout('frm_upload');
				// $this->frm_upload();
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
			case 'upload_nguoiungcu':
				$this->upload_nguoiungcu();
				break;
		}
		parent::display($tpl);
	}
	function upload_nguoiungcu(){
		$model = Core::model('Danhmucfront/Baucunguoiungcu');
		$data = $model->upload_nguoiungcu();
		Core::PrintJson($data);
	}
	function dataFilter()
	{
		$model = Core::model('Danhmucfront/Baucunguoiungcu');
		$data = $model->getDanhsach();
		Core::PrintJson($data);
	}
	function frm()
	{
		$id = JRequest::getVar('id', 0);
		$model = Core::model('Danhmucfront/Baucunguoiungcu');
		$info = $model->get($id);
		$this->assignRef('info', $info);
	}
	function save()
	{
		JSession::checkToken() or die('Invalid Token');
		$form   = JRequest::get('post');
		$model = Core::model('Danhmucfront/Baucunguoiungcu');
		$kq     = $model->save($form);
		Core::printJson($kq);
	}
	function xoa()
	{
		$id   = JRequest::getVar('id');
		$model = Core::model('Danhmucfront/Baucunguoiungcu');
		$kq     = $model->xoa($id);
		Core::printJson($kq);
	}
}
