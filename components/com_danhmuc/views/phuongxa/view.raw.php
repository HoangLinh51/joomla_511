<?php
defined('_JEXEC') or die('Restricted access');
class DanhmucViewPhuongxa extends JViewLegacy
{
	function display($tpl = null)
	{
		$tbl = 'comm_code';
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
			default:
				$this->setLayout('hoso_404');
				break;
			case 'save':
				$this->save();
				break;
			case 'xoa':
				$this->xoa();
				break;
			case 'getQuanhuyenByTinhthanh':
				$this->getQuanhuyenByTinhthanh();
				break;
		}
		parent::display($tpl);
	}
	function getQuanhuyenByTinhthanh(){
		$jinput = JFactory::getApplication()->input;
		$tinhthanh_id = $jinput->get('tinhthanh_id','', 'string');
		$quanhuyen = Core::loadAssocList('dist_code','*','cadc_code IN (0'.$tinhthanh_id.') AND daxoa=0', '(code>0) asc, muctuongduong is null asc, name is null asc');
		Core::printJson($quanhuyen);
	}
	function dataFilter()
	{
		$model = Core::model('Danhmucfront/Phuongxa');
		$data = $model->getDanhsach();
		Core::PrintJson($data);
	}
	function frm()
	{
		$id = JRequest::getVar('id', 0);
		$model = Core::model('Danhmucfront/Phuongxa');
		$info = $model->get($id);
		$this->assignRef('info', $info);
	}
	function save()
	{
		JSession::checkToken() or die('Invalid Token');
		$form   = JRequest::get('post');
		$model = Core::model('Danhmucfront/Phuongxa');
		$kq     = $model->save($form);
		Core::printJson($kq);
	}
	function xoa()
	{
		$id   = JRequest::getVar('id');
		$model = Core::model('Danhmucfront/Phuongxa');
		$kq     = $model->xoa($id);
		Core::printJson($kq);
	}
}
