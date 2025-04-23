<?php 
	class DanhmucControllerHinhthucbienche extends DanhmucController{
		public function luuhinhthucbienche(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$hinhthuctuyendung = $jinput->get('hinhthuctuyendung',array(),'array');
			$thoihan = $jinput->get('thoihan',array(),'array');
			$model = Core::model('Danhmuchethong/Hinhthucbienche');
			$id_hinhthucbienche = $model->luuhinhthucbienche($form);
			if($id_hinhthucbienche>0){
				$boolean_luu_giahan = $model->luu_hinhthucbienche_thoihan($id_hinhthucbienche,$thoihan);
				if($form['is_hinhthuctuyendung']==1){
					$boolean_luu_hinhthuctuyendung = $model->luu_hinhthucbienche_hinhthuctuyendung($id_hinhthucbienche,$hinhthuctuyendung);
				}
				Core::printJson(true);exit;
			}
			Core::printJson(false);exit;
		}
		public function delete_hinhthucbienche(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Hinhthucbienche');
				$boolean_deletehinhthucbienche = $model->delete_hinhthucbienche($id);
				$boolean_deletehinhthucbienche_thoihan = $model->delete_hinhthucbienche_thoihan($id);
				$boolean_deletehinhthucbienche_hinhthuctuyendung = $model->delete_hinhthucbienche_hinhthuctuyendung($id);
				if($boolean_deletehinhthucbienche==true&&$boolean_deletehinhthucbienche_hinhthuctuyendung==true&&$boolean_deletehinhthucbienche_thoihan==true){
					Core::printJson(true);exit;
				}
				else{
					Core::printJSon(false);exit;
				}
			}
			Core::printJson(false);exit;
		}
		public function updatehinhthucbienche(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$hinhthuctuyendung = $jinput->get('hinhthuctuyendung',array(),'array');
			$thoihan = $jinput->get('thoihan',array(),'array');
			$model = Core::model('Danhmuchethong/Hinhthucbienche');
			$boolean_deletehinhthucbienche_thoihan = $model->delete_hinhthucbienche_thoihan($form['id']);
			$boolean_deletehinhthucbienche_hinhthuctuyendung = $model->delete_hinhthucbienche_hinhthuctuyendung($form['id']);
			$boolean_luu_giahan = $model->luu_hinhthucbienche_thoihan($form['id'],$thoihan);
			if($form['is_hinhthuctuyendung']==1){
				$boolean_luu_hinhthuctuyendung = $model->luu_hinhthucbienche_hinhthuctuyendung($form['id'],$hinhthuctuyendung);
			}
			Core::printJson($model->updatehinhthucbienche($form));exit;
		}
		public function xoanhieu_hinhthucbienche(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->get('id',array(),'array');
			if(count($id>0)){
				$model = Core::model('Danhmuchethong/Hinhthucbienche');
				Core::printJson($model->xoanhieu_hinhthucbienche($id));exit;
			}
			Core::printJson(false);exit;
		}
	}
?>