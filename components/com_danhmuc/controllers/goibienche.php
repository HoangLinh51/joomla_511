<?php 
	class DanhmucControllerGoibienche extends DanhmucController{
		public function luu_goibienche(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$hinhthuc = $jinput->get('hinhthuc',array(),'array');
			if($form['id']==null||$form['id']==''){
				$model = Core::model('Danhmuchethong/Goibienche');
				$id_goibienche = $model->luu_goibienche($form);
				if($id_goibienche>0){
					for($i=0;$i<count($hinhthuc);$i++){
						$dieudong = $jinput->get('dieudong'.$hinhthuc[$i],array(),'array');
						if($dieudong!=null&&count($dieudong)>0){
							$dieudong = implode(',',$dieudong);
							$model->luu_goibienche_hinhthuc($id_goibienche,$hinhthuc[$i],$dieudong);
						}
					}
					Core::printJson($id_goibienche);exit;
				}
				else{
					Core::printJson(false);exit;
				}
			}
			else{
				$model = Core::model('Danhmuchethong/Goibienche');
				$id_goibienche = $model->update_goibienche($form);
				if($id_goibienche>0){
					$model->delete_goibienche_hinhthuc_byid($id_goibienche);
					for($i=0;$i<count($hinhthuc);$i++){
						$dieudong = $jinput->get('dieudong'.$hinhthuc[$i],array(),'array');
						if($dieudong!=null&&count($dieudong)>0){
							$dieudong = implode(',',$dieudong);
							$model->luu_goibienche_hinhthuc($id_goibienche,$hinhthuc[$i],$dieudong);
						}
					}
					Core::printJson($id_goibienche);exit;
				}
				else{
					Core::printJson(false);exit;
				}
			}
		}
		public function delete_goibienche(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Goibienche');
				$model->delete_goibienche_hinhthuc_byid($id);
				Core::printJson($model->delete_goibienche($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function find_goibienche(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Goibienche');
				Core::printJson($model->find_goibienche($id));exit;
			}
			Core::printJson(false);exit;
		}
	}
?>