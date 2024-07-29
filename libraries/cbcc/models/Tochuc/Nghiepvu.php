<?php

/**
 * Author: Phucnh
 * Date created: Jan 15, 2016
 * Company: DNICT
 */
class Tochuc_Model_Nghiepvu {

    /**
     * Đổi ngày VN sang ngày MySQL
     * @param string $dateVN
     * @return string
     */
    public function strDateVntoMySql($dateVN) {
        if (empty($dateVN)) {
            return '';
        }
        $dateVN = explode('/', $dateVN);
        return $dateVN[2] . '-' . $dateVN[1] . '-' . $dateVN[0];
    }

    /**
     * Get combobox
     * @param string $table 'abc as tbl'
     * @param string $field 'ten, id, ....'
     * @param string $where 'a = 1 and ... '
     * @param string $order 'od asc, id desc'
     * @param string $value value default
     * @param string $text 	text default
     * @param string $code
     * @param string $name
     * @param string $selected
     * @param string $idname
     * @param string $class
     * @param string $attrArray
     * @return string
     */
    public function getCbo($table, $field, $where = null, $order = null, $value = null, $text = null, $code, $name, $selected = null, $idname = null, $class = null, $attrArray = null) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select(array($field))
                ->from($table);
        if ($where != null || $where != "")
            $query->where($where);
        $query->order($order);
        $db->setQuery($query);
        $tmp = $db->loadObjectList();
        $data = array();
        if ($value != null && $text != null)
            array_push($data, array('value' => $value, 'text' => $text));
        for ($i = 0; $i < count($tmp); $i++) {
            $attr = array();
            if (isset($attrArray) && is_array($attrArray))
                foreach ($attrArray as $k => $v) {
                    $attr+=array($k => $tmp[$i]->$v);
                }
            if (!isset($attr) && !is_array($attr))
                array_push($data, array('value' => $tmp[$i]->$code, 'text' => $tmp[$i]->$name));
            else {
                array_push($data, array('value' => $tmp[$i]->$code, 'text' => $tmp[$i]->$name, 'attr' => $attr));
            }
        }
        $options = array(
            'id' => $idname,
            'list.attr' => array(
                'class' => $class,
            ),
            'option.key' => 'value',
            'option.text' => 'text',
            'option.attr' => 'attr',
            'list.select' => $selected
        );
        return $result = JHtmlSelect::genericlist($data, $idname, $options);
    }

