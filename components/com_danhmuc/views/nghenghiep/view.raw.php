<?php 
	class DanhmucViewNghenghiep extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				case 'default':
					$this->setLayout('ds_nghenghiep');
					break;
				case 'table_nghenghiep':
	                $this->timkiemnghenghiep();
	                $this->setLayout('table_nghenghiep');
	                break;
	            case 'themmoinghenghiep':
	                $this->setLayout('themnghenghiep');
	                break;
	            case 'chinhsuanghenghiep':
	                $this->findjob();
	                $this->setLayout('themnghenghiep');
	                break;
				default:
					$this->setLayout('ds_nghenghiep');
					break;
			}
			parent::display($tpl);
		}
		function findjob() {
	        $id = JRequest::getVar('id');
	        // $model = JModelLegacy::getInstance('Nghenghiep', 'DanhmucModel');
	        $model = Core::model('Danhmuckieubao/Nghenghiep');
	        $kq = $model->findjob($id);
	        //var_dump($kq);die;
	        $this->assignRef('job', $kq);
	    }

	    function timkiemnghenghiep() {
	        $timkiem_name = JRequest::getVar('ten');
	        $timkiem_code = JRequest::getVar('ma');        
	        // $model = JModelLegacy::getInstance('Nghenghiep', 'DanhmucModel');
	        $model = Core::model('Danhmuckieubao/Nghenghiep');
	        $result = $model->findjobbynameorcode($timkiem_code, $timkiem_name);
	        $this->assignRef('ds_job', $result);
	        //var_dump($result);die;
	        $this->assignRef('ten', $timkiem_name);
	        //echo $form['code'];die;
	        $this->assignRef('ma', $timkiem_code);
	    }
	}
?>