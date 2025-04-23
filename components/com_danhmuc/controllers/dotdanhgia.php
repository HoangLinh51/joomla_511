<?php 
	class DanhmucControllerDotdanhgia extends DanhmucController{
		public function luu_dotdanhgia(){
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Dotdanhgia');
			$max_date_dot = $model->get_max_date_dot();
			$max_id_dotdanhgia = $model->get_max_id_dotdanhgia();
			// var_dump($max_date_dot);die;
			if($form['id']==''){
				$id_dotdanhgia = $model->add_dotdanhgia($form);
				// $model->add_partition_dotdanhgia_thang($id_dotdanhgia);
				$model->add_partition_id_dotdanhgia($id_dotdanhgia);
				$model->add_dotdanhgia_thang($form,$id_dotdanhgia,$max_date_dot['max_date_dot']);
				$model->add_dgcbcc_user_nhiemvu($id_dotdanhgia,$max_id_dotdanhgia);
				$model->add_dgcbcc_user_quyen($id_dotdanhgia,$max_id_dotdanhgia);
				$model->add_dgcbcc_xeploai($id_dotdanhgia,$max_id_dotdanhgia);
				$model->add_dgcbcc_fk_loaicongviec_dotdanhgia($id_dotdanhgia,$max_id_dotdanhgia);
				Core::printJson($id_dotdanhgia);exit;
			}
			else{
				$id_dotdanhgia = $model->update_dotdanhgia($form);
				$model->update_dotdanhgia_thang($form);
				Core::printJson($id_dotdanhgia);exit;
			}
		}
		public function delete_dotdanhgia(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dotdanhgia');
			if($id>0){
				$model->delete_dotdanhgia_thang($id);
				Core::printJson($model->delete_dotdanhgia($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_dotdanhgia(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Dotdanhgia');
			for($i=0;$i<count($id);$i++){
				$model->delete_dotdanhgia_thang($id[$i]);
				$result[] = $model->delete_dotdanhgia($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>