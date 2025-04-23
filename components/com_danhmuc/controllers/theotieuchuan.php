<?php 
	class DanhmucControllerTheotieuchuan extends DanhmucController{
		public function luu_theotieuchuan(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$fk_tieuchuan_nhiemvu = $jinput->get('fk_tieuchuan_nhiemvu',array(),'array');
			$fk_tieuchuan_nhiemvu_danhgiacho = $jinput->get('fk_tieuchuan_nhiemvu_danhgiacho',array(),'array');
			$ids_loaicongviec = $jinput->get('ids_loaicongviec',array(),'array');
			$model = Core::model('Danhmuchethong/Theotieuchuan');
			if($form['id']==''){
				$id_tieuchuan = $model->add_theotieuchuan($form,$ids_loaicongviec);
				if(count($fk_tieuchuan_nhiemvu)>0){
					for($i=0;$i<count($fk_tieuchuan_nhiemvu);$i++){
						$model->add_dgcbcc_fk_nhiemvu_tieuchuan($id_tieuchuan,$fk_tieuchuan_nhiemvu[$i]);
					}
				}
				if(count($fk_tieuchuan_nhiemvu_danhgiacho)>0){
					for($i=0;$i<count($fk_tieuchuan_nhiemvu_danhgiacho);$i++){
						$model->add_dgcbcc_fk_nhiemvu_tieuchuan_danhgiacho($id_tieuchuan,$fk_tieuchuan_nhiemvu_danhgiacho[$i]);
					}
				}
				Core::printJson($id_tieuchuan);exit;
			}
			else{
				$id_tieuchuan = $model->update_theotieuchuan($form,$ids_loaicongviec);
				$model->delete_dgcbcc_fk_nhiemvu_tieuchuan_byidtieuchuan($form['id']);
				$model->delete_dgcbcc_fk_nhiemvu_tieuchuan_danhgiacho_byidtieuchuan($form['id']);
				if(count($fk_tieuchuan_nhiemvu)>0){
					for($i=0;$i<count($fk_tieuchuan_nhiemvu);$i++){
						$model->add_dgcbcc_fk_nhiemvu_tieuchuan($id_tieuchuan,$fk_tieuchuan_nhiemvu[$i]);
					}
				}
				if(count($fk_tieuchuan_nhiemvu_danhgiacho)>0){
					for($i=0;$i<count($fk_tieuchuan_nhiemvu_danhgiacho);$i++){
						$model->add_dgcbcc_fk_nhiemvu_tieuchuan_danhgiacho($id_tieuchuan,$fk_tieuchuan_nhiemvu_danhgiacho[$i]);
					}
				}
				Core::printJson($id_tieuchuan);exit;
			}
		}
		public function delete_theotieuchuan(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Theotieuchuan');
				Core::printJson($model->delete_theotieuchuan($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_theotieuchuan(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Theotieuchuan');
			if(count($id)>0){
				for($i=0;$i<count($id);$i++){
					$result[] = $model->delete_theotieuchuan($id[$i]);
				}
				Core::printJson($result);exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
	}
?>