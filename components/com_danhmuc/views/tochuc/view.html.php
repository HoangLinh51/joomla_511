<?php 
	class DanhmucViewTochuc extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
                case 'default':
                    $this->_initDefault();
                    $this->setLayout('default');
                    break;
                case 'ds_hangdonvisunghiep':
                    $this->_initDefault();
                    $this->setLayout('ds_hangdonvisunghiep');
                    break;
                case 'ds_tochucdang':
                    $this->_initDefault();
                    $this->setLayout('ds_tochucdang');
                    break;
                case 'ds_tochucdoan':
                    $this->_initDefault();
                    $this->setLayout('ds_tochucdoan');
                    break;
                case 'ds_tochucdoanthekhac':
                    $this->_initDefault();
                    $this->setLayout('ds_tochucdoanthekhac');
                    break;
                case 'ds_goibienche':
                    $this->_initDefault();
                    $this->setLayout('ds_goibienche');
                    break;
                case 'ds_goihinhthuchuongluong':
                    $this->_initDefault();
                    $this->setLayout('ds_goihinhthuchuongluong');
                    break;
                case 'ds_goidaotaoboiduong':
                    $this->_initDefault();
                    $this->setLayout('ds_goidaotaoboiduong');
                    break;
                case 'ds_goivitrituyendung':
                    $this->_initDefault();
                    $this->findroot_id();
                    $this->getall_function_code();
                    $this->setLayout('ds_goivitrituyendung');
                    break;
                case 'ds_goiluong':
                    $this->_initDefault();
                    $this->findroot_id_goiluong();
                    $this->getall_function_code();
                    $this->setLayout('ds_goiluong');
                    break;
                case 'ds_goichucvu':
                    $this->_initDefault();
                    $this->findroot_id_goichucvu();
                    $this->setLayout('ds_goichucvu');
                    break;
                case 'ds_linhvucbaocao':
                    $this->_initDefault();
                    $this->setLayout('ds_linhvucbaocao');
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
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery.maskedinput.min.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/jquery.validate.min.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/jquery.validate.default.js');
            $document->addScript(JUri::base(true).'/media/cbcc/js/date-time/bootstrap-datepicker.min.js');
            $document->addScript(JUri::base(true).'/media/cbcc/js/dataTables-1.10.0/jquery.dataTables.min.js');
            // $document->addScript(JUri::base(true).'/media/cbcc/js/bootstrap.tab.ajax.js');
            $document->addStyleSheet(JUri::base(true).'media/cbcc/js/dataTables-1.10.0/css/jquery.dataTables.min.css');
        }
        public function findroot_id(){
            $model = Core::model('Danhmuchethong/Goivitrituyendung');
            $this->assignRef('root_id',$model->findroot_id());
        }
        public function getall_function_code(){
            $model = Core::model('Danhmuchethong/Goivitrituyendung');
            $this->assignRef('ds_function_code',$model->getall_function_code());
        }
        public function findroot_id_goiluong(){
            $model = Core::model('Danhmuchethong/Goiluong');
            $this->assignRef('root_id',$model->findroot_id());
        }
        public function findroot_id_goichucvu(){
            $model = Core::model('Danhmuchethong/Goichucvu');
            $this->assignRef('root_id',$model->findroot_id());
        }
	}
?>