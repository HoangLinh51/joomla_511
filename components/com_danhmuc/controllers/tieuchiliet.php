<?php 
	class DanhmucControllerTieuchiliet extends DanhmucController{
		public function find_xeploai_by_id_dotdanhgia(){
			$jinput = JFactory::getApplication()->input;
			$id_dotdanhgia = $jinput->getInt('id_dotdanhgia',0);
			if($id_dotdanhgia>0){
				$model = Core::model('Danhmuchethong/Tieuchiliet');
				Core::printJson($model->find_xeploai_by_id_dotdanhgia($id_dotdanhgia));exit;
			}
			Core::printJson(false);exit;
		}
		public function luu_tieuchi_liet(){
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$id_theonhiemvu = $jinput->get('id_theonhiemvu',array(),'array');
			$id_dotdanhgia = $jinput->get('id_dotdanhgia',array(),'array');
			$id_xeploai = $jinput->get('id_xeploai',array(),'array');
			// var_dump($id_xeploai);die;
			$checkbox_nhiemvu_dotdanhgia = $jinput->get('checkbox_nhiemvu_dotdanhgia',array(),'array');
			$model = Core::model('Danhmuchethong/Tieuchiliet');
			if($form['id']==''){
				$id_tieuchi_phanloai = $model->add_tieuchi_phanloai($form);
				if($id_tieuchi_phanloai>0){
					if(count($checkbox_nhiemvu_dotdanhgia)>0){
						for($i=0;$i<count($checkbox_nhiemvu_dotdanhgia);$i++){
							$index = $checkbox_nhiemvu_dotdanhgia[$i]-1;
							$model->add_dgcbcc_fk_theonhiemvu_tieuchi_phanloai($id_tieuchi_phanloai,$id_theonhiemvu[$index],$id_dotdanhgia[$index],$id_xeploai[$index]);
						}
					}
					Core::printJson($id_tieuchi_phanloai);exit;
				}
				else{
					Core::printJson(false);exit;
				}
			}
			else{
				$id_tieuchi_phanloai = $model->update_tieuchi_phanloai($form);
				if($id_tieuchi_phanloai>0){
					$model->delete_dgcbcc_fk_theonhiemvu_tieuchi_phanloai($id_tieuchi_phanloai);
					if(count($checkbox_nhiemvu_dotdanhgia)>0){
						for($i=0;$i<count($checkbox_nhiemvu_dotdanhgia);$i++){
							$index = $checkbox_nhiemvu_dotdanhgia[$i]-1;
							$model->add_dgcbcc_fk_theonhiemvu_tieuchi_phanloai($id_tieuchi_phanloai,$id_theonhiemvu[$index],$id_dotdanhgia[$index],$id_xeploai[$index]);
						}
					}
					Core::printJson($id_tieuchi_phanloai);exit;
				}
				else{
					Core::printJson(false);exit;
				}
			}
		}
		public function delete_tieuchi_liet(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Tieuchiliet');
				$model->delete_dgcbcc_fk_theonhiemvu_tieuchi_phanloai($id);
				Core::printJson($model->delete_tieuchi_liet($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_tieuchi_liet(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if(count($id)>0){
				$model = Core::model('Danhmuchethong/Tieuchiliet');
				for($i=0;$i<count($id);$i++){
					$model->delete_dgcbcc_fk_theonhiemvu_tieuchi_phanloai($id[$i]);
					$result[] = $model->delete_tieuchi_liet($id[$i]);
				}
				Core::printJson($result);exit;
			}
			Core::printJson(false);exit;
		}
	}
?>