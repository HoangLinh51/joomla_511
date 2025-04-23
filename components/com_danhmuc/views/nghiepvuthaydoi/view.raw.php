<?php 
    class DanhmucViewNghiepvuthaydoi extends JViewLegacy{
        function display($tpl=null){           
            $task = JRequest::getVar('task');
            switch($task){
                case 'table_nghiepvuthaydoi':
                    $this->find_nghiepvuthaydoi_by_name();
                    $this->setLayout('table_nghiepvuthaydoi');
                    break;
                case 'themmoi_nghiepvuthaydoi':
                    $this->setLayout('themmoi_nghiepvuthaydoi');
                    break;
                case 'chinhsua_nghiepvuthaydoi':
                    $this->find_nghiepvuthaydoi_by_id();
                    $this->setLayout('themmoi_nghiepvuthaydoi');
                    break;
                default:
                    $this->_initDefault();
                    $this->setLayout('default');
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
        public function find_nghiepvuthaydoi_by_name(){
            $jinput = JFactory::getApplication()->input;
            $nghiepvuthaydoi_name = $jinput->getString('nghiepvuthaydoi_name','');
            $model = Core::model('Danhmuchethong/Nghiepvuthaydoi');
            $this->assignRef('ds_nghiepvuthaydoi',$model->find_nghiepvuthaydoi_by_name($nghiepvuthaydoi_name));
        }
        public function find_nghiepvuthaydoi_by_id(){
            $jinput = JFactory::getApplication()->input;
            $id = $jinput->getInt('id',0);
            if($id>0){
                $model = Core::model('Danhmuchethong/Nghiepvuthaydoi');
                $this->assignRef('nghiepvuthaydoi',$model->find_nghiepvuthaydoi_by_id($id));
            }
        }
       
    }
    
?>