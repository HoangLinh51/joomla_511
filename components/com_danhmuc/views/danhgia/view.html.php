<?php
	defined('_JEXEC') or die('Restricted access');
	class DanhmucViewDanhgia extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				case 'default':
					$this->_initDefault();
					$this->setLayout('default');
					break;
				case 'ds_nhomtieuchi':
					$this->_initDefault();
					$this->setLayout('default');
					break;	
				case 'ds_tieuchi':
					$this->_initDefault();
					$this->getall_nhomtieuchi();
					$this->setLayout('default');
					break;	
				case 'ds_loaicongviec':
					$this->_initDefault();
					$this->setLayout('default');
					break;
				case 'ds_errorsql':
					$this->_initDefault();
					$this->setLayout('default');
					break;
				case 'ds_loaingaynghi':
					$this->_initDefault();
					$this->setLayout('default');
					break;
				case 'ds_dieukienlamviec':
					$this->_initDefault();
					$this->setLayout('default');
					break;
				case 'ds_lydocongviecfail':
					$this->_initDefault();
					$this->setLayout('default');
					break;
				case 'ds_mucdothuongxuyen':
					$this->_initDefault();
					$this->setLayout('default');
					break;
				case 'ds_tinhchat':
					$this->_initDefault();
					$this->setLayout('default');
					break;
				case 'ds_xeploaicongviec':
					$this->_initDefault();
					$this->setLayout('default');
					break;
				case 'ds_xeploaichatluong':
					$this->_initDefault();
					$this->setLayout('default');
					break;
				case 'ds_theonhiemvu':
					$this->_initDefault();
					$this->setLayout('default');
					break;
				case 'ds_theotieuchuan':
					$this->_initDefault();
					$this->setLayout('default');
					break;
				case 'ds_botieuchi':
					$this->_initDefault();
					$this->getall_dgcbcc_nhiemvu();
					$this->findroot_id_botieuchi();
					$this->setLayout('default');
					break;
				case 'ds_tieuchi_donvi':
					$this->_initDefault();
					$this->getall_donvi();
					$this->getall_dotdanhgia_thang();
					$this->findroot_id_botieuchi();
					$this->setLayout('ds_tieuchi_donvi');
					break;
				case 'ds_dotdanhgia':
					$this->_initDefault();
					$this->getall_dotdanhgia();
					$this->setLayout('default');
					break;
				case 'ds_mucdophuctap_xeploai':
					$this->_initDefault();
					$this->getall_dotdanhgia();
					$this->setLayout('default');
					break;
				case 'ds_mucdothamgia':
					$this->_initDefault();
					$this->setLayout('default');
					break;
				case 'ds_tiendo_xeploai':
					$this->_initDefault();
					$this->getall_dotdanhgia();
					$this->setLayout('default');
					break;
				case 'ds_xeploai':
					$this->_initDefault();
					$this->getall_dotdanhgia();
					$this->setLayout('default');
					break;
				case 'ds_partitions':
					$this->_initDefault();
					$this->setLayout('default');
					break;
				case 'ds_tieuchi_liet':
					$this->_initDefault();
					$this->setLayout('default');
					break;
				default:
					break;
			}
			parent::display($tpl);
		}
		public function _initDefault(){
            $document = JFactory::getDocument();
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/jquery.cookie.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jstree/jquery.jstree.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/chosen.jquery.min.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/caydonvi.js' );
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery.maskedinput.min.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/jquery.validate.min.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/jquery.validate.default.js');
            $document->addScript(JUri::base(true).'/media/cbcc/js/date-time/bootstrap-datepicker.min.js');
            $document->addScript(JUri::base(true).'/media/cbcc/js/dataTables-1.10.0/jquery.dataTables.min.js');
            // $document->addScript(JUri::base(true).'/media/cbcc/js/bootstrap.tab.ajax.js');
            $document->addStyleSheet(JUri::base(true).'media/cbcc/js/dataTables-1.10.0/css/jquery.dataTables.min.css');

        }
        public function getall_nhomtieuchi(){
        	$model = Core::model('Danhmuchethong/Tieuchi');
			$this->assignRef('ds_nhomtieuchi',$model->getallnhomtieuchi());
        }
        public function findroot_id_botieuchi(){
			$model = Core::model('Danhmuchethong/botieuchi');
			$this->assignRef('root_id',$model->findroot_id());
		}
		public function getall_dgcbcc_nhiemvu(){
			$model = Core::model('Danhmuchethong/Theotieuchuan');
			$this->assignRef('ds_dgcbcc_nhiemvu',$model->getall_dgcbcc_nhiemvu());
		}
		public function getall_dotdanhgia_thang(){
			$user = JFactory::getUser();
			$user_id = $user->id;
			$donvithuocve = Core::getUserDonvi($user_id);
			$model = Core::model('Danhgia/Tieuchidonvi');
			$this->assignRef('ds_dotdanhgia_thang',$model->getall_dotdanhgia_thang($donvithuocve));
		}
		public function getall_donvi(){
			$user = JFactory::getUser();
			$user_id = $user->id;
			$donvithuocve = Core::getUserDonvi($user_id);
			$model = Core::model('Danhgia/Tieuchidonvi');
			$this->assignRef('ds_donvi',$model->getall_donvi($donvithuocve));
		}
		public function getall_dotdanhgia(){
			$model = Core::model('Danhmuchethong/Dotdanhgia');
			$this->assignRef('ds_dotdanhgia',$model->getall_dotdanhgia());
		}
	}
?>