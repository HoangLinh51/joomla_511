<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Vhytgd_Model_Nguoicocong extends JModelLegacy
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
            ->leftJoin($db->quoteName('vhxhytgd_nguoicocong', 'ncc') . ' ON nk.id = ncc.nhankhau_id')
            ->where('nk.daxoa = 0')
            ->where('hk.daxoa = 0')
            ->where('ncc.nhankhau_id IS NULL'); // Chỉ lấy người KHÔNG có trong bảng nguoicocong

        if ($nhankhau_id > 0) {
            $query->where('nk.id = ' . (int)$nhankhau_id);
        } else {
            if (!empty($keyword)) {
                $search = $db->quote('%' . $db->escape($keyword, true) . '%');
                // Thêm điều kiện tìm kiếm vào một nhóm riêng để đảm bảo logic đúng
                $query->where("(nk.hoten LIKE $search OR nk.cccd_so LIKE $search)");
            }
            if (!empty($phuongxa) && is_array($phuongxa)) {
                $phuongxa = array_map('intval', $phuongxa);
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

    public function saveNguoicocong($formData)
    {
        $db = Factory::getDbo();
        $user_id = Factory::getUser()->id;

        // Danh sách các trường cần chuyển thành mảng
        $fields_to_array = [
            'uudai_id',
            'nhankhau_id',
            'is_dat',
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
            'ghi_chu',
            'trocap',
            'phucap',
            'dmtyle_id',
            'trocapdungcu',
            'noidunguudai',
            'loaidungcu_id', // Sửa từ 'dungcu' thành 'loaidungcu_id'
            'nienhan',
            'trocap_uudai',
            'ngayuudai'
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
        $n = count($formData['is_hinhthuc'] ?? []);
        $n_uudai = count($formData['uudai_id'] ?? []);
        $maxRecords = 100; // Giới hạn tối đa 100 bản ghi
        if ($n === 0 && $n_uudai === 0) {
            error_log('No valid records to process.');
            return false;
        }
        if ($n > $maxRecords || $n_uudai > $maxRecords) {
            error_log("Too many records to process. Maximum allowed is $maxRecords, received $n for huongncc2doituong, $n_uudai for uudai2nguoicocong.");
            return false;
        }

        // Format ngày sinh
        $ngaysinh = !empty($formData['input_namsinh'])
            ? DateTime::createFromFormat('d/m/Y', $formData['input_namsinh'])
            : (!empty($formData['select_namsinh']) ? DateTime::createFromFormat('d/m/Y', $formData['select_namsinh']) : false);

        // Lưu vào bảng vhxhytgd_nguoicocong
        $data = array(
            'id' => $formData['id_nguoicocong'] ?? 0,
            'nhankhau_id' => !empty($formData['nhankhau_id'][0]) ? $formData['nhankhau_id'][0] : 0,
            'phuongxa_id' => !empty($formData['input_phuongxa_id']) ? $formData['input_phuongxa_id'] : $formData['select_phuongxa_id'] ?? null,
            'thonto_id' => !empty($formData['input_thonto_id']) ? $formData['input_thonto_id'] : $formData['select_thonto_id'] ?? null,
            'n_hoten' => $formData['hoten'] ?? null,
            'n_gioitinh_id' => !empty($formData['input_gioitinh_id']) ? $formData['input_gioitinh_id'] : $formData['select_gioitinh_id'] ?? null,
            'n_dantoc_id' => !empty($formData['input_dantoc_id']) ? $formData['input_dantoc_id'] : $formData['select_dantoc_id'] ?? null,
            'n_cccd' => $formData['cccd'] ?? null,
            'n_phuongxa_id' => !empty($formData['input_phuongxa_id']) ? $formData['input_phuongxa_id'] : $formData['select_phuongxa_id'] ?? null,
            'n_thonto_id' => !empty($formData['input_thonto_id']) ? $formData['input_thonto_id'] : $formData['select_thonto_id'] ?? null,
            'n_namsinh' => $ngaysinh ? $ngaysinh->format('Y-m-d') : null,
            'n_dienthoai' => $formData['dienthoai'] ?? null,
            'n_diachi' => $formData['diachi'] ?? null,
            'is_ngoai' => null,
            'tennguoinhan' => $formData['nguoinhangiup'] ?? null,
            'sotaikhoan' => $formData['sotaikhoan'] ?? null,
            'nganhang_id' => $formData['nganhang_id'] ?? null,
            'daxoa' => '0',
        );

        $data['is_ngoai'] = empty($data['nhankhau_id']) ? 1 : 0;

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = implode(', ', $value);
            } elseif ($value === null) {
                $data[$key] = '';
            } else {
                $data[$key] = (string)$value;
            }
        }

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
            $query->insert($db->quoteName('vhxhytgd_nguoicocong'))
                ->columns($data_insert_key)
                ->values(implode(',', $data_insert_val));
        } else {
            $query->update($db->quoteName('vhxhytgd_nguoicocong'))
                ->set(implode(',', $data_update))
                ->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }

        $db->setQuery($query);
        $db->execute();

        if ((int) $data['id'] == 0) {
            $nguoicocong_id = $db->insertid();
        } else {
            $nguoicocong_id = $data['id'];
        }

        // Lưu vào bảng vhxhytgd_huongncc2doituong và lưu ID của từng bản ghi
        $huongncc_ids = [];
        for ($dt = 0; $dt < $n; $dt++) {
            if (empty($formData['is_hinhthuc'][$dt])) {
                error_log("Bỏ qua bản ghi huongncc2doituong[$dt] vì is_hinhthuc rỗng.");
                continue;
            }

            if (isset($formData['ngayhuong'][$dt]) && !empty($formData['ngayhuong'][$dt])) {
                $ngayhuong = DateTime::createFromFormat('d/m/Y', $formData['ngayhuong'][$dt]);
            } else {
                $ngayhuong = false;
            }

            $data_chuyennganh[$dt] = array(
                'id' => $formData['id_huongncc'][$dt] ?? 0,
                'nguoicocong_id' => $nguoicocong_id,
                'is_hinhthuc' => $formData['is_hinhthuc'][$dt] ?? null,
                'dmnguoicocong_id' => $formData['dmnguoicocong_id'][$dt] ?? null,
                'trangthai_id' => $formData['trangthai_id'][$dt] ?? null,
                'trocap' => $formData['trocap'][$dt] ?? null,
                'phucap' => $formData['phucap'][$dt] ?? null,
                'dmtyle_id' => $formData['dmtyle_id'][$dt] ?? null,
                'ngayhuong' => $ngayhuong ? $ngayhuong->format('Y-m-d') : null,
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
                $querys->insert($db->quoteName('vhxhytgd_huongncc2doituong'))
                    ->columns($data_chuyennganh_insert_key[$dt])
                    ->values(implode(',', $data_chuyennganh_insert_val[$dt]));
            } else {
                $querys->update($db->quoteName('vhxhytgd_huongncc2doituong'))
                    ->set(implode(',', $data_chuyennganh_update[$dt]))
                    ->where(array($db->quoteName('id') . '=' . $db->quote($data_chuyennganh[$dt]['id'])));
            }

            error_log("Thực thi query cho huongncc2doituong[$dt]: " . (string)$querys);
            $db->setQuery($querys);
            $db->execute();

            // Lưu ID của bản ghi huongncc2doituong
            if ((int) $data_chuyennganh[$dt]['id'] == 0) {
                $huongncc_ids[$dt] = $db->insertid();
            } else {
                $huongncc_ids[$dt] = $data_chuyennganh[$dt]['id'];
            }
        }
        // Lưu vào bảng vhxhytgd_uudai2nguoicocong
        for ($ud = 0; $ud < $n_uudai; $ud++) {
            if (empty($formData['uudai_id'][$ud])) {
                error_log("Bỏ qua bản ghi uudai2nguoicocong[$ud] vì uudai_id rỗng.");
                continue;
            }

            // Sử dụng huongncc_id tương ứng thay vì nguoicocong_id
            $huongncc_id = isset($huongncc_ids[$ud]) ? $huongncc_ids[$ud] : $huongncc_ids[0] ?? $nguoicocong_id;

            if (isset($formData['ngayuudai'][$ud]) && !empty($formData['ngayuudai'][$ud])) {
                $ngayuudai = DateTime::createFromFormat('d/m/Y', $formData['ngayuudai'][$ud]);
            } else {
                $ngayuudai = false;
            }

            $data_uudai[$ud] = array(
                'id' => $formData['id_uudai'][$ud] ?? 0,
                'huongncc_id' => $huongncc_id, // Sử dụng huongncc_id thay vì nguoicocong_id
                'uudai_id' => $formData['uudai_id'][$ud] ?? null,
                'noidunguudai' => $formData['noidunguudai'][$ud] ?? null,
                'trocap' => $formData['trocapdungcu'][$ud] ?? null,
                'nienhan' => $formData['nienhan'][$ud] ?? null,
                'loaidungcu_id' => $formData['loaidungcu_id'][$ud] ?? null,
                'ngayuudai' => $ngayuudai ? $ngayuudai->format('Y-m-d') : null,
                'daxoa' => '0',
            );



            $data_uudai_insert_key[$ud] = [];
            $data_uudai_insert_val[$ud] = [];
            $data_uudai_update[$ud] = [];

            foreach ($data_uudai[$ud] as $key => $value) {
                if ($value === '' || $value === null) {
                    $data_uudai_update[$ud][] = $key . " = NULL";
                    unset($data_uudai[$ud][$key]);
                } else {
                    $data_uudai_insert_key[$ud][] = $key;
                    if ($value === 'NOW()') {
                        $data_uudai_insert_val[$ud][] = $value;
                        $data_uudai_update[$ud][] = $key . " = " . $value;
                    } else {
                        $data_uudai_insert_val[$ud][] = $db->quote($value);
                        $data_uudai_update[$ud][] = $key . " = " . $db->quote($value);
                    }
                }
            }
            // var_dump($data_uudai[$ud]);exit;

            $queryud = $db->getQuery(true);
            if ((int) $data_uudai[$ud]['id'] == 0) {
                $queryud->insert($db->quoteName('vhxhytgd_uudai2nguoicocong'))
                    ->columns($data_uudai_insert_key[$ud])

                    ->values(implode(',', $data_uudai_insert_val[$ud]));
                // echo $queryud;exit;
            } else {
                $queryud->update($db->quoteName('vhxhytgd_uudai2nguoicocong'))
                    ->set(implode(',', $data_uudai_update[$ud]))
                    ->where(array($db->quoteName('id') . '=' . $db->quote($data_uudai[$ud]['id'])));
            }

            error_log("Thực thi query cho uudai2nguoicocong[$ud]: " . (string)$queryud);
            $db->setQuery($queryud);
            $db->execute();
        }
        // exit;
        return true;
    }

    public function getDanhSachNguoiCoCong($params = array(), $startFrom = 0, $perPage = 20)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        // Truy vấn chính
        // Truy vấn chính
        $query->select([
            'a.id',
            'DATE_FORMAT(a.n_namsinh, "%d/%m/%Y") AS ngaysinh',
            'CONCAT(COALESCE(tt.tenkhuvuc, ""), IF(tt.tenkhuvuc IS NOT NULL, ", ", ""), px.tenkhuvuc) AS phuongxathonto',
            'latest_status.ten AS tentrangthai',
            'gt.tengioitinh',
            'GROUP_CONCAT(DISTINCT ldt.ten SEPARATOR ", ") AS tenloaidoituong',
            'tt.tenkhuvuc',
            'COUNT(b.is_hinhthuc) AS total_loaidoituong',
            'a.n_hoten',
            'ch.ten as tentrangthaicathuong',
            'a.n_cccd',
            'latest_status.trangthai_id', // <-- SỬA LỖI Ở ĐÂY
            'COALESCE(SUM(uudai.trocap), 0) AS tong_uudai'
        ]);
        $query->from('vhxhytgd_nguoicocong AS a')
            ->leftJoin('(
            SELECT
                b1.nguoicocong_id,
                b1.trangthai_id,
                ld.ten 
            FROM
                vhxhytgd_huongncc2doituong b1
                INNER JOIN (
                    SELECT nguoicocong_id, MAX(id) AS max_id 
                    FROM vhxhytgd_huongncc2doituong 
                    WHERE daxoa = 0 
                    GROUP BY nguoicocong_id
                ) latest ON b1.id = latest.max_id
                LEFT JOIN dmlydo ld ON ld.id = b1.trangthai_id 
        ) AS latest_status ON a.id = latest_status.nguoicocong_id')
            ->leftJoin('vhxhytgd_huongncc2doituong AS b ON a.id = b.nguoicocong_id AND b.daxoa = 0')
            ->leftJoin('danhmuc_khuvuc AS px ON px.id = a.phuongxa_id')
            ->leftJoin('danhmuc_khuvuc AS tt ON tt.id = a.thonto_id')
            ->leftJoin('dmloaidoituong AS ldt ON ldt.id = b.is_hinhthuc')
            ->leftJoin('danhmuc_gioitinh AS gt ON gt.id = a.n_gioitinh_id')
            ->leftJoin('dmlydo AS ch ON ch.id = a.trangthaich_id')

            ->leftJoin('(
            SELECT 
                huongncc_id,
                SUM(trocap) AS trocap -- Tổng trợ cấp từ bảng ưu đãi
            FROM 
                vhxhytgd_uudai2nguoicocong 
            WHERE 
                daxoa = 0 
            GROUP BY 
                huongncc_id
        ) AS uudai ON b.id = uudai.huongncc_id') // JOIN bảng ưu đãi
            ->where('a.daxoa = 0 AND b.daxoa = 0');

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

        // Phân trang
        $perPage = (int)$perPage;
        $startFrom = (int)$startFrom;
        if ($perPage > 0) {
            $query->setLimit($perPage, $startFrom);
        }

        // Ghi log truy vấn để debug
        // echo $query;
        $db->setQuery($query);
        return $db->loadAssocList();
    }




    public function CountDanhSachNCC($params = array())
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();
        $query->select('COUNT(DISTINCT a.id)');

        $query->from('vhxhytgd_nguoicocong AS a');

        $query->leftJoin('vhxhytgd_huongncc2doituong AS b ON a.id = b.nguoicocong_id');
        $query->leftJoin('vhxhytgd_uudai2nguoicocong AS c ON b.id = c.huongncc_id');

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

        // echo $query;exit;
        $result = $db->loadResult(); // Sử dụng loadResult thay vì loadAssocList cho COUNT
        return (int)$result; // Trả về số nguyên
    }

    public function getEditNCC($ncc_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.id as doituonghuong, a.*, b.id as id_huongncc,c.id as id_uudai,
        DATE_FORMAT(a.n_namsinh, "%d/%m/%Y") AS ngaysinh, c.*,
        DATE_FORMAT(b.ngayhuong, "%d/%m/%Y") AS ngayhuong2, 
        DATE_FORMAT(c.ngayuudai, "%d/%m/%Y") AS ngayuudai, 
        ld.ten as trangthai,
        gt.tengioitinh, 
        tt.tenkhuvuc, 
        a.n_hoten, ncc.ten as tenncc, ncc.trocap, ncc.phucap,
        a.n_cccd, ud.ten as tenuudai,dc.tendungcu,
        b.*');

        $query->from('vhxhytgd_nguoicocong AS a');
        $query->innerJoin('vhxhytgd_huongncc2doituong AS b ON a.id = b.nguoicocong_id');
        $query->leftJoin('vhxhytgd_uudai2nguoicocong AS c ON b.id = c.huongncc_id');
        $query->innerJoin('dmnguoicocong AS ncc ON ncc.id = b.dmnguoicocong_id');

        $query->leftJoin('danhmuc_khuvuc AS px ON px.id = a.phuongxa_id');
        $query->leftJoin('danhmuc_khuvuc AS tt ON tt.id = a.thonto_id');
        $query->leftJoin('danhmuc_gioitinh AS gt ON gt.id = a.n_gioitinh_id');
        $query->leftJoin('dmlydo AS ld ON ld.id = b.trangthai_id');
        $query->leftJoin('dmuudai AS ud ON ud.id = c.uudai_id');
        $query->leftJoin('dmdungcu AS dc ON dc.id = c.loaidungcu_id');


        $query->where('a.daxoa = 0 AND b.daxoa = 0');
        $query->where('a.id = ' . $db->quote($ncc_id));
        $query->group('b.id');

        // echo $query;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function delThongtinhuongcs($trocap_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vhxhytgd_huongncc2doituong');
        $query->set('daxoa = 1');
        $query->where('id =' . $db->quote($trocap_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function removeNguoiCoCong($chinhsach_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vhxhytgd_nguoicocong');
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
       DATE_FORMAT(a.n_namsinh, "%d/%m/%Y") AS ngaysinh, c.*,
        DATE_FORMAT(b.ngayhuong, "%d/%m/%Y") AS ngayhuong2, 
        DATE_FORMAT(c.ngayuudai, "%d/%m/%Y") AS ngayuudai2, 
        ld.ten as trangthai,
        gt.tengioitinh, 
        a.n_hoten, ncc.ten as tenncc, ncc.trocap, ncc.phucap,
        a.n_cccd, ud.ten as tenuudai,dc.tendungcu,c.trocap as trocapuudai, c.noidunguudai,
        b.*');

        $query->from('vhxhytgd_nguoicocong AS a');
        $query->leftJoin('vhxhytgd_huongncc2doituong AS b ON a.id = b.nguoicocong_id');
        $query->leftJoin('vhxhytgd_uudai2nguoicocong AS c ON b.id = c.huongncc_id');
        $query->innerJoin('dmnguoicocong AS ncc ON ncc.id = b.dmnguoicocong_id');

        $query->leftJoin('danhmuc_gioitinh AS gt ON gt.id = a.n_gioitinh_id');
        $query->leftJoin('dmlydo AS ld ON ld.id = b.trangthai_id');
        $query->leftJoin('dmuudai AS ud ON ud.id = c.uudai_id');
        $query->leftJoin('dmdungcu AS dc ON dc.id = c.loaidungcu_id');
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

        $query->from('vhxhytgd_nguoicocong AS a');

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
            ->update($db->quoteName('vhxhytgd_nguoicocong'))
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
    public function loadDoiTuongHuong($hinh_thuc)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.ten, a.is_check, a.is_huong, a.id, a.trocap, a.phucap, b.tyle, b.trocap as trocap2')
            ->from('dmnguoicocong AS a')
            ->leftJoin('dmtyle AS b ON b.id = b.dmnguoicocong_id')
            ->where('a.daxoa = 0 AND a.trangthai = 1')
            ->where('a.is_huong = ' . $db->quote($hinh_thuc));

        $db->setQuery($query);
        $result = $db->loadAssocList();

        // Định dạng lại các trường phucap, trocap, trocap2
        foreach ($result as &$item) {
            // Chuyển đổi giá trị sang float trước khi định dạng
            $item['trocap'] = number_format((float)$item['trocap'], 0, ',', '.');
            $item['trocap2'] = number_format((float)$item['trocap2'], 0, ',', '.');
        }

        return $result;
    }
    public function loadDMtyle($tyle_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.tyle, a.trocap as trocap2')
            ->from('dmtyle AS a')
            ->where('a.daxoa = 0 AND a.trangthai = 1')
            ->where('a.dmnguoicocong_id = ' . $db->quote($tyle_id));

        $db->setQuery($query);
        $result = $db->loadAssocList();

        foreach ($result as &$item) {
            $item['trocap2'] = number_format((float)$item['trocap2'], 0, ',', '.');
        }

        return $result;
    }
    public function loadDMdungcu($uudai_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.id, a.uudai_id, a.tendungcu, a.nienhan, a.muccap')
            ->from('dmdungcu AS a')
            ->where('a.daxoa = 0 AND a.trangthai = 1')
            ->where('a.uudai_id = ' . $db->quote($uudai_id));

        $db->setQuery($query);
        $result = $db->loadAssocList();

        foreach ($result as &$item) {
            $item['trocap2'] = number_format((float)$item['trocap2'], 0, ',', '.');
        }

        return $result;
    }
    public function getThongKeNguoicocong($params = array())
    {
        $db = Factory::getDbo();

        // Subquery
        $query_left = $db->getQuery(true);
        $query_left->select('a.phuongxa_id, d.tenkhuvuc AS phuongxa, a.thonto_id, c.tenkhuvuc AS thonto, 
                         COUNT(DISTINCT a.nhankhau_id) AS tong_nhankhau,COUNT(  a.trangthaich_id) as catgiam, b.trocap');
        $query_left->from('vhxhytgd_nguoicocong AS a');
        $query_left->leftJoin('vhxhytgd_huongncc2doituong AS b ON a.id = b.nguoicocong_id');
        $query_left->leftJoin('vhxhytgd_uudai2nguoicocong AS e ON b.id = e.huongncc_id');
        $query_left->innerJoin('danhmuc_khuvuc AS c ON a.thonto_id = c.id');
        $query_left->innerJoin('danhmuc_khuvuc AS d ON a.phuongxa_id = d.id');
        $query_left->where('a.daxoa = 0 AND b.daxoa = 0');
        // Điều kiện WHERE cho subquery
        if (!empty($params['phuongxa_id'])) {
            $query_left->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }

        if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
            $query_left->where($db->quoteName('a.thonto_id') . ' IN (' . implode(',', array_map([$db, 'quote'], $params['thonto_id'])) . ')');
        }
        if (!empty($params['hinhthuc_id'])) {
            $query_left->where('b.is_hinhthuc = ' . $db->quote($params['hinhthuc_id']));
        }

        if (!empty($params['doituong_id'])) {
            $query_left->where('b.dmnguoicocong_id = ' . $db->quote($params['doituong_id']));
        }
        // Query chính
        $query = $db->getQuery(true);
        $query->select(['a.id,a.cha_id,a.tenkhuvuc,a.level, SUM(ab.tong_nhankhau) as tong_nhankhau,SUM( ab.catgiam ) AS catgiam, ab.trocap'])
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
