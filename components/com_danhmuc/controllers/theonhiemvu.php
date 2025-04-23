<?php 
	class DanhmucControllerTheonhiemvu extends DanhmucController{
		public function luu_theonhiemvu(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$fk_tieuchuan_nhiemvu = $jinput->get('fk_tieuchuan_nhiemvu',array(),'array');
			$model = Core::model('Danhmuchethong/Theonhiemvu');
			if($form['id']==''){
				$id_nhiemvu = $model->add_theonhiemvu($form);
				if(count($fk_tieuchuan_nhiemvu)>0){
					for($i=0;$i<count($fk_tieuchuan_nhiemvu);$i++){
						$model->add_dgcbcc_fk_nhiemvu_tieuchuan($id_nhiemvu,$fk_tieuchuan_nhiemvu[$i]);
					}
				}
				Core::printJson($id_nhiemvu);exit;
			}
			else{
				$id_nhiemvu = $model->update_theonhiemvu($form);
				$model->delete_dgcbcc_fk_nhiemvu_tieuchuan_byidnhiemvu($form['id']);
				if(count($fk_tieuchuan_nhiemvu)>0){
					for($i=0;$i<count($fk_tieuchuan_nhiemvu);$i++){
						$model->add_dgcbcc_fk_nhiemvu_tieuchuan($id_nhiemvu,$fk_tieuchuan_nhiemvu[$i]);
					}
				}
				Core::printJson($id_nhiemvu);exit;
			}
		}
		public function delete_theonhiemvu(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Theonhiemvu');
				Core::printJson($model->delete_theonhiemvu($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_theonhiemvu(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Theonhiemvu');
			if(count($id)>0){
				for($i=0;$i<count($id);$i++){
					$result[] = $model->delete_theonhiemvu($id[$i]);
				}
				Core::printJson($result);exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
	}
?>