<?php 
	class DanhmucViewHinhthucduhoc extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				case 'themmoihtdh':
	               	$this->setLayout('themhinhthucduhoc');
	                break;
	            case 'chinhsuahtdh':
	                $this->findhtdh();
	                $this->setLayout('themhinhthucduhoc');
	                break;
	            
	            case 'table_hinhthucduhoc':
	                $this->timkiemhinhthucduhoc();
	                $this->setLayout('table_hinhthucduhoc');
	                break;
	            case 'ds_hinhthucduhoc':
	            	$this->setLayout('ds_hinhthucduhoc');
	            	break;
				default:
					break;
			}
			parent::display($tpl);
		}
		function findhtdh() {
	        $id = JRequest::getVar('id');
	        $model = Core::model('Danhmuckieubao/Hinhthucduhoc');
	        $kq = $model->findhtdh($id);
	        //var_dump($kq);die;
	        $this->assignRef('job', $kq);
	    }
	    function timkiemhinhthucduhoc(){
	        $timkiem_name = JRequest::getVar('ten');
	        $timkiem_code = JRequest::getVar('ma');
	        $model = Core::model('Danhmuckieubao/Hinhthucduhoc');
	        $result = $model->findhtdhbynameorcode($timkiem_code, $timkiem_name);
	        $this->assignRef('ds_job',$result);
	        $this->assignRef('ten',$timkiem_name);
	        $this->assignRef('ma',$timkiem_code);
	    }
	}
?>