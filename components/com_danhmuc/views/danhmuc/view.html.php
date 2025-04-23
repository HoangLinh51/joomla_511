<?php
defined('_JEXEC') or die('Restricted access');
class DanhmucViewDanhmuc extends JViewLegacy
{
    function display($tpl = null)
    {

        $task = JRequest::getVar('task');
        switch ($task) {
            case 'default':
                $this->_initDefault();
                $this->setLayout('default');
                break;
            case 'thongtinchung':
                $this->_initDefault();
                $this->setLayout('default_thongtinchung');
                break;
            case 'vitrivieclam':
                $this->_initDefault();
                $this->setLayout('default_vitrivieclam');
                break;
            case 'bienche':
                $this->_initDefault();
                $this->setLayout('default_bienche');
                break;
            case 'luongpc':
                $this->_initDefault();
                $this->setLayout('default_luongpc');
                break;
            case 'daotaoboiduong':
                $this->_initDefault();
                $this->setLayout('default_daotaoboiduong');
                break;
            case 'baucu':
                $this->_initDefault();
                $this->setLayout('default_baucu');
                break;
            case 'baucu_xuatbienban':
                $this->_initDefault();
                $this->setLayout('default_baucu_xuatbienban');
                break;
            default:
                break;
        }
        parent::display($tpl);
    }
    public function _initDefault()
    {
        $document = JFactory::getDocument();
        $document->addScript(JURI::base(true) . '/media/cbcc/js/jquery/jquery.cookie.js');
        $document->addScript(JURI::base(true) . '/media/cbcc/js/jstree/jquery.jstree.js');
        $document->addScript(JURI::base(true) . '/media/cbcc/js/jquery/chosen.jquery.min.js');
        $document->addScript(JURI::base(true) . '/media/cbcc/js/jquery.maskedinput.min.js');
        $document->addScript(JURI::base(true) . '/media/cbcc/js/jquery/jquery.validate.min.js');
        $document->addScript(JURI::base(true) . '/media/cbcc/js/jquery/jquery.validate.default.js');
        $document->addScript(JUri::base(true) . '/media/cbcc/js/date-time/bootstrap-datepicker.min.js');
        $document->addScript(JUri::base(true) . '/media/cbcc/js/dataTables-1.10.0/jquery.dataTables.min.js');
        $document->addScript(JUri::base(true) . '/media/cbcc/js/bootstrap.tab.ajax.js');
        $document->addStyleSheet(JUri::base(true) . '/media/cbcc/js/dataTables-1.10.0/css/jquery.dataTables.min.css');
        $document->addCustomTag('<link href="' . JURI::base(true) . '/media/cbcc/js/jstree/themes/default/style.css" rel="stylesheet" />');
        $document->addScript(JURI::base(true) . '/media/cbcc/js/dataTables-1.10.0/dataTables.tableTools.min.js');
        $document->addScript(JURI::base(true) . '/media/cbcc/js/dataTables-1.10.0/datatables.default.config.js');
        $document->addStyleSheet(JURI::base(true) . '/media/cbcc/js/dataTables-1.10.0/css/dataTables.tableTools.css');
    }
}
