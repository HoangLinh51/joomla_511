<?php 
	defined('_JEXEC') or die('Restricted Access');
	class DanhmucControllerKetquathidua extends JControllerLegacy{
		function luu_ketquathidua(){
			$model = Core::model('Danhmuchethong/Ketquathidua');
			$kq = $model->luu_ketquathidua();

			Core::printJson($kq);
		}
		function xoa_ketquathidua(){
			$model = Core::model('Danhmuchethong/Ketquathidua');
			$kq = $model->xoa_ketquathidua();
			Core::printJson($kq);
		}
	}
?>