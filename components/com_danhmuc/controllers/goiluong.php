<?php 
	class DanhmucControllerGoiluong extends DanhmucController{
		public function findluongbyid(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Goiluong');
				Core::printJson($model->find_luongbyid($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function reset_tree_goiluong(){
            $table = Core::table('Tochuc/Adgoiluong');
            $table->rebuild();
            $app = JFactory::getApplication();
            $link = 'index.php?option=com_danhmuc&controller=tochuc&task=ds_goiluong';
            $url = JRoute::_($link);
            $app->redirect($url);
        }
        public function save_goiluong(){
        	JSession::checkToken() or die('Invalid Token');
        	$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$ngach = $jinput->get('ngach',array(),'array');
			// var_dump($ngach);die;
			if($form['id']==''){
				$model = Core::model('Danhmuchethong/Goiluong');
				// echo '123';die;
				$id_goiluong = $model->add_goiluong($form);
				if($id_goiluong>0){
					if(count($ngach)>0){
						for($i=0;$i<count($ngach);$i++){
							$ma_ngach = $model->find_mangach_by_idngach($ngach[$i]);
							$model->add_goiluong_ngach($id_goiluong,$ngach[$i],$ma_ngach['mangach']);
						}
					}
					Core::printJson($id_goiluong);exit;
				}
				Core::printJson(false);exit;
			}
			else{
				$model = Core::model('Danhmuchethong/Goiluong');
				$id_goiluong = $model->update_goiluong($form);
				if($id_goiluong>0){
					$model->delete_goiluong_ngach_by_goiluong($id_goiluong);
					if(count($ngach)>0){
						for($i=0;$i<count($ngach);$i++){
							$ma_ngach = $model->find_mangach_by_idngach($ngach[$i]);
							$model->add_goiluong_ngach($id_goiluong,$ngach[$i],$ma_ngach['mangach']);
						}
					}
					Core::printJson($id_goiluong);exit;
				}
				Core::printJson(false);exit;
			}			
        }
        public function find_luong_by_goiluong(){
        	$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Goiluong');
				Core::printJson($model->find_luong_by_goiluong($id));exit;
			}
			Core::printJson(false);exit;
        }
        public function delete_goiluong(){
        	$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Goiluong');
				$model->delete_goiluong_ngach_by_goiluong($id);
				Core::printJson($model->delete_goiluong($id));exit;
			}
			Core::printJson(false);exit;
        }
	}
?>