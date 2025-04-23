<?php 
	class DanhmucControllerLoaicongviec extends DanhmucController{
		public function save_loaicongviec(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$id_dotdanhgia = $jinput->get('id_dotdanhgia',array(),'array');
			$model = Core::model('Danhmuchethong/Loaicongviec');
			if($form['id']==''){
				$id_loaicongviec = $model->add_loaicongviec($form);
				if($id_loaicongviec>0){
					for($i=0;$i<count($id_dotdanhgia);$i++){
						$model->add_dgcbcc_fk_loaicongviec_dotdanhgia($id_loaicongviec,$id_dotdanhgia[$i]);
					}
					Core::printJson($id_loaicongviec);exit;
				}
				Core::printJson(false);exit;
			}
			else{
				$id_loaicongviec = $model->update_loaicongviec($form);
				if($id_loaicongviec>0){
					$model->delete_dgcbcc_fk_loaicongviec_dotdanhgia($id_loaicongviec);
					for($i=0;$i<count($id_dotdanhgia);$i++){
						$model->add_dgcbcc_fk_loaicongviec_dotdanhgia($id_loaicongviec,$id_dotdanhgia[$i]);
					}
					Core::printJson($id_loaicongviec);exit;
				}
				Core::printJson();exit;
			}
		}
		public function delete_loaicongviec(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Loaicongviec');
			if($id>0){
				$model->delete_dgcbcc_fk_loaicongviec_dotdanhgia($id);
				Core::printJson($model->delete_loaicongviec($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_loaicongviec(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Loaicongviec');
			for($i=0;$i<count($id);$i++){
				$model->delete_dgcbcc_fk_loaicongviec_dotdanhgia($id);
				$result[] = $model->delete_loaicongviec($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>