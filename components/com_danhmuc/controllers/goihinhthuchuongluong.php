<?php 
	class DanhmucControllerGoihinhthuchuongluong extends DanhmucController{
		public function luu_goihinhthuchuongluong(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$hinhthucnangluong = $jinput->get('hinhthucnangluong',array(),'array');
			if($form['id']==null||$form['id']==''){
				$model = Core::model('Danhmuchethong/Goihinhthuchuongluong');
				$id_goihinhthuchuongluong = $model->luu_goihinhthuchuongluong($form);
				if($id_goihinhthuchuongluong>0){
					for($i=0;$i<count($hinhthucnangluong);$i++){
						$model->luu_goihinhthuchuongluong_htnl($id_goihinhthuchuongluong,$hinhthucnangluong[$i]);
					}
					Core::printJson($id_goihinhthuchuongluong);exit;
				}
				else{
					Core::printJson(false);exit;
				}
			}
			else{
				$model = Core::model('Danhmuchethong/Goihinhthuchuongluong');
				$id_goihinhthuchuongluong = $model->update_goihinhthuchuongluong($form);
				if($id_goihinhthuchuongluong>0){
					$model->delete_goihinhthuchuongluong_htnl_byid($id_goihinhthuchuongluong);
					for($i=0;$i<count($hinhthucnangluong);$i++){
						$model->luu_goihinhthuchuongluong_htnl($id_goihinhthuchuongluong,$hinhthucnangluong[$i]);
					}
					Core::printJson($id_goihinhthuchuongluong);exit;
				}
				else{
					Core::printJson(false);exit;
				}
			}
		}
		public function delete_goihinhthuchuongluong(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Goihinhthuchuongluong');
				$model->delete_goihinhthuchuongluong_htnl_byid($id);
				Core::printJson($model->delete_goihinhthuchuongluong($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function find_goihinhthuchuongluong(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Goihinhthuchuongluong');
				Core::printJson($model->find_goihinhthuchuongluong($id));exit;
			}
			Core::printJson(false);exit;
		}
	}
?>