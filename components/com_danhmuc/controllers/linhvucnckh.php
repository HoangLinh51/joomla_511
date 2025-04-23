<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerLinhvucnckh extends JControllerLegacy{
		function luu_linhvucnckh(){
			$model = Core::model('Danhmuchethong/Linhvucnckh');
			$kq = $model->luu_linhvucnckh();

			Core::printJson($kq);
		}
		function xoa_linhvucnckh(){
			$model = Core::model('Danhmuchethong/Linhvucnckh');
			$kq = $model->xoa_linhvucnckh();
			Core::printJson($kq);
		}
	}
?>