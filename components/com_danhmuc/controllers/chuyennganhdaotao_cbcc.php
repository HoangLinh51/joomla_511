<?php 
	class DanhmucControllerChuyennganhdaotao_cbcc extends DanhmucController{
		public function save_chuyennganhdaotao(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Chuyennganhdaotao');
			if($form['code']==null){				
				Core::printJson($model->add_chuyennganhdaotao($form));exit;
			}
			else{
				Core::printJson($model->update_chuyennganhdaotao($form));exit;
			}
		}
		public function delete_chuyennganhdaotao(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Chuyennganhdaotao');
			if($id>0){
				Core::printJson($model->delete_chuyennganhdaotao($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function xoanhieu_chuyennganhdaotao(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Chuyennganhdaotao');
			if(count($id)>0){
				for($i=0;$i<count($id);$i++){
					$result[] = $model->delete_chuyennganhdaotao($id[$i]);
				}
				Core::printJson($result);exit;
			}
			else{
				Core::printJson(false);exit;
			}			
		}
	}
?>