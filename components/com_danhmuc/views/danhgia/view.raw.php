<?php
	defined('_JEXEC') or die('Restricted access');
	class DanhmucViewDanhgia extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				case 'default':
					$this->setLayout('default');
					break;
				case 'ds_nhomtieuchi':
					$this->setLayout('ds_nhomtieuchi');
					break;
				case 'table_nhomtieuchi':
					$this->timkiemnhomtieuchi();
					$this->setLayout('table_nhomtieuchi');
					break;
				case 'themmoinhomtieuchi':
					$this->setLayout('themmoinhomtieuchi');
					break;
				case 'chinhsuanhomtieuchi':
					$this->findnhomtieuchi();
					$this->setLayout('themmoinhomtieuchi');
					break;
				case 'ds_tieuchi':
					$this->getall_nhomtieuchi();
					$this->setLayout('ds_tieuchi');
					break;
				case 'table_tieuchi':
					$this->timkiemtieuchi();
					$this->setLayout('table_tieuchi');
					break;
				case 'themmoitieuchi':
					$this->getallnhomtieuchi();
					$this->setLayout('themmoitieuchi');
					break;
				case 'chinhsuatieuchi':
					$this->getallnhomtieuchi();
					$this->findtieuchi();
					$this->setLayout('themmoitieuchi');
					break;
				case 'ds_loaicongviec':
					$this->setLayout('ds_loaicongviec');
					break;
				case 'table_loaicongviec':
					$this->timkiem_loaicongviec_byname();
					$this->setLayout('table_loaicongviec');
					break;
				case 'themmoi_loaicongviec':
					$this->getall_dotdanhgia();
					$this->setLayout('themmoi_loaicongviec');
					break;
				case 'chinhsua_loaicongviec':
					$this->getall_dotdanhgia();
					$this->find_loaicongviec();
					$this->setLayout('themmoi_loaicongviec');
					break;
				case 'ds_errorsql':
					$this->setLayout('ds_errorsql');
					break;
				case 'table_errorsql':					
					$this->setLayout('table_errorsql');
					break;
				case 'loadTable':
					$this->load_danhsach_errorsql();
					break;
				case 'ds_loaingaynghi':
					$this->setLayout('ds_loaingaynghi');
					break;
				case 'table_loaingaynghi':
					$this->timkiem_loaingaynghi_byname();
					$this->setLayout('table_loaingaynghi');
					break;
				case 'themmoi_loaingaynghi':
					$this->setLayout('themmoi_loaingaynghi');
					break;
				case 'chinhsua_loaingaynghi':
					$this->find_loaingaynghi();
					$this->setLayout('themmoi_loaingaynghi');
					break;
				case 'ds_dieukienlamviec':
					$this->setLayout('ds_dieukienlamviec');
					break;
				case 'table_dieukienlamviec':
					$this->timkiem_dieukienlamviec_byname();
					$this->setLayout('table_dieukienlamviec');
					break;
				case 'themmoi_dieukienlamviec':
					$this->setLayout('themmoi_dieukienlamviec');
					break;
				case 'chinhsua_dieukienlamviec':
					$this->find_dieukienlamviec();
					$this->setLayout('themmoi_dieukienlamviec');
					break;
				case 'ds_lydocongviecfail':
					$this->setLayout('ds_lydocongviecfail');
					break;
				case 'table_lydocongviecfail':
					$this->timkiem_lydocongviecfail_byname();
					$this->setLayout('table_lydocongviecfail');
					break;
				case 'themmoi_lydocongviecfail':
					$this->setLayout('themmoi_lydocongviecfail');
					break;
				case 'chinhsua_lydocongviecfail':
					$this->find_lydocongviecfail();
					$this->setLayout('themmoi_lydocongviecfail');
					break;
				case 'ds_mucdothuongxuyen':
					$this->setLayout('ds_mucdothuongxuyen');
					break;
				case 'table_mucdothuongxuyen':
					$this->timkiem_mucdothuongxuyen_byname();
					$this->setLayout('table_mucdothuongxuyen');
					break;
				case 'themmoi_mucdothuongxuyen':
					$this->setLayout('themmoi_mucdothuongxuyen');
					break;
				case 'chinhsua_mucdothuongxuyen':
					$this->find_mucdothuongxuyen();
					$this->setLayout('themmoi_mucdothuongxuyen');
					break;
				case 'ds_tinhchat':
					$this->setLayout('ds_tinhchat');
					break;
				case 'table_tinhchat':
					$this->timkiem_tinhchat_byname();
					$this->setLayout('table_tinhchat');
					break;
				case 'themmoi_tinhchat':
					$this->setLayout('themmoi_tinhchat');
					break;
				case 'chinhsua_tinhchat':
					$this->find_tinhchat();
					$this->setLayout('themmoi_tinhchat');
					break;
				case 'ds_xeploaicongviec':
					$this->setLayout('ds_xeploaicongviec');
					break;
				case 'table_xeploaicongviec':
					$this->timkiem_xeploaicongviec_byname();
					$this->setLayout('table_xeploaicongviec');
					break;
				case 'themmoi_xeploaicongviec':
					$this->setLayout('themmoi_xeploaicongviec');
					break;
				case 'chinhsua_xeploaicongviec':
					$this->find_xeploaicongviec();
					$this->setLayout('themmoi_xeploaicongviec');
					break;
				case 'ds_xeploaichatluong':
					$this->setLayout('ds_xeploaichatluong');
					break;
				case 'table_xeploaichatluong':
					$this->timkiem_xeploaichatluong_byname();
					$this->setLayout('table_xeploaichatluong');
					break;
				case 'themmoi_xeploaichatluong':
					$this->getall_dotdanhgia();
					$this->setLayout('themmoi_xeploaichatluong');
					break;
				case 'chinhsua_xeploaichatluong':
					$this->getall_dotdanhgia();
					$this->find_xeploaichatluong();
					$this->setLayout('themmoi_xeploaichatluong');
					break;
				case 'ds_theonhiemvu':
					$this->setLayout('ds_theonhiemvu');
					break;
				case 'table_theonhiemvu':
					$this->find_theonhiemvu_byname();
					$this->setLayout('table_theonhiemvu');
					break;
				case 'themmoi_theonhiemvu':
					$this->getall_dgcbcc_tieuchuan();
					$this->setLayout('themmoi_theonhiemvu');
					break;
				case 'chinhsua_theonhiemvu':
					$this->getall_dgcbcc_tieuchuan();
					$this->find_dgcbcc_nhiemvu_byid();
					$this->find_dgcbcc_fk_nhiemvu_tieuchuan_byidnhiemvu();
					$this->setLayout('themmoi_theonhiemvu');
					break;
				case 'ds_theotieuchuan':
					$this->setLayout('ds_theotieuchuan');
					break;
				case 'table_theotieuchuan':
					$this->find_theotieuchuan_byname();
					$this->getall_loaicongviec();
					$this->setLayout('table_theotieuchuan');
					break;
				case 'themmoi_theotieuchuan':
					$this->getall_loaicongviec();
					$this->getall_dgcbcc_nhiemvu();
					$this->setLayout('themmoi_theotieuchuan');
					break;
				case 'chinhsua_theotieuchuan':
					$this->find_dgcbcc_tieuchuan_byid();
					$this->find_dgcbcc_fk_nhiemvu_tieuchuan_byidtieuchuan();
					$this->find_dgcbcc_fk_nhiemvu_tieuchuan_danhgiacho_byidtieuchuan();
					$this->getall_loaicongviec();
					$this->getall_dgcbcc_nhiemvu();
					$this->setLayout('themmoi_theotieuchuan');
					break;
				case 'ds_botieuchi':
					$this->getall_dgcbcc_nhiemvu();
					$this->findroot_id_botieuchi();
					$this->setLayout('ds_botieuchi');
					break;
				case 'tree_botieuchi':
					$this->tree_botieuchi();
					break;
				case 'saochep_botieuchi':
					$this->getall_botieuchi();
					$this->setLayout('saochep_botieuchi');
					break;
				case 'themmoi_botieuchi':
					$this->getall_dgcbcc_tieuchuan();
					$this->getall_dgcbcc_nhiemvu();
					$this->getallnhomtieuchi();
					$this->getall_loaicongviec();
					$this->getall_botieuchi();
					$this->getall_xeploai();
					$this->getall_dgcbcc_phanloai();
					$this->setLayout('themmoi_botieuchi');
					break;
				case 'chinhsua_botieuchi':
					$this->getall_dgcbcc_tieuchuan();
					$this->getall_dgcbcc_nhiemvu();
					$this->getallnhomtieuchi();
					$this->getall_loaicongviec();
					$this->getall_botieuchi();
					$this->getall_xeploai();
					$this->find_botieuchi_by_id();
					$this->getall_dgcbcc_phanloai();
					$this->setLayout('themmoi_botieuchi');
					break;
				case 'ds_dotdanhgia':
					$this->getall_dotdanhgia();
					$this->setLayout('ds_dotdanhgia');
					break;
				case 'table_dotdanhgia':
					$this->timkiem_dotdanhgia_by_datedot();
					$this->setLayout('table_dotdanhgia');
					break;
				case 'themmoi_dotdanhgia':
					$this->getall_botieuchi();
					$this->setLayout("themmoi_dotdanhgia");
					break;
				case 'chinhsua_dotdanhgia':
					$this->find_dotdanhgia_by_id();
					$this->getall_botieuchi();
					$this->setLayout('themmoi_dotdanhgia');
					break;
				case 'ds_mucdophuctap_xeploai':
					$this->getall_dotdanhgia();
					$this->setLayout('ds_mucdophuctap_xeploai');
					break;
				case 'table_mucdophuctap_xeploai':
					$this->find_mucdophuctap_by_id_dotdanhgia();
					$this->setLayout('table_mucdophuctap_xeploai');
					break;
				case 'themmoi_mucdophuctap':
					$this->getall_dotdanhgia();
					$this->setLayout('themmoi_mucdophuctap');
					break;
				case 'chinhsua_mucdophuctap':
					$this->find_mucdophuctap_byid();
					$this->getall_dotdanhgia();
					$this->setLayout('themmoi_mucdophuctap');
					break;
				case 'ds_mucdothamgia':
					$this->setLayout('ds_mucdothamgia');
					break;
				case 'table_mucdothamgia':
					$this->timkiem_mucdothamgia_byname();
					$this->setLayout('table_mucdothamgia');
					break;
				case 'themmoi_mucdothamgia':
					$this->setLayout('themmoi_mucdothamgia');
					break;
				case 'chinhsua_mucdothamgia':
					$this->find_mucdothamgia_byid();
					$this->setLayout('themmoi_mucdothamgia');
					break;
				case 'ds_tiendo_xeploai':
					$this->getall_dotdanhgia();
					$this->setLayout('ds_tiendo_xeploai');
					break;
				case 'table_tiendo_xeploai':
					$this->find_tiendo_by_id_dotdanhgia();
					$this->setLayout('table_tiendo_xeploai');
					break;
				case 'themmoi_tiendo_xeploai':
					$this->getall_dotdanhgia();
					$this->setLayout('themmoi_tiendo_xeploai');
					break;
				case 'chinhsua_tiendo_xeploai':
					$this->find_tiendo_byid();
					$this->getall_dotdanhgia();
					$this->setLayout('themmoi_tiendo_xeploai');
					break;
				case 'ds_xeploai':
					$this->getall_dotdanhgia();
					$this->setLayout('ds_xeploai');
					break;
				case 'table_xeploai':
					$this->find_xeploai_by_id_dotdanhgia();
					$this->setLayout('table_xeploai');
					break;
				case 'themmoi_xeploai':
					$this->getall_dotdanhgia();
					$this->setLayout('themmoi_xeploai');
					break;
				case 'chinhsua_xeploai':
					$this->find_xeploai_byid();
					$this->getall_dotdanhgia();
					$this->setLayout('themmoi_xeploai');
					break;
				case 'ds_partitions':
					$this->setLayout('ds_partitions');
					break;
				case 'table_partitions':
					$this->find_partitions_by_table();
					$this->setLayout('table_partitions');
					break;
				case 'themmoi_partition':
					$this->setLayout('themmoi_partition');
					break;
				case 'chinhsua_partition':
					$this->find_partition_by_id();
					$this->setLayout('themmoi_partition');
					break;
				case 'ds_tieuchi_liet':
					$this->setLayout('ds_tieuchi_liet');
					break;
				case 'table_tieuchi_liet':
					$this->find_tieuchi_phanloai_byname();
					$this->setLayout('table_tieuchi_liet');
					break;
				case 'themmoi_tieuchi_liet':
					$this->getall_dgcbcc_dg_theonhiemvu();
					$this->getall_dotdanhgia();
					$this->setLayout('themmoi_tieuchi_liet');
					break;
				case 'chinhsua_tieuchi_liet':
					$this->getall_dgcbcc_dg_theonhiemvu();
					$this->getall_dotdanhgia();
					$this->find_tieuchi_phanloai_byid();
					$this->setLayout('themmoi_tieuchi_liet');
					break;
				case 'ds_tieuchi_donvi':
						$this->getall_donvi();
						$this->getall_dotdanhgia_thang();
						$this->findroot_id_botieuchi();
						$this->setLayout('ds_tieuchi_donvi');
						break;
				case 'change_tieuchi_donvi':
					$this->getall_dotdanhgia_thang();
					$this->setLayout('change_tieuchi_donvi');
						break;
				default:
					break;
			}
			parent::display($tpl);
		}
		public function timkiemnhomtieuchi(){
			$jinput = JFactory::getApplication()->input;
			$tk_tennhomtieuchi = $jinput->getString('ten','');
			$model = Core::model('Danhmuchethong/Nhomtieuchi');
			$ds_nhomtieuchi = $model->findnhomtieuchibyname($tk_tennhomtieuchi);
			$this->assignRef('ds_nhomtieuchi',$ds_nhomtieuchi);
		}
		public function findnhomtieuchi(){
			$jinput = JFactory::getApplication()->input;
			$tk_idnhomtieuchi = $jinput->getString('ntc_id','');
			$model = Core::model('Danhmuchethong/Nhomtieuchi');
			$nhomtieuchi = $model->findnhomtieuchibyid($tk_idnhomtieuchi);
			$this->assignRef('nhomtieuchi',$nhomtieuchi);
		}
		public function timkiemtieuchi(){
			$jinput = JFactory::getApplication()->input;
			$tk_tentieuchi = $jinput->getString('ten','');
			$nhomtieuchi = $jinput->getInt('nhomtieuchi',0);
			$model = Core::model('Danhmuchethong/Tieuchi');
			$ds_tieuchi = $model->findtieuchibyname($tk_tentieuchi,$nhomtieuchi);
			$this->assignRef('ds_tieuchi',$ds_tieuchi);
		}
		public function getall_nhomtieuchi(){
        	$model = Core::model('Danhmuchethong/Tieuchi');
			$this->assignRef('ds_nhomtieuchi',$model->getallnhomtieuchi());
        }
		public function findtieuchi(){
			$jinput = JFactory::getApplication()->input;
			$tk_idtieuchi = $jinput->getString('tc_id','');
			$model = Core::model('Danhmuchethong/Tieuchi');
			$tieuchi = $model->findtieuchibyid($tk_idtieuchi);
			$this->assignRef('tieuchi',$tieuchi);
		}
		public function getallnhomtieuchi(){
			$model = Core::model('Danhmuchethong/Tieuchi');
			$ds_nhomtieuchi = $model->getallnhomtieuchi();
			$this->assignRef('ds_nhomtieuchi',$ds_nhomtieuchi);
		}
		public function timkiem_loaicongviec_byname(){
			$jinput = JFactory::getApplication()->input;
			$tk_loaicongviec_name = $jinput->getString('tk_loaicongviec_name','');
			$model = Core::model('Danhmuchethong/Loaicongviec');
			$this->assignRef('ds_loaicongviec',$model->timkiem_loaicongviec_byname($tk_loaicongviec_name));
		}
		public function find_loaicongviec(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Loaicongviec');
				$this->assignRef('loaicongviec',$model->find_loaicongviec($id));
				$this->assignRef('ds_iddotdanhgia',$model->find_dgcbcc_fk_loaicongviec_dotdanhgia($id));
			}
		}
		public function load_danhsach_errorsql(){
			$model = Core::model('Danhmuchethong/Errorsql');
			Core::printJson($model->load_danhsach_errorsql());
		}
		public function timkiem_loaingaynghi_byname(){
			$jinput = JFactory::getApplication()->input;
			$tk_loaingaynghi_name = $jinput->getString('tk_loaingaynghi_name','');
			$model = Core::model('Danhmuchethong/Loaingaynghi');
			$this->assignRef('ds_loaingaynghi',$model->timkiem_loaingaynghi_byname($tk_loaingaynghi_name));
		}
		public function find_loaingaynghi(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Loaingaynghi');
				$this->assignRef('loaingaynghi',$model->find_loaingaynghi($id));
			}
		}
		public function timkiem_dieukienlamviec_byname(){
			$jinput = JFactory::getApplication()->input;
			$tk_dieukienlamviec_name = $jinput->getString('tk_dieukienlamviec_name','');
			$model = Core::model('Danhmuchethong/dieukienlamviec');
			$this->assignRef('ds_dieukienlamviec',$model->timkiem_dieukienlamviec_byname($tk_dieukienlamviec_name));
		}
		public function find_dieukienlamviec(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/dieukienlamviec');
				$this->assignRef('dieukienlamviec',$model->find_dieukienlamviec($id));
			}
		}
		public function timkiem_lydocongviecfail_byname(){
			$jinput = JFactory::getApplication()->input;
			$tk_lydocongviecfail_name = $jinput->getString('tk_lydocongviecfail_name','');
			$model = Core::model('Danhmuchethong/Lydocongviecfail');
			$this->assignRef('ds_lydocongviecfail',$model->timkiem_lydocongviecfail_byname($tk_lydocongviecfail_name));
		}
		public function find_lydocongviecfail(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Lydocongviecfail');
				$this->assignRef('lydocongviecfail',$model->find_lydocongviecfail($id));
			}
		}
		public function timkiem_mucdothuongxuyen_byname(){
			$jinput = JFactory::getApplication()->input;
			$tk_mucdothuongxuyen_name = $jinput->getString('tk_mucdothuongxuyen_name','');
			$model = Core::model('Danhmuchethong/Mucdothuongxuyen');
			$this->assignRef('ds_mucdothuongxuyen',$model->timkiem_mucdothuongxuyen_byname($tk_mucdothuongxuyen_name));
		}
		public function find_mucdothuongxuyen(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Mucdothuongxuyen');
				$this->assignRef('mucdothuongxuyen',$model->find_mucdothuongxuyen($id));
			}
		}
		public function timkiem_tinhchat_byname(){
			$jinput = JFactory::getApplication()->input;
			$tk_tinhchat_name = $jinput->getString('tk_tinhchat_name','');
			$model = Core::model('Danhmuchethong/Tinhchat');
			$this->assignRef('ds_tinhchat',$model->timkiem_tinhchat_byname($tk_tinhchat_name));
		}
		public function find_tinhchat(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Tinhchat');
				$this->assignRef('tinhchat',$model->find_tinhchat($id));
			}
		}
		public function timkiem_xeploaicongviec_byname(){
			$jinput = JFactory::getApplication()->input;
			$tk_xeploaicongviec_name = $jinput->getString('tk_xeploaicongviec_name','');
			$model = Core::model('Danhmuchethong/Xeploaicongviec');
			$this->assignRef('ds_xeploaicongviec',$model->timkiem_xeploaicongviec_byname($tk_xeploaicongviec_name));
		}
		public function find_xeploaicongviec(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Xeploaicongviec');
				$this->assignRef('xeploaicongviec',$model->find_xeploaicongviec($id));
			}
		}
		public function timkiem_xeploaichatluong_byname(){
			$jinput = JFactory::getApplication()->input;
			$tk_xeploaichatluong_name = $jinput->getString('tk_xeploaichatluong_name','');
			$model = Core::model('Danhmuchethong/Xeploaichatluong');
			$this->assignRef('ds_xeploaichatluong',$model->timkiem_xeploaichatluong_byname($tk_xeploaichatluong_name));
		}
		public function find_xeploaichatluong(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Xeploaichatluong');
				$this->assignRef('xeploaichatluong',$model->find_xeploaichatluong($id));
			}
		}
		// public function getall_dotdanhgia(){
		// 	$model = Core::model('Danhmuchethong/xeploaichatluong');
		// 	$this->assignRef('ds_dotdanhgia',$model->getall_dotdanhgia());
		// }
		public function find_theonhiemvu_byname(){
			$jinput = JFactory::getApplication()->input;
			$tk_theonhiemvu_name = $jinput->getString('tk_theonhiemvu_name','');
			$model = Core::model('Danhmuchethong/Theonhiemvu');
			$this->assignRef('ds_theonhiemvu',$model->find_theonhiemvu_byname($tk_theonhiemvu_name));
		}
		public function getall_dgcbcc_tieuchuan(){
			$model = Core::model('Danhmuchethong/Theonhiemvu');
			$this->assignRef('ds_dgcbcc_tieuchuan',$model->getall_dgcbcc_tieuchuan());
		}
		public function find_dgcbcc_nhiemvu_byid(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id','');
			$model = Core::model('Danhmuchethong/Theonhiemvu');
			if($id>0){
				$this->assignRef('theonhiemvu',$model->find_dgcbcc_nhiemvu_byid($id));
			}		
		}
		public function find_dgcbcc_fk_nhiemvu_tieuchuan_byidnhiemvu(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id','');
			$model = Core::model('Danhmuchethong/Theonhiemvu');
			if($id>0){
				$this->assignRef('ds_dgcbcc_fk_nhiemvu_tieuchuan',$model->find_dgcbcc_fk_nhiemvu_tieuchuan_byidnhiemvu($id));
			}
		}
		public function find_theotieuchuan_byname(){
			$jinput = JFactory::getApplication()->input;
			$tk_theotieuchuan_name = $jinput->getString('tk_theotieuchuan_name','');
			$model = Core::model('Danhmuchethong/Theotieuchuan');
			$this->assignRef('ds_theotieuchuan',$model->find_theotieuchuan_byname($tk_theotieuchuan_name));
		}
		public function getall_loaicongviec(){
			$model = Core::model('Danhmuchethong/Theotieuchuan');
			$this->assignRef('ds_loaicongviec',$model->getall_loaicongviec());
		}
		public function getall_dgcbcc_nhiemvu(){
			$model = Core::model('Danhmuchethong/Theotieuchuan');
			$this->assignRef('ds_dgcbcc_nhiemvu',$model->getall_dgcbcc_nhiemvu());
		}
		public function find_dgcbcc_tieuchuan_byid(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Theotieuchuan');
				$this->assignRef('theotieuchuan',$model->find_dgcbcc_tieuchuan_byid($id));
			}
		}
		public function find_dgcbcc_fk_nhiemvu_tieuchuan_byidtieuchuan(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Theotieuchuan');
				$this->assignRef('ds_dgcbcc_fk_nhiemvu_tieuchuan',$model->find_dgcbcc_fk_nhiemvu_tieuchuan_byidtieuchuan($id));
			}
		}
		public function find_dgcbcc_fk_nhiemvu_tieuchuan_danhgiacho_byidtieuchuan(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Theotieuchuan');
				$this->assignRef('ds_dgcbcc_fk_nhiemvu_tieuchuan_danhgiacho',$model->find_dgcbcc_fk_nhiemvu_tieuchuan_danhgiacho_byidtieuchuan($id));
			}
		}
		public function tree_botieuchi(){
			$jinput = JFactory::getApplication()->input;
			$root_id = $jinput->getString('root_id','');
	        $id = $jinput->getString('id','');
	        $user = JFactory::getUser();
			$user_id = $user->id;
			$nhiemvu_id = $jinput->getInt('nhiemvu_id',0);
			$donvithuocve = Core::getUserDonvi($user_id);
	        $model = Core::model('Danhmuchethong/Botieuchi');
	        echo $model->tree_botieuchi($id,$nhiemvu_id);die;
		}
		public function findroot_id_botieuchi(){
			$model = Core::model('Danhmuchethong/Botieuchi');
			$this->assignRef('root_id',$model->findroot_id());
		}
		public function getall_botieuchi(){
			$model = Core::model('Danhmuchethong/Botieuchi');
			$this->assignRef('ds_botieuchi',$model->getall_botieuchi());
		}
		public function getall_xeploai(){
			$model = Core::model('Danhmuchethong/Botieuchi');
			$this->assignRef('ds_xeploai',$model->getall_xeploai());
		}
		public function find_botieuchi_by_id(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/botieuchi');
				$this->assignRef('botieuchi',$model->find_botieuchi_by_id($id));
				$this->assignRef('ds_tieuchi',$model->find_tieuchi_by_botieuchi($id));
				$this->assignRef('ds_fk_theonhiemvu_botieuchi',$model->find_dgcbcc_fk_theonhiemvu_botieuchi_by_botieuchi($id));
				$this->assignRef('ds_fk_tieuchuan_dg_botieuchi',$model->find_dgcbcc_fk_tieuchuan_dg_botieuchi($id));
			}
		}
		public function getall_dotdanhgia(){
			$model = Core::model('Danhmuchethong/Dotdanhgia');
			$this->assignRef('ds_dotdanhgia',$model->getall_dotdanhgia());
		}
		public function timkiem_dotdanhgia_by_datedot(){
			$jinput = JFactory::getApplication()->input;
			$date_dot = $jinput->getString('date_dot','');
			$model = Core::model('Danhmuchethong/Dotdanhgia');
			$this->assignRef('ds_dotdanhgia',$model->timkiem_dotdanhgia_by_datedot($date_dot));
		}
		public function find_dotdanhgia_by_id(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Dotdanhgia');
				$this->assignRef('dotdanhgia',$model->find_dotdanhgia_by_id($id));
			}
		}
		public function find_mucdophuctap_by_id_dotdanhgia(){
			$jinput = JFactory::getApplication()->input;
			$id_dotdanhgia = $jinput->getInt('id_dotdanhgia',0);
			$model = Core::model('Danhmuchethong/Mucdophuctap');
			if($id_dotdanhgia>0){
				$this->assignRef('ds_mucdophuctap',$model->find_mucdophuctap_by_id_dotdanhgia($id_dotdanhgia));
			}
		}
		public function find_mucdophuctap_byid(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Mucdophuctap');
				$this->assignRef('mucdophuctap',$model->find_mucdophuctap_byid($id));
			}
		}
		public function timkiem_mucdothamgia_byname(){
			$jinput = JFactory::getApplication()->input;
			$tk_ten = $jinput->getString('tk_ten','');
			$model = Core::model('Danhmuchethong/Mucdothamgia');
				$this->assignRef('ds_mucdothamgia',$model->timkiem_mucdothamgia_byname($tk_ten));
		}
		public function find_mucdothamgia_byid(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Mucdothamgia');
				$this->assignRef('mucdothamgia',$model->find_mucdothamgia_byid($id));
			}
		}
		public function find_tiendo_by_id_dotdanhgia(){
			$jinput = JFactory::getApplication()->input;
			$id_dotdanhgia = $jinput->getInt('id_dotdanhgia',0);
			$model = Core::model('Danhmuchethong/Tiendo');
			if($id_dotdanhgia>0){
				$this->assignRef('ds_tiendo',$model->find_tiendo_by_id_dotdanhgia($id_dotdanhgia));
			}
		}
		public function find_tiendo_byid(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Tiendo');
				$this->assignRef('tiendo',$model->find_tiendo_byid($id));
			}
		}
		public function find_xeploai_by_id_dotdanhgia(){
			$jinput = JFactory::getApplication()->input;
			$id_dotdanhgia = $jinput->getInt('id_dotdanhgia',0);
			$model = Core::model('Danhmuchethong/Xeploai');
			if($id_dotdanhgia>0){
				$this->assignRef('ds_xeploai',$model->find_xeploai_by_id_dotdanhgia($id_dotdanhgia));
			}
		}
		public function find_xeploai_byid(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Xeploai');
				$this->assignRef('xeploai',$model->find_xeploai_byid($id));
			}
		}
		public function find_partitions_by_table(){
			$jinput = JFactory::getApplication()->input;
			$name_table = $jinput->getString('name_table','');
			$model = Core::model('Danhmuchethong/Partition');
			$this->assignRef('ds_partitions',$model->find_partitions_by_table($name_table));
		}
		public function find_partition_by_id(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Partition');
				$this->assignRef('partition',$model->find_partition_by_id($id));
			}
		}
		public function find_tieuchi_phanloai_byname(){
			$jinput = JFactory::getApplication()->input;
			$tk_tieuchi_name = $jinput->getString('tk_tieuchi_name','');
			$model = Core::model('Danhmuchethong/Tieuchiliet');
			$this->assignRef('ds_tieuchi_phanloai',$model->find_tieuchi_phanloai_byname($tk_tieuchi_name));
		}
		public function getall_dgcbcc_dg_theonhiemvu(){
			$model = Core::model('Danhmuchethong/Tieuchiliet');
			$this->assignRef('ds_dgcbcc_dg_theonhiemvu',$model->getall_dgcbcc_dg_theonhiemvu());
		}
		public function find_tieuchi_phanloai_byid(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Tieuchiliet');
				$this->assignRef('tieuchi_phanloai',$model->find_tieuchi_phanloai_byid($id));
				$this->assignRef('ds_dgcbcc_fk_theonhiemvu_tieuchi_phanloai',$model->find_dgcbcc_fk_theonhiemvu_tieuchi_phanloai_by_idtieuchi($id));
			}
		}
		public function getall_dgcbcc_phanloai(){
			$model = Core::model('Danhmuchethong/Botieuchi');
			$this->assignRef('ds_tieuchi_phanloai',$model->getall_tieuchi_phanloai());
		}
		public function getall_dotdanhgia_thang(){
			$user = JFactory::getUser();
			$user_id = $user->id;
			$donvithuocve = Core::getUserDonvi($user_id);
			$model = Core::model('Danhgia/Tieuchidonvi');
			$this->assignRef('ds_dotdanhgia_thang',$model->getall_dotdanhgia_thang($donvithuocve));
		}
	}
?>