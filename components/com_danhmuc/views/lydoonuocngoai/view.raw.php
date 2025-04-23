<?php 
	class DanhmucViewLydoonuocngoai extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				case 'ds_lydoonuocngoai':
					$this->setLayout('ds_lydoonuocngoai');
					break;
				case 'table_lydoonuocngoai':
	                $this->timkiemlydoonuocngoai();
	                $this->setLayout('table_lydoonuocngoai');
	                break;
	            case 'themmoilydoonuocngoai':
	                $this->setLayout('themlydoonuocngoai');
	                break;
	            case 'chinhsualydoonuocngoai':
	                $this->findlydoonuocngoai();
	                $this->setLayout('themlydoonuocngoai');
	                break;
				default:
					// $this->setLayout('ds_nghenghiep');
					break;
			}
			parent::display($tpl);
		}
		function timkiemlydoonuocngoai(){
	        $timkiem_name = JRequest::getVar('ten');
	        $timkiem_code = JRequest::getVar('ma');
	        $model = Core::model('Danhmuckieubao/Lydoonuocngoai');
	        $result = $model->findlydoonuocngoaibynameorcode($timkiem_code, $timkiem_name);
	        $this->assignRef('ds_lydoonuocngoai', $result);
	    }
	    function findlydoonuocngoai(){
	        $id = JRequest::getVar('id');
	        $model = Core::model('Danhmuckieubao/Lydoonuocngoai');
	        $kq = $model->findlydoonuocngoai($id);
	        //var_dump($kq);die;
	        $this->assignRef('lydoonuocngoai', $kq);
	    }
	}
?>