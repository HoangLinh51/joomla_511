<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerHinhthucchucdanhcongtac extends JControllerLegacy{
		function luu_hinhthucchucdanhcongtac(){
			$model = Core::model('Danhmuchethong/Hinhthucchucdanhcongtac');
			$kq = $model->luu_hinhthucchucdanhcongtac();

			Core::printJson($kq);
		}
		function xoa_hinhthucchucdanhcongtac(){
			$model = Core::model('Danhmuchethong/Hinhthucchucdanhcongtac');
			$kq = $model->xoa_hinhthucchucdanhcongtac();
			Core::printJson($kq);
		}
	}
?>