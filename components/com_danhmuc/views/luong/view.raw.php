<?php

defined('_JEXEC') or die('Restricted access');

class DanhmucViewLuong extends JViewLegacy {

    function display($tpl1 = null) {

        $task = JRequest::getVar('task');

        switch ($task) {
            case 'ds_luongcoso':
                $this->setLayout('danhsach_luongcoso');
                break;
            case 'table_luongcoso':
                $this->timkiemluongcoso();
                $this->setLayout('table_luongcoso');
                break;
            case 'themmoiluongcoso':
                $this->setLayout('themluongcoso');
                break;
            case 'chinhsualuongcoso':
                $this->findluongcoso();
                $this->setLayout('themluongcoso');
                break;
            case 'ds_donvitinhphucap':
                $this->setLayout('danhsach_donvitinhphucap');
                break;
            case 'table_donvitinhphucap':
                $this->timkiemdvtpc();
                $this->setLayout('table_donvitinhphucap');
                break;
            case 'themmoidvtpc':
                $this->setLayout('themdonvitinhphucap');
                break;
            case 'chinhsuadvtpc':
                $this->finddvtpc();
                $this->setLayout('themdonvitinhphucap');
                break;
            case 'ds_cachtinhphucap':
                $this->setLayout('danhsach_cachtinhphucap');
                break;
            case 'table_cachtinhphucap':
                $this->timkiemctpc();
                $this->setLayout('table_cachtinhphucap');
                break;
            case 'themmoictpc':
                $this->setLayout('themcachtinhphucap');
                break;
            case 'chinhsuactpc':
                $this->findctpc();
                $this->setLayout('themcachtinhphucap');
                break;
            case 'ds_loaiphucap':
                $this->setLayout('danhsach_loaiphucap');
                break;
            case 'table_loaiphucap':
                $this->timkiemloaiphucap();
                $this->getalldonvitinh();
                $this->getallcachtinh();
                $this->setLayout('table_loaiphucap');
                break;
            case 'themmoiloaiphucap':
                $this->getalldonvitinh();
                $this->getallcachtinh();
                $this->setLayout('themloaiphucap');
                break;
            case 'chinhsualoaiphucap':
                $this->getalldonvitinh();
                $this->getallcachtinh();
                $this->findloaiphucap();
                $this->setLayout('themloaiphucap');
                break;
            case 'ds_phucaplinhvuc':
                $this->setLayout('danhsach_phucaplinhvuc');
                break;
            case 'table_phucaplinhvuc':
                $this->getallloaiphucap();
                $this->timkiemphucaplinhvuc();
                $this->setLayout('table_phucaplinhvuc');
                break;
            case 'themmoiphucaplinhvuc':
                $this->getallloaiphucap();
                $this->setLayout('themphucaplinhvuc');
                break;
            case 'chinhsuaphucaplinhvuc':
                $this->getallloaiphucap();
                $this->findphucaplinhvuc();
                $this->setLayout('themphucaplinhvuc');
                break;
            case 'ds_hinhthuc_nangluongchuyenngach':
                $this->setLayout('ds_hinhthuc_nangluongchuyenngach');
                break;
            case 'table_hinhthucnangluongchuyenngach':
                $this->timkiem_hinhthucnangluongchuyenngach();
                $this->setLayout('table_hinhthucnangluongchuyenngach');
                break;
            case 'themmoihinhthucnangluongchuyenngach':
                $this->setLayout('themmoihinhthucnangluongchuyenngach');
                break;
            case 'chinhsuahinhthucnangluongchuyenngach':
                $this->find_hinhthuc_nlcn();
                $this->setLayout('themmoihinhthucnangluongchuyenngach');
                break;
            case 'ds_thuetncn':
                $this->setLayout('ds_thuetncn');
                break;
            case 'table_thuetncn':
                $this->getall_thuetncn();
                $this->setLayout('table_thuetncn');
                break;
            case 'themmoithuetncn':
                $this->setLayout('themthuetncn');
                break;
            case 'chinhsuathuetncn':
                $this->find_thuetncn();
                $this->setLayout('themthuetncn');
                break;
            case 'ds_quanly_ngachbac':
                $this->setLayout('ds_quanly_ngachbac');
                break;
            case 'tree_quanly_ngachbac':
                $this->tree_quanly_ngachbac();
                break;
            case 'table_thongtin_nhomngach':
                $this->find_nhomngach_by_id();
                $this->setLayout('table_thongtin_nhomngach');
                break;
            case 'table_thongtin_ngach':
                // $this->find_ngach_by_id();
                $this->find_cb_bac_heso_by_manhom();
                $this->setLayout('table_thongtin_ngach');
                break;
            case 'themmoi_thongtin_ngach':
                $this->getall_nganh();
                $this->find_ngach_by_ma_nhom();
                $this->setLayout('themmoi_thongtin_ngach');
                break;
            case 'chinhsua_thongtin_ngach':
                $this->find_thongtin_ngach_by_id();
                $this->getall_nganh();
                $this->find_ngach_by_ma_nhom();
                $this->setLayout('themmoi_thongtin_ngach');
                break;
            default:
                $this->_initDefault();
                $this->setLayout('default');
                break;
        }
        parent::display($tpl1);
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
    function timkiemluongcoso(){
        $timkiem_luong = JRequest::getVar('ten');
        $model = Core::model('Danhmuckieubao/Luongcoso');
        $result = $model->findluongcosobyname($timkiem_luong);
        $this->assignRef('ds_luongcoso', $result);
    }
    function findluongcoso(){
        $id = JRequest::getVar('id');
        $model = Core::model('Danhmuckieubao/Luongcoso');
        $kq = $model->findluongcoso($id);
        //var_dump($kq);die;
        $this->assignRef('luongcoso', $kq);
    }
    function timkiemdvtpc(){
        $timkiem_tendvtpc= JRequest::getVar('ten');
        $model = Core::model('Danhmuckieubao/Donvitinhphucap');
        $result = $model->finddvtpcbyname($timkiem_tendvtpc);
        $this->assignRef('ds_dvtpc', $result);
    }
    function finddvtpc(){
        $id = JRequest::getVar('id');
        $model = Core::model('Danhmuckieubao/Donvitinhphucap');
        $kq = $model->finddvtpc($id);
        //var_dump($kq);die;
        $this->assignRef('dvtpc', $kq);
    }
    function timkiemctpc(){
        $timkiem_tendvtpc= JRequest::getVar('ten');
        $model = Core::model('Danhmuckieubao/Cachtinhphucap');
        $result = $model->findctpcbyname($timkiem_tendvtpc);
        $this->assignRef('ds_ctpc', $result);
    }
    function findctpc(){
        $id = JRequest::getVar('id');
        $model = Core::model('Danhmuckieubao/Cachtinhphucap');
        $kq = $model->findctpc($id);
        //var_dump($kq);die;
        $this->assignRef('ctpc', $kq);
    }
    function timkiemloaiphucap(){
        $timkiem_tenloaiphucap= JRequest::getVar('ten');
        $model = Core::model('Danhmuckieubao/Loaiphucap');
        $result = $model->findloaiphucapbyname($timkiem_tenloaiphucap);
        $this->assignRef('ds_loaiphucap', $result);
    }
    function getalldonvitinh(){
        $model = Core::model('Danhmuckieubao/Loaiphucap');
        $result = $model->getalldonvitinh();
        $this->assignRef('ds_donvitinh', $result);
    }
    function getallcachtinh(){
        $model = Core::model('Danhmuckieubao/Loaiphucap');
        $result = $model->getallcachtinh();
        $this->assignRef('ds_cachtinh', $result);
    }
    function findloaiphucap(){
        $id = JRequest::getVar('id');
        $model = Core::model('Danhmuckieubao/Loaiphucap');
        $kq = $model->findloaiphucap($id);
        //var_dump($kq);die;
        $this->assignRef('loaiphucap', $kq);
    }
    function timkiemphucaplinhvuc(){
        $timkiem_tenphucaplinhvuc= JRequest::getVar('ten');
        $model = Core::model('Danhmuckieubao/Phucaplinhvuc');
        $result = $model->findPhucaplinhvucbyname($timkiem_tenphucaplinhvuc);
        $this->assignRef('ds_phucaplinhvuc', $result);
    }
    function getallloaiphucap(){
        $model = Core::model('Danhmuckieubao/Phucaplinhvuc');
        $result = $model->getallloaiphucap();
        $this->assignRef('ds_loaiphucap', $result);
    }
    function findphucaplinhvuc(){
        $id = JRequest::getVar('id');
        $model = Core::model('Danhmuckieubao/Phucaplinhvuc');
        $kq = $model->findphucaplinhvuc($id);
        //var_dump($kq);die;
        $this->assignRef('phucaplinhvuc', $kq);
    }
    public function timkiem_hinhthucnangluongchuyenngach(){
        $jinput = JFactory::getApplication()->input;
        $ten_hinhthuc_nlcn = $jinput->getString('ten_hinhthuc_nlcn','');
        $model = Core::model('Danhmuchethong/Hinhthucnangluongchuyenngach');
        $this->assignRef('ds_hinhthucnangluongchuyenngach', $model->timkiem_hinhthucnangluongchuyenngach($ten_hinhthuc_nlcn));
    }
    public function find_hinhthuc_nlcn(){
        $jinput = JFactory::getApplication()->input;
        $id = $jinput->getInt('id',0);
        $model = Core::model('Danhmuchethong/Hinhthucnangluongchuyenngach');
        $this->assignRef('hinhthucnangluongchuyenngach', $model->find_hinhthuc_nlcn($id));
    }
    public function getall_thuetncn(){
        $model = Core::model('Danhmuchethong/Thuethunhapcanhan');
        // echo '1231';die;
        $this->assignRef('ds_thuetncn', $model->getall_thuetncn());
    }
    public function find_thuetncn(){
        $jinput = JFactory::getApplication()->input;
        $id = $jinput->getInt('id',0);
        $model = Core::model('Danhmuchethong/Thuethunhapcanhan');
        $this->assignRef('thuetncn',$model->find_thuetncn($id));
    }
    public function tree_quanly_ngachbac(){
        $jinput = JFactory::getApplication()->input;
        $root_id = $jinput->getString('root_id','');
        $id = $jinput->getString('id','');
        $model = Core::model('Danhmuchethong/Ngachbac');
        echo ($model->tree_quanly_ngachbac($id));die;
    }
    public function find_nhomngach_by_id(){
        $jinput = JFactory::getApplication()->input;
        $id = $jinput->getInt('id',0);
        if($id>0){
            $model = Core::model('Danhmuchethong/Ngachbac');
            $this->assignRef('ngachbac',$model->find_nhomngach_by_id($id));
        }
    }
    // public function find_ngach_by_id(){
    //     $jinput = JFactory::getApplication()->input;
    //     $id = $jinput->getInt('id',0);
    //     if($id>0){
    //         $model = Core::model('Danhmuchethong/Ngachbac');
    //         $this->assignRef('ngachbac',$model->find_ngach_by_id($id));
    //     }
    // }
    public function getall_nganh(){
        $model = Core::model('Danhmuchethong/Ngachbac');
        $this->assignRef('ds_nganh',$model->getall_nganh());
    }
    public function find_ngach_by_ma_nhom(){
        $jinput = JFactory::getApplication()->input;
        $id = $jinput->getInt('id',0);
        if($id>0){
            $model = Core::model('Danhmuchethong/Ngachbac');
            $this->assignRef('ds_ngach',$model->find_ngach_by_ma_nhom($id));
        }
    }
    public function find_cb_bac_heso_by_manhom(){
        $jinput = JFactory::getApplication()->input;
        $id = $jinput->getInt('id',0);
        if($id>0){
            $model = Core::model('Danhmuchethong/Ngachbac');
            $this->assignRef('ds_cb_bac_heso',$model->find_cb_bac_heso_by_manhom($id));
        }
    }
    public function find_thongtin_ngach_by_id(){
        $jinput = JFactory::getApplication()->input;
        $id_ngach = $jinput->getInt('id_ngach',0);
        if($id_ngach>0){
            $model = Core::model('Danhmuchethong/Ngachbac');
            $this->assignRef('cb_bac_heso',$model->find_thongtin_ngach_by_id($id_ngach));
        }
    }
}