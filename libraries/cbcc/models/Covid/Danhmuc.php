<?php
class Covid_Model_Danhmuc extends JModelLegacy{
    public function getDanhsachKhuvuc(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*,b.ten AS cha');
        $query->from('dmh_danhmuckhuvuc AS a');
        $query->innerJoin('dmh_danhmuckhuvuc AS b ON a.cha_id = b.id');
        $query->where('a.daxoa = 0');
        $query->order('a.level,b.ten ASC, a.ten ASC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDanhsachNhacungcap(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*');
        $query->from('dmh_danhmucnhacungcap AS a');
        $query->where('a.daxoa = 0');
        $query->order('a.ten');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDanhsachNhomThucpham(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*');
        $query->from('dmh_danhmucnhomhanghoa AS a');
        $query->where('a.daxoa = 0');
        $query->order('a.ten');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDanhsachThucpham(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*,b.ten AS nhomhanghoa,c.ten AS nhacungcap');
        $query->from('dmh_danhmuchanghoa AS a');
        $query->innerJoin('dmh_danhmucnhomhanghoa AS b ON a.nhomhanghoa_id = b.id');
        $query->innerJoin('dmh_danhmucnhacungcap AS c ON a.nhacungcap_id = c.id');
        $query->where('a.daxoa = 0');
        $query->order('c.ten,b.sapxep,a.ten');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDanhsachNguoidangky(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*,CONCAT(b1.ten," - ",b2.ten," - ",b3.ten) AS khuvuc');
        $query->from('dmh_thongtinnguoidangky AS a');
        $query->innerJoin('dmh_danhmuckhuvuc AS b1 ON a.thonto_id = b1.id');
        $query->innerJoin('dmh_danhmuckhuvuc AS b2 ON a.phuongxa_id = b2.id');
        $query->innerJoin('dmh_danhmuckhuvuc AS b3 ON a.quanhuyen_id = b3.id');
        $query->where('a.daxoa = 0');
        $query->order('a.hovaten');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDanhsachNguoiquanly(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*,CONCAT(b.name," (",b.username,")") AS taikhoan');
        $query->from('dmh_thongtinnguoiquanly AS a');
        $query->innerJoin('#__users AS b ON a.user_id = b.id AND b.id > 100');
        $query->where('a.daxoa = 0');
        $query->group('a.id');
        $query->order('a.hovaten');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDanhsachZaloLoi(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,b.hovaten,a.sodienthoai,a.noidung,a.error,DATE_FORMAT(a.thoigian,"%h:%i:%s %d/%m/%Y") AS thoigian,c.name AS nguoithuchien');
        $query->from('dmh_loizalo AS a');
        $query->innerJoin('dmh_thongtinnguoiquanly AS b ON a.sodienthoai = b.sodienthoai');
        $query->innerJoin('#__users AS c ON a.nguoithuchien = c.id');
        $query->where('a.daxoa = 0');
        $query->order('a.thoigian DESC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDanhsachTaikhoan(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.name,a.username,a.email,a.block,a.requireReset,GROUP_CONCAT(c.title SEPARATOR "<br/>") AS nhomnguoidung');
        $query->from('#__users AS a');
        $query->innerJoin('#__user_usergroup_map AS b ON a.id = b.user_id');
        $query->innerJoin('#__usergroups AS c ON b.group_id = c.id AND c.id > 9');
        $query->where('a.id > 100');
        $query->group('a.id');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getNhacungcapById($nhacungcap_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*,GROUP_CONCAT(b.khuvuc_id) AS phuongxa');
        $query->from('dmh_danhmucnhacungcap AS a');
        $query->leftJoin('dmh_gioihannhacungcap AS b ON a.id = b.nhacungcap_id');
        $query->where('a.id = '.$db->quote($nhacungcap_id));
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    public function getNhomThucphamById($nhomthucpham_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*');
        $query->from('dmh_danhmucnhomhanghoa AS a');
        $query->where('a.id = '.$db->quote($nhomthucpham_id));
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    public function getThucphamById($thucpham_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*');
        $query->from('dmh_danhmuchanghoa AS a');
        $query->where('a.id = '.$db->quote($thucpham_id));
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    public function getKhuvucById($khuvuc_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*');
        $query->from('dmh_danhmuckhuvuc AS a');
        $query->where('a.id = '.$db->quote($khuvuc_id));
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    public function getNguoidangkyById($nguoidangky_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*');
        $query->from('dmh_thongtinnguoidangky AS a');
        $query->where('a.id = '.$db->quote($nguoidangky_id));
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    public function getNguoiquanlyById($nguoiquanly_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*');
        $query->from('dmh_thongtinnguoiquanly AS a');
        $query->where('a.id = '.$db->quote($nguoiquanly_id));
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    public function getTaikhoanById($taikhoan_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*,b.group_id,c.*');
        $query->from('#__users AS a');
        $query->innerJoin('#__user_usergroup_map AS b ON a.id = b.user_id AND b.group_id > 9');
        $query->leftJoin('dmh_user2danhmuckhuvuc AS c ON a.id = c.user_id');
        $query->where('a.id = '.$db->quote($taikhoan_id));
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    public function saveNhacungcap($formData){
        $db = JFactory::getDbo();
        $data = array(
            'id' => $formData['id'],
            'ten' => trim($formData['ten']),
            'is_macdinh' => $formData['is_macdinh'],
            'sudung' => $formData['sudung']
		);
		foreach ($data as $key => $value) {
            if ($value == '' || $value == null) {
                unset($data[$key]);
                $data_update[] = $key . " = NULL";
            } else {
                $data_insert_key[] = $key;
                $data_insert_val[] = $db->quote($value);
                $data_update[] = $key . " = " . $db->quote($value);
            }
		}
        $query = $db->getQuery(true);
        if ((int) $data['id'] == 0) {
            $query->insert($db->quoteName('dmh_danhmucnhacungcap'))->columns($data_insert_key)->values(implode(',', $data_insert_val));
        }else{
            $query->update($db->quoteName('dmh_danhmucnhacungcap'));
            $query->set(implode(',', $data_update));
            $query->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }
        $db->setQuery($query);
        if(!$db->query()){
            return false;
        }
        if ((int) $data['id'] == 0){ 
            $formData['id'] = $db->insertid();
        }else{
            $query = $db->getQuery(true);
            $query->delete('dmh_gioihannhacungcap')->where('nhacungcap_id = '.$db->quote($formData['id']));
            $db->setQuery($query);
            if(!$db->query()){
                return false;
            }
        }
        if(count($formData['phuongxa_id']) > 0){
            for($i = 0, $n = count($formData['phuongxa_id']); $i < $n; $i++){
                $val_insert[] = $db->quote($formData['id']).','.$db->quote($formData['phuongxa_id'][$i]);
            }
            $query = $db->getQuery(true);
            $query->insert('dmh_gioihannhacungcap')->columns('nhacungcap_id,khuvuc_id');
            $query->values($val_insert);
            $db->setQuery($query);
            if(!$db->query()){
                return false;
            }
        }
        return true;
    }
    public function saveNhomThucpham($formData){
        $db = JFactory::getDbo();
        $data = array(
            'id' => $formData['id'],
            'ten' => trim($formData['ten']),
            'sapxep' => $formData['sapxep'],
            'sudung' => $formData['sudung']
		);
		foreach ($data as $key => $value) {
            if ($value == '' || $value == null) {
                unset($data[$key]);
                $data_update[] = $key . " = NULL";
            } else {
                $data_insert_key[] = $key;
                $data_insert_val[] = $db->quote($value);
                $data_update[] = $key . " = " . $db->quote($value);
            }
		}
        $query = $db->getQuery(true);
        if ((int) $data['id'] == 0) {
            $query->insert($db->quoteName('dmh_danhmucnhomhanghoa'))->columns($data_insert_key)->values(implode(',', $data_insert_val));
        }else{
            $query->update($db->quoteName('dmh_danhmucnhomhanghoa'));
            $query->set(implode(',', $data_update));
            $query->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }
        $db->setQuery($query);
        return $db->query();
    }
    public function saveThucpham($formData){
        $db = JFactory::getDbo();
        $data = array(
            'id' => $formData['id'],
            'nhacungcap_id' => $formData['nhacungcap_id'],
            'nhomhanghoa_id' => $formData['nhomhanghoa_id'],
            'ten' => trim($formData['ten']),
            'dvt' => trim($formData['dvt']),
            'giathamkhao' => $formData['giathamkhao'],
            'is_macdinh' => $formData['is_macdinh'],
            'sudung' => $formData['sudung']
		);
		foreach ($data as $key => $value) {
            if ($value == '' || $value == null) {
                unset($data[$key]);
                $data_update[] = $key . " = NULL";
            } else {
                $data_insert_key[] = $key;
                $data_insert_val[] = $db->quote($value);
                $data_update[] = $key . " = " . $db->quote($value);
            }
		}
        $query = $db->getQuery(true);
        if ((int) $data['id'] == 0) {
            $query->insert($db->quoteName('dmh_danhmuchanghoa'))->columns($data_insert_key)->values(implode(',', $data_insert_val));
        }else{
            $query->update($db->quoteName('dmh_danhmuchanghoa'));
            $query->set(implode(',', $data_update));
            $query->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }
        $db->setQuery($query);
        return $db->query();
    }
    public function saveThucphamNhieu($formData){
        $db = JFactory::getDbo();
        for($i = 0, $n = count($formData['nhacungcap_id']); $i < $n; $i++){
            $vals[] = $db->quote($formData['nhacungcap_id'][$i]).','.$db->quote($formData['nhomhanghoa_id'][$i]).','.$db->quote($formData['ten'][$i]).','.$db->quote($formData['dvt'][$i]).','.$db->quote($formData['giathamkhao'][$i]).','.$db->quote($formData['is_macdinh'][$i]).','.$db->quote($formData['sudung'][$i]);
        }
        $query = $db->getQuery(true);
        $query->insert($db->quoteName('dmh_danhmuchanghoa'))->columns('nhacungcap_id,nhomhanghoa_id,ten,dvt,giathamkhao,is_macdinh,sudung');
        $query->values($vals);
        $db->setQuery($query);
        return $db->query();
    }
    public function saveKhuvuc($formData){
        $db = JFactory::getDbo();
        $data = array(
            'id' => $formData['id'],
            'ten' => trim($formData['ten']),
            'cha_id' => $formData['cha_id'],
            'level' => $formData['level'],
            'sudung' => $formData['sudung']
		);
		foreach ($data as $key => $value) {
            if ($value == '' || $value == null) {
                unset($data[$key]);
                $data_update[] = $key . " = NULL";
            } else {
                $data_insert_key[] = $key;
                $data_insert_val[] = $db->quote($value);
                $data_update[] = $key . " = " . $db->quote($value);
            }
		}
        $query = $db->getQuery(true);
        if ((int) $data['id'] == 0) {
            $query->insert($db->quoteName('dmh_danhmuckhuvuc'))->columns($data_insert_key)->values(implode(',', $data_insert_val));
        }else{
            $query->update($db->quoteName('dmh_danhmuckhuvuc'));
            $query->set(implode(',', $data_update));
            $query->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }
        $db->setQuery($query);
        return $db->query();
    }
    public function saveNguoidangky($formData){
        $db = JFactory::getDbo();
        $data = array(
            'id' => $formData['id'],
            'hovaten' => trim($formData['hovaten']),
            'diachi' => trim($formData['diachi']),
            'quanhuyen_id' => $formData['quanhuyen_id'],
            'phuongxa_id' => $formData['phuongxa_id'],
            'thonto_id' => $formData['thonto_id'],
            'sodienthoai' => $formData['sodienthoai'],
            'sokhau' => $formData['sokhau']
		);
		foreach ($data as $key => $value) {
            if ($value == '' || $value == null) {
                unset($data[$key]);
                $data_update[] = $key . " = NULL";
            } else {
                $data_insert_key[] = $key;
                $data_insert_val[] = $db->quote($value);
                $data_update[] = $key . " = " . $db->quote($value);
            }
		}
        $query = $db->getQuery(true);
        if ((int) $data['id'] == 0) {
            $query->insert($db->quoteName('dmh_thongtinnguoidangky'))->columns($data_insert_key)->values(implode(',', $data_insert_val));
        }else{
            $query->update($db->quoteName('dmh_thongtinnguoidangky'));
            $query->set(implode(',', $data_update));
            $query->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }
        $db->setQuery($query);
        return $db->query();
    }
    public function saveNguoiquanly($formData){
        $db = JFactory::getDbo();
        $data = array(
            'id' => $formData['id'],
            'hovaten' => trim($formData['hovaten']),
            'sodienthoai' => $formData['sodienthoai'],
            'is_zalo' => $formData['is_zalo'],
            'user_id' => $formData['user_id'],
            'sudung' => $formData['sudung']
		);
		foreach ($data as $key => $value) {
            if ($value == '' || $value == null) {
                unset($data[$key]);
                $data_update[] = $key . " = NULL";
            } else {
                $data_insert_key[] = $key;
                $data_insert_val[] = $db->quote($value);
                $data_update[] = $key . " = " . $db->quote($value);
            }
		}
        $query = $db->getQuery(true);
        if ((int) $data['id'] == 0) {
            $query->insert($db->quoteName('dmh_thongtinnguoiquanly'))->columns($data_insert_key)->values(implode(',', $data_insert_val));
        }else{
            $query->update($db->quoteName('dmh_thongtinnguoiquanly'));
            $query->set(implode(',', $data_update));
            $query->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }
        $db->setQuery($query);
        return $db->query();
    }
    public function saveTaikhoan($formData){
        jimport('joomla.user.helper');
        $name 	= $formData['name'];
        $username 	= $formData['username'];
        $email 		= $formData['email'];
        $matkhau 	= $formData['password'];
        $group_id 	= $formData['group_id'];
        //------------------Các thông tin cấu hình--------------------
        $db = JFactory::getDbo();
        if($formData['id'] == ''){
            //--------------------Thêm tài khoản ----------------------
            $usersParams = JComponentHelper::getParams('com_users');
            $user = new JUser(JRequest::getVar( 'id', 0, 'post', 'int'));
            $post['name'] = $name;
            $post['username'] = $username;
            $post['email'] = $email;
            $post['password'] = $matkhau;
            $post['password2'] = $matkhau;
            //set default group.
            $defaultUserGroup = $usersParams->get('new_usertype', $group_id);
            //default to defaultUserGroup i.e.,Registered
            $post['groups'] = array('2', $group_id);
            $post['block'] = $formData['block'];
            $post['requireReset'] = $formData['requireReset'];
            if(!$user->bind($post)){
                return false;
            }
            if(!$user->save()){
                return false;
            }
            $query = $db->getQuery(true);
            $query = 'INSERT INTO core_user_action_donvi (user_id,action_id,iddonvi,group_id)
                        SELECT '.$db->quote($user->get('id')).' AS user_id,action_id,0 AS iddonvi,group_id
                            FROM core_group_action
                            WHERE group_id IN (2,'.$group_id.')';
            $db->setQuery($query);
            if(!$db->query()){
                return false;
            }
        }else{
            if($formData['password'] != ''){
                jimport('joomla.user.helper');
                $salt		= JUserHelper::genRandomPassword(32);
                $crypt		= JUserHelper::getCryptedPassword($formData['password'], $salt);
                $password	= $crypt.':'.$salt;
            }else{
                $password = '';
            }
            $data = array(
                'id' => $formData['id'],
                'name' => trim($formData['name']),
                'username' => trim($formData['username']),
                'password' => $password,
                'email' => $formData['email'],
                'block' => $formData['block'],
                'requireReset' => $formData['requireReset']
            );
            foreach ($data as $key => $value) {
                if ($value == '' || $value == null) {
                    unset($data[$key]);
                } else {
                    $data_update[] = $key . " = " . $db->quote($value);
                }
            }
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->update('#__users');
            $query->set(implode(',', $data_update));
            $query->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
            $db->setQuery($query);
            if(!$db->query()){
                return false;
            }
            $query = $db->getQuery(true);
            $query->delete('#__user_usergroup_map')->where('user_id = '.$db->quote($data['id']));
            $db->setQuery($query);
            if(!$db->query()){
                return false;
            }
            $query = $db->getQuery(true);
            $query->insert('#__user_usergroup_map');
            $query->columns(array('user_id','group_id'));
            $query->values(array($db->quote($data['id']).',2',$db->quote($data['id']).','.$db->quote($group_id)));
            $db->setQuery($query);
            if(!$db->query()){
                return false;
            }
            $query = $db->getQuery(true);
            $query->delete('core_user_action_donvi')->where('user_id = '.$db->quote($data['id']));
            $db->setQuery($query);
            if(!$db->query()){
                return false;
            }
            $query = 'INSERT INTO core_user_action_donvi (user_id,action_id,iddonvi,group_id)
                        SELECT '.$db->quote($data['id']).' AS user_id,action_id,0 AS iddonvi,group_id
                            FROM core_group_action
                            WHERE group_id IN (2,'.$group_id.')';
            $db->setQuery($query);
            if(!$db->query()){
                return false;
            }
            $query = $db->getQuery(true);
            $query->delete('dmh_user2danhmuckhuvuc')->where('user_id = '.$db->quote($data['id']));
            $db->setQuery($query);
            if(!$db->query()){
                return false;
            }
        }
        $quanhuyen_id = implode(',',$formData['quanhuyen_id']);
        $phuongxa_id = implode(',',$formData['phuongxa_id']);
        $thonto_id = implode(',',$formData['thonto_id']);
        $query = $db->getQuery(true);
        $query->insert($db->quoteName('dmh_user2danhmuckhuvuc'));
        $query->columns(array('user_id','quanhuyen_id','phuongxa_id','thonto_id'));
        $query->values($db->quote($data['id']).','.$db->quote($quanhuyen_id).','.$db->quote($phuongxa_id).','.$db->quote($thonto_id));
        $db->setQuery($query);
        if(!$db->query()){
            return false;
        }
        return true;
    }
    public function removeNhacungcap($nhacungcap_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('dmh_danhmucnhacungcap'));
        $query->set('daxoa = 1');
        $query->where('id = ' . $db->quote($nhacungcap_id));
        $db->setQuery($query);
        return $db->query();
    }
    public function removeNhomThucpham($nhomthucpham_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('dmh_danhmucnhomhanghoa'));
        $query->set('daxoa = 1');
        $query->where('id = ' . $db->quote($nhomthucpham_id));
        $db->setQuery($query);
        return $db->query();
    }
    public function removeThucpham($thucpham_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('dmh_danhmuchanghoa'));
        $query->set('daxoa = 1');
        $query->where('id = ' . $db->quote($thucpham_id));
        $db->setQuery($query);
        return $db->query();
    }
    public function removeKhuvuc($khuvuc_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('dmh_danhmuckhuvuc'));
        $query->set('daxoa = 1');
        $query->where('id = ' . $db->quote($khuvuc_id));
        $db->setQuery($query);
        return $db->query();
    }
    public function removeNguoidangky($nguoidangky_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('dmh_thongtinnguoidangky'));
        $query->set('daxoa = 1');
        $query->where('id = ' . $db->quote($nguoidangky_id));
        $db->setQuery($query);
        return $db->query();
    }
    public function removeNguoiquanly($nguoiquanly_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('dmh_thongtinnguoiquanly'));
        $query->set('daxoa = 1');
        $query->where('id = ' . $db->quote($nguoiquanly_id));
        $db->setQuery($query);
        return $db->query();
    }
    public function removeZaloLoi($zaloloi_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('dmh_loizalo'));
        $query->set('daxoa = 1');
        $query->where('id = ' . $db->quote($zaloloi_id));
        $db->setQuery($query);
        return $db->query();
    }
    public function removeTaikhoan($taikhoan_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('#__users'));
        $query->set('block = 1');
        $query->where('id = ' . $db->quote($taikhoan_id));
        $db->setQuery($query);
        return $db->query();
    }
    public function changeKhuvuc($khuvuc_id, $trangthai){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('dmh_danhmuckhuvuc'));
        if($trangthai == '1'){
            $query->set('sudung = 0');
        }else if($trangthai == '0'){
            $query->set('sudung = 1');
        }else{
            return false;
        }
        $query->where('id = ' . $db->quote($khuvuc_id));
        $db->setQuery($query);
        return $db->query();
    }
    public function getHanghoaByNhacungcap($nhacungcap_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.ten,a.giathamkhao,a.dvt,a.is_macdinh,a.nhomhanghoa_id,b.ten AS nhomhanghoa');
        $query->from('dmh_danhmuchanghoa AS a');
        $query->innerJoin('dmh_danhmucnhomhanghoa AS b ON a.nhomhanghoa_id = b.id');
        $query->where('a.daxoa = 0 AND a.sudung = 1 AND a.nhacungcap_id = '.$db->quote($nhacungcap_id));
        $query->order('b.sapxep ASC,a.is_macdinh DESC,a.ten ASC');
        $db->setQuery($query);
        $rows = $db->loadAssocList();
        for($i = 0, $n = count($rows); $i < $n; $i++){
            $result['dulieu'][] = $rows[$i];
            if($rows[$i]['is_macdinh'] == '1'){
                $result['macdinh'][] = $rows[$i]['id'];
            }
        }
        return $result;
    }
    public function getNhacungcapByPhuongxa($phuongxa_id){
        $db = JFactory::getDbo();
        foreach ($phuongxa_id as $key => $value) {
            $data_val[] = $db->quote($value);
		}
        $query = $db->getQuery(true);
        $query->select('a.id,a.ten,a.is_macdinh');
        $query->from('dmh_danhmucnhacungcap AS a');
        $query->where('a.sudung = 1 AND a.daxoa = 0');
        if($phuongxa_id != ''){
            $query->where('a.id NOT IN (SELECT nhacungcap_id FROM dmh_gioihannhacungcap WHERE khuvuc_id IN ('.implode(',',$data_val).'))');
        }
        $query->order('ten ASC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getKhucvucByIdCha($cha_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,ten,cha_id,level');
        $query->from('dmh_danhmuckhuvuc');
        $query->where('sudung = 1 AND daxoa = 0 AND cha_id = '.$db->quote($cha_id));
        $query->order('ten ASC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getKhucvucchaByLevel($level){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,ten,cha_id,level');
        $query->from('dmh_danhmuckhuvuc');
        $query->where('daxoa = 0 AND level = '.$db->quote((int)$level-1));
        $query->order('ten ASC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getTaikhoanDuocQuanly(){
        $db = JFactory::getDbo();
        $model = Core::model('Covid/Covid');
        $phanquyen = $model->getPhanquyen();
        $condition = '';
        if($phanquyen['quanhuyen_id'] != '-1' && (int)$phanquyen['quanhuyen_id'] > 0){
            $condition.= ' AND c.quanhuyen_id IN ('.$phanquyen['quanhuyen_id'].')';
        }
        if($phanquyen['phuongxa_id'] != '-1' && (int)$phanquyen['phuongxa_id'] > 0){
            $condition.= ' AND c.phuongxa_id IN ('.$phanquyen['phuongxa_id'].')';
        }
        if($phanquyen['thonto_id'] != '-1' && (int)$phanquyen['thonto_id'] > 0){
            $condition.= ' AND c.thonto_id IN ('.$phanquyen['thonto_id'].')';
        }
        $query = $db->getQuery(true);
        $query->select('a.id,a.name,a.username');
        $query->from('#__users AS a');
        $query->innerJoin('#__user_usergroup_map AS b ON a.id = b.user_id AND b.group_id IN (106,107,108)');
        $query->innerJoin('dmh_user2danhmuckhuvuc AS c ON a.id = c.user_id'.$condition);
        $query->where('a.id > 100 AND a.block = 0');
        $query->group('a.id');
        $query->order('a.name');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getNoidungTinnhanZalo($option = array()){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('dmh_thongtinnguoiquanly AS a');
        $query->innerJoin('dmh_user2danhmuckhuvuc AS b ON a.user_id = b.user_id');
        $query->where('a.sudung = 1 AND a.is_zalo = 1 AND a.daxoa = 0');
        if(isset($option['nguoiquanly_id'])){
            $query->where('a.id = '.$db->quote($option['nguoiquanly_id']));
        }
        $db->setQuery($query);
        $nguoiquanly = $db->loadAssocList();
        $n = count($nguoiquanly);
        if($n > 0){
            $query = $db->getQuery(true);
            $query->select('b.thonto_id,SUM(IF(a.trangthai = 1 AND a.daxoa = 0,1,0)) AS soluong_dangky,SUM(IF(a.trangthai = 2 AND nguoixuatfile IS NULL AND a.daxoa = 0,1,0)) AS soluong_tonghop,SUM(IF(a.trangthai = 2 AND nguoixuatfile IS NOT NULL AND a.daxoa = 0,1,0)) AS soluong_xuatphieu');
            $query->from('dmh_thongtindonhang AS a');
            $query->innerJoin('dmh_thongtinnguoidangky AS b ON a.nguoidangky_id = b.id');
            $query->where('a.trangthai IN (1,2)');
            $query->group('b.thonto_id');
            $db->setQuery($query);
            $thonto = $db->loadAssocList('thonto_id');
            $tong_dangky = 0; $tong_tonghop = 0; $tong_xuatphieu = 0;
            for($i = 0; $i < $n; $i++){
                $result[$i]['sdt'] = $nguoiquanly[$i]['sodienthoai'];
                if($nguoiquanly[$i]['quanhuyen_id'] == '-1' && $nguoiquanly[$i]['phuongxa_id'] == '-1' && $nguoiquanly[$i]['thonto_id'] == '-1'){
                    if($tong_dangky == 0 && $tong_tonghop == 0 && $tong_xuatphieu == 0){
                        foreach($thonto AS $key => $val){
                            $tong_dangky+= $val['soluong_dangky'];
                            $tong_tonghop+= $val['soluong_tonghop'];
                            $tong_xuatphieu+= $val['soluong_xuatphieu'];
                        }
                    }
                    $result[$i]['content'] = 'PM Đăng ký thực phẩm kính thông báo: 
    - Đơn vị có '.$tong_dangky.' đơn hàng đăng ký mới cần rà soát, tổng hợp;
    - Đơn vị có '.$tong_tonghop.' đơn hàng cần xuất phiếu tổng hợp để gửi cho nhà cung cấp;
    - Đơn vị có '.$tong_xuatphieu.' đơn hàng cần cung ứng cho người dân.
Vui lòng truy cập vào phần mềm để xử lý các đơn hàng.
Trân trọng!';
                }else{
                    $thontoquanly = explode(',',$nguoiquanly[$i]['thonto_id']);
                    $soluong_dangky = 0;$soluong_tonghop = 0;$soluong_xuatphieu = 0;
                    foreach($thontoquanly AS $key => $val){
                        $soluong_dangky+= $thonto[$val]['soluong_dangky'];
                        $soluong_tonghop+= $thonto[$val]['soluong_tonghop'];
                        $soluong_xuatphieu+= $thonto[$val]['soluong_xuatphieu'];
                    }
                    $result[$i]['content'] = 'PM Đăng ký thực phẩm kính thông báo: 
    - Đơn vị có '.$soluong_dangky.' đơn hàng đăng ký mới cần rà soát, tổng hợp;
    - Đơn vị có '.$soluong_tonghop.' đơn hàng cần xuất phiếu tổng hợp để gửi cho nhà cung cấp;
    - Đơn vị có '.$soluong_xuatphieu.' đơn hàng cần cung ứng cho người dân.
Vui lòng truy cập vào phần mềm để xử lý các đơn hàng.
Trân trọng!';
                }
            }
        }
        return $result;
    }
    public function getNoidungTinnhanZaloLoi($zaloloi_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('dmh_loizalo'));
        $query->set('daxoa = 1');
        $query->where('id = ' . $db->quote($zaloloi_id));
        $db->setQuery($query);
        if(!$db->query()){
            return false;
        }
        $query = $db->getQuery(true);
        $query->select('sodienthoai AS sdt,noidung AS content');
        $query->from('dmh_loizalo');
        $query->where('id = '.$db->quote($zaloloi_id));
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function saveLoiZalo($postData,$thongbaoloi){
        $user_id = JFactory::getUser()->id;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->insert('dmh_loizalo');
        $query->columns('sodienthoai,noidung,error,thoigian,nguoithuchien');
        for($i = 0, $n = count($postData); $i < $n; $i++){
            $query->values($db->quote($postData[$i]['sdt']).','.$db->quote($postData[$i]['content']).','.$db->quote($thongbaoloi).',NOW(),'.$db->quote($user_id));
        }
        $db->setQuery($query);
        return $db->query();
    }
}