<?php
defined('_JEXEC') or die('Restricted access');
class Danhmucfront_Model_Baucucauhinhemail
{
	function guiemail($phuongxa_id)
	{
		$return = false;
		$guiemail = Core::loadAssocList('baucu_cauhinh_capbaucunhanemail', '*', 'diadiemhanhchinh_id=' . (int)$phuongxa_id);
		for ($i = 0; $i < count($guiemail); $i++) {
			$email = Core::loadAssoc('baucu_cauhinh_capbaucu2email', '*', 'capbaucunhanemail_id=' . $guiemail[$i]['id']);
			// var_dump($email);continue;
			if (strlen(trim($email['email'])) > 0) {
				$email['email'] = $this->stringToArrDb(str_replace(';',',',$email['email']));
				foreach($email['email'] as $k => $v){
					$form = array();
					$form['nguoinhan'] = str_replace("'","",$v);
					$form['subject'] =  'THÔNG BÁO BẦU CỬ ĐƠN VỊ '.Core::loadResult('ins_dept','name','id='.(int)$phuongxa_id);
					$form['body'] = 'Các tổ bầu cử của tại '.Core::loadResult('ins_dept','name','id='.(int)$phuongxa_id).' đã hoàn thành nhập thông tin số lượng phiếu bầu!';
					$form['fromname'] = 'DNICT';
					$form['mailfrom'] = 'dnict@gmail.com';
					$return = $this->send_email($form);
				}
			}
		}
		return $return;
	}
	function send_email($formData)
	{
		// $config = JFactory::getConfig();
		// $nguoinhan = $user->email;
		// $ar = array('phucnh.dnict@gmail.com','phucnhapp@gmail.com');
		// $nguoinhan = $formData['nguoinhan'];
		$data['nguoinhan'] = $formData['nguoinhan'];
		$data['subject'] = $formData['subject'];
		$data['body'] = $formData['body'];
		$data['fromname'] = $formData['fromname'];
		$data['mailfrom'] = $formData['mailfrom'];
		// var_dump($data);
		// $return = $return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $nguoinhan, $subject, $body, false, null, 'phucnh.dnict@gmail.com');
		$return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['nguoinhan'], $data['subject'], $data['body']);
		return $return;
		// Core::printJson($return);
	}
	public function save($formData)
	{
		// lấy id với diadiemhanhchinh_id và capbaucu_id
		// có thì update, ko có thì new, trả về từng id rồi cập nhật email
		for ($i = 0; $i < count($formData['capbaucu_id']); $i++) {
			$form[] = array();
			$form['diadiemhanhchinh_id'] = $formData['diadiemhanhchinh_id'];
			$form['capbaucu_id'] = $formData['capbaucu_id'][$i];
			$form['email'] = $formData['email'][$i];
			// if(Core::loadResult('baucu_cauhinh_capbaucunhanemail','id','diadiemhanhchinh_id='.(int)$form['diadiemhanhchinh_id'].' AND capbaucu_id='.(int)$form['capbaucu_id']) > 0)
			$form['capbaucunhanemail_id'] = $this->saveCauhinhemail($form);
			$form['id'] = $formData['fk_id'][$i];
			$this->saveCauhinhFk($form);
		}
		return true;
	}
	public function saveCauhinhemail($formData)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
			$db->quoteName('diadiemhanhchinh_id') . ' = ' . $db->quote($formData['diadiemhanhchinh_id']),
			$db->quoteName('capbaucu_id') . ' = ' . $db->quote($formData['capbaucu_id']),
		);
		$tmp_id = Core::loadResult('baucu_cauhinh_capbaucunhanemail', 'id', 'diadiemhanhchinh_id=' . (int)$formData['diadiemhanhchinh_id'] . ' AND capbaucu_id=' . (int)$formData['capbaucu_id']);
		if ($tmp_id > 0) {
			array_push($fields, $db->quoteName('ngayhieuchinh') . ' = now()');
			array_push($fields, $db->quoteName('nguoihieuchinh_id') . ' = ' . JFactory::getUser()->id);
			$conditions = array(
				$db->quoteName('diadiemhanhchinh_id') . ' = ' . $db->quote($formData['diadiemhanhchinh_id']),
				$db->quoteName('capbaucu_id') . ' = ' . $db->quote($formData['capbaucu_id']),
			);
			$query->update($db->quoteName('baucu_cauhinh_capbaucunhanemail'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$db->query();
			return $tmp_id;
		} else {
			array_push($fields, $db->quoteName('daxoa') . ' = 0');
			array_push($fields, $db->quoteName('ngaytao') . ' = now()');
			array_push($fields, $db->quoteName('nguoitao_id') . ' = ' . JFactory::getUser()->id);
			$query->insert($db->quoteName('baucu_cauhinh_capbaucunhanemail'));
			$query->set($fields);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();
		}
	}
	public function saveCauhinhFk($formData)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
			$db->quoteName('capbaucunhanemail_id') . ' = ' . $db->quote($formData['capbaucunhanemail_id']),
			$db->quoteName('email') . ' = ' . $db->quote($formData['email']),
		);
		if (isset($formData['id']) && $formData['id'] > 0) {
			$conditions = array(
				$db->quoteName('id') . '=' . $db->quote($formData['id'])
			);
			$query->update($db->quoteName('baucu_cauhinh_capbaucu2email'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$db->query();
			return $formData['id'];
		} else {
			$query->insert($db->quoteName('baucu_cauhinh_capbaucu2email'));
			$query->set($fields);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();
		}
	}
	// function xoa($id)
	// {
	// 	$db = JFactory::getDbo();
	// 	$query = $db->getQuery(true);
	// 	if ($id != null && count($id) > 0 && is_array($id))
	// 		$conditions = array(
	// 			$db->quoteName('id') . ' IN (' . implode(',', $db->quote($id)) . ')'
	// 		);
	// 	else return false;

	// 	// Dùng cái này nếu xóa hẳn row
	// 	// $query->delete('baucu_cauhinhemail');
	// 	// $query->where($conditions);

	// 	// Dùng cái này nếu có daxoa
	// 	$fields = array(
	// 		$db->quoteName('daxoa') . ' = 1',
	// 		$db->quoteName('trangthai') . ' = 0',
	// 	);
	// 	$query->update($db->quoteName('baucu_cauhinhemail'))->set($fields)->where($conditions);

	// 	$db->setQuery($query);
	// 	return $db->query();
	// }
	function get($id)
	{
		$db = JFactory::getDbo();
		return Core::loadAssoc('baucu_cauhinhemail', '*', 'id=' . $db->quote($id));
	}
	/**
	 * Chuyển string sang array, bắt SQL-injection, các filter string/int đều phải bọc
	 * input: string
	 * output: array
	 */
	static function stringToArrDb($string)
	{
		$db = JFactory::getDbo();
		if ($string != null && $string != 'null' && $string != '' && $string != 'undefined')
			$arr = explode(',', $string);
		$rs = [];
		if (is_array($arr)) {
			foreach ($arr as $k => $v) {
				$rs[] = $db->quote($v);
			}
		}
		return $rs;
	}
}
