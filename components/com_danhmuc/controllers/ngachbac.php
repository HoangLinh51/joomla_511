<?php 
	class DanhmucControllerNgachbac extends DanhmucController{
		public function luu_ngachbac(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$idbac = $jinput->get('idbac',array(),'array');
			$heso = $jinput->get('heso',array(),'array');
			$id_nhomngach_heso = $jinput->get('id_nhomngach_heso',array(),'array');
			$model = Core::model('Danhmuchethong/Ngachbac');
			if($form['id']==''){
				$id_ngachbac = $model->add_ngachbac($form,$idbac,$heso);
				if($id_ngachbac>0&&count($idbac)>0&&count($heso)>0){
					for($i=0;$i<count($idbac);$i++){
						// add nhomngach vào
						$model->add_cb_nhomngach_heso($id_ngachbac,$idbac[$i],$heso[$i], $form['code']);
					}
				}
				Core::printJson($id_ngachbac);die;
			}
			else{
				$id_ngachbac = $model->update_ngachbac($form,$idbac,$heso);
				// $model->delete_cb_nhomngach_heso($id_ngachbac);
				$ds_cb_bac_heso = $model->find_cb_bac_heso_by_manhom($id_ngachbac);
				// var_dump($ds_cb_bac_heso);die;
				if(count($ds_cb_bac_heso)>0){
					for($i=0;$i<count($ds_cb_bac_heso);$i++){
						$model->delete_cb_nhomngach_heso($ds_cb_bac_heso[$i]['id']);
					}
				}
				if($id_ngachbac>0&&count($idbac)>0&&count($heso)>0){
					for($i=0;$i<count($idbac);$i++){
						if($id_nhomngach_heso[$i]==0){
							$model->add_cb_nhomngach_heso($id_ngachbac,$idbac[$i],$heso[$i], $form['code']);
						}
						else if($id_nhomngach_heso[$i]>0){
							$model->update_cb_nhomngach_heso($id_nhomngach_heso[$i],$idbac[$i],$heso[$i], $form['code']);
						}
						if(count($ds_cb_bac_heso)>0){
							for($j=0;$j<count($ds_cb_bac_heso);$j++){
								$model->add_cb_nhomngach_heso($ds_cb_bac_heso[$j]['id'],$idbac[$i],$heso[$i], $ds_cb_bac_heso[$j]['mangach']);
							}
						}
					}
				}
				Core::printJson($id_ngachbac);die;
			}
		}
		public function luu_thongtin_ngachbac(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Ngachbac');
			if($form['id']==''){
				$id_ngachbac = $model->add_thongtin_ngachbac($form);
				if($id_ngachbac>0){
					$ds_nhomngach_heso = $model->find_nhomngach_heso_by_id_ngach($form['manhom']);
					for($i=0;$i<count($ds_nhomngach_heso);$i++){
						$model->add_cb_nhomngach_heso($id_ngachbac,$ds_nhomngach_heso[$i]['idbac'],$ds_nhomngach_heso[$i]['heso'],$form['mangach']);
					}
					Core::printJson(true);exit;
				}
				Core::printJson(false);exit;
			}
			else{
				$rs = $model->update_thongtin_ngachbac($form);
				$cb_nhomngach_heso = Core::loadAssocList('cb_nhomngach_heso','*','id_ngach = '.(int)$form['id']);
				// update lại tên
				for($i=0; $i<count($cb_nhomngach_heso);$i++){
					$model->update_cb_nhomngach_heso($cb_nhomngach_heso[$i]['id'], $cb_nhomngach_heso[$i]['idbac'], $cb_nhomngach_heso[$i]['heso'],$form['mangach']);
				}
				Core::printJson($rs);exit;
			}
		}
		public function delete_cb_nhomngach_heso_by_id(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$model = Core::model('Danhmuchethong/Ngachbac');
				Core::printJson($model->delete_cb_nhomngach_heso_by_id($id));exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
		public function delete_cb_bac_heso(){
			$jinput = JFactory::getApplication()->input;
			$array_id = $jinput->getInt('array_id',0);
			if(count($array_id)>0){
				$model = Core::model('Danhmuchethong/Ngachbac');
				for($i=0;$i<count($array_id);$i++){
					$result[] = $model->delete_cb_bac_heso($array_id[$i]);
					$model->delete_cb_nhomngach_heso($array_id[$i]);
				}
				Core::printJson($result);exit;
			}
			Core::printJson(false);exit;
		}
	}
?>