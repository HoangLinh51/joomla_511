<?php 
	class DanhmucControllerGoichucvu extends DanhmucController{
		public function find_goichucvu_byid(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Goichucvu');
				Core::printJson($model->find_goichucvu_byid($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function reset_tree_goichucvu(){
            $table = Core::table('Tochuc/Adgoichucvu');
            $table->rebuild();
            $app = JFactory::getApplication();
            $link = 'index.php?option=com_danhmuc&controller=tochuc&task=ds_goichucvu';
            $url = JRoute::_($link);
            $app->redirect($url);
		}
		public function save_goichucvu(){
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$name_chucvu = $jinput->get('name_chucvu',array(),'array');
			$thoihanbonhiem = $jinput->get('thoihanbonhiem',array(),'array');
			$capbonhiem = $jinput->get('capbonhiem',array(),'array');
			$chucvu_id = $jinput->get('chucvu_id',array(),'array');
			$model = Core::model('Danhmuchethong/Goichucvu');
			if(!$form['id']||$form['id']==null){
				Core::printJson($model->add_goichucvu($form));exit;
			}
			else{
				$model->delete_goichucvu_chucvu_bygoichucvu($form['id']);
				if(count($thoihanbonhiem)>0){
					for($i=0;$i<count($thoihanbonhiem);$i++){
						$model->add_goichucvu_chucvu($form['id'],$chucvu_id[$i],$name_chucvu[$i],$thoihanbonhiem[$i],$capbonhiem[$i]);
					}
				}
				Core::printJson($model->update_goichucvu($form));exit;
			}	
		}
		public function find_chucvu_by_id(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Goichucvu');
			if($id>0){
				Core::printJson($model->find_chucvu_by_id($id));exit;
			}
		}
		public function delete_goichucvu_chucvu(){
			$jinput = JFactory::getApplication()->input;
			$id_goichucvu = $jinput->getInt('id_goichucvu',0);
			$id_chucvu = $jinput->getInt('id_chucvu',0);
			$tenchucvu = $jinput->getString('tenchucvu','');
			// echo $id_goichucvu;die;
			$model = Core::model('Danhmuchethong/Goichucvu');
			if($id_goichucvu>0&&$id_chucvu>0){
				Core::printJson($model->delete_goichucvu_chucvu($id_goichucvu,$id_chucvu,$tenchucvu));exit;
			}
			Core::printJson(false);exit;
		}
		public function delete_goichucvu(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Goichucvu');
				$model->delete_goichucvu_chucvu_bygoichucvu($id);
				Core::printJson($model->delete_goichucvu($id));exit;
			}
			Core::printJson(false);exit;
		}
	}
?>