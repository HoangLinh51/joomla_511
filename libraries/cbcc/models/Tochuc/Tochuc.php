<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

/**
 * Author: Phucnh
 * Date created: May 12, 2015
 * Company: DNICT
 */
class Tochuc_Model_Tochuc {

    /**
     * Lấy all quá trình khen thưởng theo đơn vị id
     * @param int $donvi_id
     * @return array
     */
    public function getAllKhenthuongById($donvi_id) {
        return $this->getThongtin('a.*, b.name as hinhthuc', 'ins_quatrinhkhenthuong a', 
                array('left' => 'ins_dmkhenthuongkyluat b ON b.id=a.rew_code_kt'), array("iddonvi_kt= " . Factory::getDbo()->quote($donvi_id)), 
                'start_date_kt desc');
    }

    /**
     * Lấy all quá trình kỷ luật theo đơn vị id
     * @param int $donvi_id
     * @return array
     */
    public function getAllKyluatById($donvi_id) {
        return $this->getThongtin('a.*, b.name as hinhthuc', 'ins_quatrinhkyluat a', 
                array('left' => 'ins_dmkhenthuongkyluat b ON b.id=a.rew_code_kl'), array("a.iddonvi_kl= " . Factory::getDbo()->quote($donvi_id)), 
                'a.start_date_kl desc');
    }

    /**
     * Lấy all quá trình khen thưởng + kỷ luật theo đơn vị id
     * @param int $donvi_id
     * @return array
     */
    public function getAllKhenthuongkyluatById($donvi_id) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query = "  select 
                        a.id_kt,a.iddonvi_kt,a.rew_code_kt,a.reason_kt,a.start_date_kt,
                        a.end_date_kt,a.approv_number_kt,a.approv_unit_kt,
                        a.approv_per_kt,a.approv_date_kt, b.type as ktkl, b.name as hinhthuc 
                        from ins_quatrinhkhenthuong a
                        left join ins_dmkhenthuongkyluat b on a.rew_code_kt = b.id
                        where a.iddonvi_kt = " . $db->quote($donvi_id) . "
                    union
                    select
                        c.id_kl,c.iddonvi_kl,c.rew_code_kl,c.reason_kl,c.start_date_kl,
                        c.end_date_kl,c.approv_number_kl,c.approv_unit_kl,c.approv_per_kl,
                        c.approv_date_kl, d.type as ktkl, d.name as hinhthuc 
                        from ins_quatrinhkyluat c
                        left join ins_dmkhenthuongkyluat d on c.rew_code_kl = d.id
                        where c.iddonvi_kl = " . $db->quote($donvi_id) . "
                        order by start_date_kt desc";
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    /**
     * Lấy 1 quá trình kỷ luật theo  id
     * @param int $donvi_id
     * @return array
     */
    public function getEditKhenthuongById($id_kt) {
        return $this->getThongtin('*', 'ins_quatrinhkhenthuong', null, array("id_kt= ".Factory::getDbo()->quote($id_kt)), null);
    }

    /**
     * Lấy 1 quá trình khen thưởng theo  id
     * @param int $donvi_id
     * @return array
     */
    public function getEditKyluatById($id_kl) {
        return $this->getThongtin('*', 'ins_quatrinhkyluat', null, array("id_kl= ".Factory::getDbo()->quote($id_kl)), null);
    }

