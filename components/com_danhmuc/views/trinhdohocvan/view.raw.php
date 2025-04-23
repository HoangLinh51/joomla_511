<?php 
	class DanhmucViewTrinhdohocvan extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				case 'ds_trinhdohocvan':
					$this->setLayout('ds_trinhdohocvan');
					break;
				case 'table_trinhdohocvan':
	                $this->timkiemtrinhdohocvan();
	                $this->setLayout('table_trinhdohocvan');
	                break;
	            case 'themmoitrinhdohocvan':
	                $this->setLayout('themtrinhdohocvan');
	                break;
	            case 'chinhsuatrinhdohocvan':
	                $this->findtdhv();
	                $this->setLayout('themtrinhdohocvan');
	                break;
				default:
					// $this->setLayout('ds_nghenghiep');
					break;
			}
			parent::display($tpl);
		}
		function timkiemtrinhdohocvan(){
	        $tk_matdhv = JRequest::getVar('ma');
	        $tk_tentdhv = JRequest::getVar('ten');
	        $model = Core::model('Danhmuckieubao/Trinhdohocvan');
	        $kq = $model->findtdhvbynameorcode($tk_matdhv,$tk_tentdhv);
	        $this->assignRef('ds_tdhv',$kq);
	    }
	    function findtdhv(){
	        $id = JRequest::getVar('id');
	        $model = Core::model('Danhmuckieubao/Trinhdohocvan');
	        $kq = $model->findtdhv($id);
	        $this->assignRef('tdhv', $kq);
	    }
	}
?>