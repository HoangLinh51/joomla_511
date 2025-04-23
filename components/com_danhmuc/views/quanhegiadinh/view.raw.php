<?php 
	class DanhmucViewQuanhegiadinh extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				case 'ds_quanhegiadinh':
					$this->setLayout('ds_quanhegiadinh');
					break;
				case 'table_quanhegiadinh':
	                $this->timkiemquanhegiadinh();
	                $this->setLayout('table_quanhegiadinh');
	                break;
	            case 'themmoiquanhegiadinh':
	                $this->setLayout('themquanhegiadinh');
	                break;
	            case 'chinhsuaquanhegiadinh':
	                $this->findquanhegiadinh();
	                $this->setLayout('themquanhegiadinh');
	                break;
				default:
					// $this->setLayout('ds_nghenghiep');
					break;
			}
			parent::display($tpl);
		}
		function timkiemquanhegiadinh(){
	        $timkiem_name = JRequest::getVar('ten');
	        // $timkiem_code = JRequest::getVar('ma');
	        $model = Core::model('Danhmuckieubao/Quanhegiadinh');
	        $result = $model->findquanhegiadinhbynameorcode($timkiem_name);
	        $this->assignRef('ds_quanhegiadinh', $result);
	    }
	    function findquanhegiadinh(){
	        $id = JRequest::getVar('id');
	        $model = Core::model('Danhmuckieubao/Quanhegiadinh');
	        $kq = $model->findquanhegiadinh($id);
	        //var_dump($kq);die;
	        $this->assignRef('quanhegiadinh', $kq);
	    }
	}
?>