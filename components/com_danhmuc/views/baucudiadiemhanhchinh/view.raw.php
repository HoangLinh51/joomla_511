<?php
defined('_JEXEC') or die('Restricted access');
class DanhmucViewBaucudiadiemhanhchinh extends JViewLegacy
{
	function display($tpl = null)
	{
		$tbl = 'baucu_diadiemhanhchinh';
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
		}
		parent::display($tpl);
	}
	function dataFilter()
	{
		$model = Core::model('Danhmucfront/Baucudiadiemhanhchinh');
		$data = $model->getDanhsach();
		Core::PrintJson($data);
	}
	function frm()
	{
		$user_id = JFactory::getUser()->id;
		$donviquanly_id = Core::getManageUnit((int)$user_id, null, null, null);
        $donvi = Core::_getDanhsachDonviDuocPhanquyen($donviquanly_id, null, null, null);
        
        $donvi = Core::loadAssocList('ins_dept','*','type IN (1,3) AND active=1 AND id IN (0'.implode(',', $donvi).') and ins_cap in (8,9,10,11,12,13)','lft asc');

		$id = JRequest::getVar('id', 0);
		$model = Core::model('Danhmucfront/Baucudiadiemhanhchinh');
		$info = $model->get($id);
		$this->assignRef('info', $info);
		$this->assignRef('donvi', $donvi);
	}
	function save()
	{
		JSession::checkToken() or die('Invalid Token');
		$form   = JRequest::get('post');
		$model = Core::model('Danhmucfront/Baucudiadiemhanhchinh');
		$kq     = $model->save($form);
		Core::printJson($kq);
	}
	function xoa()
	{
		$id   = JRequest::getVar('id');
		$model = Core::model('Danhmucfront/Baucudiadiemhanhchinh');
		$kq     = $model->xoa($id);
		Core::printJson($kq);
	}
}