// Nghiệp vụ tổ chức ------------------------------------
    // ĐỔI TÊN TỔ CHỨC, PHÒNG, TỔ CHỨC HOẠT ĐỘNG NHƯ PHÒNG
    /**
     * 	Cập nhật ngày kết thúc quá trình công tác
     * 	Nghiệp vụ ĐỔI TÊN, SÁP NHẬP sử dụng hàm này
     * @param type $ngayhieuluc
     * @param type $donvi_id
     * @param type $type
     * @return boolean
     */
    public function updateNgayketthucCongtac($ngayhieuluc, $donvi_id, $type) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "
                                    update quatrinhcongtac a, hosochinh_quatrinhhientai b
                                            set a.end_date_ct = DATE_ADD(" . $db->quote($this->strDateVntoMySql($ngayhieuluc)) . ",INTERVAL -1 DAY)
                                            where a.emp_id_ct = b.hosochinh_id AND a.start_date_ct <= " . $db->quote($this->strDateVntoMySql($ngayhieuluc)) . " and a.end_date_ct is null";

        if ($type == 1 || $type == 3) {
            $query .= " and a.inst_code_ct = " . $db->quote($donvi_id) . "
                                            and a.inst_code_ct = b.congtac_donvi_id";
        } else if ($type == 0) {
            $query .= " and a.dept_id = " . $db->quote($donvi_id) . "
                                            and a.dept_id = b.congtac_phong_id";
        } else
            return false;
        $query .= "	
                                            and b.hoso_trangthai = '00';";
        $db->setQuery($query);
        $db->query();
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 	Cập nhật ngày kết thúc quá trình kiêm nhiệm, biệt phái
     * @param type $ngayhieuluc
     * @param type $donvi_id
     * @param type $type
     * @return boolean
     */
    public function updateNgayketthucKiemnhiembietphai($ngayhieuluc, $donvi_id, $type) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        // echo $type;
        $query = "
			UPDATE ct_kiemnhiembietphai a, hosochinh_quatrinhhientai b
			set a.end_date_knbp = DATE_ADD(" . $db->quote($this->strDateVntoMySql($ngayhieuluc)) . ",INTERVAL -1 DAY)";
        $query .=" WHERE a.start_date_knbp <= " . $db->quote($this->strDateVntoMySql($ngayhieuluc)) . " and a.end_date_knbp is null";
        if ($type == 1 || $type == 3) {
            $query .= " and a.inst_code_knbp = " . $db->q($donvi_id);
// 						"and a.inst_code_knbp = b.congtac_donvi_id";
        } else if ($type == 0) {
            $query .= " and a.dept_code_knbp = " . $db->q($donvi_id);
// 						"and a.dept_code_knbp = b.congtac_phong_id";
        } else
            return false;
        $query.= " and a.emp_id_knbp = b.hosochinh_id
			 and b.hoso_trangthai = '00'";
        $db->setQuery($query);
        $db->query();
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 	Thêm mới quá trình công tác ứng với tên thay đổi
     *
     * @param type $formData
     * @return boolean
     */
    public function addCongtac($formData) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "insert into quatrinhcongtac(
					emp_id_ct,
					inst_code_ct,
					inst_name_ct,
					start_date_ct,
					pos_sys_fk,
					pos_name_ct,
					coef_ct,
					dept_name,
					dept_id,
					whois_pos_mgr_id,
					cachthucbonhiem_id,
					ngaycongbo_ct
				)
				select
					hosochinh_id,
					congtac_donvi_id as inst_code_ct,
					" . ($formData['type'] != 0 ? $db->q($formData['name_moi']) : "congtac_donvi") . " as inst_name_ct,
					" . $db->q($this->strDateVntoMySql($formData['hieuluc_ngay'])) . " as start_date_ct,
					congtac_chucvu_id as pos_sys_fk,
					congtac_chucvu as pos_name_ct,
					congtac_chucvu_heso as coef_ct,
                    " . ($formData['type'] == 0 ? $db->q($formData['name_moi']) : $db->q('')) . " as dept_name,
					" . ($formData['type'] == 0 ? 'congtac_phong_id' : 0) . " as dept_id,
					congtac_hinhthuc_phancongbonhiem_id as whois_pos_mgr_id,
					congtac_cachthucbonhiem_id as cachthucbonhiem_id,
					congtac_chucvu_ngaycongbo as ngaycongbo_ct
				from hosochinh_quatrinhhientai
				where " . ($formData['type'] == 0 ? 'congtac_phong_id' : 'congtac_donvi_id') . " = " . $db->q($formData['donvi_id']) . " 
				and hoso_trangthai = '00'
				";
        $db->setQuery($query);
        // echo $query;die;
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 	Thêm mới quá trình kiêm nhiệm, biệt phái ứng với tên thay đổi
     * @param type $formData
     * @return boolean
     */
    public function addKiemnhiembietphai($formData) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "insert into ct_kiemnhiembietphai(
                    emp_id_knbp, start_date_knbp, type_knbp, inst_code_knbp, inst_name_knbp, dept_code_knbp,
                    dept_name_knbp, pos_sys_knbp, pos_name_knbp, status, soquyetdinh_knbp, ngaybanhanh_knbp,
                    coquan_banhanh_knbp, coef_knbp)
                select
                knbp.emp_id_knbp,
                " . $db->q($this->strDateVntoMySql($formData['hieuluc_ngay'])) . " as start_date_knbp,
                knbp.type_knbp,
                knbp.inst_code_knbp,
                " . ($formData['type'] != 0 ? $db->q($formData['name_moi']) : "knbp.inst_name_knbp") . " as inst_name_knbp,
                knbp.dept_code_knbp,
                " . ($formData['type'] == 0 ? $db->q($formData['name_moi']) : "knbp.dept_name_knbp") . " as dept_name_knbp,
                knbp.pos_sys_knbp,
                knbp.pos_name_knbp,
                knbp.status,
                knbp.soquyetdinh_knbp,
                knbp.ngaybanhanh_knbp,
                knbp.coquan_banhanh_knbp,
                knbp.coef_knbp
                from ct_kiemnhiembietphai knbp
                inner join hosochinh_quatrinhhientai hsht ON hsht.hosochinh_id = knbp.emp_id_knbp
                where " . ($formData['type'] == 0 ? 'knbp.dept_code_knbp' : 'knbp.inst_code_knbp') . " = " . $db->q($formData['donvi_id']) . "  
                and knbp.end_date_knbp is not null
                and hsht.hoso_trangthai = '00'
                group by knbp.type_knbp, knbp.emp_id_knbp
                order by knbp.start_date_knbp desc
                ";
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * Hàm đổi tên tổ chức
     * @param type $donvi_id
     * @param type $name_moi
     * @return boolean
     */
    public function doitenInsdept($donvi_id, $name_moi) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "UPDATE ins_dept SET name = " . $db->quote($name_moi) . " , s_name = " . $db->quote($name_moi) . " where id=" . $db->quote($donvi_id);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * Hàm cập nhật trạng thái đơn vị
     * @param type $donvi_id
     * @param type $active
     * @return boolean
     */
    public function updateTrangthai($donvi_id, $active) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "UPDATE ins_dept SET ";
        $query .= "active = " . $db->quote($active) . " where id=" . $db->quote($donvi_id);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * Hàm cập nhật tên đơn vị, phòng ban cho hồ sơ của đơn vị chính sau khi sáp nhập/ đổi tên
     * @param type $donvi_id
     * @param type $name_moi
     * @param type $type
     * @return boolean
     */
    public function updateHshtChinh($donvi_id, $name_moi, $type) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "UPDATE hosochinh_quatrinhhientai SET ";
        if ($type == 0)
            $query .=" congtac_phong = " . $db->quote($name_moi) . " where congtac_phong_id=" . $db->quote($donvi_id);
        else
            $query .= "congtac_donvi = " . $db->quote($name_moi) . " where congtac_donvi_id=" . $db->quote($donvi_id);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * Hàm cập nhật đơn vị, phòng mới khi sáp nhập
     * @param type $donvi_id_cu
     * @param type $donvi_id_moi
     * @param type $name_moi
     * @param type $type
     * @return boolean
     */
    public function updateHshtPhu($donvi_id_cu, $donvi_id_moi, $name_moi, $type) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "UPDATE hosochinh_quatrinhhientai SET ";
        if ($type == 0)
            $query .=" congtac_phong = " . $db->quote($name_moi) . ",congtac_phong_id =" . $db->quote($donvi_id_moi) . " where congtac_phong_id=" . $db->quote($donvi_id_cu);
        else
            $query .= "congtac_donvi = " . $db->quote($name_moi) . ",congtac_donvi_id =" . $db->quote($donvi_id_moi) . ", congtac_phong = '',congtac_phong_id =0  where congtac_donvi_id=" . $db->quote($donvi_id_cu);
        $db->setQuery($query);
