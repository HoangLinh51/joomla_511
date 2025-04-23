<?php 
	defined('_JEXEC') or die('Restricted access');
	class DanhmucViewCongtaccbcc extends JViewLegacy{
		function display($tpl=null){
			$task = JRequest::getVar('task');
			switch($task){
				case 'ds_linhvuc':
					$this->setLayout('ds_linhvuc');
					break;
				case 'table_linhvuc':
					$this->timkiemlinhvuc();
					$this->setLayout('table_linhvuc');
					break;
				case 'themmoilinhvuc':
					$this->setLayout('themmoilinhvuc');
					break;
				case 'chinhsualinhvuc':
					$this->findlinhvuc();
					$this->setLayout('themmoilinhvuc');
					break;
				case 'ds_thuhut':
					$this->setLayout('ds_thuhut');
					break;
				case 'table_thuhut':
					$this->timkiemthuhut();
					$this->setLayout('table_thuhut');
					break;
				case 'themmoithuhut':
					$this->setLayout('themmoithuhut');
					break;
				case 'chinhsuathuhut':
					$this->findthuhut();
					$this->setLayout('themmoithuhut');
					break;
				case 'ds_khoicoquan':
					$this->setLayout('ds_khoicoquan');
					break;
				case 'table_khoicoquan':
					$this->timkiemkhoicoquan();
					$this->setLayout('table_khoicoquan');
					break;
				case 'themmoikhoicoquan':
					$this->setLayout('themmoikhoicoquan');
					break;
				case 'chinhsuakhoicoquan':
					$this->findkhoicoquan();
					$this->setLayout('themmoikhoicoquan');
					break;
				case 'ds_nhiemvuduocgiao':
					$this->setLayout('ds_nhiemvuduocgiao');
					break;
				case 'table_nhiemvuduocgiao':
					$this->timkiemnhiemvuduocgiao();
					$this->setLayout('table_nhiemvuduocgiao');
					break;
				case 'themmoinhiemvuduocgiao':
					$this->setLayout('themmoinhiemvuduocgiao');
					break;
				case 'chinhsuanhiemvuduocgiao':
					$this->findnhiemvuduocgiao();
					$this->setLayout('themmoinhiemvuduocgiao');
					break;
				case 'ds_binhbaudonvi':
					$this->setLayout('ds_binhbaudonvi');
					break;
				case 'table_binhbaudonvi':
					$this->timkiembinhbaudonvi();
					$this->setLayout('table_binhbaudonvi');
					break;
				case 'themmoibbdv':
					$this->setLayout('themmoibinhbaudonvi');
					break;
				case 'chinhsuabbdv':
					$this->findbbdv();
					$this->setLayout('themmoibinhbaudonvi');
					break;
				case 'ds_vitrituyendung':
					$this->setLayout('ds_vitrituyendung');
					break;
				case 'table_vitrituyendung':
					$this->timkiemvitrituyendung();
					$this->setLayout('table_vitrituyendung');
					break;
				case 'themmoivitrituyendung':
					$this->setLayout('themmoivitrituyendung');
					break;
				case 'chinhsuavitrituyendung':
					$this->findvitrituyendung();
					$this->setLayout('themmoivitrituyendung');
					break;
				case 'ds_doituongquanly':
					$this->setLayout('ds_doituongquanly');
					break;
				case 'table_doituongquanly':
					$this->timkiemdoituongquanly();
					$this->setLayout('table_doituongquanly');
					break;
				case 'themmoidoituongquanly':
					$this->setLayout('themmoidoituongquanly');
					break;
				case 'chinhsuadoituongquanly':
					$this->finddoituongquanly();
					$this->setLayout('themmoidoituongquanly');
					break;
				case 'ds_trangthaihoso':
					$this->setLayout('ds_trangthaihoso');
					break;
				case 'table_trangthaihoso':
					$this->timkiemtrangthaihoso();
					$this->setLayout('table_trangthaihoso');
					break;
				case 'themmoitrangthaihoso':
					$this->setLayout('themmoitrangthaihoso');
					break;
				case 'chinhsuatrangthaihoso':
					$this->findtrangthaihoso();
					$this->setLayout('themmoitrangthaihoso');
					break;
				case 'ds_hinhthucnghihuu':
					$this->setLayout('ds_hinhthucnghihuu');
					break;
				case 'table_hinhthucnghihuu':
					$this->timkiemhinhthucnghihuu();
					$this->setLayout('table_hinhthucnghihuu');
					break;
				case 'themmoihinhthucnghihuu':
					$this->setLayout('themmoihinhthucnghihuu');
					break;
				case 'chinhsuahinhthucnghihuu':
					$this->findhinhthucnghihuu();
					$this->setLayout('themmoihinhthucnghihuu');
					break;
				case 'ds_trangthaidonvi':
					$this->setLayout('ds_trangthaidonvi');
					break;
				case 'table_trangthaidonvi':
					$this->timkiemtrangthaidonvi();
					$this->setLayout('table_trangthaidonvi');
					break;
				case 'themmoitrangthaidonvi':
					$this->setLayout('themmoitrangthaidonvi');
					break;
				case 'chinhsuatrangthaidonvi':
					$this->findtrangthaidonvi();
					$this->setLayout('themmoitrangthaidonvi');
					break;
				case 'ds_nguontuyendung':
					$this->setLayout('ds_nguontuyendung');
					break;
				case 'table_nguontuyendung':
					$this->timkiemnguontuyendung();
					$this->setLayout('table_nguontuyendung');
					break;
				case 'themmoinguontuyendung':
					$this->setLayout('themmoinguontuyendung');
					break;
				case 'chinhsuanguontuyendung':
					$this->findnguontuyendung();
					$this->setLayout('themmoinguontuyendung');
					break;
				case 'ds_congviecchuyenmon':
					$this->setLayout('ds_congviecchuyenmon');
					break;
				case 'table_congviecchuyenmon':
					$this->timkiemcongviecchuyenmon();
					$this->setLayout('table_congviecchuyenmon');
					break;
				case 'themmoicongviecchuyenmon':
					$this->setLayout('themmoicongviecchuyenmon');
					break;
				case 'chinhsuacongviecchuyenmon':
					$this->findcongviecchuyenmon();
					$this->setLayout('themmoicongviecchuyenmon');
					break;
				case 'ds_binhbauphanloaicbcc':
					$this->setLayout('ds_binhbauphanloaicbcc');
					break;
				case 'table_binhbauphanloaicbcc':
					$this->timkiembinhbauphanloaicbcc();
					$this->setLayout('table_binhbauphanloaicbcc');
					break;
				case 'themmoibinhbauphanloaicbcc':
					$this->setLayout('themmoibinhbauphanloaicbcc');
					break;
				case 'chinhsuabinhbauphanloaicbcc':
					$this->findbinhbauphanloaicbcc();
					$this->setLayout('themmoibinhbauphanloaicbcc');
					break;
				case 'ds_phanloaidonvisunghiep':
					$this->setLayout('ds_phanloaidonvisunghiep');
					break;
				case 'table_phanloaidonvisunghiep':
					$this->timkiemphanloaidonvisunghiep();
					$this->setLayout('table_phanloaidonvisunghiep');
					break;
				case 'themmoiphanloaidonvisunghiep':
					$this->setLayout('themmoiphanloaidonvisunghiep');
					break;
				case 'chinhsuaphanloaidonvisunghiep':
					$this->findphanloaidonvisunghiep();
					$this->setLayout('themmoiphanloaidonvisunghiep');
					break;
				case 'ds_cacloaiquyetdinh':
					$this->setLayout('ds_cacloaiquyetdinh');
					break;
				case 'table_cacloaiquyetdinh':
					$this->timkiemcacloaiquyetdinh();
					$this->setLayout('table_cacloaiquyetdinh');
					break;
				case 'themmoicacloaiquyetdinh':
					$this->setLayout('themmoicacloaiquyetdinh');
					break;
				case 'chinhsuacacloaiquyetdinh':
					$this->findcacloaiquyetdinh();
					$this->setLayout('themmoicacloaiquyetdinh');
					break;
				case 'ds_lydodinuocngoai':
					$this->setLayout('ds_lydodinuocngoai');
					break;
				case 'table_lydodinuocngoai':
					$this->timkiemlydodinuocngoai();
					$this->setLayout('table_lydodinuocngoai');
					break;
				case 'themmoilydodinuocngoai':
					$this->setLayout('themmoilydodinuocngoai');
					break;
				case 'chinhsualydodinuocngoai':
					$this->findlydodinuocngoai();
					$this->setLayout('themmoilydodinuocngoai');
					break;
				case 'ds_hinhthucthoiviecnghihuu':
					$this->setLayout('ds_hinhthucthoiviecnghihuu');
					break;
				case 'table_hinhthucthoiviecnghihuu':
					$this->timkiemhinhthucthoiviecnghihuu();
					$this->setLayout('table_hinhthucthoiviecnghihuu');
					break;
				case 'themmoihinhthucthoiviecnghihuu':
					$this->setLayout('themmoihinhthucthoiviecnghihuu');
					break;
				case 'chinhsuahinhthucthoiviecnghihuu':
					$this->findhinhthucthoiviecnghihuu();
					$this->setLayout('themmoihinhthucthoiviecnghihuu');
					break;
				case 'ds_thuocdienquanly':
					$this->setLayout('ds_thuocdienquanly');
					break;
				case 'table_thuocdienquanly':
					$this->timkiemthuocdienquanly();
					$this->setLayout('table_thuocdienquanly');
					break;
				case 'themmoithuocdienquanly':
					$this->setLayout('themmoithuocdienquanly');
					break;
				case 'chinhsuathuocdienquanly':
					$this->findthuocdienquanly();
					$this->setLayout('themmoithuocdienquanly');
					break;
				default:					
					$this->setLayout('default');
					break;
			}
			parent::display($tpl);
		}
		public function timkiemlinhvuc(){
			$tk_tenlinhvuc = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Linhvuc');
			$kq=$model->findlinhvucbyname($tk_tenlinhvuc);
			$this->assignRef('ds_linhvuc',$kq);
		}
		public function findlinhvuc(){
			$id = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Linhvuc');
			$kq=$model->findlinhvuc($id);
			$this->assignRef('linhvuc',$kq);
		}
		public function timkiemthuhut(){
			$tk_tenthuhut = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Thuhut');
			$kq=$model->findthuhutbyname($tk_tenthuhut);
			$this->assignRef('ds_thuhut',$kq);
		}
		public function findthuhut(){
			$id = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Thuhut');
			$kq=$model->findthuhut($id);
			$this->assignRef('thuhut',$kq);
		}
		public function timkiemkhoicoquan(){
			$tk_tenkhoicoquan = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Khoicoquan');
			$kq=$model->findkhoicoquanbyname($tk_tenkhoicoquan);
			$this->assignRef('ds_khoicoquan',$kq);
		}
		public function findkhoicoquan(){
			$id = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Khoicoquan');
			$kq=$model->findkhoicoquan($id);
			$this->assignRef('khoicoquan',$kq);
		}
		public function timkiemnhiemvuduocgiao(){
			$tk_tennhiemvuduocgiao = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Nhiemvuduocgiao');
			$kq=$model->findnhiemvuduocgiaobyname($tk_tennhiemvuduocgiao);
			$this->assignRef('ds_nhiemvuduocgiao',$kq);
		}
		public function findnhiemvuduocgiao(){
			$id = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Nhiemvuduocgiao');
			$kq=$model->findnhiemvuduocgiao($id);
			$this->assignRef('nhiemvuduocgiao',$kq);
		}
		public function timkiembinhbaudonvi(){
			$tk_tenbinhbaudonvi = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Binhbaudonvi');
			$kq = $model->findbbdvbyname($tk_tenbinhbaudonvi);
			$this->assignRef('ds_binhbaudonvi',$kq);
		}
		public function findbbdv(){
			$id_binhbaudonvi = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Binhbaudonvi');
			$kq = $model->findbbdv($id_binhbaudonvi);
			$this->assignRef('binhbaudonvi',$kq);
		}
		public function timkiemvitrituyendung(){
			$tk_tenvitrituyendung = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Vitrituyendung');
			$kq = $model->findvitrituyendungbyname($tk_tenvitrituyendung);
			$this->assignRef('ds_vitrituyendung',$kq);
		}
		public function findvitrituyendung(){
			$id_vitrituyendung = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Vitrituyendung');
			$kq = $model->findvitrituyendung($id_vitrituyendung);
			$this->assignRef('vitrituyendung',$kq);
		}
		public function timkiemdoituongquanly(){
			$tk_tendoituongquanly = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Doituongquanly');
			$kq = $model->finddoituongquanlybyname($tk_tendoituongquanly);
			$this->assignRef('ds_doituongquanly',$kq);
		}
		public function finddoituongquanly(){
			$id_doituongquanly = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Doituongquanly');
			$kq = $model->finddoituongquanly($id_doituongquanly);
			$this->assignRef('doituongquanly',$kq);
		}
		public function timkiemtrangthaihoso(){
			$tk_tentrangthaihoso = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Trangthaihoso');
			$kq = $model->findtrangthaihosobyname($tk_tentrangthaihoso);
			$this->assignRef('ds_trangthaihoso',$kq);
		}
		public function findtrangthaihoso(){
			$id_trangthaihoso = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Trangthaihoso');
			$kq = $model->findtrangthaihoso($id_trangthaihoso);
			$this->assignRef('trangthaihoso',$kq);
		}
		public function timkiemhinhthucnghihuu(){
			$tk_tenhinhthucnghihuu = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Hinhthucnghihuu');
			$kq = $model->findhinhthucnghihuubyname($tk_tenhinhthucnghihuu);
			$this->assignRef('ds_hinhthucnghihuu',$kq);
		}
		public function findhinhthucnghihuu(){
			$id_hinhthucnghihuu = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Hinhthucnghihuu');
			$kq = $model->findhinhthucnghihuu($id_hinhthucnghihuu);
			$this->assignRef('hinhthucnghihuu',$kq);
		}
		public function timkiemtrangthaidonvi(){
			$tk_tentrangthaidonvi = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Trangthaidonvi');
			$kq = $model->findtrangthaidonvibyname($tk_tentrangthaidonvi);
			$this->assignRef('ds_trangthaidonvi',$kq);
		}
		public function findtrangthaidonvi(){
			$id_trangthaidonvi = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Trangthaidonvi');
			$kq = $model->findtrangthaidonvi($id_trangthaidonvi);
			$this->assignRef('trangthaidonvi',$kq);
		}
		public function timkiemnguontuyendung(){
			$tk_tennguontuyendung = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Nguontuyendung');
			$kq = $model->findnguontuyendungbyname($tk_tennguontuyendung);
			$this->assignRef('ds_nguontuyendung',$kq);
		}
		public function findnguontuyendung(){
			$id_nguontuyendung = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Nguontuyendung');
			$kq = $model->findnguontuyendung($id_nguontuyendung);
			$this->assignRef('nguontuyendung',$kq);
		}
		public function timkiemcongviecchuyenmon(){
			$tk_tencongviecchuyenmon = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Congviecchuyenmon');
			$kq = $model->findcongviecchuyenmonbyname($tk_tencongviecchuyenmon);
			$this->assignRef('ds_congviecchuyenmon',$kq);
		}
		public function findcongviecchuyenmon(){
			$id_congviecchuyenmon = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Congviecchuyenmon');
			$kq = $model->findcongviecchuyenmon($id_congviecchuyenmon);
			$this->assignRef('congviecchuyenmon',$kq);
		}
		public function timkiembinhbauphanloaicbcc(){
			$tk_tenbinhbauphanloaicbcc = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Binhbauphanloaicbcc');
			$kq = $model->findbinhbauphanloaicbccbyname($tk_tenbinhbauphanloaicbcc);
			$this->assignRef('ds_binhbauphanloaicbcc',$kq);
		}
		public function findbinhbauphanloaicbcc(){
			$id_binhbauphanloaicbcc = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Binhbauphanloaicbcc');
			$kq = $model->findbinhbauphanloaicbcc($id_binhbauphanloaicbcc);
			$this->assignRef('binhbauphanloaicbcc',$kq);
		}
		public function timkiemphanloaidonvisunghiep(){
			$tk_tenphanloaidonvisunghiep = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Phanloaidonvisunghiep');
			$kq = $model->findphanloaidonvisunghiepbyname($tk_tenphanloaidonvisunghiep);
			$this->assignRef('ds_phanloaidonvisunghiep',$kq);
		}
		public function findphanloaidonvisunghiep(){
			$id_phanloaidonvisunghiep = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Phanloaidonvisunghiep');
			$kq = $model->findphanloaidonvisunghiep($id_phanloaidonvisunghiep);
			$this->assignRef('phanloaidonvisunghiep',$kq);
		}
		public function timkiemcacloaiquyetdinh(){
			$tk_tencacloaiquyetdinh = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Cacloaiquyetdinh');
			$kq = $model->findcacloaiquyetdinhbyname($tk_tencacloaiquyetdinh);
			$this->assignRef('ds_cacloaiquyetdinh',$kq);
		}
		public function findcacloaiquyetdinh(){
			$id_cacloaiquyetdinh = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Cacloaiquyetdinh');
			$kq = $model->findcacloaiquyetdinh($id_cacloaiquyetdinh);
			$this->assignRef('cacloaiquyetdinh',$kq);
		}
		public function timkiemlydodinuocngoai(){
			$ten_tklydodinuocngoai = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Lydodinuocngoai');
			$kq = $model->findlydodinuocngoaibyname($ten_tklydodinuocngoai);
			$this->assignRef('ds_lydodinuocngoai',$kq);
		}
		public function findlydodinuocngoai(){
			$id_lydodinuocngoai = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Lydodinuocngoai');
			$kq = $model->findlydodinuocngoai($id_lydodinuocngoai);
			$this->assignRef('lydodinuocngoai',$kq);
		}
		public function timkiemhinhthucthoiviecnghihuu(){
			$ten_tkhinhthucthoiviecnghihuu = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Hinhthucthoiviecnghihuu');
			$kq = $model->findhinhthucthoiviecnghihuubyname($ten_tkhinhthucthoiviecnghihuu);
			$this->assignRef('ds_hinhthucthoiviecnghihuu',$kq);
		}
		public function findhinhthucthoiviecnghihuu(){
			$id_hinhthucthoiviecnghihuu = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Hinhthucthoiviecnghihuu');
			$kq = $model->findhinhthucthoiviecnghihuu($id_hinhthucthoiviecnghihuu);
			$this->assignRef('hinhthucthoiviecnghihuu',$kq);
		}
		public function timkiemthuocdienquanly(){
			$ten_tkthuocdienquanly = JRequest::getVar('ten');
			$model = Core::model('Danhmuckieubao/Thuocdienquanly');
			$kq = $model->findthuocdienquanlybyname($ten_tkthuocdienquanly);
			$this->assignRef('ds_thuocdienquanly',$kq);
		}
		public function findthuocdienquanly(){
			$id_thuocdienquanly = JRequest::getVar('id');
			$model = Core::model('Danhmuckieubao/Thuocdienquanly');
			$kq = $model->findthuocdienquanly($id_thuocdienquanly);
			$this->assignRef('thuocdienquanly',$kq);
		}
	}
?>