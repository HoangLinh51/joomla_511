<?php 
	class DanhmucViewChucvu extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				case 'ds_quanlychucvutuongduong':
					$this->setLayout('ds_quanlychucvutuongduong');
					break;
				case 'table_qlcvtd':
					$this->timkiemchucvutuongduong();
					$this->setLayout('table_quanlychucvutuongduong');
					break;
				case 'themmoichucvutuongduong':
					$this->setLayout('themmoichucvutuongduong');
					break;
				case 'chinhsuachucvutuongduong':
					$this->findchucvutuongduong();
					$this->setLayout('themmoichucvutuongduong');
					break;
				default:
					$this->setLayout('default');
					break;
			}
			parent::display($tpl);
		}
		public function timkiemchucvutuongduong(){
			$tk_tencvtd = JRequest::getVar('ten');
			$tk_tencvtd1 = JRequest::getVar('ten1');
			$tk_tencvtd2 = JRequest::getVar('ten2');
			$model = Core::model('Danhmuckieubao/Quanlychucvutuongduong');
			// $model = Core::model('Danhmuckieubao/Quanlychucvutuongduong');
			$kq = $model->findcvtdbyname($tk_tencvtd,$tk_tencvtd1,$tk_tencvtd2);
			$this->assignRef('ds_cvtd',$kq);
		}
		public function findchucvutuongduong(){
			$id_cvtd = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Quanlychucvutuongduong');
			$kq = $model->findcvtd($id_cvtd);
			$this->assignRef('cvtd',$kq);
		}
	}
?>