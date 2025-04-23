<?php
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucViewThongtincbccvc extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				default:
					$this->_initDefault();
					$this->setLayout('default');
					break;
			}
			parent::display($tpl);
		}
		public function _initDefault(){
			$document = JFactory::getDocument();
			$document->addScript(JUri::base(true).'/media/cbcc/js/bootstrap.tab.ajax.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/jquery.cookie.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jstree/jquery.jstree.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/chosen.jquery.min.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery.maskedinput.min.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/jquery.validate.min.js');
            $document->addScript(JURI::base(true).'/media/cbcc/js/jquery/jquery.validate.default.js');
            $document->addScript(JUri::base(true).'/media/cbcc/js/date-time/bootstrap-datepicker.min.js');
            $document->addScript(JUri::base(true).'/media/cbcc/js/dataTables-1.10.0/jquery.dataTables.min.js');
            $document->addStyleSheet(JUri::base(true).'media/cbcc/js/dataTables-1.10.0/css/jquery.dataTables.min.css');

        }
	}
 ?>