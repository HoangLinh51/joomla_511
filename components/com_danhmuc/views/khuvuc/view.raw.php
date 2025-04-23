<?php 
	class DanhmucViewKhuvuc extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				case 'ds_khuvuc':
					$this->setLayout('ds_khuvuc');
					break;
				case 'table_khuvuc':
	                $this->timkiemkhuvuc();    
	                $this->setLayout('table_khuvuc');
	                break;
	            case 'themmoikhuvuc':
	                $this->getallquan();
	                $this->setLayout('themkhuvuc');
	                break;
	            case 'chinhsuakhuvuc':
	                $this->findkhuvuc();
	                $this->setLayout('themkhuvuc');
	                break;
				default:
					// $this->setLayout('ds_nghenghiep');
					break;
			}
			parent::display($tpl);
		}
		function getallquan(){
	        $model = Core::model('Danhmuckieubao/Khuvuc');
	        $result = $model->getallquan();
	        $this->assignRef('ds_quan',$result);
	    }
		function timkiemkhuvuc(){
	        $timkiem_name = JRequest::getVar('ten');
	        $timkiem_code = JRequest::getVar('ma');
	        $model = Core::model('Danhmuckieubao/Khuvuc');
	        $result = $model->findkhuvucbynameorcode($timkiem_code, $timkiem_name);
	        $result1 = $model->getallquanhuyen();
	        $result2= $model->getallphuongxa();
	        $this->assignRef('ds_quanhuyen',$result1);
	        $this->assignRef('ds_phuongxa',$result2);
	        $this->assignRef('ds_kv',$result);
	        $this->assignRef('ten',$timkiem_name);
	        $this->assignRef('ma',$timkiem_code);
	    }   
	    
	    function findkhuvuc() {
	        $id = JRequest::getVar('id');
	        $model = Core::model('Danhmuckieubao/Khuvuc');
	        $kq = $model->findkhuvuc($id);
	        $result1 = $model->getallquanhuyen();
	        $this->assignRef('ds_quan',$result1);
	        $this->assignRef('khuvuc', $kq);
	    }
	}
?>