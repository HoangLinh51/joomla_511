<?php
class Traodoi_Model_Noidung{
	public function create($formData, $option = null){
		$table = Core::table('Traodoi/Noidung');
		$data = array(				
				'chude_id'=>$formData['chude_id'],
				'thongtinlienquan'=>$formData['thongtinlienquan'],
				'nguoitao'=>$formData['nguoitao'],
				'tieude'=>$formData['tieude'],
				'noidung'=>$formData['noidung'],
				'ngaytao'=>date('Y-m-d H:i:s'),				
				'hienthi'=>0
				
		);
		foreach ($data as $key => $value) {
			if (null == $value || '' == $value) {
				unset($data[$key]);
			}
		}
		$table->bind($data);
		return $table->store();	
	}
	
}