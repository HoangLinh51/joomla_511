<?php 
	class DanhmucViewQuanhegiadinh extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				default:
					// $this->setLayout('ds_nghenghiep');
					break;
			}
			parent::display($tpl);
		}
	}
?>