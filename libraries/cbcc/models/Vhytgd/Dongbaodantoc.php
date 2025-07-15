<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Vhytgd_Model_Dongbaodantoc extends JModelLegacy
{

    public function getTitle()
    {
        return "Tie";
    }
    public function getThonTobyPhuongxaId($phuongxa_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id, tenkhuvuc');
        $query->from('danhmuc_khuvuc');
        $query->where('daxoa = 0 AND cha_id = ' . $db->quote($phuongxa_id));
        $query->order('tenkhuvuc ASC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getPhanquyen()
    {
        $user_id = Factory::getUser()->id;
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('quanhuyen_id,phuongxa_id');
        $query->from('phanquyen_user2khuvuc AS a');
        $query->where('a.user_id = ' . $db->quote($user_id));
        $db->setQuery($query);
        $result = $db->loadAssoc();

        if ($result['phuongxa_id'] == '') {
            echo '<div class="alert alert-error"><strong>Bạn không được phân quyền sử dụng chức năng này. Vui lòng liên hệ quản trị viên!!!</strong></div>';
            exit;
        } else {
            return $result;
        }
    }
    public function checkNhankhauInDanhSachQuanSu($nhankhau_id, $table)
    {
        // Get database object
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('COUNT(*)')
            ->from($db->quoteName('vhxhytgd_dongbao'))
            ->where($db->quoteName('nhankhau_id') . ' = ' . (int)$nhankhau_id)
            ->where('daxoa = 0');

        // Execute query
        $db->setQuery($query);
        // echo $query;
        // exit;

        try {
            $count = $db->loadResult();
            return $count > 0;
        } catch (Exception $e) {
            throw new Exception('Lỗi truy vấn cơ sở dữ liệu: ' . $e->getMessage());
        }
    }
    public function getDanhSachNhanKhau($phuongxa = [], $keyword = '', $limit = 10, $offset = 0, $nhankhau_id = 0)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select([
                'nk.id',
                'nk.hoten',
                'nk.cccd_so',
                'DATE_FORMAT(nk.ngaysinh, "%d/%m/%Y") AS ngaysinh',
                'nk.dienthoai',
                'hk.diachi',
                'nk.gioitinh_id',
                'nk.dantoc_id',
                'nk.tongiao_id',
                'hk.phuongxa_id',
                'hk.thonto_id',
                'hk.diachi',
            ])
            ->from($db->quoteName('vptk_hokhau2nhankhau', 'nk'))
            ->leftJoin($db->quoteName('vptk_hokhau', 'hk') . ' ON nk.hokhau_id = hk.id')
            ->where('nk.daxoa = 0')
            ->where('hk.daxoa = 0 and nk.dantoc_id != 1');

        if ($nhankhau_id > 0) {
            $query->where('nk.id = ' . (int)$nhankhau_id);
        } else {
            if (!empty($keyword)) {
                $search = $db->quote('%' . $db->escape($keyword, true) . '%');
                $query->where("nk.hoten LIKE $search OR nk.cccd_so LIKE $search");
            }
            if (!empty($phuongxa) && is_array($phuongxa)) {
                $phuongxa = array_map('intval', $phuongxa);
                // Chỉ lấy những bản ghi có phường xã nằm trong danh sách, loại bỏ các bản ghi phường xã null hoặc không thuộc danh sách
                $query->where('hk.phuongxa_id IS NOT NULL AND hk.phuongxa_id IN (' . implode(',', $phuongxa) . ')');
            }
        }
        $query->order('nk.hokhau_id DESC');

        // Clone query để đếm tổng số
        $countQuery = clone $query;
        $countQuery->clear('select')->select('COUNT(*)');

        $db->setQuery($countQuery);
        $total = (int) $db->loadResult();
        // echo $query;
        // Lấy dữ liệu trang hiện tại
        $query->setLimit($limit, $offset);
        $db->setQuery($query);
        $items = $db->loadObjectList();

        return [
            'items' => $items,
            'has_more' => ($offset + count($items)) < $total
        ];
    }


    public function saveDongbaodantoc($formData)
    {
        $db = Factory::getDbo();
        $user_id = Factory::getUser()->id;
        // var_dump($formData['nhankhau_id']);
        // exit;
        // Danh sách các trường cần chuyển thành mảng
        $fields_to_array = [
            'chinhsach_id',
            'loaihotro_id',
            'trangthai_id',
        ];

        // Chuyển các trường thành mảng nếu cần
        foreach ($fields_to_array as $field) {
            if (isset($formData[$field]) && !is_array($formData[$field])) {
                $formData[$field] = [$formData[$field]];
            } elseif (!isset($formData[$field])) {
                $formData[$field] = [];
            }
        }
        // Kiểm tra số lượng bản ghi
        $n = count($formData['chinhsach_id']);

        $maxRecords = 100; // Giới hạn tối đa 100 bản ghi
        if ($n === 0) {
            error_log('No valid records to process.');
            return false;
        }
        if ($n > $maxRecords) {
            error_log("Too many records to process. Maximum allowed is $maxRecords, received $n.");
            return false;
        }
        $ngaysinh = !empty($formData['input_namsinh'])
            ? DateTime::createFromFormat('d/m/Y', $formData['input_namsinh'])
            : (!empty($formData['select_namsinh']) ? DateTime::createFromFormat('d/m/Y', $formData['select_namsinh']) : false);
        // Lưu vào bảng vhxhytgd_doituonghbtxh
        $data = array(
            'id' => $formData['id_doituonghuongcs'] ?? 0,
            'nhankhau_id' => !empty($formData['nhankhau_id']) ? $formData['nhankhau_id'] : 0, // Gán 0 nếu không có dữ liệu
            'phuongxa_id' => !empty($formData['input_phuongxa_id']) ? $formData['input_phuongxa_id'] : $formData['select_phuongxa_id'] ?? null,
            'thonto_id' => !empty($formData['input_thonto_id']) ? $formData['input_thonto_id'] : $formData['select_thonto_id'] ?? null,
            'sotaikhoan' => $formData['sotaikhoan'] ?? null,
            'nganhang_id' => $formData['nganhang_id'] ?? null,
            'n_hoten' => $formData['hoten'] ?? null,
            'n_gioitinh_id' => !empty($formData['input_gioitinh_id']) ? $formData['input_gioitinh_id'] : $formData['select_gioitinh_id'] ?? null,
            'n_dantoc_id' => !empty($formData['input_dantoc_id']) ? $formData['input_dantoc_id'] : $formData['select_dantoc_id'] ?? null,
            'n_cccd' => $formData['cccd'] ?? null,
            'n_phuongxa_id' => !empty($formData['input_phuongxa_id']) ? $formData['input_phuongxa_id'] : $formData['select_phuongxa_id'] ?? null,
            'n_thonto_id' => !empty($formData['input_thonto_id']) ? $formData['input_thonto_id'] : $formData['select_thonto_id'] ?? null,
            'n_namsinh' => $ngaysinh ? $ngaysinh->format('Y-m-d') : null,
            'n_dienthoai' => $formData['dienthoai'] ?? null,
            'n_dantoc_id' => $formData['n_dantoc_id'] ?? null,
            'n_diachi' => $formData['diachi'] ?? null,
            'is_ngoai' => null,
            'tennguoinhan' => $formData['nguoinhangiup'] ?? null,
            'is_ngoai' => $formData['id_doituonghuongcs'] ?? 0,

            'daxoa' => '0',
        );

        $data['is_ngoai'] = empty($data['nhankhau_id']) ? 1 : 0;

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // Nếu giá trị là mảng, chuyển đổi thành chuỗi
                $data[$key] = implode(', ', $value);
            } elseif ($value === null) {
                // Nếu giá trị là null, chuyển đổi thành chuỗi rỗng
                $data[$key] = '';
            } else {
                // Chuyển đổi các giá trị khác thành chuỗi
                $data[$key] = (string)$value;
            }
        }
        // var_dump($data);
        // exit;

        if ((int) $data['id'] == 0) {
            $data['nguoitao_id'] = $user_id;
            $data['ngaytao'] = 'NOW()';
        } else {
            $data['nguoihieuchinh_id'] = $user_id;
            $data['ngayhieuchinh'] = 'NOW()';
        }

        $data_insert_key = [];
        $data_insert_val = [];
        $data_update = [];

        foreach ($data as $key => $value) {
            if ($value === '' || $value === null) {
                $data_update[] = $key . " = NULL";
                unset($data[$key]);
            } else {
                $data_insert_key[] = $key;
                if ($value === 'NOW()') {
                    $data_insert_val[] = $value;
                    $data_update[] = $key . " = " . $value;
                } else {
                    $data_insert_val[] = $db->quote($value);
                    $data_update[] = $key . " = " . $db->quote($value);
                }
            }
        }

        $query = $db->getQuery(true);
        if ((int) $data['id'] == 0) {
            $query->insert($db->quoteName('vhxhytgd_dongbao'))
                ->columns($data_insert_key)
                ->values(implode(',', $data_insert_val));
            // echo $query;
            // exit;
        } else {
            $query->update($db->quoteName('vhxhytgd_dongbao'))
                ->set(implode(',', $data_update))
                ->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }

        $db->setQuery($query);
        $db->execute();

        if ((int) $data['id'] == 0) {
            $dongbao_id = $db->insertid();
        } else {
            $dongbao_id = $data['id'];
        }
        // var_dump($dongbao_id);exit;
        for ($dt = 0; $dt < $n; $dt++) {
            if (empty($formData['chinhsach_id'][$dt])) {
                continue;
            }

            $ngayhotro = !empty($formData['ngayhotro'][$dt]) ? DateTime::createFromFormat('d/m/Y', $formData['ngayhotro'][$dt]) : false;
            // var_dump($formData['dongbao_id']);exit;
            $data_chuyennganh[$dt] = array(
                'id' => $formData['dongbao_id'][$dt] ?? 0,
                'dongbao_id' => $dongbao_id,
                'chinhsach_id' => $formData['chinhsach_id'][$dt] ?? null,
                'noidung' => $formData['noidung'][$dt] ?? null,
                'ghichu' => $formData['ghichu'][$dt] ?? null,
                'loaihotro_id' => $formData['loaihotro_id'][$dt] ?? null,
                'trangthai_id' => $formData['trangthai_id'][$dt] ?? null,
                'ngayhotro' => $ngayhotro ? $ngayhotro->format('Y-m-d') : null,
                'daxoa' => '0',
            );


            $data_chuyennganh_insert_key[$dt] = [];
            $data_chuyennganh_insert_val[$dt] = [];
            $data_chuyennganh_update[$dt] = [];

            foreach ($data_chuyennganh[$dt] as $key => $value) {
                if ($value === '' || $value === null) {
                    $data_chuyennganh_update[$dt][] = $key . " = NULL";
                    unset($data_chuyennganh[$dt][$key]);
                } else {
                    $data_chuyennganh_insert_key[$dt][] = $key;
                    if ($value === 'NOW()') {
                        $data_chuyennganh_insert_val[$dt][] = $value;
                        $data_chuyennganh_update[$dt][] = $key . " = " . $value;
                    } else {
                        $data_chuyennganh_insert_val[$dt][] = $db->quote($value);
                        $data_chuyennganh_update[$dt][] = $key . " = " . $db->quote($value);
                    }
                }
            }
            $querys = $db->getQuery(true);
            if ((int) $data_chuyennganh[$dt]['id'] == 0) {
                $querys->insert($db->quoteName('vhxhytgd_dongbao2chinhsach'))
                    ->columns($data_chuyennganh_insert_key[$dt])
                    ->values(implode(',', $data_chuyennganh_insert_val[$dt]));
            } else {
                $querys->update($db->quoteName('vhxhytgd_dongbao2chinhsach'))
                    ->set(implode(',', $data_chuyennganh_update[$dt]))
                    ->where(array($db->quoteName('id') . '=' . $db->quote($data_chuyennganh[$dt]['id'])));
                // echo $querys;exit;
            }
            $db->setQuery($querys);
            $db->execute();
        }

        return true;
    }

    public function getDanhSachDongbaodantoc($params = array(), $startFrom = 0, $perPage = 20)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        // Subquery để lấy bản ghi mới nhất từ bảng vhxhytgd_dongbao2chinhsach
        $subQueryLatest = $db->getQuery(true);
        $subQueryLatest->select('b1.dongbao_id, b1.trangthai_id, ld.ten')
            ->from('vhxhytgd_dongbao2chinhsach b1')
            ->join(
                'INNER',
                '(SELECT dongbao_id, MAX(id) AS max_id 
              FROM vhxhytgd_dongbao2chinhsach 
              WHERE daxoa = 0 
              GROUP BY dongbao_id) latest ON b1.id = latest.max_id'
            )
            ->join('LEFT', 'dmlydo ld ON ld.id = b1.trangthai_id');

        $query->select([
            'a.id',
            'DATE_FORMAT(a.n_namsinh, "%d/%m/%Y") AS ngaysinh',
            'CONCAT(COALESCE(tt.tenkhuvuc, ""), IF(tt.tenkhuvuc IS NOT NULL, ", ", ""), px.tenkhuvuc) AS phuongxathonto',
            'latest_status.ten AS tentrangthai',
            'gt.tengioitinh',
            'tt.tenkhuvuc',
            'ld2.ten AS tentrangthaicathuong',
            'COUNT(b.chinhsach_id) AS total_chinhsach',
            'a.n_hoten',
            'a.n_cccd',
            'b.trangthai_id',
            'CASE 
            WHEN a.trangthaich_id IS NULL OR a.trangthaich_id = 0 THEN latest_status.ten 
            ELSE NULL 
        END AS trangthaiten'
        ]);

        $query->from('vhxhytgd_dongbao AS a')
            ->join('LEFT', '(' . $subQueryLatest . ') AS latest_status ON a.id = latest_status.dongbao_id')
            ->join('LEFT', 'vhxhytgd_dongbao2chinhsach AS b ON a.id = b.dongbao_id AND b.daxoa = 0')
            ->join('LEFT', 'danhmuc_khuvuc AS px ON px.id = a.phuongxa_id')
            ->join('LEFT', 'danhmuc_khuvuc AS tt ON tt.id = a.thonto_id')
            ->join('LEFT', 'danhmuc_gioitinh AS gt ON gt.id = a.n_gioitinh_id')
            ->join('LEFT', 'dmlydo AS ld2 ON ld2.id = a.trangthaich_id');

        $query->where('a.daxoa = 0 and b.daxoa = 0');

        // Thêm điều kiện lọc
        if (!empty($params['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }
        if (!empty($params['thonto_id'])) {
            $query->where('a.thonto_id = ' . $db->quote($params['thonto_id']));
        }

        $phanquyen = $this->getPhanquyen();
        if (empty($params['phuongxa_id']) && $phanquyen['phuongxa_id'] != '-1') {
            $query->where('a.phuongxa_id IN (' . str_replace("'", '', $db->quote($phanquyen['phuongxa_id'])) . ')');
        }
        if (!empty($params['hoten'])) {
            $query->where('a.n_hoten LIKE ' . $db->quote('%' . $params['hoten'] . '%'));
        }

        if (!empty($params['cccd'])) {
            $query->where('a.n_cccd = ' . $db->quote($params['cccd']));
        }


        $query->group('a.id');
        // echo $query;
        // Phân trang
        $perPage = (int)$perPage;
        $startFrom = (int)$startFrom;
        if ($perPage > 0) {
            $query->setLimit($perPage, $startFrom);
        }

        // Ghi log truy vấn để debug
        error_log('Query getDanhSachDoiTuongCS: ' . (string)$query);

        $db->setQuery($query);
        return $db->loadAssocList();
    }


    public function CountDBDT($params = array())
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();
        $query->select('COUNT(DISTINCT a.id)');

        $query->from('vhxhytgd_dongbao AS a');
        $query->leftJoin('vhxhytgd_dongbao2chinhsach AS b ON a.id = b.dongbao_id');
        $query->leftJoin('danhmuc_khuvuc AS px ON px.id = a.phuongxa_id');
        $query->leftJoin('danhmuc_khuvuc AS tt ON tt.id = a.thonto_id');
        $query->leftJoin('danhmuc_gioitinh AS gt ON gt.id = a.n_gioitinh_id');

        $query->where('a.daxoa = 0 AND b.daxoa = 0');

        if (!empty($params['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }
        if (!empty($params['thonto_id'])) {
            $query->where('a.thonto_id = ' . $db->quote($params['thonto_id']));
        }

        $phanquyen = $this->getPhanquyen();
        if (empty($params['phuongxa_id']) && $phanquyen['phuongxa_id'] != '-1') {
            $query->where('a.phuongxa_id IN (' . str_replace("'", '', $db->quote($phanquyen['phuongxa_id'])) . ')');
        }
        if (!empty($params['hoten'])) {
            $query->where('a.n_hoten LIKE ' . $db->quote('%' . $params['hoten'] . '%'));
        }

        if (!empty($params['cccd'])) {
            $query->where('a.n_cccd = ' . $db->quote($params['cccd']));
        }

        $db->setQuery($query);

        // echo $query;
        $result = $db->loadResult(); // Sử dụng loadResult thay vì loadAssocList cho COUNT
        return (int)$result; // Trả về số nguyên
    }

    public function getEditDBDT($dbdt_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.id as doituonghuong, a.*, b.id as id_trocap,
        DATE_FORMAT(a.n_namsinh, "%d/%m/%Y") AS ngaysinh, 
        DATE_FORMAT(b.ngayhotro, "%d/%m/%Y") AS ngayhotro2, 
        CONCAT(COALESCE(tt.tenkhuvuc, ""), IF(tt.tenkhuvuc IS NOT NULL, ", ", ""), px.tenkhuvuc) AS phuongxathonto, 
        gt.tengioitinh, 
        ld.ten as tentrangthai,
        tt.tenkhuvuc, 
        cs.tenchinhsach as csdongbao,
        ht.tenchinhsach as loaihotro,
        a.n_hoten, 
        a.n_cccd, 
        b.*');

        $query->from('vhxhytgd_dongbao AS a');
        $query->leftJoin('vhxhytgd_dongbao2chinhsach AS b ON a.id = b.dongbao_id');
        $query->leftJoin('danhmuc_khuvuc AS px ON px.id = a.phuongxa_id');
        $query->leftJoin('danhmuc_khuvuc AS tt ON tt.id = a.thonto_id');
        $query->leftJoin('danhmuc_chinhsachdongbao AS cs ON cs.id = b.chinhsach_id');
        $query->leftJoin('danhmuc_gioitinh AS gt ON gt.id = a.n_gioitinh_id');
        $query->leftJoin('danhmuc_loaihotro AS ht ON ht.id = b.loaihotro_id');
        $query->leftJoin('dmlydo AS ld ON ld.id = b.trangthai_id');
        $query->where('a.daxoa = 0 AND b.daxoa = 0');
        $query->where('a.id = ' . $db->quote($dbdt_id));

        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function delThongtinhuongcs($trocap_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vhxhytgd_dongbao2chinhsach');
        $query->set('daxoa = 1');
        $query->where('id =' . $db->quote($trocap_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function removeDongbaodantoc($chinhsach_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vhxhytgd_dongbao');
        $query->set('daxoa = 1');
        $query->where('id =' . $db->quote($chinhsach_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function getDetailDBDT($doituong_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id as doituonghuong, a.*, b.id as id_trocap,
        DATE_FORMAT(a.n_namsinh, "%d/%m/%Y") AS ngaysinh, 
        DATE_FORMAT(b.ngayhotro, "%d/%m/%Y") AS ngayhotro2, 
        CONCAT(COALESCE(tt.tenkhuvuc, ""), IF(tt.tenkhuvuc IS NOT NULL, ", ", ""), px.tenkhuvuc) AS phuongxathonto, 
        gt.tengioitinh, 
        ld.ten as tentrangthai,
        tt.tenkhuvuc, 
        cs.tenchinhsach as csdongbao,
        ht.tenchinhsach as loaihotro,
        a.n_hoten, 
        a.n_cccd, 
        b.*');

        $query->from('vhxhytgd_dongbao AS a');
        $query->leftJoin('vhxhytgd_dongbao2chinhsach AS b ON a.id = b.dongbao_id');
        $query->leftJoin('danhmuc_khuvuc AS px ON px.id = a.phuongxa_id');
        $query->leftJoin('danhmuc_khuvuc AS tt ON tt.id = a.thonto_id');
        $query->leftJoin('danhmuc_chinhsachdongbao AS cs ON cs.id = b.chinhsach_id');
        $query->leftJoin('danhmuc_gioitinh AS gt ON gt.id = a.n_gioitinh_id');
        $query->leftJoin('danhmuc_loaihotro AS ht ON ht.id = b.loaihotro_id');
        $query->leftJoin('dmlydo AS ld ON ld.id = b.trangthai_id');
        $query->where('a.daxoa = 0 AND b.daxoa = 0');
        $query->where('a.id = ' . $db->quote($doituong_id));

        // echo $query;exit;

        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDetailCatCS($doituong_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.trangthaich_id, a.lydo,     DATE_FORMAT(a.ngaycat, "%d/%m/%Y") AS ngaycat');

        $query->from('vhxhytgd_doituonghbtxh AS a');

        $query->where('a.daxoa = 0 ');
        $query->where('a.id = ' . $db->quote($doituong_id));

        // echo $query;exit;

        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function saveCatHuongCS($formData)
    {
        $db = Factory::getDbo();
        $ngaycat = !empty($formData['ngaycat']) ? DateTime::createFromFormat('d/m/Y', $formData['ngaycat']) : false;

        $query = $db->getQuery(true)
            ->update($db->quoteName('vhxhytgd_doituonghbtxh'))
            ->set($db->quoteName('trangthaich_id') . ' = ' . $db->quote($formData['trangthaich_id']))
            ->set($db->quoteName('ngaycat') . ' = ' . $db->quote($ngaycat ? $ngaycat->format('Y-m-d') : null))
            ->set($db->quoteName('lydo') . ' = ' . $db->quote($formData['lydo']))
            ->where($db->quoteName('id') . ' = ' . $db->quote($formData['trocap_id']));
        // echo $query;
        // exit;
        $db->setQuery($query);
        $db->execute();



        return true;
    }
    public function getThongKeDongbaodantoc($params = array())
    {
        $db = Factory::getDbo();

        // Subquery
        $query_left = $db->getQuery(true);
        $query_left->select(['a.nhankhau_id as dongbao, a.phuongxa_id,d.tenkhuvuc AS tenphuongxa,a.thonto_id,c.tenkhuvuc AS tenthonto']);
        $query_left->from('vhxhytgd_dongbao AS a');
        $query_left->innerJoin('vhxhytgd_dongbao2chinhsach AS cs ON a.id = cs.dongbao_id');
        $query_left->innerJoin('danhmuc_khuvuc AS c ON a.thonto_id = c.id');
        $query_left->innerJoin('danhmuc_khuvuc AS d ON a.phuongxa_id = d.id');
        $query_left->where('a.daxoa = 0 AND cs.daxoa = 0');

        // Điều kiện WHERE cho subquery
        if (!empty($params['phuongxa_id'])) {
            $query_left->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }

        if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
            $query_left->where($db->quoteName('a.thonto_id') . ' IN (' . implode(',', array_map([$db, 'quote'], $params['thonto_id'])) . ')');
        }
        if (!empty($params['chinhsach_id'] )) {
            $query_left->where('cs.chinhsach_id = ' . $db->quote($params['chinhsach_id']));
        }

        // $query_left->group(['a.phuongxa_id', 'a.thonto_id']);

        // Query chính
        $query = $db->getQuery(true);
        $query->select(['a.id,a.cha_id,a.tenkhuvuc,a.level, COUNT(ab.dongbao) as tongsodongbao'])
            ->from('danhmuc_khuvuc AS a')
            ->leftJoin('(' . $query_left . ') AS ab ON (a.id = ab.thonto_id OR a.id = ab.phuongxa_id)');

        // Điều kiện cho query chính
        if (!empty($params['phuongxa_id'])) {
            $query->where($db->quoteName('a.id') . ' = ' . $db->quote($params['phuongxa_id']) . ' OR ' . $db->quoteName('a.cha_id') . ' = ' . $db->quote($params['phuongxa_id']));
        }
        if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
            $query->where($db->quoteName('a.id') . ' IN (' . implode(',', array_map([$db, 'quote'], $params['thonto_id'])) . ')');
        }

        $query->group(['a.id', 'a.cha_id', 'a.tenkhuvuc', 'a.level']);
        $query->order('a.level, a.id ASC');
        // echo $query;
        $db->setQuery($query);
        $results = $db->loadAssocList();



        return $results;
    }
}
