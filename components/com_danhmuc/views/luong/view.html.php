<?php
defined('_JEXEC') or die('Restricted access');
    class DanhmucViewLuong extends JViewLegacy{
        function display($tpl=null){
            
            $task = JRequest::getVar('task');
            switch($task){
                case 'ds_luongcoso':
                    $this->setLayout('danhsach_luongcoso');
                    break;
                case 'ds_hinhthuc_nangluongchuyenngach':
                    $this->_initDefault();
                    $this->setLayout('ds_hinhthuc_nangluongchuyenngach');
                    break;
                case 'ds_thuetncn':
                    $this->_initDefault();
                    $this->setLayout('ds_thuetncn');
                    break;
                case 'ds_quanly_ngachbac':
                    $this->_initDefault();
                    $this->setLayout('ds_quanly_ngachbac');
                    break;
                case 'themmoi_ngachbac':
                    $this->_initDefault();
                    $this->getall_bangluong();
                    $this->setLayout('themmoi_ngachbac');
                    break;
                case 'chinhsua_ngachbac':
                    $this->_initDefault();
                    $this->getall_bangluong();
                    $this->find_nhomngach_by_id();
                    $this->find_nhomngach_heso_by_id_ngach();
                    $this->setLayout('themmoi_ngachbac');
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
            $document->addScript(JURI::base(true).'/media/cbcc/js/jstree-3.2.1/jstree.min.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/chosen.jquery.min.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery.maskedinput.min.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/jquery.validate.min.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/jquery.validate.default.js');
            $document->addScript(JUri::base(true).'/media/cbcc/js/date-time/bootstrap-datepicker.min.js');
            $document->addScript(JUri::base(true).'/media/cbcc/js/dataTables-1.10.0/jquery.dataTables.min.js');
            // $document->addScript(JUri::base(true).'/media/cbcc/js/bootstrap.tab.ajax.js');
            $document->addStyleSheet(JUri::base(true).'media/cbcc/js/dataTables-1.10.0/css/jquery.dataTables.min.css');

        }
        public function getall_bangluong(){
            $model = Core::model('Danhmuchethong/Ngachbac');
            $this->assignRef('ds_cb_bangluong',$model->getall_bangluong());
        }
        public function find_nhomngach_by_id(){
            $jinput = JFactory::getApplication()->input;
            $id = $jinput->getInt('id',0);
            if($id>0){
                $model = Core::model('Danhmuchethong/Ngachbac');
                $this->assignRef('ngachbac',$model->find_nhomngach_by_id($id));
            }
        }
        public function find_nhomngach_heso_by_id_ngach(){
            $jinput = JFactory::getApplication()->input;
            $id = $jinput->getInt('id',0);
            if($id>0){
                $model = Core::model('Danhmuchethong/Ngachbac');
                $this->assignRef('ds_nhomngach_heso',$model->find_nhomngach_heso_by_id_ngach($id));
            }
        }           
    }