<?php

defined('_JEXEC') or die('Restricted access');

class DanhmucViewDanhmuc extends JViewLegacy {

    function display($tpl = null) {
        $task = JRequest::getVar('task');
        switch ($task) {
            default:
                $this->setLayout('page_404');
                break;
        }
        parent::display($tpl);
    }
}