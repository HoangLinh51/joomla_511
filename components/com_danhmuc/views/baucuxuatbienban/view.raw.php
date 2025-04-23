<?php
defined('_JEXEC') or die('Restricted access');
class DanhmucViewBaucuxuatbienban extends JViewLegacy
{
	function display($tpl = null)
	{
		$tbl = 'baucu_baucuxuatbienban';
		$this->tbl = $tbl;
		$task = JRequest::getVar('task');
		switch ($task) {
			case 'default_bm21':
				$this->setLayout('default_bm21');
				break;
			case 'default_bm22':
				$this->setLayout('default_bm22');
				break;
			case 'default_bm26':
				$this->setLayout('default_bm26');
				break;
			case 'default_bm27':
				$this->setLayout('default_bm27');
				break;
			case 'default_bm30':
				$this->setLayout('default_bm30');
				break;
			case 'default_bm32':
				$this->setLayout('default_bm32');
				break;
			case 'default_khuvucbophieu':
				$this->setLayout('default_khuvucbophieu');
				break;
			case 'default_danhsachcutri':
				$this->setLayout('default_danhsachcutri');
				break;
			case 'default':
				$this->setLayout('default');
				break;
			case 'danhsach':
				$this->danhsach();
				break;
			default:
				$this->setLayout('hoso_404');
				break;
			case 'taimau':
				$this->taimau();
				break;
			case 'getDonvibaucu':
				$this->getDonvibaucu();
				break;
			case 'getDonvi':
				$this->getDonvi();
				break;
			case 'taimau_khuvucbophieu':
				$this->taimau_khuvucbophieu();
				break;
			case 'taimau_danhsachcutri':
				$this->taimau_danhsachcutri();
				break;
		}
		parent::display($tpl);
	}

	function taimau()
	{
		$bieumau = JRequest::getVar('bieumau', '');
		// $capbaucu_id = JRequest::getInt('capbaucu_id', 0, 'int');
		// $dotbaucu_id = JRequest::getInt('dotbaucu_id', 0, 'int');
		// $donvibaucu_id = JRequest::getInt('donvibaucu_id', 0, 'int');
		// $this->dotbaucu_id = $dotbaucu_id;
		// $this->donvibaucu_id = $donvibaucu_id;
		// $this->capbaucu = Core::loadAssoc('baucu_capbaucu','*','id='.(int)$capbaucu_id);
		// $this->donvibaucu = Core::loadAssoc('baucu_donvibaucu','*','id='.(int)$donvibaucu_id);
		// if(in_array($bieumau, array('bm21','bm22','bm26','bm27','bm30','bm32')))
		// 	$this->setLayout($bieumau);
		// else $this->setLayout('hoso_404');
		$this->danhsach();
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-type: application/vnd.ms-word; charset=utf-8'");
		header("Content-Disposition: attachment; Filename=BieuMau_" . $bieumau . '_' . date('dmyHis') . ".doc");
	}
	function danhsach()
	{
		$bieumau = JRequest::getVar('bieumau', '');
		$capbaucu_id = JRequest::getInt('capbaucu_id', 0, 'int');
		$dotbaucu_id = JRequest::getInt('dotbaucu_id', 0, 'int');
		$donvibaucu_id = JRequest::getInt('donvibaucu_id', 0, 'int');
		$this->dotbaucu_id = $dotbaucu_id;
		$this->donvibaucu_id = $donvibaucu_id;
		$this->capbaucu = Core::loadAssoc('baucu_capbaucu', '*', 'id=' . (int)$capbaucu_id);
		$this->donvibaucu = Core::loadAssoc('baucu_donvibaucu', '*', 'id=' . (int)$donvibaucu_id);
		if (in_array($bieumau, array('bm21', 'bm22', 'bm26', 'bm27', 'bm30', 'bm32', 'bmkhuvucbophieu', 'bmdanhsachcutri')))
			$this->setLayout($bieumau);
		else $this->setLayout('hoso_404');
	}
	function getDonvibaucu()
	{
		$capbaucu_id = JRequest::getVar('capbaucu_id', 0);
		$dotbaucu_id = JRequest::getVar('dotbaucu_id', 0);
		$user_id = JFactory::getUser()->id;
		$config = json_decode(Core::config('baucu/tonghop/donvibaucu'));
		$donvi_loaitru = $config-> $user_id;
		// $donvi_loaitru =0;
		$kq = Core::loadAssocList('baucu_donvibaucu a', '*, (select ten from baucu_diadiemhanhchinh where id=a.diaphuongbaucu_id limit 1) as diaphuongbaucu ', 'daxoa=0 AND a.dotbaucu_id=' . (int)$dotbaucu_id . ' AND a.capbaucu_id=' . (int)$capbaucu_id.' AND a.id IN ('.$donvi_loaitru.')', 'a.diaphuongbaucu_id asc, a.ten asc');
		// mở cái này ra để test chọn nhiều đơn vị bầu cử khác
		// $kq = Core::loadAssocList('baucu_donvibaucu a', '*, (select ten from baucu_diadiemhanhchinh where id=a.diaphuongbaucu_id limit 1) as diaphuongbaucu ', 'daxoa=0 AND a.dotbaucu_id=' . (int)$dotbaucu_id . ' AND a.capbaucu_id=' . (int)$capbaucu_id, 'a.diaphuongbaucu_id asc, a.ten asc');
		Core::printJson($kq);
	}
	function getDonvi()
	{
		$capbaucu_id = JRequest::getVar('capbaucu_id', 0);
		$dotbaucu_id = JRequest::getVar('dotbaucu_id', 0);
		$kq = Core::loadAssocList('baucu_diadiemhanhchinh a', '*, (select ten from baucu_diadiemhanhchinh where id=a.parent_id limit 1) as diaphuongbaucu', 'daxoa=0 AND a.cap=' . (int)$capbaucu_id, 'a.ten asc');
		Core::printJson($kq);
	}
	function taimau_khuvucbophieu()
	{
		require_once JPATH_LIBRARIES . '/phpexcel/Classes/PHPExcel/IOFactory.php';
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0); /* chon sheet active la sheet 1 */
		$activeSheet = $objPHPExcel->getActiveSheet(); /* get sheet active */
		$styleArray = array(
			'font' => array(
				'bold' => true
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$border = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$activeSheet->getStyle('A1:AZ2')->applyFromArray($styleArray);
		$activeSheet->setCellValue('A1', 'Thông tin chung');
		$activeSheet->getStyle('A1:L1')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'b8cce4'))));
		$activeSheet->mergeCells('A1:L1');





		
		ob_end_clean();
		$excelFileName = 'Export'.date('d_m_Y');
		if ($type==1) $excelFileName.='_ID';
		else $excelFileName.='_Name';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $excelFileName .'.xls"');
		header('Cache-Control: max-age=1');
		header ('Expires: Mon, 20 Jan 2015 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
	
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save('php://output');
		exit();
	}
	function taimau_danhsachcutri()
	{
	}
}
