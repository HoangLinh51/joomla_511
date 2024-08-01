<?php

use Joomla\CMS\Factory;

class Core_Model_Attachment {

    private $_tableName = 'core_attachment';
    private $_primary = 'id';

    public function attachment($file_id, $object_id, $type_id, $user_id) {
        $db = Factory::getDbo();
        //$this->deleteByObjectIdAndTypeId($object_id, $type_id);
        //$data = ;
        if (is_array($file_id)) {
            for ($i = 0; $i < count($file_id); $i++) {
                $object = new stdClass();
                $object->object_id = $object_id;
                $object->type_id = $type_id;
                $object->id = $file_id[$i];
                $db->updateObject($this->_tableName, $object, $this->_primary);
            }
        } else {
            $object = new stdClass();
            $object->object_id = $object_id;
            $object->type_id = $type_id;
            $object->id = $file_id;
            $db->updateObject($this->_tableName, $object, $this->_primary);
        }
        /*
          // Xoa file temlp
          $query = $db->getQuery(true);
          $query->select('*')
          ->from($this->_tableName)
          ->where("created_by = ".$db->q($user_id))
          ->where("type_id = -1");
          $db->setQuery($query);
          $rows = $db->loadAssocList();
          for ($i = 0; $i < count($rows); $i++) {
          $filename = JPATH_ROOT.'/'.$rows[$i]['folder'].'/'.$rows[$i]['code'];
          if (!file_exists($filename)) {
          unlink($filename);
          }
          $db->setQuery("DELETE FROM ".$this->_tableName." WHERE type_id = -1 AND created_by=".$db->q($user_id));
          $db->execute();
          }
         */
        //$db->setQuery($query);
        return true;
    }

    public function clearTempFileByUser($user_id) {
        // Xoa file temlp
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')
                ->from($this->_tableName)
                ->where("created_by = " . $db->q($user_id))
                ->where("type_id = -1");
        $db->setQuery($query);
        $rows = $db->loadAssocList();
        for ($i = 0; $i < count($rows); $i++) {
            $filename = JPATH_ROOT . '/' . $rows[$i]['folder'] . '/' . $rows[$i]['code'];
            if (!file_exists($filename)) {
                unlink($filename);
            }
            $db->setQuery("DELETE FROM " . $this->_tableName . " WHERE type_id = -1 AND created_by=" . $db->q($user_id));
            $db->execute();
        }
    }

    public function create($formData, $option = array()) {
        return Core::insert($this->_tableName, $formData, $this->_primary);
    }

    public function update($formData, $option = array()) {
        return Core::update($this->_tableName, $formData, $this->_primary);
    }

    public function read($id) {
        return Core::read($this->_tableName, array($this->_primary . ' = ' => $id));
    }

    public function getRowByCode($code) {
        //var_dump($code);exit;
        return Core::read($this->_tableName, array("code = " => $code));
    }

    public function getRowByObjectIdAndTypeId($object_id, $type_id) {
        //var_dump($code);exit;
        return Core::read($this->_tableName, array("object_id = " => $object_id, "type_id = " => $type_id));
    }

    public function delete($id) {
        $row = Core::loadAssoc($this->_tableName, array('code', 'folder'), array("$this->_primary = " => $id));
        if ($row !== null) {
            $filename = JPATH_ROOT . '/' . $row['folder'] . '/' . $row['code'];
            if (!file_exists($filename)) {
                unlink($filename);
            }
        }
        return Core::delete($this->_tableName, array("$this->_primary = " => $id));
    }

    public function deleteByObjectIdAndTypeId($object_id, $type_id) {
        $rows = Core::loadAssoc($this->_tableName, array('code', 'folder'), array("object_id = " => $object_id, "type_id = " => $type_id));
        for ($i = 0; $i < count($rows); $i++) {
            $filename = JPATH_ROOT . '/' . $rows[$i]['folder'] . '/' . $rows[$i]['code'];
            if (!file_exists($filename)) {
                unlink($filename);
            }
        }
        return Core::delete($this->_tableName, array("object_id = " => $object_id, "type_id = " => $type_id));
    }

    public function deleteByCode($code) {
        $row = Core::loadAssoc($this->_tableName, array('code', 'folder'), array("code = " => $code));
        if ($row !== null) {
            $filename = JPATH_ROOT . '/' . $row['folder'] . '/' . $row['code'];
            if (!file_exists($filename)) {
                unlink($filename);
            }
        }
        return Core::delete($this->_tableName, array("code = " => $code));
    }

