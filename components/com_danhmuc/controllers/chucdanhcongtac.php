<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerChucdanhcongtac extends JControllerLegacy{
		function luu_chucdanhcongtac(){
			$model = Core::model('Danhmuchethong/Chucdanhcongtac');
			$kq = $model->luu_chucdanhcongtac();

			Core::printJson($kq);
		}
		function xoa_chucdanhcongtac(){
			$model = Core::model('Danhmuchethong/Chucdanhcongtac');
			$kq = $model->xoa_chucdanhcongtac();
			Core::printJson($kq);
		}
	}
?>