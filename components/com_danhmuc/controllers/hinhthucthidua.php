<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerHinhthucthidua extends JControllerLegacy{
		function luu_hinhthucthidua(){
			$model = Core::model('Danhmuchethong/Hinhthucthidua');
			$kq = $model->luu_hinhthucthidua();

			Core::printJson($kq);
		}
		function xoa_hinhthucthidua(){
			$model = Core::model('Danhmuchethong/Hinhthucthidua');
			$kq = $model->xoa_hinhthucthidua();
			Core::printJson($kq);
		}
	}
?>