<?php 
	class DanhmucViewTochuc extends JViewLegacy{
		function display($tpl=null){
            $task = JRequest::getVar('task');
			switch($task){
                case 'default':
                    $this->setLayout('default');
                    break;
                case 'ds_hinhthucphanhangdonvi':
                    $this->setLayout('ds_hinhthucphanhangdonvi');
                    break;
                case 'table_htphdv':
                    $this->timkiemhtphdv();
                    $this->setLayout('table_htphdv');
                    break;
                case 'themmoihtphdv':
                    $this->setLayout('themmoihinhthucphanhangdonvi');
                    break;
                case 'chinhsuahtphdv':
                    $this->findhtphdv();
                    $this->setLayout('themmoihinhthucphanhangdonvi');
                    break;
                case 'ds_hangdonvisunghiep':
                    $this->setLayout('ds_hangdonvisunghiep');
                    break;
                case 'table_hdvsn':
                    $this->timkiemhdvsn();
                    $this->setLayout('table_hdvsn');
                    break;
                case 'themmoihdvsn':
                    $this->setLayout('themmoihangdonvisunghiep');
                    break;
                case 'chinhsuahdvsn':
                    $this->findhdvsn();
                    $this->setLayout('themmoihangdonvisunghiep');
                    break;
                case 'ds_linhvucbaocao':
                    $this->setLayout('ds_linhvucbaocao');
                    break;
                case 'table_linhvucbaocao':
                    $this->timkiemlinhvucbaocaobyname();
                    $this->setLayout('table_linhvucbaocao');
                    break;
                case 'themmoilinhvucbaocao':
                    $this->setLayout('themmoilinhvucbaocao');
                    break;
                case 'sualinhvucbaocao':
                    $this->findlinhvucbaocao();
                    $this->setLayout('themmoilinhvucbaocao');
                    break;
                case 'ds_tochucdang':
                    $this->setLayout('ds_tochucdang');
                    break;
                case 'table_tochucdang':
                    $this->timkiem_tochucdang_byname();
                    $this->setLayout('table_tochucdang');
                    break;
                case 'themmoitochucdang':
                    $this->setLayout('themmoitochucdang');
                    break;
                case 'chinhsuatochucdang':
                    $this->findtochucdang();
                    $this->setLayout('themmoitochucdang');
                    break;
                case 'ds_tochucdoan':
                    $this->setLayout('ds_tochucdoan');
                    break;
                case 'table_tochucdoan':
                    $this->timkiem_tochucdoan_byname();
                    $this->setLayout('table_tochucdoan');
                    break;
                case 'themmoitochucdoan':
                    $this->setLayout('themmoitochucdoan');
                    break;
                case 'chinhsuatochucdoan':
                    $this->findtochucdoan();
                    $this->setLayout('themmoitochucdoan');
                    break;
                case 'ds_tochucdoanthekhac':
                    $this->setLayout('ds_tochucdoanthekhac');
                    break;
                case 'table_tochucdoanthekhac':
                    $this->timkiem_tochucdoanthekhac_byname();
                    $this->setLayout('table_tochucdoanthekhac');
                    break;
                case 'themmoitochucdoanthekhac':
                    $this->setLayout('themmoitochucdoanthekhac');
                    break;
                case 'chinhsuatochucdoanthekhac':
                    $this->findtochucdoanthekhac();
                    $this->setLayout('themmoitochucdoanthekhac');
                    break;
                case 'ds_goibienche':
                    $this->setLayout('ds_goibienche');
                    break;
                case 'table_goibienche':
                    $this->getall_goibienche();
                    $this->setLayout('table_goibienche');
                    break;
                case 'table_bienche_hinhthuc':
                    $this->getall_bienche_hinhthuc();
                    $this->setLayout('table_bienche_hinhthuc');
                    break;
                case 'ds_goihinhthuchuongluong':
                    $this->setLayout('ds_goihinhthuchuongluong');
                    break;
                case 'table_goihinhthuchuongluong':
                    $this->getall_goihinhthuchuongluong();
                    $this->setLayout('table_goihinhthuchuongluong');
                    break;
                case 'table_goihthl_htnl':
                    $this->getall_hinhthucnangluong();
                    $this->setLayout('table_goihthl_htnl');
                    break;
                case 'ds_goidaotaoboiduong':
                    $this->setLayout('ds_goidaotaoboiduong');
                    break;
                case 'table_goidaotaoboiduong':
                    $this->getall_goidaotaoboiduong();
                    $this->setLayout('table_goidaotaoboiduong');
                    break;
                case 'table_goidtbd_ltd':
                    $this->getall_goidaotaoboiduong_ltd();
                    $this->setLayout('table_goidtbd_ltd');
                    break;
                case 'ds_goivitrituyendung':
                    $this->findroot_id();
                    $this->getall_function_code();
                    $this->setLayout('ds_goivitrituyendung');
                    break;
                case 'treeGoivitrituyendung':
                    $this->treeGoivitrituyendung();
                    break;
                case 'ds_goiluong':
                    $this->findroot_id_goiluong();
                    $this->getall_function_code();
                    $this->setLayout('ds_goiluong');
                    break;
                case 'treeGoiluong':
                     $this->treeGoiluong();
                    break;
                case 'ds_goichucvu':
                    $this->findroot_id_goichucvu();
                    $this->setLayout('ds_goichucvu');
                    break;
                case 'treeGoichucvu':
                    $this->treeGoichucvu();
                    break;
                case 'table_goichucvu':
                    $this->getall_capbonhiem();
                    $this->find_chucvu_by_idgoichucvu();
                    $this->findroot_id_chucvu();
                    $this->setLayout('table_goichucvu');
                    break;
                case 'treeChucvu':
                    $this->treeChucvu();
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
        public function timkiemhtphdv(){
            $jinput = JFactory::getApplication()->input;
            $tk_tenhtphdv = $jinput->getString('tk_tenhtphdv','');
            $model = Core::model('Danhmuckieubao/Hinhthucphanhangdonvi');
            $this->assignRef('ds_htphdv',$model->findhtphdvbyname($tk_tenhtphdv));
        }
        public function findhtphdv(){
            $jinput = JFactory::getApplication()->input;
            $id_htphdv = $jinput->getString('id_htphdv','');
            $model = Core::model('Danhmuckieubao/Hinhthucphanhangdonvi');
            $this->assignRef('htphdv',$model->findhtphdv($id_htphdv));
        }
        public function timkiemhdvsn(){
            $jinput = JFactory::getApplication()->input;
            $tk_tenhdvsn = $jinput->getString('tk_tenhdvsn','');
            $model = Core::model('Danhmuchethong/Hangdonvisunghiep');
            $this->assignRef('ds_hdvsn',$model->findhdvsnbyname($tk_tenhdvsn));
        }
        public function findhdvsn(){
            $jinput = JFactory::getApplication()->input;
            $id_hdvsn = $jinput->getString('id_hdvsn','');
            $model = Core::model('Danhmuchethong/Hangdonvisunghiep');
            $this->assignRef('hdvsn',$model->findhdvsn($id_hdvsn));
        }
        public function timkiemlinhvucbaocaobyname(){
            $jinput = JFactory::getApplication()->input;
            $tk_ten_lvbc = $jinput->getString('tk_ten_lvbc','');
            $tk_trangthai_lvbc = $jinput->getString('tk_trangthai_lvbc','');
            $model = Core::model('Danhmuc/Linhvucbaocao');
            $ds_linhvucbaocao = $model->timkiemlinhvucbaocaobyname($tk_ten_lvbc,$tk_trangthai_lvbc);
            // var_dump($ds_linhvucbaocao);die;
            $this->assignRef('ds_linhvucbaocao',$ds_linhvucbaocao);
        }
        public function findlinhvucbaocao(){
            $jinput = JFactory::getApplication()->input;
            $id = $jinput->getInt('id',0);
            if($id>0){
                $model = Core::model('Danhmuc/Linhvucbaocao');
                $this->assignRef('linhvucbaocao',$model->findlinhvucbaocao($id));
            }
        }
        public function timkiem_tochucdang_byname(){
            $jinput = JFactory::getApplication()->input;
            $tk_tentochucdang = $jinput->getString('tk_tentochucdang','');
            $model = Core::model('Danhmuchethong/Tochucdang');
            $this->assignRef('ds_tochucdang',$model->timkiem_tochucdang_byname($tk_tentochucdang));
        }
        public function findtochucdang(){
            $jinput = JFactory::getApplication()->input;
            $id_tochucdang = $jinput->getInt('id_tochucdang',0);
            if($id_tochucdang>0){
                $model = Core::model('Danhmuchethong/Tochucdang');
                $this->assignRef('tochucdang',$model->findtochucdang($id_tochucdang));
            }
        }
        public function timkiem_tochucdoan_byname(){
            $jinput = JFactory::getApplication()->input;
            $tk_tentochucdoan = $jinput->getString('tk_tentochucdoan','');
            $model = Core::model('Danhmuchethong/Tochucdoan');
            $this->assignRef('ds_tochucdoan',$model->timkiem_tochucdoan_byname($tk_tentochucdoan));
        }
        public function findtochucdoan(){
            $jinput = JFactory::getApplication()->input;
            $id_tochucdoan = $jinput->getInt('id_tochucdoan',0);
            if($id_tochucdoan>0){
                $model = Core::model('Danhmuchethong/Tochucdoan');
                $this->assignRef('tochucdoan',$model->findtochucdoan($id_tochucdoan));
            }
        }
        public function timkiem_tochucdoanthekhac_byname(){
            $jinput = JFactory::getApplication()->input;
            $tk_tentochucdoanthekhac = $jinput->getString('tk_tentochucdoanthekhac','');
            $model = Core::model('Danhmuchethong/Tochucdoanthekhac');
            $this->assignRef('ds_tochucdoanthekhac',$model->timkiem_tochucdoanthekhac_byname($tk_tentochucdoanthekhac));
        }
        public function findtochucdoanthekhac(){
            $jinput = JFactory::getApplication()->input;
            $id_tochucdoanthekhac = $jinput->getInt('id_tochucdoanthekhac',0);
            if($id_tochucdoanthekhac>0){
                $model = Core::model('Danhmuchethong/Tochucdoanthekhac');
                $this->assignRef('tochucdoanthekhac',$model->findtochucdoanthekhac($id_tochucdoanthekhac));
            }
        }
        public function getall_goibienche(){
            $model = Core::model('Danhmuchethong/Goibienche');
            $this->assignRef('ds_goibienche',$model->getall_goibienche());
        }
        public function getall_bienche_hinhthuc(){
            $model = Core::model('Danhmuchethong/Goibienche');
            $this->assignRef('ds_bienche_hinhthuc',$model->getall_bienche_hinhthuc());
        }
        public function getall_goihinhthuchuongluong(){
            $model = Core::model('Danhmuchethong/Goihinhthuchuongluong');
            $this->assignRef('ds_goihinhthuchuongluong',$model->getall_goihinhthuchuongluong());
        }
        public function getall_hinhthucnangluong(){
            $model = Core::model('Danhmuchethong/Goihinhthuchuongluong');
            $this->assignRef('ds_hinhthucnangluong',$model->getall_hinhthucnangluong());
        }
        public function getall_goidaotaoboiduong(){
            $model = Core::model('Danhmuchethong/Goidaotaoboiduong');
            $this->assignRef('ds_goidaotaoboiduong',$model->getall_goidaotaoboiduong());
        }
        public function getall_goidaotaoboiduong_ltd(){
            $model = Core::model('Danhmuchethong/Goidaotaoboiduong');
            $this->assignRef('ds_goidaotaoboiduong_ltd',$model->getall_goidaotaoboiduong_ltd());
        }
        public function findroot_id(){
            $model = Core::model('Danhmuchethong/Goivitrituyendung');
            $this->assignRef('root_id',$model->findroot_id());
        }
        public function getall_function_code(){
            $model = Core::model('Danhmuchethong/Goivitrituyendung');
            $this->assignRef('ds_function_code',$model->getall_function_code());
        }
        public function treeGoivitrituyendung(){
            $jinput = JFactory::getApplication()->input;
            $root_id = $jinput->getString('root_id','');
            $id = $jinput->getString('id','');
            $model = Core::model('Danhmuchethong/Goivitrituyendung');
            echo $model->tree_goivitrituyendung($id);die;
        }
        public function findroot_id_goiluong(){
            $model = Core::model('Danhmuchethong/Goiluong');
            $this->assignRef('root_id',$model->findroot_id());
        }
        public function treeGoiluong(){
            $jinput = JFactory::getApplication()->input;
            $root_id = $jinput->getString('root_id','');
            $id = $jinput->getString('id','');
            $model = Core::model('Danhmuchethong/Goiluong');
            echo $model->tree_goiluong($id);die;
        }
        public function findroot_id_goichucvu(){
            $model = Core::model('Danhmuchethong/Goichucvu');
            $this->assignRef('root_id',$model->findroot_id());
        }
        public function treeGoichucvu(){ 
            $jinput = JFactory::getApplication()->input;
            $root_id = $jinput->getString('root_id','');
            $id = $jinput->getString('id','');
            $model = Core::model('Danhmuchethong/Goichucvu');
            echo $model->tree_goichucvu($id);die;
        }
        public function find_chucvu_by_idgoichucvu(){
            $jinput = JFactory::getApplication()->input;
            $id = $jinput->getInt('id',0);
            if($id>0){
                $model = Core::model('Danhmuchethong/Goichucvu');
                $this->assignRef('ds_chucvu',$model->find_chucvu_by_idgoichucvu($id));
            }
        }
        public function getall_capbonhiem(){
            $model = Core::model('Danhmuchethong/Goichucvu');
            $this->assignRef('ds_capbonhiem',$model->getall_capbonhiem());
        }
        public function findroot_id_chucvu(){
            $model = Core::model('Danhmuchethong/Goichucvu');
            $this->assignRef('root_id_chucvu',$model->findroot_id_chucvu());
        }
        public function treeChucvu(){
            $jinput = JFactory::getApplication()->input;
            $root_id_chucvu = $jinput->getString('root_id_chucvu','');
            $id = $jinput->getString('id','');
            $model = Core::model('Danhmuchethong/Goichucvu');
            echo $model->tree_chucvu($id);die;
        }
	}
?>