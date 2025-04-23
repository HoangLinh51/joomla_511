<?php 
	class DanhmucControllerDgcbcc_dotdanhgia extends DanhmucController{
		public function luu_dgcbcc_dotdanhgia(){
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/DgcbccDotdanhgia');
			$max_date_dot = $model->get_max_date_dot();
			// var_dump($max_date_dot);die;
			if($form['id']==''){
				$id_dotdanhgia = $model->add_dgcbcc_dotdanhgia($form);
				$model->add_partition_dotdanhgia_thang($id_dotdanhgia);
				$model->add_dgcbcc_dotdanhgia_thang($form,$id_dotdanhgia,$max_date_dot['max_date_dot']);
				Core::printJson($id_dotdanhgia);exit;
			}
			else{
				$id_dotdanhgia = $model->update_dgcbcc_dotdanhgia($form);
				$model->update_dgcbcc_dotdanhgia_thang($form);
				Core::printJson($id_dotdanhgia);exit;
			}
		}
		public function delete_dgcbcc_dotdanhgia(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/DgcbccDotdanhgia');
			if($id>0){
				$model->delete_dgcbcc_dotdanhgia_thang($id);
				Core::printJson($model->delete_dgcbcc_dotdanhgia($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_dgcbcc_dotdanhgia(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/DgcbccDotdanhgia');
			for($i=0;$i<count($id);$i++){
				$model->delete_dgcbcc_dotdanhgia_thang($id[$i]);
				$result[] = $model->delete_dgcbcc_dotdanhgia($id[$i]);
			}
			Core::printJson($result);exit;
		}
	}
?>