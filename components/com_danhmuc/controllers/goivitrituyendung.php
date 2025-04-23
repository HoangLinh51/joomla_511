<?php 
	class DanhmucControllerGoivitrituyendung extends DanhmucController{
		public function findvitrituyendungbyid(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Goivitrituyendung');
				Core::printJson($model->find_vitrituyendungbyid($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function reset_tree_goivtvl(){
            $table = Core::table('Tochuc/Adgoivitrivieclam');
            $table->rebuild();
            $app = JFactory::getApplication();
            $link = 'index.php?option=com_danhmuc&controller=tochuc&task=ds_goivitrituyendung';
            $url = JRoute::_($link);
            $app->redirect($url);
        }
        public function save_goivttd(){
        	JSession::checkToken() or die('Invalid Token');
        	$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$vitrituyendung = $jinput->get('vitrituyendung',array(),'array');
			if($form['id']==''){
				$model = Core::model('Danhmuchethong/Goivitrituyendung');
				// echo '123';die;
				$id_goivttd = $model->add_goivttd($form);
				if($id_goivttd>0){
					if(count($vitrituyendung)>0){
						for($i=0;$i<count($vitrituyendung);$i++){
							$model->add_goivttd_vttd($id_goivttd,$vitrituyendung[$i]);
						}
					}
					Core::printJson($id_goivttd);exit;
				}
				Core::printJson(false);exit;
			}
			else{
				$model = Core::model('Danhmuchethong/Goivitrituyendung');
				$id_goivttd = $model->update_goivttd($form);
				if($id_goivttd>0){
					$model->delete_goivttd_vttd_by_goivttd($id_goivttd);
					if(count($vitrituyendung)>0){
						for($i=0;$i<count($vitrituyendung);$i++){
							$model->add_goivttd_vttd($id_goivttd,$vitrituyendung[$i]);
						}
					}
					Core::printJson($id_goivttd);exit;
				}
				Core::printJson(false);exit;
			}			
        }
        public function find_vitrituyendung_by_goivttd(){
        	$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Goivitrituyendung');
				Core::printJson($model->find_vitrituyendung_by_goivttd($id));exit;
			}
			Core::printJson(false);exit;
        }
        public function delete_goivttd(){
        	$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Goivitrituyendung');
				$model->delete_goivttd_vttd_by_goivttd($id);
				Core::printJson($model->delete_goivttd($id));exit;
			}
			Core::printJson(false);exit;
        }
	}
?>