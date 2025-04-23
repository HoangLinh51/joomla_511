<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerDetainckh extends JControllerLegacy{
		function luu_detainckh(){
			$model = Core::model('Danhmuchethong/Detainckh');
			$kq = $model->luu_detainckh();

			Core::printJson($kq);
		}
		function xoa_detainckh(){
			$model = Core::model('Danhmuchethong/Detainckh');
			$kq = $model->xoa_detainckh();
			Core::printJson($kq);
		}
	}
?>