<?php

class Tochuc_Model_InsDept {

    /**
     * Lấy tất cả tổ chức
     * @param type $params
     * @param type $order
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function findAll($params = null, $order = null, $offset = null, $limit = null) {
        $table = Core::table('Tochuc/InsDept');
        $db = $table->getDbo();
        $query = $db->getQuery(true);
        $query->select(array('*'))
                ->from($table->getTableName())
        ;
        if (isset($params['name']) && !empty($params['name'])) {
            $query->where('name LIKE (' . $db->quote('%' . $params['name'] . '%') . ')');
        }
        if ($order == null) {
            $query->order('lft');
        } else {
            $query->order($order);
        }

        if ($offset != null && $limit != null) {
            $db->setQuery($query, $offset, $limit);
        } else {
            $db->setQuery($query);
        }
        return $db->loadAssocList();
        //return $table->delete($id);
    }

    /**
     * Lấy dữ liệu đơn vị
     * @param type $id
     * @return type
     */
    public function read($id) {
        $table = Core::table('Tochuc/InsDept');
        if (!$table->load($id)) {
            return array();
        }
        $fields = array_keys($table->getFields());
        $data = array();
        for ($i = 0; $i < count($fields); $i++) {
            $data[$fields[$i]] = $table->$fields[$i];
        }
        return $data;
    }

    /**
     * Lấy tên đơn vị theo id
     * @param type $id
     * @return type
     */
    public function getNameById($id) {
        $table = Core::table('Tochuc/InsDept');
        if (!$table->load($id)) {
            return null;
        }
        return $table->name;
    }

    public function collect($params = null, $order = null, $offset = null, $limit = null) {
        $table = Core::table('Tochuc/InsDept');
        $db = $table->getDbo();
        $query = $db->getQuery(true);
        $query->select(array('id', 'name'))
                ->from($table->getTableName());
        if ($params['type'] == 'donvi') {
            $query->where('type = 1 OR type = 3');
        } elseif ($params['type'] == 'phong' && isset($params['inst_code'])) {
            $query->where('(type = 0 OR type =3) AND parent_id = ' . $db->quote($params['inst_code']));
        } elseif ($params['type'] == 'vochua') {
            $query->where('type = 2');
        }
        if ($order == null) {
            $query->order('lft');
        } else {
            $query->order($order);
        }
        if ($offset != null && $limit != null) {
            $db->setQuery($query, $offset, $limit);
        } else {
            $db->setQuery($query);
        }
        return $db->loadAssocList();
    }

    /**
     * Lấy mảng thông tin đơn vị
     * @param type $params
     * @param type $order
     * @param type $offset
     * @param type $limit
     * @return array
     */
    public function collect_Inst($params = null, $order = null, $offset = null, $limit = null) {
        $table = Core::table('Tochuc/InsDept');
        $db = $table->getDbo();
        $exceptionUnits = Core::getUnManageDonvi($params['user_id'], 'com_hoso', 'treeview', 'treeview');
        $exception_condition = ($exceptionUnits) ? 'id NOT IN (' . $exceptionUnits . ')' : '';
        $query = $db->getQuery(true);
        $query->select(array('id', 'name AS value', 'ins_cap AS level', 'type'))
                ->from($table->getTableName());
        $query->where('type = 1 OR type = 3');
        if ($exception_condition != '') {
            $query->where($exception_condition);
        }
        if (isset($params['name']) && !empty($params['name'])) {
            if (strpos($params['name'], 'button-ajax') === false) {
                $query->where('name LIKE (' . $db->quote('%' . $params['name'] . '%') . ')');
            }
        }
        if ($order == null) {
            $query->order('lft');
        } else {
            $query->order($order);
        }
// 		echo $query->__toString();exit;
        if ($offset != null && $limit != null) {
            $db->setQuery($query, $offset, $limit);
        } else {
            $db->setQuery($query);
        }
        return $db->loadAssocList();
    }

