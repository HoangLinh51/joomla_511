<?php 
	class DanhmucControllerGoidaotaoboiduong extends DanhmucController{
		public function luu_goidaotaoboiduong(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$loaitrinhdo = $jinput->get('loaitrinhdo',array(),'array');
			// var_dump($loaitrinhdo);die;
			if($form['id']==null||$form['id']==''){
				$model = Core::model('Danhmuchethong/Goidaotaoboiduong');
				$id_goidaotaoboiduong = $model->luu_goidaotaoboiduong($form);
				if($id_goidaotaoboiduong>0){
					for($i=0;$i<count($loaitrinhdo);$i++){
						$model->luu_goidaotaoboiduong_ltd($id_goidaotaoboiduong,$loaitrinhdo[$i]);
					}
					Core::printJson($id_goidaotaoboiduong);exit;
				}
				else{
					Core::printJson(false);exit;
				}
			}
			else{
				$model = Core::model('Danhmuchethong/Goidaotaoboiduong');
				$id_goidaotaoboiduong = $model->update_goidaotaoboiduong($form);
				if($id_goidaotaoboiduong>0){
					$model->delete_goidaotaoboiduong_ltd_byid($id_goidaotaoboiduong);
					for($i=0;$i<count($loaitrinhdo);$i++){
						$model->luu_goidaotaoboiduong_ltd($id_goidaotaoboiduong,$loaitrinhdo[$i]);
					}
					Core::printJson($id_goidaotaoboiduong);exit;
				}
				else{
					Core::printJson(false);exit;
				}
			}
		}
		public function delete_goidaotaoboiduong(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Goidaotaoboiduong');
				$model->delete_goidaotaoboiduong_ltd_byid($id);
				Core::printJson($model->delete_goidaotaoboiduong($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function find_goidaotaoboiduong(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Goidaotaoboiduong');
				Core::printJson($model->find_goidaotaoboiduong($id));exit;
			}
			Core::printJson(false);exit;
		}
	}
?>