<?php 
	class DanhmucViewQuocgia extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				case 'ds_quocgia':
					$this->setLayout('ds_quocgia');
					break;
				case 'table_quocgia':
	                $this->timkiemquocgia();
	                $this->setLayout('table_quocgia');
	                break;
	            case 'themmoiquocgia':
	                $this->setLayout('themquocgia');
	                break;
	            case 'chinhsuaquocgia':
	                $this->findquocgia();
	                $this->setLayout('themquocgia');
	                break; 
				default:
					// $this->setLayout('ds_nghenghiep');
					break;
			}
			parent::display($tpl);
		}
		function timkiemquocgia(){
	        $timkiem_name = JRequest::getVar('ten');   
	        $model = Core::model('Danhmuckieubao/Quocgia');
	        $result = $model->findquocgiabynameorcode($timkiem_name);
	        $this->assignRef('ds_quocgia', $result);
	    }
	    function findquocgia(){
	        $id = JRequest::getVar('id');
	        $model = Core::model('Danhmuckieubao/Quocgia');
	        $kq = $model->findquocgia($id);
	        //var_dump($kq);die;
	        $this->assignRef('quocgia', $kq);
	    }
	}
?>