    /**
     * Lấy mảng thông tin phòng ban
     * @param type $params
     * @param type $order
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function collect_Dept($params = null, $order = null, $offset = null, $limit = null) {
        $table = Core::table('Tochuc/InsDept');
        $db = $table->getDbo();
        $exceptionUnits = Core::getUnManageDonvi($params['user_id'], 'com_hoso', 'treeview', 'treeview');
        $exception_condition = ($exceptionUnits) ? 'id NOT IN (' . $exceptionUnits . ')' : '';
        $query = $db->getQuery(true);
        $query->select(array('id', 'name AS value'))
                ->from($table->getTableName());
        if (isset($params['inst_code']) && !empty($params['inst_code'])) {
            $query->where('parent_id = ' . $db->quote($params['inst_code']));
        }
        if ($exception_condition != '') {
            $query->where($exception_condition);
        }
        if (isset($params['name']) && !empty($params['name'])) {
            if (strpos($params['name'], 'button-ajax') === false) {
                $query->where('name LIKE (' . $db->quote('%' . $params['name'] . '%') . ')');
            }
        }
        if ($order == null) {
            $query->order('lft');
        } else {
            $query->order($order);
        }

        if ($offset != null && $limit != null) {
            $db->setQuery($query, $offset, $limit);
        } else {
            $db->setQuery($query);
        }
        return $db->loadAssocList();
    }

    /**
     * Hàm tìm kiếm tổ chức
     * @param type $formData
     * @param type $order
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function search($formData, $order = null, $offset = null, $limit = null) {
        foreach ($formData as $key => $value) {
            if (null == $value || '' == $value) {
                unset($formData[$key]);
            }
        }
//                var_dump($formData['arrConfig']);die;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select(array('distinct(a.id),a.*',
                    'chuquan.name AS coquanchuquan_name',
                    'loaihinh.name AS loaihinh_name',
                    'ins_status.name AS trangthaitochuc',
                    'ins_type.name AS kieutochuc',
                    'ins_cap.name AS captochuc',
                    'ins_cachthuc_thanhlap.name AS cachthucthanhlap',
                    'cb_goivitrivieclam.name AS vieclamtochuc',
                    'bc_goibienche.name AS bienchetochuc',
                    'cb_goichucvu.name AS chucvutochuc',
                    'cb_goiluong.name AS luongtochuc',
                    'cb_goihinhthuchuongluong.name AS huongluongtochuc',
                    'cb_goidaotaoboiduong.name AS daotaotochuc',
                ))
                ->from('ins_dept a')
                ->join('LEFT', 'ins_dept chuquan ON chuquan.id = a.ins_created')
                ->join('LEFT', 'ins_dept_loaihinh loaihinh ON loaihinh.id = a.ins_loaihinh')
                ->join('LEFT', 'ins_status ins_status ON ins_status.id = a.active')
                ->join('LEFT', 'ins_type ins_type ON ins_type.id = a.type')
                ->join('LEFT', 'ins_cachthuc_thanhlap ins_cachthuc_thanhlap ON ins_cachthuc_thanhlap.id = a.type_created')
                ->join('LEFT', 'ins_cap ins_cap ON ins_cap.id = a.ins_cap')
                ->join('LEFT', 'cb_goivitrivieclam cb_goivitrivieclam ON cb_goivitrivieclam.id = a.goivitrivieclam')
                ->join('LEFT', 'bc_goibienche bc_goibienche ON bc_goibienche.id = a.goibienche')
                ->join('LEFT', 'cb_goichucvu cb_goichucvu ON cb_goichucvu.id = a.goichucvu')
                ->join('LEFT', 'cb_goiluong cb_goiluong ON cb_goiluong.id = a.goiluong')
                ->join('LEFT', 'cb_goihinhthuchuongluong cb_goihinhthuchuongluong ON cb_goihinhthuchuongluong.id = a.goihinhthuchuongluong')
                ->join('LEFT', 'cb_goidaotaoboiduong cb_goidaotaoboiduong ON cb_goidaotaoboiduong.id = a.goidaotao')
        ;
        //var_dump(isset($formData['name']));
        // thong tin chung
        if (isset($formData['status'])) {
            $query->where('a.active IN (' . implode(',', $formData['status']) . ')');
        }
        if (isset($formData['ins_loaihinh'])) {
            $query->where('a.ins_loaihinh = ' . $db->quote($formData['ins_loaihinh']));
        }
        if (isset($formData['name'])) {
            $query->where('a.name LIKE ' . $db->quote('%' . $formData['name'] . '%'));
            // $query->where('a.name LIKE BINARY('.$db->quote('%'.$formData['name'].'%').')');
        }
        if (isset($formData['s_name'])) {
            $query->where('a.s_name LIKE (' . $db->quote('%' . $formData['s_name'] . '%') . ')');
        }
        if (isset($formData['masothue'])) {
            $query->where('a.masothue LIKE ' . $db->quote('%' . $formData['masothue'] . '%'));
        }
        if (isset($formData['masotabmis'])) {
            $query->where('a.masotabmis LIKE ' . $db->quote('%' . $formData['masotabmis'] . '%'));
        }
        if (isset($formData['eng_name'])) {
            $query->where('a.eng_name LIKE ' . $db->quote('%' . $formData['eng_name'] . '%'));
        }
        if (isset($formData['code'])) {
            $query->where('a.code LIKE ' . $db->quote('%' . $formData['code'] . '%'));
        }
        if (isset($formData['diachi'])) {
            $query->where('a.diachi LIKE ' . $db->quote('%' . $formData['diachi'] . '%'));
        }
        if (isset($formData['dienthoai'])) {
            $query->where('a.dienthoai LIKE ' . $db->quote('%' . $formData['dienthoai'] . '%'));
        }
        if (isset($formData['email'])) {
            $query->where('a.email LIKE ' . $db->quote('%' . $formData['email'] . '%'));
        }
        if (isset($formData['fax'])) {
            $query->where('a.fax like ' . $db->quote('%' . $formData['fax'] . '%'));
        }
        if (isset($formData['phucapdacthu'])) {
            $query->where('a.phucapdacthu like ' . $db->quote('%' . $formData['phucapdacthu'] . '%'));
        }
        if (isset($formData['type_created'])) {
            $query->where('a.type_created = ' . $db->quote($formData['type_created']));
        }
        if (isset($formData['ins_created'])) {
            $query->where('a.ins_created = ' . $db->quote($formData['ins_created']));
        }
        // Phúc thêm
        // Thông tin thêm
        if (isset($formData['ins_linhvuc'])) {
            $ins_linhvuc = implode(',', $formData['ins_linhvuc']);
            $str = " ins_dept_linhvuc lv ON a.id = lv.ins_dept_id";
            $query->join('left', $str);
            $query->where("lv.linhvuc_id IN ($db->quote($ins_linhvuc))");
        }
        if (isset($formData['goibienche'])) {
            $query->where('a.goibienche = ' . $db->quote($formData['goibienche']));
        }
        if (isset($formData['goichucvu'])) {
            $query->where('a.goichucvu = ' . $db->quote($formData['goichucvu']));
        }
        if (isset($formData['goiluong'])) {
            $query->where('a.goiluong = ' . $db->quote($formData['goiluong']));
        }
        if (isset($formData['goidaotao'])) {
            $query->where('a.goidaotao = ' . $db->quote($formData['goidaotao']));
        }
        if (isset($formData['goihinhthuchuongluong'])) {
            $query->where('a.goihinhthuchuongluong = ' . $db->quote($formData['goihinhthuchuongluong']));
        }
        // Lịch sử
        if (isset($formData['cachthuc_id']) || isset($formData['name_history']) || isset($formData['quyetdinh_ngay_start']) || isset($formData['quyetdinh_ngay_end']) || isset($formData['hieuluc_ngay_start']) || isset($formData['hieuluc_ngay_end']) || isset($formData['quyetdinh_so'])) {
            $str = "ins_dept_quatrinh insqt ON insqt.dept_id = a.id";
            $query->join("INNER", $str);
        }
        if (isset($formData['cachthuc_id'])) {
            $query->where('insqt.cachthuc_id = ' . $db->quote($formData['cachthuc_id']));
        }
        if (isset($formData['name_history'])) {
            $query->where('insqt.name = ' . $db->quote($formData['name_history']));
        }
        if (isset($formData['quyetdinh_so'])) {
            $query->where('insqt.quyetdinh_so = ' . $db->quote($formData['quyetdinh_so']));
        }
        if (isset($formData['quyetdinh_ngay_start'])) {
            $query->where('str_to_date(insqt.quyetdinh_ngay,"%d/%m/%Y") ' . $this->getComparition($formData['quyetdinh_ngay_start_condition']) . '  str_to_date(' . $db->quote($formData['quyetdinh_ngay_start']) . ',"%d/%m/%Y")');
        }
        if (isset($formData['quyetdinh_ngay_end'])) {
            $query->where('str_to_date(insqt.quyetdinh_ngay,"%d/%m/%Y") ' . $this->getComparition($formData['quyetdinh_ngay_end_condition']) . '  str_to_date(' . $db->quote($formData['quyetdinh_ngay_end']) . ',"%d/%m/%Y")');
        }
        if (isset($formData['hieuluc_ngay_start'])) {
            $query->where('insqt.hieuluc_ngay ' . $this->getComparition($formData['hieuluc_ngay_start_condition']) . ' str_to_date(' . $db->quote($formData['hieuluc_ngay_start']) . ',"%d/%m/%Y")');
        }
        if (isset($formData['hieuluc_ngay_end'])) {
            $query->where('insqt.hieuluc_ngay ' . $this->getComparition($formData['hieuluc_ngay_end_condition']) . ' str_to_date(' . $db->quote($formData['hieuluc_ngay_end']) . ',"%d/%m/%Y")');
        }
        // end Phúc thêm
        // sửa lại
        if (isset($formData['ins_cap'])) {
            $ins_cap = explode(',',$formData['ins_cap']);
            for($jj=0; $jj<count($ins_cap); $jj++){
                if((int)$ins_cap[$jj]>0)
                $tmp_ins_cap[] = $ins_cap[$jj];
            }
            $w_ins_cap = implode(',', $tmp_ins_cap);
            $sql = '(SELECT node.id, node.name
				FROM ins_cap AS node,
				ins_cap AS parent
				WHERE node.lft BETWEEN parent.lft AND parent.rgt
				AND node.id IN (' . $db->quote($w_ins_cap) . ')
				GROUP BY node.id
				ORDER BY node.lft) cap ON cap.id = a.ins_cap';
            $query->join('INNER', $sql);
// 			$query->where('a.ins_cap = '.$db->quote($formData['ins_cap']));
// 			$query->join('INNER', 'ins_cap cap ON cap.id = a.ins_cap');
            $query->select('cap.name AS capdonvi_name');
        } else {
            $query->join('LEFT', 'ins_cap cap ON cap.id = a.ins_cap');
            $query->select('cap.name AS capdonvi_name');
        }
        if (isset($formData['type'])) {
            $query->where('a.type = ' . $db->quote($formData['type']));
        }
        if (isset($formData['parent_id']) && $formData['parent_id']>0) {
            $donvi_id = $formData['parent_id'];
            $sql = " a.id IN (SELECT distinct(node.id) FROM ins_dept AS node, ins_dept AS parent
					  WHERE node.lft BETWEEN parent.lft AND parent.rgt AND  parent.id = ".$db->quote($donvi_id)."
					  )";
            $query->where($sql);
        }
        $query->order($db->quoteName($formData['ord']) . ' asc');
        $db->setQuery($query);
		// echo $query->__toString();die;
        if ($offset !== null && $limit !== null) {
            $db->setQuery($query, $offset, $limit);
        } else {
            $db->setQuery($query);
        }
        return $db->loadAssocList();
    }

    /**
     * Lấy thông tin 1 bảng theo các điều kiện
     * @param array $field
     * @param string $table
     * @param array $arrJoin
     * @param array $where
     * @param string $order
     */
    function getThongtin($field, $table, $arrJoin = null, $where = null, $order = null) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($field)
                ->from($table);
        if (count($arrJoin) > 0)
            foreach ($arrJoin as $key => $val) {
                $query->join($key, $val);
            }
        for ($i = 0; $i < count($where); $i++)
            if ($where[$i] != '')
                $query->where($where);
        if ($order != null)
            $query->order($order);
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    /**
     * combobox với một danh mục đơn giản
     * @param string $select
     * @param string $id
     * @return string
     */
    public function getCbo($table, $field, $where = null, $order, $text, $code, $name, $selected = null, $idname = null, $class = null, $attrArray = null) {
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
        array_push($data, array('value', 'text' => $text));
        for ($i = 0; $i < count($tmp); $i++) {
            $attr = array();
            if (isset($attrArray) && is_array($attrArray))
                foreach ($attrArray as $k => $v) {
                    $attr += array($k => $tmp[$i]->$v);
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

    /**
     * Hàm chuyển đổi dấu so sánh
     * @param type $in
     * @return string
     */
    public function getComparition($in) {
        if ($in == 'EQ')
            $out = '=';
        elseif ($in == 'GE')
            $out = '>=';
        elseif ($in == 'GT')
            $out = '>';
        elseif ($in == 'LE')
            $out = '<=';
        elseif ($in == 'LT')
            $out = '<';
        return $out;
    }

    /**
     * Tạo các field thiết lập các trường hiển thị
     * @return string
     */
    function initConfig() {
        $arr = array(
            'name' => 'Tên',
            's_name' => 'Tên viết tắt',
            'trangthaitochuc' => 'Trạng thái',
            'kieutochuc' => 'Loại hình',
            'code' => 'Mã số tổ chức',
            'loaihinh_name' => 'Loại hình',
            'captochuc' => 'Cấp đơn vị',
            'date_created' => 'Ngày thành lập',
            'cachthucthanhlap' => 'Cách thức thành lập',
            'coquanchuquan_name' => 'Cơ quan chủ quản',
            'ghichu' => 'Ghi chú',
            'dienthoai' => 'Điện thoại',
            'masothue' => 'Mã số thuế',
            'masotabmis' => 'Mã số Tabmis',
            'fax' => 'Fax',
            'phucapdacthu' => 'Phụ cấp đặc thù',
            'bienchetochuc' => 'Gói biên chế',
            'chucvutochuc' => 'Gói chức vụ',
            'huongluongtochuc' => 'Gói hình thức hưởng lương',
            'luongtochuc' => 'Gói lương',
            'daotaotochuc' => 'Gói đào tạo',
            'vieclamtochuc' => 'Gói vị trí việc làm',
                   'id'=>'Id'
        );
        return $arr;
    }

}
