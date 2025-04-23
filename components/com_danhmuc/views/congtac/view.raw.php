<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucViewCongtac extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				case 'ds_capbonhiembanhanh':
					$this->setLayout('ds_capbonhiembanhanh');
					break;
				case 'table_capbonhiembanhanh':
					$this->timkiemcapbonhiembanhanh();
					$this->setLayout('table_capbonhiembanhanh');
					break;
				case 'themmoicapbonhiembanhanh':
					$this->setLayout('themmoicapbonhiembanhanh');
					break;
				case 'chinhsuacapbonhiembanhanh':
					$this->findcapbonhiembanhanh();
					$this->setLayout('themmoicapbonhiembanhanh');
					break;
				default:
					$this->setLayout('default');
					break;
			}
			parent::display($tpl);
		}
		function timkiemcapbonhiembanhanh(){
			$timkiem_capbonhiembanhanh = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Capbonhiembanhanh');
			$result= $model->findcbnbhbyname($timkiem_capbonhiembanhanh);
			$this->assignRef('ds_capbonhiembanhanh',$result);
		}
		function findcapbonhiembanhanh(){
			$id_capbonhiembanhanh = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Capbonhiembanhanh');
			$result = $model->findcapbonhiembanhanh($id_capbonhiembanhanh);
			$this->assignRef('capbonhiembanhanh',$result);
		}
	}
?>