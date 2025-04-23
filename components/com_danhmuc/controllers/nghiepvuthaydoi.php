<?php 
	class DanhmucControllerNghiepvuthaydoi extends DanhmucController{
		public function luu_nghiepvuthaydoi(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Nghiepvuthaydoi');
			$user = JFactory::getUser();
			$user_id = $user->id;
			$today = date('Y-m-d H:i:s');
			if($form['id']==''){
				Core::printJson($model->add_nghiepvuthaydoi($form,$user_id,$today));exit;
			}
			else{
				Core::printJson($model->update_nghiepvuthaydoi($form,$user_id,$today));exit;
			}
		}
		public function delete_nghiepvuthaydoi(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Nghiepvuthaydoi');
				Core::printJson($model->delete_nghiepvuthaydoi($id));exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
		public function xoanhieu_nghiepvuthaydoi(){
			$jinput = JFactory::getApplication()->input;
			$array_id = $jinput->getInt('array_id',0);
			if(count($array_id)>0){
				$model = Core::model('Danhmuchethong/Nghiepvuthaydoi');
				for($i=0;$i<count($array_id);$i++){
					$result[] = $model->delete_nghiepvuthaydoi($array_id[$i]);
				}
				Core::printJson($result);exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
	}
?>