<?php 
	class DanhmucViewNganhnghe extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				case 'ds_nganhnghe':
					$this->setLayout('ds_nganhnghe');
					break;
				case 'table_nganhnghe':
	                $this->timkiemnganhnghe();
	                $this->setLayout('table_nganhnghe');
	                break;
	            case 'themmoinganhnghe':
	                $this->setLayout('themnganhnghe');
	                break;
	            case 'chinhsuanganhnghe':
	                $this->findnganhnghe();
	                $this->setLayout('themnganhnghe');
	                break;	
				default:
					// $this->setLayout('ds_nghenghiep');
					break;
			}
			parent::display($tpl);
		}
		function timkiemnganhnghe(){
	        $timkiem_name = JRequest::getVar('ten');
	        $timkiem_code = JRequest::getVar('ma');
	        $model = Core::model('Danhmuckieubao/Nganhnghe');
	        $result = $model->findnganhnghebynameorcode($timkiem_code, $timkiem_name);
	        $this->assignRef('ds_nganhnghe', $result);
	    }
	    function findnganhnghe() {
	        $id = JRequest::getVar('id');
	        $model = Core::model('Danhmuckieubao/Nganhnghe');
	        $kq = $model->findnganhnghe($id);
	        //var_dump($kq);die;
	        $this->assignRef('nganhnghe', $kq);
	    }
	}
?>