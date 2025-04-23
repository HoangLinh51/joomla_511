<?php
defined('_JEXEC') or die;
class DanhmucViewBaucucauhinhemail extends JViewLegacy
{
    public function display($tpl = null)
    {   
    	$task = JFactory::getApplication()->input->get('task');
        switch($task){
            default:
                $this->setLayout('hoso_404');
                break;
            case 'default':
                $this->_initDefaultPage();
                $this->setLayout('default');
                break;
        }                
        parent::display($tpl);
    }
    function _initDefaultPage(){
    	$document = JFactory::getDocument();
        $document->addScript(JUri::base(true).'/media/cbcc/js/jquery/chosen.jquery.min.js');
        $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/jquery.cookie.js');
        $document->addScript(JURI::base(true).'/media/cbcc/js/jstree/jquery.jstree.js');
        $document->addCustomTag('<link href="'.JURI::base(true).'/media/cbcc/js/jstree/themes/default/style.css" rel="stylesheet" />');
        $document->addScript(JURI::base(true).'/media/cbcc/js/dataTables-1.10.0/jquery.dataTables.min.js');
        $document->addScript(JURI::base(true).'/media/cbcc/js/dataTables-1.10.0/dataTables.tableTools.min.js');
        $document->addScript(JURI::base(true).'/media/cbcc/js/dataTables-1.10.0/datatables.default.config.js');
        $document->addStyleSheet(JURI::base(true).'/media/cbcc/js/dataTables-1.10.0/css/dataTables.tableTools.css');
        $document->addScript(JURI::base(true).'/media/cbcc/js/jquery.maskedinput.min.js');
        $document->addScript(JURI::base(true).'/media/cbcc/js/date-time/bootstrap-datepicker.min.js');
        $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/jquery.validate.min.js');
        $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/jquery.validate.default.js');
    }
}
