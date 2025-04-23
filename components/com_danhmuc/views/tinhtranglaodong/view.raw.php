<?php 
	class DanhmucViewTinhtranglaodong extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				case 'ds_tinhtranglaodong':
					$this->setLayout('ds_tinhtranglaodong');
					break;
				case 'table_tinhtranglaodong':
	                $this->timkiemttld();
	                $this->setLayout('table_tinhtranglaodong');
	                break;
	            case 'themmoitinhtranglaodong':
	                $this->setLayout('themtinhtranglaodong');
	                break;
	            case 'chinhsuatinhtranglaodong':
	                $this->findttld();
	                $this->setLayout('themtinhtranglaodong');
	                break;	
				default:
					// $this->setLayout('ds_nghenghiep');
					break;
			}
			parent::display($tpl);
		}
		function timkiemttld() {
	        $timkiem_name = JRequest::getVar('ten');
	        $timkiem_code = JRequest::getVar('ma');
	        $model = Core::model('Danhmuckieubao/Tinhtranglaodong');
	        $result = $model->findttldbynameorcode($timkiem_code, $timkiem_name);
	        $this->assignRef('ds_ttld', $result);
	    }
	    function findttld() {
	        $id = JRequest::getVar('id');
	        $model = Core::model('Danhmuckieubao/Tinhtranglaodong');
	        $kq = $model->findttld($id);
	        //var_dump($kq);die;
	        $this->assignRef('ttld', $kq);
	    }
	}
?>