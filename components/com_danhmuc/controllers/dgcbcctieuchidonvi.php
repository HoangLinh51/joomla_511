<?php 
	class DanhmucControllerDgcbcctieuchidonvi extends DanhmucController{
		public function find_tieuchi_by_botieuchi(){
			$jinput= JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$id_dotdanhgia_thang = $jinput->getString('id_dotdanhgia_thang','');
			// echo $id_dotdanhgia_thang;die;
			if($id>0&&$id_dotdanhgia_thang>0){
				$model = Core::model('Danhmuchethong/DgcbccTieuchiDonvi');
				Core::printJson($model->find_tieuchi_by_botieuchi($id,$id_dotdanhgia_thang));exit;
			}
			Core::printJson(false);exit;
		}
		public function luu_dgcbcc_tieuchi_donvi(){
			$jinput= JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$user = JFactory::getUser();
			$user_id = $user->id;
			$donvithuocve = Core::getUserDonvi($user_id);
			$model = Core::model('Danhmuchethong/DgcbccTieuchiDonvi');
			Core::printJson($model->luu_dgcbcc_tieuchi_donvi($form,$donvithuocve));exit;
		}
	}
?>