    /**
     * lay Id tạm một số không trùng
     * @return integer
     */
    public function getIdTemp() {
        //return $this->getDbTable()->insert(array());
        $table = Core::table('Core/AttachmentTmp');
        $table->save(array());
        return $table->id;
    }

    /**
     * Lay thư mục lưu trử
     * @param integer $nam
     * @param integer $thang
     * @return string
     */
    function getDir($nam, $thang) {
        //$con = Zend_Registry::get('attachmentConfig');
        $config = Core::config();
        //$rootPath = dirname($_SERVER['PHP_SELF']);
        $root = 'upload';
        $temp_path = $config->tmp_path;
        $dirPath = $root . '/' . $nam . '/' . $thang;
        if (!file_exists($root))
            mkdir($root, 0777);
        if (!file_exists($temp_path))
            mkdir($temp_path, 0777);
        if (!file_exists($root . '/' . $nam))
            mkdir($root . '/' . $nam);
        if (!file_exists($dirPath))
            mkdir($dirPath, 0777);
        return $dirPath;
    }

    /**
     * Lấy đường dẫn file tạm
     * @return string
     */
    public function getTempPath() {
        // $root = 'upload';
        //$temp_path = 'uploader/tmp';
        $config = Core::config();
        //$rootPath = dirname($_SERVER['PHP_SELF']);
        $root = 'upload';
        $temp_path = $config->tmp_path;
        if (!file_exists($root))
            mkdir($root, 0777);
        if (!file_exists($temp_path))
            mkdir($temp_path, 0777);
        return $temp_path;
    }

