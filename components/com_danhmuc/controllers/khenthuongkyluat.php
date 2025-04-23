<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerKhenthuongkyluat extends JControllerLegacy{
		function luu_khenthuongkyluat(){
			$model = Core::model('Danhmuchethong/Khenthuongkyluat');
			$kq = $model->luu_khenthuongkyluat();

			Core::printJson($kq);
		}
		function xoa_khenthuongkyluat(){
			$model = Core::model('Danhmuchethong/Khenthuongkyluat');
			$kq = $model->xoa_khenthuongkyluat();
			Core::printJson($kq);
		}
	}
?>