    function saveBiencheChitietPhanloai($quatrinh_id, $id, $bienchelanhdao, $bienchechuyenmon, $bienche68) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('quatrinh_id') . '=' . $db->quote($quatrinh_id),
            $db->quoteName('bienchelanhdao') . '=' . $db->quote($bienchelanhdao),
            $db->quoteName('bienchechuyenmon') . '=' . $db->quote($bienchechuyenmon),
            $db->quoteName('bienche68') . '=' . $db->quote($bienche68),
        );
        if (isset($id) && $id > 0) {
            $conditions = array(
                $db->quoteName('id') . '=' . $db->quote($id)
            );
            $query->update($db->quoteName('ins_dept_quatrinh_bienche_chitiet_phanloai'))->set($fields)->where($conditions);
        } else {
            $query->insert($db->quoteName('ins_dept_quatrinh_bienche_chitiet_phanloai'));
            $query->set($fields);
        }
        $db->setQuery($query);
        // echo $query;die;
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Hàm lưu quá trình khen thưởng
     * @param array $formData
     * @return boolean
     */
    public function saveKhenthuong($formData) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('iddonvi_kt') . '=' . $db->quote($formData['iddonvi_kt']),
            $db->quoteName('rew_code_kt') . '=' . $db->quote($formData['rew_code_kt']),
            $db->quoteName('reason_kt') . '=' . $db->quote($formData['reason_kt']),
            $db->quoteName('approv_number_kt') . '=' . $db->quote($formData['approv_number_kt']),
            $db->quoteName('approv_unit_kt') . '=' . $db->quote($formData['approv_unit_kt']),
            $db->quoteName('approv_per_kt') . '=' . $db->quote($formData['approv_per_kt']),
            $db->quoteName('start_date_kt') . '=' . $db->quote($formData['start_date_kt']),
            $db->quoteName('end_date_kt') . '=' . $db->quote($formData['end_date_kt']),
            $db->quoteName('approv_date_kt') . '=' . $db->quote($formData['approv_date_kt']),
        );
        if (isset($formData['id_kt']) && $formData['id_kt'] > 0) {
            $conditions = array(
                $db->quoteName('id_kt') . '=' . $db->quote($formData['id_kt'])
            );
            $query->update($db->quoteName('ins_quatrinhkhenthuong'))->set($fields)->where($conditions);
        } else {
            $query->insert($db->quoteName('ins_quatrinhkhenthuong'));
            $query->set($fields);
        }
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Hàm lưu quá trình kỷ luật
     * @param unknown $formData
     * @return boolean
     */
    public function saveKyluat($formData) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('iddonvi_kl') . '=' . $db->quote($formData['iddonvi_kl']),
            $db->quoteName('rew_code_kl') . '=' . $db->quote($formData['rew_code_kl']),
            $db->quoteName('reason_kl') . '=' . $db->quote($formData['reason_kl']),
            $db->quoteName('approv_number_kl') . '=' . $db->quote($formData['approv_number_kl']),
            $db->quoteName('approv_unit_kl') . '=' . $db->quote($formData['approv_unit_kl']),
            $db->quoteName('approv_per_kl') . '=' . $db->quote($formData['approv_per_kl']),
            $db->quoteName('start_date_kl') . '=' . $db->quote($formData['start_date_kl']),
            $db->quoteName('end_date_kl') . '=' . $db->quote($formData['end_date_kl']),
            $db->quoteName('approv_date_kl') . '=' . $db->quote($formData['approv_date_kl']),
        );
        if (isset($formData['id_kl']) && $formData['id_kl'] > 0) {
            $conditions = array(
                $db->quoteName('id_kl') . '=' . $db->quote($formData['id_kl'])
            );
            $query->update($db->quoteName('ins_quatrinhkyluat'))->set($fields)->where($conditions);
        } else {
            $query->insert($db->quoteName('ins_quatrinhkyluat'));
            $query->set($fields);
        }
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Xóa quá trình khen thưởng
     * @param int $id_kt
     * @return boolean
     */
    public function removeKhenthuong($id_kt) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('id_kt') . ' IN (' . $db->quote($id_kt) . ')'
        );
        $query->delete($db->quoteName('ins_quatrinhkhenthuong'));
        $query->where($conditions);
        $db->setQuery($query);
        if (!$db->query()) {
            Error::raiseError(500, $db->getErrorMsg());
            return false;
        } else {
            return true;
        }
    }

    /**
     * Xóa quá trình kỷ luật
     * @param int $id_kl
     * @return boolean
     */
    public function removeKyluat($id_kl) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('id_kl') . ' IN (' . $db->quote($id_kl) . ')'
        );
        $query->delete($db->quoteName('ins_quatrinhkyluat'));
        $query->where($conditions);
        $db->setQuery($query);
        if (!$db->query()) {
            Error::raiseError(500, $db->getErrorMsg());
            return false;
        } else {
            return true;
        }
    }

    /**
     * Hàm lấy thông tin từ 1 table, có thể join thêm bảng và điều kiện, trả về 1 list đối tượng
     * @param array $field
     * @param string $table
     * @param array $arrJoin array(key => value)
     * @param array $where array(where1, where2)
     * @param string $order
     * @return objectlist
     */
    function getThongtin($field, $table, $arrJoin = null, $where = null, $order = null) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select($field)
              ->from($table);
        if (!empty($arrJoin) && is_array($arrJoin)) {
            foreach ($arrJoin as $key => $val) {
                $query->join($key, $val);
            }
        }
        if(!empty($where)){
            $query->where($where);
        }
        if (!empty($order)) {
            $query->order($order);
        }
    
        $db->setQuery($query);
        return $db->loadObjectList();
    }    

    //----------------------------------------- model
    public function __construct() {
        Table::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');
    }

    /**
     * Đổi tên Tổ chức
     * @param type $dept_id
     * @param type $name
     * @return type
     */
    public function changeName($dept_id, $name) {
        return Core::update('ins_dept', array('id' => $dept_id, 'name' => $name), 'id');
    }

    /**
     * Xóa tổ chức
     * @param unknown $id
     * @return boolean
     */
    public function deleteDept($id) {
        $table = Core::table('Tochuc/InsDept');
        $a = $table->load($id);

        $rows = Core::loadAssocList('ins_dept_quatrinh', array('id'), array('dept_id = ' => $id));
        for ($i = 0; $i < count($rows); $i++) {
            $this->delQuaTrinh($rows[$i]['id']);
        }
        $rows = Core::loadAssocList('ins_dept_quatrinh_bienche', array('id'), array('dept_id = ' => $id));
        for ($i = 0; $i < count($rows); $i++) {
            $this->delQuaTrinhGiaoBienche($rows[$i]['id']);
        }
        return $table->delete();
    }

    /**
     * Lưu tổ chức
     * @param type $formData
     * @return type
     */
    public function saveDept($formData) {
        $table = Core::table('Tochuc/InsDept');
        $reference_id = (int) $formData['parent_id'];
        $data = array(
            'id' => $formData['id'],
            'parent_id' => $formData['parent_id'],
            'name' => $formData['name'],
            'name_dieudong' => $formData['name_dieudong'],
            's_name' => $formData['s_name'],
            'code' => $formData['code'],
            'ins_loaihinh' => $this->getLoaihinhByIdCap((int) $formData['ins_cap']),
            'ins_cap' => (int) $formData['ins_cap'],
            'number_created' => $formData['number_created'],
            'date_created' => $formData['date_created'],
            'type_created' => $formData['type_created'],
            'active' => $formData['active'],
            'ins_created' => $formData['ins_created'],
            'chitiet' => $formData['chitiet'],
            'ghichu' => $formData['ghichu'],
            'dienthoai' => $formData['dienthoai'],
            'email' => $formData['email'],
            'diachi' => $formData['diachi'],
            'goibienche' => $formData['goibienche'],
            'goiluong' => $formData['goiluong'],
            'goichucvu' => $formData['goichucvu'],
            'type' => $formData['type'],
            'chukyso_nguoidaidien_id' => $formData['chukyso_nguoidaidien_id'],
            'chukyso_sohieu' => $formData['chukyso_sohieu'],
            'chukyso_ngaycap' => TochucHelper::strDateVntoMySql($formData['chukyso_ngaycap']),
            'chukyso_trangthai_id' => $formData['chukyso_trangthai_id'],
            'chukyso_lancap' => $formData['chukyso_lancap'],
            'masothue' => $formData['masothue'],
            'masotabmis' => $formData['masotabmis'],
            'eng_name' => $formData['eng_name'],
            'fax' => $formData['fax'],
            'phucapdacthu' => $formData['phucapdacthu'],
            'vanban_active' => $formData['vanban_active'],
            'vanban_created' => $formData['vanban_created'],
            'goihinhthuchuongluong' => $formData['goihinhthuchuongluong'],
            'goivitrivieclam' => $formData['goivitrivieclam'],
            'goidaotao' => $formData['goidaotao'],
            'chucnang' => $formData['chucnang'],
            'loaidonvihanhchinh_id' => $formData['loaidonvihanhchinh_id'],
            'website' => $formData['website'],
            'donvixuly_nghiepvu_id' => $formData['donvixuly_nghiepvu_id'],
            'ngayhieuchinh' => date('Y-m-d'),
            'nguoihieuchinh' => Factory::getUser()->id,
        );
        var_dump($data);die;
        if ((int) $formData['id'] == 0) {
            // Specify where to insert the new node.
            //$reference_id = (int)$formData['parent_id'];
            if ($reference_id == 0) {
                $reference_id = $table->getRootId();
            }
            if ($reference_id === false) {
                $reference_id = $table->addRoot();
            }
            $table->setLocation($reference_id, 'last-child');
            // Bind data to the table object.
            unset($data['id']);
            foreach ($data as $key => $value) {
                //var_dump($value);
                if ($value == '' || $value == null) {
                    unset($data[$key]);
                }
            }
            //exit;
            $table->bind($data);
            // Check that the node data is valid.
            $table->check();
            // Store the node in the database table.
            $table->store();
            return $table->id;
        } else {
            if ($reference_id != Core::loadResult('ins_dept', array('parent_id'), array('id = ' => $formData['id']))) {
                $table->setLocation($reference_id, 'last-child');
            }
            $table->bind($data);
            $table->check();
            $table->store();
            Core::update('ins_dept', $data, 'id', true);
            return $table->id;
        }
        //var_dump($data);exit;
    }

    /**
     * Lưu lĩnh vực
     * @param type $dept_id
     * @param type $arrLinhvuc
     */
    public function saveLinhvuc($dept_id, $arrLinhvuc = array()) {
        $table = Core::table('Tochuc/Adtochuclinhvuc');
        Core::delete('ins_dept_linhvuc', array('ins_dept_id = ' => $dept_id));
        for ($i = 0; $i < count($arrLinhvuc); $i++) {
            if ((int) $arrLinhvuc[$i] > 0) {
                $data = array('ins_dept_id' => $dept_id, 'linhvuc_id' => (int) $arrLinhvuc[$i]);
                //var_dump($data);
                $table->bind($data);
                $table->check();
                // Store the node in the database table.
                $table->store();
            }
        }
    }

    /**
     * Lấy lĩnh vực theo đơn vị
     * @param type $dept_id
     * @return type
     */
    public function getLinhvucByIdDept($dept_id) {
        return Core::loadColumn('ins_dept_linhvuc', array('linhvuc_id'), array('ins_dept_id = ' => (int) $dept_id));
    }

    /**
     * Lưu văn bản
     * @param type $formData
     * @return vanban.id
     */
    public function saveVanban($formData) {
        $table = Core::table('Tochuc/Advanban');
        $data = array(
            'id' => (int) $formData['id'],
            'mahieu' => $formData['mahieu'],
            'tieude' => $formData['tieude'],
            'trichdan' => $formData['trichdan'],
            'ngaybanhanh' => $formData['ngaybanhanh'],
            'nguoiky' => $formData['nguoiky'],
            'ordering' => $formData['ordering'],
            'coquan_banhanh_id' => $formData['coquan_banhanh_id'],
            'coquan_banhanh' => $formData['coquan_banhanh'],
            'ngaytao' => date('Y-m-d H:i:s'),
            'nguoitao' => Factory::getUser()->id
        );
        //var_dump($data);
        $table->bind($data);
        $table->check();
        $table->store();
        return $table->id;
    }

    /**
     * Lưu tập tin
     * @param type $vanban_id
     * @param type $fileupload_id
     */
    public function saveTaptin($vanban_id, $fileupload_id) {
        $user = Factory::getUser();
        $mapper = Core::model('Core/Attachment');
        $type_id = 1;
        if (is_array($fileupload_id)) {
            for ($i = 0; $i < count($fileupload_id); $i++) {
                $mapper->attachment($fileupload_id[$i], $vanban_id, $type_id, $user->id);
            }
        } else {
            if ((int) $fileupload_id > 0) {
                $mapper->attachment($fileupload_id, $vanban_id, $type_id, $user->id);
            }
        }
        $mapper->clearTempFileByUser($user->id);
    }

    /**
     * Xóa quá trình lịch sử
     * @param type $quatrinh_id
     * @return boolean
     */
    public function delQuaTrinh($quatrinh_id) {
        $type_id = 1;
        $attachmentMapper = Core::model('Core/Attachment');
        $flag = false;
        $vanban_id = Core::loadResult('ins_dept_quatrinh', array('vanban_id'), array('id = ' => $quatrinh_id));
        if ($attachmentMapper->deleteByObjectIdAndTypeId((int) $vanban_id, $type_id)) {
            Core::delete('ins_vanban', array('id = ' => (int) $vanban_id));
            Core::delete('ins_dept_quatrinh', array('id = ' => (int) $quatrinh_id));
            $flag = true;
        }
        return $flag;
    }

    /**
     * Lưu quá trình lịch sử
     * @param array $formData
     * @return id_quatrinh
     */
    public function saveQuatrinh($formData) {
        $table = Core::table('Tochuc/Adquatrinh');
        if (strlen($formData['hieuluc_ngay']) <= 0)
            $hieuluc_ngay = date('Y-m-d');
        else
            $hieuluc_ngay = $formData['hieuluc_ngay'];
        $data = array(
            'id' => (int) $formData['id'],
            'quyetdinh_so' => $formData['quyetdinh_so'],
            // 'quyetdinh_ngay' => TochucHelper::strDateVntoMySql($formData['quyetdinh_ngay']),
            'quyetdinh_ngay' => $formData['quyetdinh_ngay'],
            'user_id' => Factory::getUser()->id,
            'ghichu' => $formData['ghichu'],
            'chitiet' => $formData['chitiet'],
            'name' => $formData['name'],
            'hieuluc_ngay' => TochucHelper::strDateVntoMySql($hieuluc_ngay),
            'dept_id' => $formData['dept_id'],
            'cachthuc_id' => $formData['cachthuc_id'],
            'vanban_id' => $formData['vanban_id'],
            'ordering' => $formData['ordering'],
            'ngay_tao' => date('Y-m-d')
        );
        //var_dump($data);
        foreach ($data as $key => $value) {
            if ($value == '' || $value == null) {
                unset($data[$key]);
            }
        }
        $table->bind($data);
        $table->check();
        $table->store();
        return $table->id;
    }
    /**
     * Lưu logs sử dụng nghiệp vụ tổ chức
     * @param array $formData
     * @return id_quatrinh
     */
    public function saveLogNghiepVu($formData) {
        $table = Core::table('Tochuc/Nghiepvulogs');
        $data = array(
            'id' => (int) $formData['id'],
            'quatrinh_id' => (int) $formData['quatrinh_id'],
            'noidung' => $formData['noidung'],
            'cachthuc_id' => (int) $formData['cachthuc_id'],
            'donvi_id_input' => $formData['donvi_id_input'],
            'donvi_id_output' => $formData['donvi_id_output'],
            'trangthai' => $formData['trangthai'],
            // 'ins_type' => $formData['type'],
            'nguoitao' => Factory::getUser()->id,
            'ngaytao' => date('Y-m-d H:i:s')
        );
        //var_dump($data);
        foreach ($data as $key => $value) {
            if ($value == '' || $value == null) {
                unset($data[$key]);
            }
        }
        $table->bind($data);
        $table->check();
        $table->store();
        return $table->id;
    }

    public function copyTochuc($donvi_id, $name) {
        $db = Factory::getDbo();
        $query = "INSERT INTO ins_dept 
                        (parent_id,name,s_name,ins_loaihinh,ins_cap,active,ins_created,goibienche,goiluong,goichucvu,type,level,
                        lft,rgt,ins_level,goihinhthuchuongluong,goidaotao,chucnang,goivitrivieclam,donvixuly_nghiepvu_id,type_created)
                    SELECT 
                        parent_id,".$db->quote($name).",".$db->quote($name).",ins_loaihinh,ins_cap,active,ins_created,goibienche,goiluong,goichucvu,type,level,
                        lft,rgt,ins_level,goihinhthuchuongluong,goidaotao,chucnang,goivitrivieclam,donvixuly_nghiepvu_id,type_created 
                    FROM ins_dept 
                    WHERE id = " . $db->quote($donvi_id);
        $db->setQuery($query);
        $db->query();
        $id = $db->insertId();
        return $id;
    }

    /**
     * Update phân quyền ???
     * @param type $dept_id
     * @param type $parent_id
     */
    public function updatePhanQuyen($dept_id, $parent_id) {
        $db = Factory::getDbo();
        $query = "UPDATE cb_detail_groups_actions SET iddonvi=CONCAT(iddonvi,'".$db->quote($dept_id)."','') WHERE iddonvi LIKE CONCAT('%','".$db->quote($parent_id)."','%'))";
        $db->setQuery($query);
        $db->query();
    }

    /**
     * Get all data
     * @param type $id
     * @return type
     */
    public function read($id) {
        $table = Core::table('Tochuc/InsDept');
        $table->load($id);
        return $table;
    }

    /**
     * Lấy thông tin quá trình
     * @param type $quatrinh_id
     * @return type
     */
    public function getOneQuaTrinhById($quatrinh_id) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')
                ->from('ins_dept_quatrinh')
                ->where('id = ' . $db->quote($quatrinh_id));
        $db->setQuery($query);
        return $db->loadAssoc();
    }

    /**
     * Lấy all quá trình theo tổ chức
     * @param type $dept_id
     * @return type
     */
    public function getAllQuaTrinhById($dept_id) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')
                ->from('ins_dept_quatrinh')
                ->where('dept_id = ' . $db->quote($dept_id))
                ->order('hieuluc_ngay DESC, id desc')
        ;
        $db->setQuery($query);
        return $db->loadAssocList();
    }

    /**
     * Lấy văn bản id
     * @param type $vanban_id
     * @return type
     */
    public function getVanbanById($vanban_id) {
        return Core::loadAssoc('ins_vanban', array('id',
                    'mahieu',
                    'tieude',
                    'trichdan',
                    'ngaybanhanh',
                    'nguoiky',
                    'ordering',
                    'coquan_banhanh_id',
                    'coquan_banhanh',
                    'ngaytao',
                    'nguoitao'), array('id = ' => (int) $vanban_id));
    }

    /**
     * Lấy file theo vanban_id
     * @param type $vanban_id
     * @return type
     */
    public function getFilebyIdVanban($vanban_id) {
        // Type_id đối chiếu table type_filedinhkem
        return Core::loadAssocList('core_attachment', array('*'), array('type_id = ' => 1, 'object_id = ' => $vanban_id));
    }

    /**
     * Đổi trạng thái tổ chức
     * @param type $dept_id
     * @param type $active
     * @return type
     */
    public function saveChangeActive($dept_id, $active) {
        $table = Core::table('Tochuc/InsDept');
        $table->load($dept_id);
        $table->active = $active;
        $table->check();
        return $table->store();
    }

    /*
     * tranferHosoTwoTochuc ???
     * @papram integer
     * @papram integer
     * @return boolean
     */

    public function tranferHosoTwoTochuc($dept_from_id, $dept_to_id) {
        $db = Factory::getDbo();
        //lay tat ca cac hoso thuoc don vi co id dept_from_id 
        $query = $db->getQuery(true);
        $query->select(array('lft', 'rgt'))
                ->from('ins_dept')
                ->where('id = ' . $db->quote($dept_from_id));
        $db->setQuery($query);
        $node = $db->loadResult();
        if ($node != null) {
            $query = 'UPDATE hosochinh_quatrinhhientai 
                        SET congtac_phong_id=' . $db->quote($dept_to_id) . ' 
                        WHERE hosochinh_id IN (
                            SELECT a.hosochinh_id 
                                FROM hosochinh_quatrinhhientai a
                                INNER JOIN ins_dept b ON a.congtac_phong_id = b.id
                                WHERE (b.lft >=' . $node['lft'] . ' AND b.rgt <= 6' . $node['lft'] . ') 
                                    AND (a.hoso_trangthai = "00" OR a.hoso_trangthai IS NULL)
                        )';
            $db->setQuery($query);
            return $db->query();
        }
        return false;
    }

    /**
     * Sap nhập ver cũ ???
     * @param type $formData
     * @return type
     */
    public function saveSapnhap($formData) {
        $table = Core::table('Tochuc/Adsapnhap');
        $data = array(
            'dept_chinh_id' => $formData['dept_chinh_id'],
            'dept_phu_id' => $formData['dept_phu_id'],
            'quatrinh_id' => $formData['quatrinh_id'],
            'dept_chinh_name' => $formData['dept_chinh_name'],
            'dept_phu_name' => $formData['dept_phu_name']
        );
        foreach ($data as $key => $value) {
            if ($value == '' || $value == null) {
                unset($data[$key]);
            }
        }
        return $table->save($data);
    }

    /**
     * Lấy quá trình biên chế theo id
     * @param int $id
     * @return array
     */
    public function getQuatrinhBiencheById($id) {
        $table = Core::table('Tochuc/Adquatrinhbienche');
        $table->load($id);
        return $table;
    }

    /**
     * Lưu quá trình biên chế
     * @param array $formData
     * @return boolean
     */
    public function saveQuatrinhBienche($formData) {
        $table = Core::table('Tochuc/Adquatrinhbienche');
        $data = array(
            'id' => $formData['id'],
            'quyetdinh_so' => $formData['quyetdinh_so'],
            'quyetdinh_ngay' => $formData['quyetdinh_ngay'],
            'hieuluc_ngay' => TochucHelper::strDateVntoMySql($formData['hieuluc_ngay']),
            'user_id' => Factory::getUser()->id,
            'ghichu' => $formData['ghichu'],
            'dept_id' => $formData['dept_id'],
            'nghiepvu_id' => $formData['nghiepvu_id'],
            'ngay_tao' => date('Y-m-d H:i:s'),
            'vanban_id' => $formData['vanban_id'],
            'ordering' => 99,
            'nam' => $formData['nam']
        );
        $table->bind($data);
        $table->check();
        $table->store();
        return $table->id;
    }

    /**
     * Xóa quá trình biên chế
     * @param int $quatrinh_id
     * @return boolean
     */
    public function delQuaTrinhGiaoBienche($quatrinh_id) {
        $flag = false;
        $tableQuatrinhbienche = Core::table('Tochuc/Adquatrinhbienche');
        $tableVanban = Core::table('Tochuc/Advanban');
        $tableQuatrinhbienche->load($quatrinh_id);
        $tableVanban->load($tableQuatrinhbienche->vanban_id);
        Core::delete('ins_dept_quatrinh_bienche_chitiet', array('quatrinh_id = ' => $quatrinh_id));
        if (Core::delete('core_attachment', array('object_id = ' => $tableQuatrinhbienche->vanban_id, 'type_id=' => 1))) {
            if ($tableVanban->delete()) {
                if ($tableQuatrinhbienche->delete()) {
                    $flag = true;
                }
            }
        }
        return $flag;
    }

    /**
     * Luu quá trình biên chế chi tiết
     * @param int $quatrinh_id
     * @param int $hinhthuc_id
     * @param int $bienche
     * @return boolean
     */
    public function saveQuatrinhBiencheChitiet($quatrinh_id, $hinhthuc_id, $bienche) {
        $table = Core::table('Tochuc/Adquatrinhbienchechitiet');
        return $table->save(array('quatrinh_id' => $quatrinh_id, 'hinhthuc_id' => $hinhthuc_id, 'bienche' => $bienche));
    }

    /**
     * Lấy danh sách quá trình biên chế theo đơn vị
     * @param int $dept_id
     * @return array
     */
    public function getQuatrinhBiencheByDeptId($dept_id) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        // $query->select(array('fk.*,a.*'))->from('ins_dept_quatrinh_bienche a')
        //         ->join('left', 'ins_dept_quatrinh_bienche_chitiet_phanloai fk ON fk.quatrinh_id = a.id')
        //         ->where('a.dept_id = ' . $db->quote($dept_id))->order('a.nam desc'); 
        $query->select(array('a.*'))->from('ins_dept_quatrinh_bienche a')
                // ->join('left', 'ins_dept_quatrinh_bienche_chitiet_phanloai fk ON fk.quatrinh_id = a.id')
                ->where('a.dept_id = ' . $db->quote($dept_id))->order('a.nam desc');
        $db->setQuery($query);
        // echo $query;
        return $db->loadAssocList();
    }

    /**
     * Lấy hình thức biên chế theo quá trình
     * @param int $quatrinh_id
     * @return array
     */
    public function getHinhThucBienCheByQuatrinh($quatrinh_id) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query = 'SELECT b.id,b.name,a.bienche,a.quatrinh_id 
                    FROM bc_hinhthuc b 
                    INNER JOIN ins_dept_quatrinh_bienche_chitiet a ON (a.hinhthuc_id = b.id AND a.quatrinh_id = ' . $db->quote((int) $quatrinh_id) . ')
                    ORDER BY b.name ASC';
        $db->setQuery($query);
        return $db->loadAssocList();
    }

    /**
     * Lấy hình thức biên chế theo gói biên chế của đơn vị
     * @param int $goibienche_id
     * @return array
     */
    public function getHinhThucBienche($goibienche_id) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select(array('a.id', 'a.name'))->from($db->quoteName('bc_hinhthuc', 'a'))
                ->join('INNER', 'bc_goibienche_hinhthuc AS b ON a.id = b.hinhthuc_id')
                ->where('b.goibienche_id = ' . $db->quote($goibienche_id))->order('a.name ASC');
        //$query->select(array('a.ID','a.NAME'))->from($db->quoteName('bc_hinhthuc','a'));
        $db->setQuery($query);
        return $db->loadAssocList();
    }

    /**
     * Lấy hạng đơn vị ???
     * @param int $goichucvu_id
     * @return array
     */
    public function getHangDonviByIdGoiChucvu($goichucvu_id) {
        return Core::loadResult('cb_goichucvu', array('ins_level_id'), array('id = ' => (int) $goichucvu_id));
    }

    /**
     * Lấy loại hình đơn vị theo cấp đơn vị
     * @param int $ins_cap_id
     * @return int
     */
    public function getLoaihinhByIdCap($ins_cap_id) {
        /**
         *  lay node cha cua ins_cap
         * 1: Hanh chinh
         * 2: Su Nghiep
         */
        $db = Factory::getDbo();
        $query = 'SELECT parent.id
                    FROM ins_cap AS node, ins_cap AS parent 
                    WHERE node.lft BETWEEN parent.lft AND parent.rgt 
                        AND parent.lft > 0 AND node.id = ' . $db->quote($ins_cap_id) . '
                    GROUP BY parent.id 
                    ORDER BY node.lft 
                    LIMIT 1';
        $db->setQuery($query);
        return $db->loadResult();
    }

    /**
     * Thinhlh: Giao biên chế
     * @param int $id_donvi
     * @return int
     */
    public function sumBienchegiao($id_donvi) {
        $year = date("Y");
        $db = Factory::getDbo();
        // Tổng biên chế của tất cả đơn vị con
        /* $query	=	'SELECT SUM(a.bienche) FROM ins_dept_quatrinh_bienche_chitiet a
          INNER JOIN ins_dept_quatrinh_bienche b ON b.id = a.quatrinh_id
          INNER JOIN (
          SELECT node.id FROM ins_dept AS node, ins_dept AS parent
          WHERE node.lft BETWEEN parent.lft AND parent.rgt AND parent.id = '.$db->quote($id_donvi).'
          ) AS dvbc ON b.dept_id = dvbc.id
          WHERE b.nam = '.$db->quote($year); */
        // Tổng biên chế của đơn vị
        $query = 'SELECT SUM(a.bienche) 
                    FROM ins_dept_quatrinh_bienche_chitiet a
                    INNER JOIN ins_dept_quatrinh_bienche b ON b.id = a.quatrinh_id
                    WHERE b.dept_id = ' . $db->quote($id_donvi) . ' AND b.nam = ' . $db->quote($year);
        $db->setQuery($query);
        return $db->loadResult();
    }

    /**
     * Thinhlh: Biên chế hiện có
     * @param int $id_donvi
     * @return int
     */
    public function sumBienchehienco($id_donvi) {
        $db = Factory::getDbo();
        $query = 'SELECT count(hs.hosochinh_id) 
                    FROM hosochinh_quatrinhhientai as hs
                    INNER JOIN (
                        SELECT gbc.hinhthuc_id 
                            FROM ins_dept AS ind
                            INNER JOIN bc_goibienche_hinhthuc as gbc on ind.goibienche = gbc.goibienche_id
                            WHERE ind.id = ' . $db->quote($id_donvi) . ') AS ht ON hs.bienche_hinhthuc_id = ht.hinhthuc_id
                    WHERE hs.hoso_trangthai ="00" and hs.congtac_donvi_id = ' . $db->quote($id_donvi);
        $db->setQuery($query);
        return $db->loadResult();
    }

    /**
     * Lấy ra danh sách cây báo trong cấu hình cây báo cáo
     * @param int $ins_dept
     * @return array
     */
    public function getCayBaocao1($ins_dept = 0) {
        $db = Factory::getDbo();
        if ((int) $ins_dept > 0) {
            $query = 'SELECT bc.`name`,bc.report_group_code,
                            IF (bc.report_group_code IN (SELECT cf.report_group_code
                                                            FROM config_donvi_bc AS cf WHERE cf.ins_dept = '.$db->quote($ins_dept).'), "checked","") AS checked
                        FROM config_donvi_bc AS bc
                        WHERE bc.report_group_code IS NOT NULL AND bc.report_group_code <> ""
                        GROUP BY bc.report_group_code
                        ORDER BY bc.report_group_name';
        } else {
            $query = 'SELECT `name`, report_group_code, if(report_group_code = "thongkenhanh" , \'checked = "checked"\', "") as checked 
                        FROM config_donvi_bc
			WHERE report_group_code IS NOT NULL AND report_group_code <> ""
                        GROUP BY report_group_code
                        ORDER BY report_group_name';
        }
        $db->setQuery($query);
        // echo $query;die;
        $data = $db->loadAssocList();
        return $data;
    }

    /**
     * Lấy cây bso cáo
     * @param int $ins_dept
     * @return array
     */
    public function getCaybaocao($ins_dept = 0) {
        // get all
        $db = Factory::getDbo();
        $query = 'SELECT `name`, report_group_code, if(report_group_code = "thongkenhanh" , \'checked = "checked"\', "") as checked 
                    FROM config_donvi_bc
                    WHERE report_group_code IS NOT NULL AND report_group_code <> ""
                    GROUP BY report_group_code
                    ORDER BY report_group_name';
        $db->setQuery($query);
        
        $data = $db->loadAssocList();
        if ($ins_dept > 0) {
            $query = "SELECT cf.report_group_code 
                        FROM config_donvi_bc AS cf 
                        WHERE cf.ins_dept = ".$db->quote($ins_dept);
            $db->setQuery($query);
            $checked = $db->loadColumn();
            if (count($checked) > 0) {
                for ($i = 0; $i < count($data); $i++) {
                    if (in_array($data[$i]['report_group_code'], $checked))
                        $data[$i]['checked'] = 'checked';
                }
            }
        }
        return $data;
    }

    /**
     * Lấy ra id config cây báo 
     * @param int $ins_dept
     * @param string $report_group_code
     * @return array
     */
    public function getIdConfigBc($ins_dept, $report_group_code) {
        $db = Factory::getDbo();
        $query = 'SELECT id, parent_id, ins_dept, report_group_name
                    FROM config_donvi_bc 
                    WHERE ins_dept = ' . $db->quote($ins_dept) . ' AND report_group_code = ' . $db->quote($report_group_code);
        $db->setQuery($query);
        $data = $db->loadAssoc();
        return $data;
    }

    /**
     * Check tổ chức trùng, đếm số lượng tổ chức trùng tên
     * @param string $name_tc Tên tổ chức
     * @param int $id 
     * @param int $parent_id 
     * @return int
     */
    public function checkTochucTrung() {
        $app = Factory::getApplication()->input;
        $name_tc = $app->getVar('name_tc');
        $id = $app->getVar('id');
        $parent_id = $app->getInt('parent_id', null);
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('count(id)')->from('ins_dept')
                ->where('LOWER(name) = LOWER(' . $db->quote($name_tc) . ')')
                ->where('parent_id = ' . $db->quote($parent_id))
                ->where('id != ' . $db->quote($id));
        $db->setQuery($query);
        return $db->loadResult();
    }

    /**
     * Cập nhật tên
     * @param string $table
     * @param string $fieldUpdate
     * @param string $fieldWhere
     * @param string $valueUpdate
     * @param string $valueWhere
     */
    public function changeNameUpdated($table, $fieldUpdate, $fieldWhere, $valueUpdate, $valueWhere) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName($fieldUpdate) . '=' . $db->quote($valueUpdate),
        );
        $conditions = array(
            $db->quoteName($fieldWhere) . '=' . $db->quote($valueWhere)
        );
        $query->update($db->quoteName($table))->set($fields)->where($conditions);
        $db->setQuery($query);
        $db->query();
    }

    /**
     * Lấy danh sách văn bản thành lập tổ chức
     * @param int $donvi_id
     * @return object
     */
    public function danhsachIns_dept_vanban($donvi_id = -1) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('vb.mahieu, vb.ngaybanhanh, vb.coquan_banhanh,  vb2.ins_vanban_id')
                ->from('ins_vanban vb')
                ->join('inner', 'ins_dept_vanban vb2 ON vb2.ins_vanban_id = vb.id')
                ->where('vb2.ins_dept_id = ' . $db->quote($donvi_id));
        $db->setQuery($query);
        // echo $query;
        return $db->loadObjectList();
    }

    /**
     * Lấy mảng tập tin đính kèm
     * @param int $vanban_id
     * @return object
     */
    public function taptindinhkem($vanban_id = -1) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('code, filename')
                ->from('core_attachment')
                ->where('object_id = ' . $db->quote($vanban_id));
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    /**
     * Lấy tên tập tin đính kèm
     * @param strong $code
     * @return object
     */
    public function taptindinhkem1($code = -1) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('filename')
                ->from('core_attachment')
                ->where('code = ' . $db->quote($code));
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    /**
     * Xóa van ban theo đơn vị
     * @param int $donvi_id
     * @return boolean
     */
    public function xoaIns_dept_vanban($donvi_id) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('ins_dept_id') . ' IN (' . $db->quote($donvi_id) . ')'
        );
        $query->delete($db->quoteName('ins_dept_vanban'));
        $query->where($conditions);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Xóa file đính kèm
     * @param int $vanban_id
     * @return boolean
     */
    public function xoaCore_attachment($vanban_id) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('object_id') . ' IN (' . $vanban_id . ')'
        );
        $query->delete($db->quoteName('core_attachment'));
        $query->where($conditions);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Xóa văn bản theo văn bản
     * @param int $vanban_id
     * @return boolean
     */
    public function xoaIns_vanban($vanban_id) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('id') . ' IN (' . $vanban_id . ')'
        );
        $query->delete($db->quoteName('ins_vanban'));
        $query->where($conditions);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Lưu văn bản theo đơn vị, vanban_id
     * @param int $donvi_id
     * @param int $vanban_id
     * @return boolean
     */
    public function luuIns_dept_vanban($donvi_id, $vanban_id) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('ins_dept_id') . '=' . $db->quote($donvi_id),
            $db->quoteName('ins_vanban_id') . '=' . $db->quote($vanban_id),
        );
        $query->insert($db->quoteName('ins_dept_vanban'));
        $query->set($fields);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Tạo mã tổ chức mới
     * @param int $donvi_id
     * @return string
     */
    public function generateCodeTochucNew($donvi_id) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $donvi_id = $db->quote($donvi_id);
        $query = "SELECT
                    CONCAT(
                        (SELECT CODE FROM ins_dept WHERE id = ".$db->quote($donvi_id)."),'.',
                        (IF(MAX(CAST(REPLACE(CODE,CONCAT((SELECT CODE FROM ins_dept WHERE id = ".$db->quote($donvi_id)." ),'.',''),'') AS UNSIGNED)) >0,
                            MAX(CAST(REPLACE(CODE,CONCAT((SELECT CODE FROM ins_dept WHERE id = ".$db->quote($donvi_id)." ),'.',''),'') AS UNSIGNED)) ,0)+1)
                    )
                    FROM ins_dept
                    WHERE parent_id = ".$db->quote($donvi_id);
        $db->setQuery($query);
        return $db->loadResult();
    }

    /**
     * Check mã số tổ chức trùng
     * @param string $code
     * @return int
     */
    public function checkMasoTrung($code) {
        $db = Factory::getDbo();
        $query = 'SELECT COUNT(*)
                    FROM ins_dept
                    WHERE code = ' . $db->quote($code);
        $db->setQuery($query);
        return $db->loadResult();
    }

    /**
     * Check số lượng hồ sơ của đơn vị theo phòng hoặc đơn vị
     * @param int $donvi
     * @return int
     */
    public function checkSoluongHosoByDonvi($donvi) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('COUNT(*)')->from('hosochinh_quatrinhhientai')
                ->where('hoso_trangthai = "00"')
                ->where('( congtac_donvi_id = ' . $db->quote($donvi) . ' OR congtac_phong_id= ' . $db->quote($donvi) . ')');
        $db->setQuery($query);
        return $db->loadResult();
    }

    function luucauhinh() {
        $db = Factory::getDbo();
        $app = Factory::getApplication()->input;
        $formData = $app->getVar('cauhinh');
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('ngaybatdau') . '=' . $db->quote(Core::convertToEnDateFromVNdate($formData['ngaybatdau'])),
            $db->quoteName('ngayketthuc') . '=' . $db->quote(Core::convertToEnDateFromVNdate($formData['ngayketthuc'])),
            $db->quoteName('donvi_id') . '=' . $db->quote($formData['donvi_id']),
            $db->quoteName('loaiquyetdinh_id') . '=' . $db->quote($formData['loaiquyetdinh_id']),
            $db->quoteName('ngachtuongduong') . '=' . $db->quote($formData['ngachtuongduong']),
            $db->quoteName('sokyhieu') . '=' . $db->quote($formData['sokyhieu']),
            $db->quoteName('diadanh') . '=' . $db->quote($formData['diadanh']),
            $db->quoteName('tenloaiquyetdinh') . '=' . $db->quote($formData['tenloaiquyetdinh']),
            $db->quoteName('cancu') . '=' . $db->quote($formData['cancu']),
            $db->quoteName('chucvunguoiky') . '=' . $db->quote($formData['chucvunguoiky']),
            $db->quoteName('noinhan') . '=' . $db->quote($formData['noinhan']),
            $db->quoteName('tentinh') . '=' . $db->quote($formData['tentinh']),
            $db->quoteName('tendonvi') . '=' . $db->quote($formData['tendonvi']),
            $db->quoteName('xetdenghi') . '=' . $db->quote($formData['xetdenghi']),
            $db->quoteName('donvilienquan') . '=' . $db->quote($formData['donvilienquan']),
            $db->quoteName('thutruongdonvi') . '=' . $db->quote($formData['thutruongdonvi']),
        );
        if (isset($formData['id']) && $formData['id'] > 0) {
            $conditions = array(
                $db->quoteName('id') . '=' . $db->quote($formData['id'])
            );
            array_push($fields, $db->quoteName('ngayhieuchinh') . ' = now()');
            array_push($fields, $db->quoteName('nguoihieuchinh') . ' = ' . Factory::getUser()->id);
            $query->update($db->quoteName('nghiepvu_mauxuatquyetdinh'))->set($fields)->where($conditions);
        } else {
            array_push($fields, $db->quoteName('ngaytao') . ' = now()');
            array_push($fields, $db->quoteName('nguoitao') . ' = ' . Factory::getUser()->id);
            $query->insert($db->quoteName('nghiepvu_mauxuatquyetdinh'));
            $query->set($fields);
        }
        $db->setQuery($query);
        return $db->query();
    }

    function xoacauhinh() {
        $db = Factory::getDbo();
        $app = Factory::getApplication()->input;
        $formData = $app->getVar('cauhinh');
        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('donvi_id') . ' = ' . $db->quote($formData['donvi_id'])
        );
        $query->delete($db->quoteName('nghiepvu_mauxuatquyetdinh'));
        $query->where($conditions);
        $db->setQuery($query);
        return $db->query();
    }

    public function getCboMauxuatquyetdinh($donvi_id, $loaiquyetdinh_id, $ngachtuongduong, $selected = null, $id = null) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select(array('id', 'CONCAT("Từ ", date_format(ngaybatdau,"%d/%m/%Y"), if(ngayketthuc="0000-00-00"," đến nay",CONCAT(" đến ", date_format(ngayketthuc,"%d/%m/%Y")))) as name'))
                ->from($db->quoteName('nghiepvu_mauxuatquyetdinh', 'a'))
                ->where('donvi_id = ' . $donvi_id)
                ->where('loaiquyetdinh_id=' . $loaiquyetdinh_id)
                ->where('ngachtuongduong=' . $ngachtuongduong);
        $query->order('ngaybatdau DESC');
        $db->setQuery($query);
        $tmp = $db->loadObjectList();
        if (count($tmp) > 0)
            $tmp_moinhat = $tmp[0]->id;
        $data = array();

        for ($i = 0; $i < count($tmp); $i++) {
            array_push($data, array('value' => $tmp[$i]->id, 'text' => $tmp[$i]->name));
        }
        array_push($data, array('value', 'text' => '-- Nhập mới --'));
        $options = array(
            'id' => $id,
            'list.attr' => array(
                'class' => '',
                'z-index' => '9999',
                'style' => 'width: 100%'
            ),
            'option.key' => 'value',
            'option.text' => 'text',
            'option.attr' => 'attr',
            'list.select' => $tmp_moinhat
        );
        return $result = HtmlSelect::genericlist($data, $id, $options);
    }

    function savegiaouoc($formData) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('noidung') . '=' . $db->quote($formData['noidung']),
            $db->quoteName('nam') . '=' . $db->quote($formData['nam']),
            $db->quoteName('donvi_id') . '=' . $db->quote($formData['donvi_id']),
            $db->quoteName('daidiencongdoan') . '=' . $db->quote($formData['daidiencongdoan']),
            $db->quoteName('daidienchinhquyen') . '=' . $db->quote($formData['daidienchinhquyen']),
        );
        if (isset($formData['id']) && $formData['id'] > 0) {
            $conditions = array(
                $db->quoteName('id') . '=' . $db->quote($formData['id'])
            );
            array_push($fields, $db->quoteName('ngayhieuchinh') . ' = NOW()');
            array_push($fields, $db->quoteName('nguoihieuchinh') . ' = ' . Factory::getUser()->id);
            $query->update($db->quoteName('ins_dept_giaouocthidua'))->set($fields)->where($conditions);
            $id = $formData['id'];
            $db->setQuery($query);
            $db->query();
        } else {
            array_push($fields, $db->quoteName('ngaytao') . ' = NOW()');
            array_push($fields, $db->quoteName('nguoitao') . ' = ' . Factory::getUser()->id);
            $query->insert($db->quoteName('ins_dept_giaouocthidua'));
            $query->set($fields);
            $db->setQuery($query);
            $db->query();
            $id = $db->insertId();
        }
        return $id;
    }

    function xoagiaouoc() {
        $db = Factory::getDbo();
        $app = Factory::getApplication()->input;
        $id = $app->getVar('id');
        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('id') . ' = ' . $db->quote($id)
        );
        $query->delete($db->quoteName('ins_dept_giaouocthidua'));
        $query->where($conditions);
        $db->setQuery($query);
        return $db->query();
    }

    public function luuFkGiaoUoc($giaouoc_id, $code) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('ins_dept_giaouocthidua_id') . '=' . $db->quote($giaouoc_id),
            $db->quoteName('code') . '=' . $db->quote($code)
        );
        $query->insert($db->quoteName('ins_dept_giaouocthidua_fk_attachment'));
        $query->set($fields);
        $db->setQuery($query);
        $db->query();
        return $db->insertId();
    }

    function savephanhangdonvi($formData) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('ngaybatdau') . '=' . $db->quote(Core::convertToEnDateFromVNdate($formData['ngaybatdau'])),
            $db->quoteName('ngayketthuc') . '=' . $db->quote(Core::convertToEnDateFromVNdate($formData['ngayketthuc'])),
            $db->quoteName('hinhthucphanhang_id') . '=' . $db->quote($formData['hinhthucphanhang_id']),
            $db->quoteName('hangdonvisunghiep_id') . '=' . $db->quote($formData['hangdonvisunghiep_id']),
            $db->quoteName('ghichu') . '=' . $db->quote($formData['ghichu']),
            $db->quoteName('soqd') . '=' . $db->quote($formData['soqd']),
            $db->quoteName('ngayqd') . '=' . $db->quote(Core::convertToEnDateFromVNdate($formData['ngayqd'])),
            $db->quoteName('coquanqd') . '=' . $db->quote($formData['coquanqd']),
            $db->quoteName('donvi_id') . '=' . $db->quote($formData['donvi_id']),
        );
        if (isset($formData['id']) && $formData['id'] > 0) {
            $conditions = array(
                $db->quoteName('id') . '=' . $db->quote($formData['id'])
            );
            array_push($fields, $db->quoteName('ngayhieuchinh') . ' = NOW()');
            array_push($fields, $db->quoteName('nguoihieuchinh') . ' = ' . Factory::getUser()->id);
            $query->update($db->quoteName('ins_dept_phanhangdonvi'))->set($fields)->where($conditions);
            $id = $formData['id'];
            $db->setQuery($query);
            $db->query();
        } else {
            array_push($fields, $db->quoteName('ngaytao') . ' = NOW()');
            array_push($fields, $db->quoteName('nguoitao') . ' = ' . Factory::getUser()->id);
            $query->insert($db->quoteName('ins_dept_phanhangdonvi'));
            $query->set($fields);
            $db->setQuery($query);
            $db->query();
            $id = $db->insertId();
        }
        // echo $query;
        return $id;
    }
    function updateHangHienTaiDonVi($donvi_id){
        $hanghientai = Core::loadAssocList('ins_dept_phanhangdonvi','hangdonvisunghiep_id','donvi_id = '.(int)$donvi_id,' ngayqd DESC');
        Core::update('ins_dept',array('hangdonvisunghiep_id'=>$hanghientai[0]['hangdonvisunghiep_id'],'id'=>(int)$donvi_id),'id');
        return true;
    }
    // function xoaphanhangdonvi() {
    //     $db = Factory::getDbo();
    //     $id = JRequest::getVar('id');
    //     $query = $db->getQuery(true);
    //     $conditions = array(
    //         $db->quoteName('id') . ' = ' . $db->quote($id)
    //     );
    //     $query->delete($db->quoteName('ins_dept_phanhangdonvi'));
    //     $query->where($conditions);
    //     $db->setQuery($query);
    //     return $db->query();
    // }

    public function luuFkPhanHangDonVi($giaouoc_id, $code) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('ins_dept_phanhangdonvi_id') . '=' . $db->quote($giaouoc_id),
            $db->quoteName('code') . '=' . $db->quote($code)
        );
        $query->insert($db->quoteName('ins_dept_phanhangdonvi_fk_attachment'));
        $query->set($fields);
        $db->setQuery($query);
        $db->query();
        return $db->insertId();
    }

}
