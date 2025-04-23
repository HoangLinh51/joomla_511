<?php 
	class DanhmucViewChuyennganhdaotao extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				case 'ds_chuyennganhdaotao':
					$this->setLayout('ds_chuyennganhdaotao');
					break;
				case 'table_chuyennganhdaotao':
	                $this->timkiemchuyennganhdaotao();
	                $this->setLayout('table_chuyennganhdaotao');
	                break;
	            case 'themmoichuyennganhdaotao':
	                $this->setLayout('themchuyennganhdaotao');
	                break;
	            case 'chinhsuachuyennganhdaotao':
	                $this->findchuyennganhdaotao();
	                $this->setLayout('themchuyennganhdaotao');
	                break;
				default:
					// $this->setLayout('ds_nghenghiep');
					break;
			}
			parent::display($tpl);
		}
		function timkiemchuyennganhdaotao(){
	        $timkiem_name = JRequest::getVar('ten');
	        $timkiem_code = JRequest::getVar('ma');
	        $model = Core::model('Danhmuckieubao/Chuyennganhdaotao');
	        $result = $model->findchuyennganhdaotaobynameorcode($timkiem_code, $timkiem_name);
	        $this->assignRef('ds_chuyennganhdaotao', $result);
	    }
	    function findchuyennganhdaotao(){
	        $id = JRequest::getVar('id');
	        $model = Core::model('Danhmuckieubao/Chuyennganhdaotao');
	        $kq = $model->findchuyennganhdaotao($id);
	        //var_dump($kq);die;
	        $this->assignRef('chuyennganhdaotao', $kq);
	    }
	}
?>