//                echo $query;die;
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * Cập nhật text trong các cây báo cáo
     * @param type $donvi_id
     * @param type $name_moi
     * @return boolean
     */
    public function updateConfigBaocao($donvi_id, $name_moi) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "UPDATE config_donvi_bc SET ";
        $query .= "name = " . $db->quote($name_moi) . " where ins_dept=" . $db->quote($donvi_id);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }

    /////////////////////////////////////////////////////////////
    //  NGHIỆP VỤ SÁP NHẬP
    //
    //
    //
    //
    //
    /////////////////////////////////////////////////////////////
    /**
     * Xóa Tổ chức phụ trong config báo cáo
     * @param int $donvi_id
     * @return boolean
     */
    public function removeTochucphu($donvi_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $subQ = $db->getQuery(true);
        $subQ->select('id')->from('ins_dept')->where('parent_id = ' . $db->quote($donvi_id));
        $conditions = array(
            $db->quoteName('ins_dept') . ' IN (' . $subQ . ')'
        );
        $query->delete($db->quoteName('config_donvi_bc'));
        $query->where($conditions);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 	Thêm mới quá trình công tác ứng với tên thay đổi
     * @param type $formData
     * @return boolean
     */
    public function addCongtacPhu($formData) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "insert into quatrinhcongtac(
                            emp_id_ct, inst_code_ct, inst_name_ct, dept_name,dept_id,
                            start_date_ct, pos_sys_fk, pos_name_ct, coef_ct, whois_pos_mgr_id,
                            cachthucbonhiem_id, ngaycongbo_ct)
                select
                        hosochinh_id,
                        congtac_donvi_id as inst_code_ct,
                        congtac_donvi as inst_name_ct,
                        congtac_phong as dept_name,
                        congtac_phong_id as dept_id,

                        " . $db->q($this->strDateVntoMySql($formData['hieuluc_ngay'])) . " as start_date_ct,
                        congtac_chucvu_id as pos_sys_fk,
                        congtac_chucvu as pos_name_ct,
                        congtac_chucvu_heso as coef_ct,

                        congtac_hinhthuc_phancongbonhiem_id as whois_pos_mgr_id,
                        congtac_cachthucbonhiem_id as cachthucbonhiem_id,
                        congtac_chucvu_ngaycongbo as ngaycongbo_ct
                from hosochinh_quatrinhhientai
                where " . ($formData['type'] == 0 ? 'congtac_phong_id' : 'congtac_donvi_id') . " = " . $db->q($formData['donvi_id']) . " 
                and hoso_trangthai = '00'
                ";
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 	Thêm mới quá trình kiêm nhiệm, biệt phái ứng với tên thay đổi
     * @param type $formData
     * @return boolean
     */
    public function addKiemnhiembietphaiPhu($formData) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "insert into ct_kiemnhiembietphai(
                            emp_id_knbp, start_date_knbp, type_knbp, inst_code_knbp, inst_name_knbp,
                            dept_code_knbp, dept_name_knbp, pos_sys_knbp, pos_name_knbp, status,
                            soquyetdinh_knbp, ngaybanhanh_knbp, coquan_banhanh_knbp, coef_knbp)
                select
                knbp.emp_id_knbp,
                " . $db->q($this->strDateVntoMySql($formData['hieuluc_ngay'])) . " as start_date_knbp,
                knbp.type_knbp,
                " . ($formData['type'] == 1 ? $db->q($formData['donvi_id']) : "knbp.inst_code_knbp") . " as inst_code_knbp,
                " . ($formData['type'] == 1 ? $db->q($formData['name_moi']) : "knbp.inst_name_knbp") . " as inst_name_knbp,
                " . ($formData['type'] == 0 ? $db->q($formData['donvi_id']) : "knbp.dept_code_knbp") . " as dept_code_knbp,
                " . ($formData['type'] == 0 ? $db->q($formData['name_moi']) : "knbp.dept_name_knbp") . " as dept_name_knbp,
                knbp.pos_sys_knbp,
                knbp.pos_name_knbp,
                knbp.status,
                knbp.soquyetdinh_knbp,
                knbp.ngaybanhanh_knbp,
                knbp.coquan_banhanh_knbp,
                knbp.coef_knbp
                from ct_kiemnhiembietphai knbp
                inner join hosochinh_quatrinhhientai hsht ON hsht.hosochinh_id = knbp.emp_id_knbp
                where " . ($formData['type'] == 0 ? 'knbp.dept_code_knbp' : 'knbp.inst_code_knbp') . " = " . $db->q($formData['donvi_id_cu']) . "  
                and knbp.end_date_knbp is not null
                and hsht.hoso_trangthai = '00'
                group by knbp.type_knbp, knbp.emp_id_knbp
                order by knbp.start_date_knbp desc
                ";
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        } else {
            return true;
        }
    }
    function getDonviByParent($parent_id, $donvi=null, $capdonvi=null, $loaihinh= null){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $lft_rgt = Core::loadAssoc('ins_dept','lft, rgt','id='.$db->quote($parent_id));
        $query->select('*')
        ->from('ins_dept')
        ->where('lft BETWEEN '.$db->quote((int)$lft_rgt['lft']).' AND '.$db->quote((int)$lft_rgt['rgt']))
        ->where('active = 1')
        ->where('(type = 1 or type = 3)')
        ->order('lft ASC');
        if(strlen($donvi)>0 && $donvi != null && $donvi != 'null') $query->where('id IN (0'.$donvi.')');
        if(strlen($capdonvi)>0 && $capdonvi != null && $capdonvi != 'null') $query->where('ins_cap IN (SELECT b.id FROM `ins_cap` a inner join ins_cap b  ON b.lft BETWEEN a.lft AND a.rgt where a.id in (0'.$capdonvi.'))');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    function dataFilterDDonViChuaChuyenHoSo(){
        $input = JFactory::getApplication()->input;
        $array['noidung'] = $input->get('flt_noidung', '', 'string');
        $array['cachthuc_id'] = $input->get('flt_cachthuc_id', 0, 'int');
        $array['trangthai'] = $input->get('flt_trangthai', 0, 'int');
        // $arrar['ngaybanhanh_tu'] = $input->get('flt_ngaybanhanh_tu', 0, 'string');
        // $arrar['ngaybanhanh_den'] = $input->get('flt_ngaybanhanh_den', 0, 'string');
		$db = JFactory::getDbo();
		$db->sql("SET character_set_client=utf8");
		$db->sql("SET character_set_connection=utf8");
		$db->sql("SET character_set_results=utf8");
		$columns = array(
				array('db' => 'a.id',								'dt' => 0),
				array('db' => 'a.noidung',								'dt' => 1),
				array('db' => 'a.ngaytao', 'alias'=>'ngaytao',		'dt' => 2),
				array('db' => 'c.name', 'alias'=>'nghiepvu_name',		'dt' => 3),
				array('db' => 'a.cachthuc_id',  'dt' => 4),
                array('db' => 'a.quatrinh_id',  'dt' => 5),
				array('db' => 'a.trangthai',  'dt' => 6)
		);
		$table = 'ins_dept_nghiepvu_logs AS a';
		$primaryKey = 'a.id';
		$join = ' INNER JOIN ins_dept_quatrinh b ON b.id= a.quatrinh_id';
        $join .= ' INNER JOIN ins_dept_cachthuc c ON c.id= a.cachthuc_id';
        // 
		if(isset($array['cachthuc_id']) && (int)$array['cachthuc_id'] > 0 ) 
            $where[] = 'a.cachthuc_id = '.$db->quote($array['cachthuc_id']);
        if(isset($array['noidung']) && mb_strlen($array['noidung']) > 0) 
            $where[] = 'a.noidung = '.$db->quote($array['noidung']);
		if(isset($array['trangthai']) && mb_strlen($array['trangthai']) > 0) 
            $where[] = 'a.trangthai = '.$db->quote($array['trangthai']);
        else $where[] = 'a.trangthai = 0';
		// if(isset($array['flt_ngaybatdau'])) 
		// 	$where[] = 'a.batdau >= '.$db->quote($this->strDateVntoMySql($array['flt_ngaybatdau']).' 00:00:01');
		// if(isset($array['flt_ngayketthuc'])) 
		// 	$where[] = 'a.ketthuc <= '.$db->quote($this->strDateVntoMySql($array['flt_ngaybatdau']).' 23:59:59');
		$where = implode(' AND ', $where).' order by a.ngaytao desc';
		$datatables = Core::model('Core/Datatables');
		return $datatables->simple( $_POST, $table, $primaryKey, $columns ,$join, $where);
	}
    /**
     * Set độ dài GROUP_CONCAT mysql
     */
    public function setGroupconcat($val){
    	$db = JFactory::getDbo();
    	$query = $db->getQuery(true);
        $query = 'SET SESSION group_concat_max_len = '.$val.';';
        $db->setQuery($query);
        $db->query();
    }
}