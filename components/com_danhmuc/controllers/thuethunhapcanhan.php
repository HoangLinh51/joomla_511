<?php 
	class DanhmucControllerThuethunhapcanhan extends DanhmucController{
		public function add_thuetncn(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Thuethunhapcanhan');
			Core::printJson($model->add_thuetncn($form));exit;
			// if(preg_match('/[\'";]/', $form['ghichu'])||preg_match('/[SELECT,UNION]/i',$form['ghichu'])){
			// 	Core::printJson(false);exit;
			// }
			// else{
				
			// }			
		}
		public function delete_thuetncn(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Thuethunhapcanhan');
				Core::printJson($model->delete_thuetncn($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function update_thuetncn(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Thuethunhapcanhan');
			Core::printJson($model->update_thuetncn($form));exit;
		}
		public function xoanhieu_thuetncn(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Thuethunhapcanhan');
				Core::printJson($model->deletemany_thuetncn($id));exit;
			}
			Core::printJson(false);exit;
		}
	}
?>