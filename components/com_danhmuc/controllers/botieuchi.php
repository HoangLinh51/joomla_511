<?php 
	class DanhmucControllerBotieuchi extends DanhmucController{
		public function reset_tree_botieuchi(){
			$table = Core::table('Danhgia/Botieuchi');
            $table->rebuild();
            $app = JFactory::getApplication();
            $link = 'index.php?option=com_danhmuc&controller=danhgia&task=ds_botieuchi';
            $url = JRoute::_($link);
            $app->redirect($url);
		}
		public function sapxeplen_tree_botieuchi(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$table = Core::table('Danhgia/Botieuchi');
           	 	$table->orderUp($id);
			}
            $app = JFactory::getApplication();
            $link = 'index.php?option=com_danhmuc&controller=danhgia&task=ds_botieuchi';
            $url = JRoute::_($link);
            $app->redirect($url);
		}
		public function sapxepxuong_tree_botieuchi(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			if($id>0){
				$table = Core::table('Danhgia/Botieuchi');
            	$table->orderDown($id);
			}
            $app = JFactory::getApplication();
            $link = 'index.php?option=com_danhmuc&controller=danhgia&task=ds_botieuchi';
            $url = JRoute::_($link);
            $app->redirect($url);
		}
		public function luu_botieuchi(){
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$tieuchi = $jinput->get('tieuchi',array(),'array');
			$diem_min_tieuchi = $jinput->get('diem_min_tieuchi',array(),'array');
			$diem_max_tieuchi = $jinput->get('diem_max_tieuchi',array(),'array');
			// var_dump($diem_max_tieuchi);die;
			$code_xeploai_tieuchi = $jinput->get('code_xeploai_tieuchi',array(),'array');
			$id_tieuchi_phanloai = $jinput->get('id_tieuchi_phanloai',array(),'array');
			// var_dump($id_tieuchi_phanloai);die;
			$id_theonhiemvu = $jinput->get('id_theonhiemvu',array(),'array');
			$diem_min = $jinput->get('diem_min',array(),'array');
			$diem_max = $jinput->get('diem_max',array(),'array');
			$id_tieuchuan_dg = $jinput->get('id_tieuchuan_dg',array(),'array');
			$model = Core::model('Danhmuchethong/Botieuchi');
			if($form['id']==''){
				$id_botieuchi = $model->add_botieuchi($form);
			}
			else{
				$model->delete_dgcbcc_fk_botieuchi_tieuchi_by_botieuchi_id($form['id']);
				$model->delete_dgcbcc_fk_theonhiemvu_botieuchi_by_id_botieuchi($form['id']);
				$model->delete_dgcbcc_fk_tieuchuan_dg_botieuchi_by_id_botieuchi($form['id']);
				$id_botieuchi = $model->update_botieuchi($form);
			}
			if($id_botieuchi>0&&count($tieuchi)>0){
				for($i=0;$i<count($diem_min_tieuchi);$i++){
					if($tieuchi[$i]!=null&&$tieuchi[$i]>0){
						$model->add_dgcbcc_fk_botieuchi_tieuchi($id_botieuchi,$tieuchi[$i],$diem_min_tieuchi[$i],$diem_max_tieuchi[$i],$code_xeploai_tieuchi[$i],$id_tieuchi_phanloai[$i]);
					}					
				}
			}
			if($id_botieuchi>0&&count($id_theonhiemvu)>0){
				for($i=0;$i<count($id_theonhiemvu);$i++){
					$diem_min_value = (int) $diem_min[$id_theonhiemvu[$i]];
					$diem_max_value = (int) $diem_max[$id_theonhiemvu[$i]];
					$model->add_dgcbcc_fk_theonhiemvu_botieuchi($id_botieuchi,$id_theonhiemvu[$i],$diem_min_value,$diem_max_value);
				}
			}
			if($id_botieuchi>0&&count($id_tieuchuan_dg)>0){
				for($i=0;$i<count($id_tieuchuan_dg);$i++){
					$model->add_dgcbcc_fk_tieuchuan_dg_botieuchi($id_botieuchi,$id_tieuchuan_dg[$i]);
				}
			}
			Core::printJson($id_botieuchi);exit;
		}
		public function find_tieuchi_by_nhomtieuchi(){
			$jinput = JFactory::getApplication()->input;
			$id_nhomtieuchi = $jinput->getInt('id_nhomtieuchi',0);
			$model = Core::model('Danhmuchethong/Tieuchi');
			if($id_nhomtieuchi>0){
				Core::printJson($model->find_tieuchi_by_nhomtieuchi($id_nhomtieuchi));exit;
			}
			Core::printJson(false);exit;
		}
		public function delete_botieuchi(){
			$jinput = JFactory::getApplication()->input;
			$id = $jinput->getInt('id',0);
			$model = Core::model('Danhmuchethong/Botieuchi');
			if($id>0){
				Core::printJson($model->delete_botieuchi($id));exit;
			}
			Core::printJson(false);exit;
		}
		public function saochep_botieuchi(){
			JSession::checkToken() or die('Invalid Token');
			$jinput = JFactory::getApplication()->input;
			$form = $jinput->get('frm',array(),'array');
			$model = Core::model('Danhmuchethong/Botieuchi');
			$result = $model->saochep_botieuchi($form);
			$count = 0;
			if(count($result)>0){
				for($i=0;$i<count($result);$i++){
					if($result[$i]==true){
						$count++;
					}
				}
				if($count>0){
					Core::printJson(true);exit;
				}
				else{
					Core::printJson(false);exit;
				}
			}
			else{
				Core::printJson(false);exit;
			}		
		}
		public function find_tieuchuan_by_nhiemvu_id(){
			$jinput = JFactory::getApplication()->input;
			$checkbox_id_theonhiemvu = $jinput->getString('checkbox_id_theonhiemvu','');
			if(count($checkbox_id_theonhiemvu>0)){
				$model = Core::model('Danhmuchethong/Botieuchi');
				Core::printJson($model->find_tieuchuan_by_nhiemvu_id($checkbox_id_theonhiemvu));exit;
			}
			else{
				Core::printJson(false);exit;
			}
		}
	}
?>