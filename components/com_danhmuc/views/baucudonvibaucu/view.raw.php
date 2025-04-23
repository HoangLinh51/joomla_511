<?php
defined('_JEXEC') or die('Restricted access');
class DanhmucViewBaucudonvibaucu extends JViewLegacy
{
	function display($tpl = null)
	{
		$tbl = 'baucu_donvibaucu';
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
		$model = Core::model('Danhmucfront/Baucudonvibaucu');
		$data = $model->getDanhsach();
		Core::PrintJson($data);
	}
	function frm()
	{
		$id = JRequest::getVar('id', 0);
		$model = Core::model('Danhmucfront/Baucudonvibaucu');
		$info = $model->get($id);
		$this->assignRef('info', $info);
	}
	function save()
	{
		JSession::checkToken() or die('Invalid Token');
		$form   = JRequest::get('post');
		$model = Core::model('Danhmucfront/Baucudonvibaucu');
		$kq     = $model->save($form);
		// xử lý lưu mấy cái fk kia
		if($kq>0){
			Core::delete('baucu_donvibaucu2diadiem','donvibaucu_id='.(int)$kq);
			for($i=0; $i<count($form['diadiembaucu_id']); $i++) $model->luuFkDiadiem($kq, $form['diadiembaucu_id'][$i]);
			Core::delete('baucu_donvibaucu2loaiphieubau','donvibaucu_id='.(int)$kq);
			for($i=0; $i<count($form['loaiphieubau_id']); $i++) $model->luuFkLoaiphieubau($kq, $form['loaiphieubau_id'][$i]);
			Core::delete('baucu_donvibaucu2nguoiungcu','donvibaucu_id='.(int)$kq);
			for($i=0; $i<count($form['nguoiungcu_id']); $i++) $model->luuFkNguoiungcu($kq, $form['nguoiungcu_id'][$i]);
			Core::delete('baucu_donvibaucu2tobaucu','donvibaucu_id='.(int)$kq);
			for($i=0; $i<count($form['tobaucu_id']); $i++) $model->luuFkTobaucu($kq, $form['tobaucu_id'][$i]);
		}
		Core::printJson($kq);
	}
	function xoa()
	{
		$id   = JRequest::getVar('id');
		$model = Core::model('Danhmucfront/Baucudonvibaucu');
		$kq     = $model->xoa($id);
		Core::printJson($kq);
	}
}
