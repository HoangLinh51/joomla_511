<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Vhytgd_Model_Doituonghuongcs extends JModelLegacy
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
            ->where('hk.daxoa = 0');

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

        // Lấy dữ liệu trang hiện tại
        $query->setLimit($limit, $offset);
        $db->setQuery($query);
        $items = $db->loadObjectList();

        return [
            'items' => $items,
            'has_more' => ($offset + count($items)) < $total
        ];
    }

    public function saveDoituongCS($formData)
    {
        $db = Factory::getDbo();
        $user_id = Factory::getUser()->id;
        // var_dump($formData);
        // exit;
        // Danh sách các trường cần chuyển thành mảng
        $fields_to_array = [
            'trocap_id',
            'nhankhau_id',
            'is_dat',
            'giadinhvanhoa_tieubieu',
            'lydokhongdat',
            'ghichu',
            'id_giadinhvanhoa',
            'hoten',
            'cccd_so',
            'dienthoai',
            'n_gioitinh_id',
            'diachi',
            'ngaysinh',
            'is_search',
            'ma_hotro',
            'bien_dong',
            'chinh_sach',
            'loai_doi_tuong',
            'he_so',
            'muc_tien_chuan',
            'thuc_nhan',
            'so_quyet_dinh',
            'ngay_quyet_dinh',
            'huong_tu_ngay',
            'trang_thai',
            'ghi_chu'
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
        $n = count($formData['ma_hotro']);

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
            'nhankhau_id' => !empty($formData['nhankhau_id'][0]) ? $formData['nhankhau_id'][0] : 0, // Gán 0 nếu không có dữ liệu
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
            'madoituong' => $formData['madoituong'] ?? null,
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
            $query->insert($db->quoteName('vhxhytgd_doituonghbtxh'))
                ->columns($data_insert_key)
                ->values(implode(',', $data_insert_val));
        } else {
            $query->update($db->quoteName('vhxhytgd_doituonghbtxh'))
                ->set(implode(',', $data_update))
                ->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }
        // echo $query;
        // exit;
        $db->setQuery($query);
        $db->execute();

        if ((int) $data['id'] == 0) {
            $doituongbtxh_id = $db->insertid();
        } else {
            $doituongbtxh_id = $data['id'];
        }
        // var_dump($doituongbtxh_id);exit;
        // Lưu vào bảng vhxhytgd_huongbtxh2doituong
        for ($dt = 0; $dt < $n; $dt++) {
            // Kiểm tra trường bắt buộc
            if (empty($formData['ma_hotro'][$dt]) && empty($formData['loai_doi_tuong'][$dt])) {
                error_log("Skipping record $dt: Both ma_hotro and loai_doi_tuong are empty.");
                continue;
            }

            // Format ngày
            $ngayky = !empty($formData['ngay_quyet_dinh'][$dt]) ? DateTime::createFromFormat('d/m/Y', $formData['ngay_quyet_dinh'][$dt]) : false;
            $huongtungay = !empty($formData['huong_tu_ngay'][$dt]) ? DateTime::createFromFormat('d/m/Y', $formData['huong_tu_ngay'][$dt]) : false;
            // var_dump($formData['id_giadinhvanhoa']);
            $data_chuyennganh[$dt] = array(
                'id' => $formData['trocap_id'][$dt] ?? 0,
                'doituongbtxh_id' => $doituongbtxh_id,
                'maht' => $formData['ma_hotro'][$dt] ?? null,
                'biendong_id' => $formData['bien_dong'][$dt] ?? null,
                'chinhsach_id' => $formData['chinh_sach'][$dt] ?? null,
                'loaidoituong_id' => $formData['loai_doi_tuong'][$dt] ?? null,
                'heso' => $formData['he_so'][$dt] ?? null,
                'sotien' => $formData['thuc_nhan'][$dt] ?? null,
                'soqdhuong' => $formData['so_quyet_dinh'][$dt] ?? null,
                'ngayky' => $ngayky ? $ngayky->format('Y-m-d') : null,
                'huongtungay' => $huongtungay ? $huongtungay->format('Y-m-d') : null,
                'trangthai_id' => $formData['trang_thai'][$dt] ?? null,
                'ghichu' => $formData['ghi_chu'][$dt] ?? null,
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
                $querys->insert($db->quoteName('vhxhytgd_huongbtxh2doituong'))
                    ->columns($data_chuyennganh_insert_key[$dt])
                    ->values(implode(',', $data_chuyennganh_insert_val[$dt]));
            } else {
                $querys->update($db->quoteName('vhxhytgd_huongbtxh2doituong'))
                    ->set(implode(',', $data_chuyennganh_update[$dt]))
                    ->where(array($db->quoteName('id') . '=' . $db->quote($data_chuyennganh[$dt]['id'])));
            }
            // echo $querys;
            $db->setQuery($querys);
            $db->execute();
        }
        // exit;

        return true;
    }

    public function getDanhSachDoiTuongCS($params = array(), $startFrom = 0, $perPage = 20)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        // Subquery để lấy bản ghi mới nhất từ bảng vhxhytgd_huongbtxh2doituong
        $subQueryLatest = $db->getQuery(true);
        $subQueryLatest->select('b1.doituongbtxh_id, b1.trangthai_id, ld.ten')
            ->from('vhxhytgd_huongbtxh2doituong b1')
            ->join(
                'INNER',
                '(SELECT doituongbtxh_id, MAX(id) AS max_id 
              FROM vhxhytgd_huongbtxh2doituong 
              WHERE daxoa = 0 
              GROUP BY doituongbtxh_id) latest ON b1.id = latest.max_id'
            )
            ->join('LEFT', 'dmlydo ld ON ld.id = b1.trangthai_id');

        $query->select([
            'a.id',
            'DATE_FORMAT(a.n_namsinh, "%d/%m/%Y") AS ngaysinh',
            'CONCAT(COALESCE(tt.tenkhuvuc, ""), IF(tt.tenkhuvuc IS NOT NULL, ", ", ""), px.tenkhuvuc) AS phuongxathonto',
            'latest_status.ten AS tentrangthai',
            'gt.tengioitinh',
            'GROUP_CONCAT(DISTINCT ldt.ten SEPARATOR ", ") AS tenloaidoituong',
            'tt.tenkhuvuc',
            'ld2.ten AS tentrangthaicathuong',
            'COUNT(b.loaidoituong_id) AS total_loaidoituong',
            'a.n_hoten',
            'a.n_cccd',
            'b.trangthai_id',
            'CASE 
            WHEN a.trangthaich_id IS NULL OR a.trangthaich_id = 0 THEN latest_status.ten 
            ELSE NULL 
        END AS trangthaiten'
        ]);

        $query->from('vhxhytgd_doituonghbtxh AS a')
            ->join('LEFT', '(' . $subQueryLatest . ') AS latest_status ON a.id = latest_status.doituongbtxh_id')
            ->join('LEFT', 'vhxhytgd_huongbtxh2doituong AS b ON a.id = b.doituongbtxh_id AND b.daxoa = 0')
            ->join('LEFT', 'danhmuc_khuvuc AS px ON px.id = a.phuongxa_id')
            ->join('LEFT', 'danhmuc_khuvuc AS tt ON tt.id = a.thonto_id')
            ->join('LEFT', 'dmloaidoituong AS ldt ON ldt.id = b.loaidoituong_id')
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


    public function CountDanhSachDoituongCS($params = array())
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();
        $query->select('COUNT(DISTINCT a.id)');

        $query->from('vhxhytgd_doituonghbtxh AS a');
        $query->leftJoin('vhxhytgd_huongbtxh2doituong AS b ON a.id = b.doituongbtxh_id');
        $query->leftJoin('danhmuc_khuvuc AS px ON px.id = a.phuongxa_id');
        $query->leftJoin('danhmuc_khuvuc AS tt ON tt.id = a.thonto_id');
        $query->leftJoin('dmloaidoituong AS ldt ON ldt.id = b.loaidoituong_id');
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
        if ($params['tendoituong'] != '') {
            $query->where('a.tendoituong LIKE ' . $db->quote('%' . $params['tendoituong'] . '%'));
        }
        if ($params['loaidoituong_id'] != '') {
            $query->where('b.loaidoituong_id = ' . $db->quote($params['loaidoituong_id']));
        }
        if ($params['cccd'] != '') {
            $query->where('a.n_cccd = ' . $db->quote($params['cccd']));
        }
        if ($params['madoituong'] != '') {
            $query->where('a.madoituong = ' . $db->quote($params['madoituong']));
        }
        $db->setQuery($query);

        // echo $query;
        $result = $db->loadResult(); // Sử dụng loadResult thay vì loadAssocList cho COUNT
        return (int)$result; // Trả về số nguyên
    }

    public function getEditDoiTuongCS($doituong_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.id as doituonghuong, a.*, b.id as id_trocap,
        DATE_FORMAT(a.n_namsinh, "%d/%m/%Y") AS ngaysinh, 
        DATE_FORMAT(b.ngayky, "%d/%m/%Y") AS ngayquyetdinh, 
        DATE_FORMAT(b.huongtungay, "%d/%m/%Y") AS tungay, 
        CONCAT(COALESCE(tt.tenkhuvuc, ""), IF(tt.tenkhuvuc IS NOT NULL, ", ", ""), px.tenkhuvuc) AS phuongxathonto, 
        gt.tengioitinh, 
        ldt.ten AS tenloaidoituong, ldt.sotien as muctienchuan,
        ld.ten as tentrangthai,
        tt.tenkhuvuc, 
        bd.ten as tenbiendong,
        cs.ten as tenchinhsach,
        a.n_hoten, 
        a.n_cccd, 
        b.*');

        $query->from('vhxhytgd_doituonghbtxh AS a');
        $query->leftJoin('vhxhytgd_huongbtxh2doituong AS b ON a.id = b.doituongbtxh_id');
        $query->leftJoin('danhmuc_khuvuc AS px ON px.id = a.phuongxa_id');
        $query->leftJoin('danhmuc_khuvuc AS tt ON tt.id = a.thonto_id');
        $query->leftJoin('dmloaidoituong AS ldt ON ldt.id = b.loaidoituong_id');
        $query->leftJoin('danhmuc_gioitinh AS gt ON gt.id = a.n_gioitinh_id');
        $query->leftJoin('dmloaibiendong AS bd ON bd.id = b.biendong_id');
        $query->leftJoin('dmchinhsach AS cs ON cs.id = b.chinhsach_id');
        $query->leftJoin('dmlydo AS ld ON ld.id = b.trangthai_id');
        $query->where('a.daxoa = 0 AND b.daxoa = 0');
        $query->where('a.id = ' . $db->quote($doituong_id));

        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function delThongtinhuongcs($trocap_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vhxhytgd_huongbtxh2doituong');
        $query->set('daxoa = 1');
        $query->where('id =' . $db->quote($trocap_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function removeDoiTuongChinhSach($chinhsach_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vhxhytgd_doituonghbtxh');
        $query->set('daxoa = 1');
        $query->where('id =' . $db->quote($chinhsach_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function getDetailDOITUONGCS($doituong_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.id as doituonghuong, a.*, b.id as id_trocap,
        DATE_FORMAT(a.n_namsinh, "%d/%m/%Y") AS ngaysinh, 
        DATE_FORMAT(b.ngayky, "%d/%m/%Y") AS ngayquyetdinh, 
        DATE_FORMAT(b.huongtungay, "%d/%m/%Y") AS tungay, 
        DATE_FORMAT(a.ngaycat, "%d/%m/%Y") AS ngaycat, 

        CONCAT(COALESCE(tt.tenkhuvuc, ""), IF(tt.tenkhuvuc IS NOT NULL, ", ", ""), px.tenkhuvuc) AS phuongxathonto, 
        gt.tengioitinh, 
        ldt.ten AS tenloaidoituong, ldt.sotien as muctieuchuan,
        ld.ten as tentrangthai,
        tt.tenkhuvuc, 
        bd.ten as tenbiendong,
        cs.ten as tenchinhsach,
        a.n_hoten, 
        a.n_cccd, 
        b.*');

        $query->from('vhxhytgd_doituonghbtxh AS a');
        $query->leftJoin('vhxhytgd_huongbtxh2doituong AS b ON a.id = b.doituongbtxh_id');
        $query->leftJoin('danhmuc_khuvuc AS px ON px.id = a.phuongxa_id');
        $query->leftJoin('danhmuc_khuvuc AS tt ON tt.id = a.thonto_id');
        $query->leftJoin('dmloaidoituong AS ldt ON ldt.id = b.loaidoituong_id');
        $query->leftJoin('danhmuc_gioitinh AS gt ON gt.id = a.n_gioitinh_id');
        $query->leftJoin('dmloaibiendong AS bd ON bd.id = b.biendong_id');
        $query->leftJoin('dmchinhsach AS cs ON cs.id = b.chinhsach_id');
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
    public function getThongKeDoituonghuongcs($params = array())
    {
        $db = Factory::getDbo();

        // Subquery
        $query_left = $db->getQuery(true);
        $query_left->select([
            'a.phuongxa_id',
            'px.tenkhuvuc AS phuongxa',
            'a.thonto_id',
            'f.tenkhuvuc AS thonto',
            'SUM(CASE WHEN b.biendong_id = 1 THEN 1 ELSE 0 END) AS loaibiendong_id_1',
            'SUM(CASE WHEN b.biendong_id = 2 THEN 1 ELSE 0 END) AS loaibiendong_id_2',
            'SUM(CASE WHEN b.biendong_id = 3 THEN 1 ELSE 0 END) AS loaibiendong_id_3',
            'SUM(CASE WHEN b.biendong_id = 4 THEN 1 ELSE 0 END) AS loaibiendong_id_4'
        ]);
        $query_left->from('vhxhytgd_doituonghbtxh AS a')
            ->innerJoin('vhxhytgd_huongbtxh2doituong AS b ON a.id = b.doituongbtxh_id')

            ->innerJoin('danhmuc_khuvuc AS f ON a.thonto_id = f.id')
            ->innerJoin('danhmuc_khuvuc AS px ON a.phuongxa_id = px.id')
            ->where('a.daxoa = 0 AND b.daxoa = 0');

        // Điều kiện WHERE cho subquery
        if (!empty($params['phuongxa_id'])) {
            $query_left->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }

        if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
            $query_left->where($db->quoteName('a.thonto_id') . ' IN (' . implode(',', array_map([$db, 'quote'], $params['thonto_id'])) . ')');
        }
        if (!empty($params['loaidoituong_id'])) {
            $query_left->where('b.loaidoituong_id = ' . $db->quote($params['loaidoituong_id']));
        }
        if (!empty($params['nam_from']) && !empty($params['nam_to'])) {
            $query_left->where('YEAR(b.huongtungay) BETWEEN ' . $db->quote($params['nam_from']) . ' AND ' . $db->quote($params['nam_to']));
        }

        if (!empty($params['thang_from']) && !empty($params['thang_to'])) {
            $query_left->where('MONTH(b.huongtungay) BETWEEN ' . $db->quote($params['thang_from']) . ' AND ' . $db->quote($params['thang_to']));
        }
        $query_left->group(['a.phuongxa_id', 'a.thonto_id']);

        // Query chính
        $query = $db->getQuery(true);
        $query->select([
            'a.id',
            'a.cha_id',
            'a.tenkhuvuc',
            'a.level',
            'COALESCE(SUM(ab.loaibiendong_id_1), 0) AS loaibiendong_id_1',
            'COALESCE(SUM(ab.loaibiendong_id_2), 0) AS loaibiendong_id_2',
            'COALESCE(SUM(ab.loaibiendong_id_3), 0) AS loaibiendong_id_3',
            'COALESCE(SUM(ab.loaibiendong_id_4), 0) AS loaibiendong_id_4'

        ])
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