    /**
     * Lay danh sách các file by type id, created id (người upload)
     * @param integer $idObject
     * @param integer $isTemp
     * @return mixed
     */
    public function getListByTypeIdAndCreatedId($type_id, $created_id) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')->from($this->_tableName);
        $query->where('created_id = ' . $db->q($created_id));
        $query->where('type_id = ' . $db->q($type_id));
        $db->setQuery($query);
        return $db->loadAssocList();
    }

    /**
     * Lay danh sách các file by Object id
     * @param integer $idObject
     * @param integer $isTemp
     * @return mixed
     */
    public function getListFile($idObject, $isTemp) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')->from($this->_tableName);
        $query->where('object_id = ' . $db->q($idObject));
        //$query->where('created_by = '.$db->q($idObject));
        if ($isTemp == -1) { //La id tam
            $query->where('type_id = ' . $db->q($isTemp));
        }
        $db->setQuery($query);
        //echo $query;
        return $db->loadAssocList();
    }

    /**
     * 
     * @param integer $idObject
     * @param integer $type
     * @return mixed
     */
    public function getFileByIdObjectAndType($idObject, $type) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')->from($this->_tableName);
        $query->where('object_id = ' . $db->q($idObject));
        $query->where('type_id = ' . $db->q($type));
        $db->setQuery($query);
        return $db->loadAssocList();
    }

    /**
     * Xóa file
     * @param string $code
     */
    public function deleteFileByMaso($code) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')->from($this->_tableName)->where("code=" . $db->q($code));
        $db->setQuery($query);
        $re = $db->loadObject();
        //var_dump($expression);
        if (!$re) {
            echo "Không tìm thấy file cần xóa";
            return false;
            //thong bao loi
        } else {
            $path = $re->folder . '/' . $code;
            unlink($path);
            //Xoa file trong csdl

            $db->setQuery('DELETE FROM ' . $this->_tableName . ' WHERE id = ' . $db->q($re->id));
            //return 
            return $db->execute();
        }
    }

    public function updateObjectIdAndTypeIdByCode($code, $object_id, $type_id) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('object_id') . ' = ' . $db->quote($object_id),
            $db->quoteName('type_id') . ' = ' . $db->quote($type_id)
        );
        // Conditions for which records should be updated.
        $conditions = array(
            $db->quoteName('code') . ' = ' . $db->quote($code)
        );
        $query->update($db->quoteName($this->_tableName))->set($fields)->where($conditions);
        $db->setQuery($query);
        return $db->execute();
    }

    public function updateTypeIdByCode($code, $type_id, $movefile = false, $object_id = null) {
        $file = $this->getRowByCode($code);
        if ($file == null) {
            return null;
        }
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('type_id') . ' = ' . $db->quote($type_id)
        );
        if ($object_id != null) {
            $fields[] = $db->quoteName('object_id') . ' = ' . $db->quote($object_id);
        }

        if ($movefile == true) {
            $config = Core::config();
            $old_file = $file['folder'] . '/' . $file['code'];
            if (file_exists($old_file)) {
                $date = getdate();
                $dirPath = $this->getDir($date['year'], $date['mon']);
                $new_file = $dirPath . '/' . $file['code'];
                if (copy($old_file, $new_file)) {
                    //unlink($old_file);
                    $fields[] = $db->quoteName('folder') . ' = ' . $db->quote($dirPath);
                }
            }
        }
        // Conditions for which records should be updated.
        $conditions = array(
            $db->quoteName('code') . ' = ' . $db->quote($code)
        );
        $query->update($db->quoteName($this->_tableName))->set($fields)->where($conditions);
        $db->setQuery($query);
        return $db->execute();
    }

    public function fixedFileNotCopy() {
        $config = Core::config();
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*,YEAR(a.created_at) AS nam, MONTH(a.created_at) AS thang')
                ->from($db->quoteName('core_attachment', 'a'))
                ->where('a.type_id <> -1 AND a.folder = ' . $db->quote($config->tmp_path));
// 	    echo $query->__toString();exit;
        $db->setQuery($query);
        $rows = $db->loadAssocList();

        for ($i = 0, $n = count($rows); $i < $n; $i++) {
            $row = $rows[$i];
            $query = $db->getQuery(true);
            $fields = array(
                $db->quoteName('type_id') . ' = ' . $db->quote($row['type_id'])
            );
            $fields[] = $db->quoteName('object_id') . ' = ' . $db->quote($row['object_id']);
            $config = Core::config();
            $old_file = $row['folder'] . '/' . $row['code'];
            if (file_exists($old_file)) {
                $dirPath = $this->getDir($row['nam'], $row['thang']);
                $new_file = $dirPath . '/' . $row['code'];
                if (copy($old_file, $new_file)) {
                    $fields[] = $db->quoteName('folder') . ' = ' . $db->quote($dirPath);
                }
            }
            $conditions = array(
                $db->quoteName('code') . ' = ' . $db->quote($row['code'])
            );
            $query->update($db->quoteName($this->_tableName))->set($fields)->where($conditions);
            $db->setQuery($query);
            $db->execute();
        }
        echo 'Updated!!!';
        exit;
    }
    public function getDanhsachAnhthe($params) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.hosochinh_id, b.code,b.url')
                ->from($db->quoteName('hosochinh_quatrinhhientai', 'a'))
                ->join('INNER', 'core_attachment AS b ON a.hosochinh_id = b.object_id AND b.type_id = 2');
        if (isset($params['donvi_id']) && !empty($params['donvi_id'])) {
            $query->where('(a.congtac_donvi_id = ' . $db->quote($params['donvi_id']) . ' OR a.congtac_phong_id = ' . $db->quote($params['donvi_id']) . ')');
        }
        $db->setQuery($query);
        if (isset($params['key']) && !empty($params['key'])) {
            return $db->loadAssocList($params['key']);
        } else {
            return $db->loadAssocList();
        }
    }
    public function checkQuyenBaomatTepdinhkem($idHoso,$donvi_id){
        $db = Factory::getDbo();
        $user_id = Factory::getUser()->id;
        $query = $db->getQuery(true);
        $query->select('COUNT(*)')->from('core_user_hoso')->where('user_id = '.$db->quote($user_id))->where('hoso_id  = '.$db->quote($idHoso));
        $db->setQuery($query);
        $result = $db->loadResult();
        if($result > 0){
            // Trường hợp cá nhân hiệu chỉnh hồ sơ
            $ketqua = '1';
        }else{
            if(Core::_checkPerAction($user_id,'com_hoso','hoso','xemTatcaTepdinhkem')){
                // Trường hợp người khác không phải là cán bộ tổ chức đơn vị như Sở Nội vụ, Lãnh đạo đơn vị, ...
                $ketqua = '1';
            }else{
                $donvithuocve_id = (int)Core::getUserDonvi($user_id);
                if($donvithuocve_id === $donvi_id){
                    if(Core::_checkPerAction($user_id,'com_hoso','hoso','xemTepdinhkem')){
                        // Trường hợp cán bộ tổ chức đơn vị hiệu chỉnh hồ sơ
                        $ketqua = '1';
                    }else{
                        $ketqua = '0';
                    }
                }else{
                    $ketqua = '0';
                }
            }
        }
        return $ketqua;
    }
}
