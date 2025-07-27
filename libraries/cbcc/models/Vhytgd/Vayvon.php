<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Vhytgd_Model_Vayvon extends JModelLegacy
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

    //get list phường xã theo quyền user 
    public function getPhuongXaById($id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.tenkhuvuc,a.cha_id AS quanhuyen_id,b.cha_id AS tinhthanh_id,a.level');
        $query->from('danhmuc_khuvuc AS a');
        $query->innerJoin('danhmuc_khuvuc AS b ON a.cha_id = b.id');
        if ($id == '-1') {
            $query->where('a.level = 2 AND a.daxoa = 0');
        } else {
            $query->where('a.level = 2 AND a.daxoa = 0 AND a.id IN (' . $id . ')');
        }
        $query->order('tenkhuvuc ASC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function checkVayVon($nhankhau_id, $table)
    {
        // Get database object
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('COUNT(*)')
            ->from($db->quoteName('vhxhytgd_nguoivayvon'))
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


    public function saveVayvon($formData)
    {
        $db = Factory::getDbo();
        $user_id = Factory::getUser()->id;
        // Danh sách các trường cần chuyển thành mảng
        $fields_to_array = [
            'nguonvon_id',
            'chuongtrinh_id',
            'tinhtrang_id',
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
        $n = count($formData['nguonvon_id']);
        $ngaysinh = !empty($formData['input_namsinh'])
            ? DateTime::createFromFormat('d/m/Y', $formData['input_namsinh'])
            : (!empty($formData['select_namsinh']) ? DateTime::createFromFormat('d/m/Y', $formData['select_namsinh']) : false);
        // Lưu vào bảng vhxhytgd_doituonghbtxh
        $data = array(
            'id' => $formData['vayvon_id'] ?? 0,
            'nhankhau_id' => !empty($formData['nhankhau_id']) ? $formData['nhankhau_id'] : 0, // Gán 0 nếu không có dữ liệu
            'phuongxa_id' => !empty($formData['input_phuongxa_id']) ? $formData['input_phuongxa_id'] : $formData['select_phuongxa_id'] ?? null,
            'thonto_id' => !empty($formData['input_thonto_id']) ? $formData['input_thonto_id'] : $formData['select_thonto_id'] ?? null,
            'makh' => $formData['makhachhang'] ?? null,
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
            $query->insert($db->quoteName('vhxhytgd_nguoivayvon'))
                ->columns($data_insert_key)
                ->values(implode(',', $data_insert_val));
            // echo $query;
            // exit;
        } else {
            $query->update($db->quoteName('vhxhytgd_nguoivayvon'))
                ->set(implode(',', $data_update))
                ->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }

        $db->setQuery($query);
        $db->execute();

        if ((int) $data['id'] == 0) {
            $nguoivayvon_id = $db->insertid();
        } else {
            $nguoivayvon_id = $data['id'];
        }
        for ($dt = 0; $dt < $n; $dt++) {
            if (empty($formData['nguonvon_id'][$dt])) {
                continue;
            }

            $ngaygiaingan = !empty($formData['ngaygiaingan'][$dt]) ? DateTime::createFromFormat('d/m/Y', $formData['ngaygiaingan'][$dt]) : false;
            $ngaydenhan = !empty($formData['ngaydenhan'][$dt]) ? DateTime::createFromFormat('d/m/Y', $formData['ngaydenhan'][$dt]) : false;

            $data_chuyennganh[$dt] = array(
                'id' => $formData['id_2nguonvon'][$dt] ?? 0,
                'nguoivayvon_id' => $nguoivayvon_id,
                'chuongtrinhvay_id' => $formData['chuongtrinh_id'][$dt] ?? null,
                'nguonvon_id' => $formData['nguonvon_id'][$dt] ?? null,
                'ngaygiaingan' => $ngaygiaingan ? $ngaygiaingan->format('Y-m-d') : null,
                'ngaydenhan' => $ngaydenhan ? $ngaydenhan->format('Y-m-d') : null,
                'tiengiaingan' => $formData['giaingan'][$dt] ?? null,
                'laisuatvay' => $formData['laisuat'][$dt] ?? null,
                'tongduno' => $formData['tongduno'][$dt] ?? null,
                'trangthaivay_id' => $formData['tinhtrang_id'][$dt] ?? null,
                'somonvay' => $formData['somonvay'][$dt] ?? null,
                'is_tochuc' => $formData['thanhviento'][$dt] ?? null,
                'nguoitochuc' => $formData['totruong'][$dt] ?? null,
                'doanhoi_id' => $formData['tochuchoi_id'][$dt] ?? null,
                'ghichu' => $formData['ghichu'][$dt] ?? null,
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
                $querys->insert($db->quoteName('vhxhytgd_nguoivayvon2chuongtrinh'))
                    ->columns($data_chuyennganh_insert_key[$dt])
                    ->values(implode(',', $data_chuyennganh_insert_val[$dt]));
                // echo $querys;exit;

            } else {
                $querys->update($db->quoteName('vhxhytgd_nguoivayvon2chuongtrinh'))
                    ->set(implode(',', $data_chuyennganh_update[$dt]))
                    ->where(array($db->quoteName('id') . '=' . $db->quote($data_chuyennganh[$dt]['id'])));
            }
            $db->setQuery($querys);
            $db->execute();
        }
        // exit;
        return true;
    }

    public function getDanhSachVayVon($params = array(), $startFrom = 0, $perPage = 20)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        // Chọn các trường cần thiết
        $query->select('a.*, 
        COUNT(b.id) AS tong, 
        CONCAT(
            COALESCE(a.n_diachi, ""), 
            IF(a.n_diachi IS NOT NULL AND a.n_diachi != "", ", ", ""), 
            COALESCE(tt.tenkhuvuc, ""), 
            IF(tt.tenkhuvuc IS NOT NULL AND tt.tenkhuvuc != "", ", ", ""), 
            px.tenkhuvuc
        ) AS phuongxathonto
    ');

        // Từ bảng chính
        $query->from('vhxhytgd_nguoivayvon AS a');
        $query->leftJoin('vhxhytgd_nguoivayvon2chuongtrinh AS b ON a.id = b.nguoivayvon_id');
        $query->leftJoin('danhmuc_khuvuc AS px ON px.id = a.phuongxa_id');
        $query->leftJoin('danhmuc_khuvuc AS tt ON tt.id = a.thonto_id');
        $query->leftJoin('danhmuc_gioitinh AS gt ON gt.id = a.n_gioitinh_id');

        // Điều kiện lọc
        $query->where('a.daxoa = 0 AND b.daxoa = 0');

        // Thêm điều kiện lọc theo tham số
        if (!empty($params['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }
        if (!empty($params['thonto_id'])) {
            $query->where('a.thonto_id = ' . $db->quote($params['thonto_id']));
        }

        // Kiểm tra quyền truy cập
        $phanquyen = $this->getPhanquyen();
        if (empty($params['phuongxa_id']) && $phanquyen['phuongxa_id'] != '-1') {
            $query->where('a.phuongxa_id IN (' . str_replace("'", '', $db->quote($phanquyen['phuongxa_id'])) . ')');
        }
        if (!empty($params['hoten'])) {
            $query->where('a.n_hoten LIKE ' . $db->quote('%' . $params['hoten'] . '%'));
        }
        if (!empty($params['makhachhang'])) {
            $query->where('a.makh = ' . $db->quote($params['makhachhang']));
        }

        // Nhóm theo ID
        $query->group('a.id');

        // Phân trang
        $perPage = (int)$perPage;
        $startFrom = (int)$startFrom;
        if ($perPage > 0) {
            $query->setLimit($perPage, $startFrom);
        }

        // Ghi log truy vấn để debug
        error_log('Query getDanhSachDoiTuongCS: ' . (string)$query);

        // Thực hiện truy vấn và trả về kết quả
        $db->setQuery($query);
        return $db->loadAssocList();
    }



    public function CountDBDT($params = array())
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();
        $query->select('COUNT(DISTINCT a.id)');

        $query->from('vhxhytgd_nguoivayvon AS a');
        $query->leftJoin('vhxhytgd_nguoivayvon2chuongtrinh AS b ON a.id = b.nguoivayvon_id');
        $query->leftJoin('danhmuc_khuvuc AS px ON px.id = a.phuongxa_id');
        $query->leftJoin('danhmuc_khuvuc AS tt ON tt.id = a.thonto_id');
        $query->leftJoin('danhmuc_gioitinh AS gt ON gt.id = a.n_gioitinh_id');;

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

        if (!empty($params['makhachhang'])) {
            $query->where('a.makh = ' . $db->quote($params['makhachhang']));
        }

        $db->setQuery($query);

        // echo $query;
        $result = $db->loadResult(); // Sử dụng loadResult thay vì loadAssocList cho COUNT
        return (int)$result; // Trả về số nguyên
    }

    public function getEditVayvon($vayvon_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.*,a.id as vayvon_id, b.*, b.id as id_2nguonvon, cs.tenchuongtrinhvay, nv.tennguonvon, tt.tentrangthaivay, dh.tendoanhoi,
        DATE_FORMAT(b.ngaygiaingan, "%d/%m/%Y") AS ngaygiaingan2,DATE_FORMAT(a.n_namsinh, "%d/%m/%Y") AS ngaysinh,DATE_FORMAT(b.ngaydenhan, "%d/%m/%Y") AS ngaydenhan2,FORMAT(b.tongduno, 0) AS tongduno_formatted,FORMAT(b.tiengiaingan, 0) AS tiengiaingan_format');

        $query->from('vhxhytgd_nguoivayvon AS a');
        $query->leftJoin('vhxhytgd_nguoivayvon2chuongtrinh AS b ON a.id = b.nguoivayvon_id');

        $query->leftJoin('danhmuc_chuongtrinhvay AS cs ON cs.id = b.chuongtrinhvay_id');
        $query->leftJoin('danhmuc_nguonvon AS nv ON nv.id = b.nguonvon_id');
        $query->leftJoin('danhmuc_trangthaivay AS tt ON tt.id = b.trangthaivay_id');
        $query->leftJoin('danhmuc_doanhoi AS dh ON dh.id = b.doanhoi_id');
        $query->where('a.daxoa = 0 AND b.daxoa = 0');
        $query->where('a.id = ' . $db->quote($vayvon_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function delThongtinvayvon($trocap_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vhxhytgd_nguoivayvon2chuongtrinh');
        $query->set('daxoa = 1');
        $query->where('id =' . $db->quote($trocap_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function removeVayVon($chinhsach_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vhxhytgd_nguoivayvon');
        $query->set('daxoa = 1');
        $query->where('id =' . $db->quote($chinhsach_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function getDetailVayVon($vayvon_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*,a.id as vayvon_id, b.*, b.id as id_2nguonvon, cs.tenchuongtrinhvay, nv.tennguonvon, tt.tentrangthaivay, dh.tendoanhoi,
        DATE_FORMAT(b.ngaygiaingan, "%d/%m/%Y") AS ngaygiaingan2,DATE_FORMAT(a.n_namsinh, "%d/%m/%Y") AS ngaysinh,DATE_FORMAT(b.ngaydenhan, "%d/%m/%Y") AS ngaydenhan2,FORMAT(b.tongduno, 0) AS tongduno_formatted,FORMAT(b.tiengiaingan, 0) AS tiengiaingan_format');

        $query->from('vhxhytgd_nguoivayvon AS a');
        $query->leftJoin('vhxhytgd_nguoivayvon2chuongtrinh AS b ON a.id = b.nguoivayvon_id');

        $query->leftJoin('danhmuc_chuongtrinhvay AS cs ON cs.id = b.chuongtrinhvay_id');
        $query->leftJoin('danhmuc_nguonvon AS nv ON nv.id = b.nguonvon_id');
        $query->leftJoin('danhmuc_trangthaivay AS tt ON tt.id = b.trangthaivay_id');
        $query->leftJoin('danhmuc_doanhoi AS dh ON dh.id = b.doanhoi_id');
        $query->where('a.daxoa = 0 AND b.daxoa = 0');
        $query->where('a.id = ' . $db->quote($vayvon_id));

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
    public function getThongKeVayvon($params = array())
    {
        $db = Factory::getDbo();

        // Subquery
        $query_left = $db->getQuery(true);
        $query_left->select('SUM( cs.tongduno ) AS kinhphi,a.nhankhau_id as songuoivayvon, a.phuongxa_id,d.tenkhuvuc AS tenphuongxa,a.thonto_id,c.tenkhuvuc AS tenthonto');
        $query_left->from('vhxhytgd_nguoivayvon AS a');
        $query_left->innerJoin('vhxhytgd_nguoivayvon2chuongtrinh AS cs ON a.id = cs.nguoivayvon_id');
        $query_left->innerJoin('danhmuc_khuvuc AS c ON a.thonto_id = c.id');
        $query_left->innerJoin('danhmuc_khuvuc AS d ON a.phuongxa_id = d.id');
        $query_left->where('a.daxoa = 0 AND cs.daxoa = 0');
        $query_left->group('a.thonto_id');
        // Điều kiện WHERE cho subquery
        if (!empty($params['phuongxa_id'])) {
            $query_left->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }

        if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
            $query_left->where($db->quoteName('a.thonto_id') . ' IN (' . implode(',', array_map([$db, 'quote'], $params['thonto_id'])) . ')');
        }
        if (!empty($params['chuongtrinh_id'])) {
            $query_left->where('cs.chuongtrinhvay_id = ' . $db->quote($params['chuongtrinh_id']));
        }

        if (!empty($params['trangthai_id'])) {
            $query_left->where('cs.trangthaivay_id = ' . $db->quote($params['trangthai_id']));
        }
        // Query chính
        $query = $db->getQuery(true);
        $query->select(['a.id,a.cha_id,a.tenkhuvuc,a.level, COUNT(ab.songuoivayvon) as tongsonguoivayvon, CONCAT(FORMAT(SUM(ab.kinhphi),"vi_VN")) AS tongkinhphi'])
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

    public function getDanhSachXuatExcel($filters, $phuongxa)
    {
        $hoten = isset($filters['hoten']) ? trim($filters['hoten']) : '';
        $makhachhang = isset($filters['makhachhang']) ? trim($filters['makhachhang']) : '';
        $phuongxa_id = isset($filters['phuongxa_id']) ? (int)$filters['phuongxa_id'] : 0;
        $thonto_id = isset($filters['thonto_id']) ? (int)$filters['thonto_id'] : 0;

        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        // Select fields
        $query->select([
            'a.makh',
            'a.n_hoten',
            'DATE_FORMAT(a.n_namsinh, "%d/%m/%Y") AS namsinh',
            'a.n_dienthoai',
            'a.n_cccd',
            'DATE_FORMAT(hk.cccd_ngaycap, "%d/%m/%Y") AS cccd_ngaycap',
            'hk.cccd_coquancap',
            'a.n_diachi',
            'px.tenkhuvuc AS phuongxa',
            'tt.tenkhuvuc AS thonto',
            'b.somonvay',
            'DATE_FORMAT(b.ngaygiaingan, "%d/%m/%Y") AS ngaygiaingan',
            'DATE_FORMAT(b.ngaydenhan, "%d/%m/%Y") AS ngaydenhan',
            'cs.tenchuongtrinhvay',
            'b.nguoitochuc',
            'dh.tendoanhoi',
            'nv.tennguonvon',
            'b.laisuatvay',
            'b.tiengiaingan',
            'b.tongduno',
        ]);

        $query->from('vhxhytgd_nguoivayvon AS a')
            ->leftJoin($db->quoteName('vptk_hokhau2nhankhau', 'hk') .' ON hk.id = a.nhankhau_id AND a.is_ngoai = 0 AND hk.daxoa = 0')
            ->leftJoin($db->quoteName('danhmuc_khuvuc', 'px') . ' ON px.id = a.n_phuongxa_id AND px.daxoa = 0')
            ->leftJoin($db->quoteName('danhmuc_khuvuc', 'tt') . ' ON tt.id = a.n_thonto_id AND tt.daxoa = 0')
            ->leftJoin('vhxhytgd_nguoivayvon2chuongtrinh AS b ON a.id = b.nguoivayvon_id')
            ->leftJoin('danhmuc_chuongtrinhvay AS cs ON cs.id = b.chuongtrinhvay_id')
            ->leftJoin('danhmuc_nguonvon AS nv ON nv.id = b.nguonvon_id')
            ->leftJoin('danhmuc_doanhoi AS dh ON dh.id = b.doanhoi_id')
            ->where('a.daxoa = 0 AND b.daxoa = 0');

        // Apply filters
        $phuongxaIds = !empty($phuongxa) && is_array($phuongxa)
            ? array_map('intval', array_column($phuongxa, 'id'))
            : [];

        if (!empty($phuongxa_id)) {
            $query->where('a.n_phuongxa_id = ' . (int)$phuongxa_id);
        } else {
            // Không có phường xã filter → dùng danh sách phân quyền
            if (!empty($phuongxaIds)) {
                $query->where('a.n_phuongxa_id IN (' . implode(',', $phuongxaIds) . ')');
            } else {
                // Nếu không có phân quyền nào thì có thể lấy tất cả hoặc 1=0 tùy yêu cầu
                $query->where('a.n_phuongxa_id IN (SELECT id FROM danhmuc_phuongxa WHERE daxoa = 0)');
            }
        }

        if ($thonto_id > 0) {
            $query->where($db->quoteName('a.n_thonto_id') . ' = ' . (int)$thonto_id);
        }

        if (!empty($hoten)) {
            $query->where($db->quoteName('a.n_hoten') . ' LIKE ' . $db->quote('%' . $db->escape($hoten) . '%'));
        }

        if (!empty($makhachhang)) {
            // Có thể lọc cả trên a.n_cccd hoặc hk.cccd_so
            $query->where($db->quoteName('a.makh') . ' LIKE ' . $db->quote('%' . $db->escape($makhachhang) . '%'));
        }

        $query->order($db->quoteName('a.id') . ' DESC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
}
