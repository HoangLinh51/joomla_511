<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Vhytgd_Model_Giadinhvanhoa extends JModelLegacy
{

    public function getTitle()
    {
        return "Tie";
    }
    public function getKhuvucByIdCha($cha_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,tenkhuvuc,cha_id,level');
        $query->from('danhmuc_khuvuc');
        $query->where('daxoa = 0 AND cha_id = ' . $db->quote($cha_id));
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
    public function getThanhVienGiaDinhVanHoa($thonto_id, $nam, $search = '')
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        // Truy vấn để lấy thông tin nhân khẩu
        $query->select([
            'a.id AS nhankhau_id',
            'a.hoten',
            'b.tengioitinh',
            'a.cccd_so',
            'a.dienthoai',
            'c.diachi',
            'DATE_FORMAT(a.ngaysinh, "%d/%m/%Y") AS ngaysinh'
        ])
            ->from('vptk_hokhau2nhankhau AS a')
            ->innerJoin('danhmuc_gioitinh AS b ON a.gioitinh_id = b.id')
            ->innerJoin('vptk_hokhau AS c ON a.hokhau_id = c.id AND c.thonto_id = ' . $db->quote($thonto_id))
            ->where('a.is_chuho = 1');

        if (!empty($search)) {
            $query->where('(' . $db->quoteName('a.hoten') . ' LIKE ' . $db->quote('%' . $db->escape($search) . '%') .
                ' OR ' . $db->quoteName('a.cccd_so') . ' LIKE ' . $db->quote('%' . $db->escape($search) . '%') . ')');
        }
        // echo $query;exit;
        try {
            $db->setQuery($query);
            $result = $db->loadAssocList();
        } catch (Exception $e) {
            return ['error' => 'Lỗi khi truy vấn nhân khẩu: ' . $e->getMessage()];
        }

        // Truy vấn để lấy thông tin ban điều hành
        $query = $db->getQuery(true);
        $query->select([
            'a.id',
            'b.nhankhau_id',
            'a.phuongxa_id',
            'a.thonto_id',
            'a.nam'
        ])
            ->from('vhxhytgd_giadinhvanhoa AS a')
            ->innerJoin('vhxhytgd_giadinhvanhoa2danhhieu as b on b.giadinhvanhoa_id = a.id')
            ->where('a.daxoa = 0 AND a.thonto_id = ' . $db->quote($thonto_id) . ' AND a.nam = ' . $db->quote($nam));

        try {
            $db->setQuery($query);
            $giadinhvanhoa = $db->loadAssocList();
        } catch (Exception $e) {
            return ['error' => 'Lỗi khi truy vấn ban điều hành: ' . $e->getMessage()];
        }

        // Gộp dữ liệu
        for ($i = 0, $n = count($result); $i < $n; $i++) {
            $result[$i]['giadinhvanhoa'] = [];
            for ($j = 0, $m = count($giadinhvanhoa); $j < $m; $j++) {
                if ($result[$i]['nhankhau_id'] == $giadinhvanhoa[$j]['nhankhau_id']) {
                    $result[$i]['giadinhvanhoa'][] = $giadinhvanhoa[$j];
                }
            }
            if (empty($result[$i]['giadinhvanhoa'])) {
                $result[$i]['giadinhvanhoa'] = [[
                    'id' => '',
                    'nhankhau_id' => $result[$i]['nhankhau_id']
                ]];
            }
        }

        return $result;
    }
    public function saveGiaDinhVH($formData)
    {
        $db = Factory::getDbo();
        $user_id = Factory::getUser()->id;

        // Ghi log dữ liệu form để debug
        error_log('Form Data: ' . print_r($formData, true));
        // Chuyển các trường thành mảng nếu là chuỗi
        $fields_to_array = [
            'nam',
            'nhankhau_id',
            'is_dat', // Sửa từ is_dangvien thành is_dat
            'giadinhvanhoa_tieubieu',
            'lydokhongdat',
            'ghichu',
            'id_giadinhvanhoa',
            'hoten',
            'cccd_so',
            'dienthoai',
            'gioitinh_id',
            'diachi',
            'ngaysinh',
            'is_search'
        ];

        foreach ($fields_to_array as $field) {
            if (isset($formData[$field]) && !is_array($formData[$field])) {
                $formData[$field] = [$formData[$field]];
            } elseif (!isset($formData[$field])) {
                $formData[$field] = [];
            }
        }

        // Tính số lượng bản ghi cần xử lý (dựa trên hoten thay vì nhankhau_id)
        $n = count($formData['hoten']);
        if ($n === 0) {
            error_log('No valid records to process.');
            return false;
        }

        // Lưu vào bảng vhxhytgd_giadinhvanhoa
        $data = array(
            'id' => $formData['giadinhvanhoa'] ?? 0,
            'phuongxa_id' => $formData['phuongxa_id'] ?? null,
            'nam' => isset($formData['nam']) ? implode(',', $formData['nam']) : null,
            'thonto_id' => $formData['thonto_id'] ?? null,
            'daxoa' => '0',
        );
        // var_dump($data);exit;
        if ((int) $data['id'] == 0) {
            $data['nguoitao_id'] = $user_id;
            $data['ngaytao'] = 'NOW()';
        } else {
            $data['nguoixoa_id'] = $user_id;
            $data['nguoihieuchinh_id'] = $user_id;
            $data['ngayhieuchinh'] = 'NOW()';
        }

        $data_insert_key = [];
        $data_insert_val = [];
        $data_update = [];

        foreach ($data as $key => $value) {
            if ($value == '' || $value == null) {
                $data_update[] = $key . " = NULL";
                unset($data[$key]);
            } else {
                $data_insert_key[] = $key;
                if ($value == 'NOW()') {
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
            $query->insert($db->quoteName('vhxhytgd_giadinhvanhoa'))
                ->columns($data_insert_key)
                ->values(implode(',', $data_insert_val));
        } else {
            $query->update($db->quoteName('vhxhytgd_giadinhvanhoa'))
                ->set(implode(',', $data_update))
                ->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }

        $db->setQuery($query);
        $db->execute();

        if ((int) $data['id'] == 0) {
            $giadinhvanhoa_id = $db->insertid();
        } else {
            $giadinhvanhoa_id = $data['id'];
        }

        // Lưu vào bảng vhxhytgd_giadinhvanhoa2danhhieu
        for ($dt = 0; $dt < $n; $dt++) {
            // Kiểm tra trường bắt buộc (hoten hoặc cccd_so)
            if (empty($formData['hoten'][$dt]) && empty($formData['cccd_so'][$dt])) {
                error_log("Skipping record $dt: Both hoten and cccd_so are empty.");
                continue;
            }


            $dbs = Factory::getDbo();
            $querys = $dbs->getQuery(true);

            $data_chuyennganh[$dt] = array(
                'id' => $formData['id_giadinhvanhoa'][$dt] ?? 0,
                'giadinhvanhoa_id' => $giadinhvanhoa_id,
                'nhankhau_id' => $formData['nhankhau_id'][$dt] ?? null,
                'is_dat' => $formData['is_dat'][$dt] ?? '2', // Sửa từ is_dangvien thành is_dat
                'is_giadinhvanhoatieubieu' => $formData['gdvh_tieubieu'][$dt] ?? '0',
                'lydokhongdat' => $formData['lydokhongdat'][$dt] ?? '',
                'ghichu' => $formData['ghichu'][$dt] ?? '',
                'daxoa' => '0',
                'n_hoten' => $formData['hoten'][$dt] ?? null,
                'n_gioitinh_id' => $formData['gioitinh_id'][$dt] ?? null,
                'n_cccd' => $formData['cccd_so'][$dt] ?? null,
                'n_dienthoai' => $formData['dienthoai'][$dt] ?? null,
                'n_phuongxa_id' => $formData['phuongxa_id'] ?? null,
                'n_thonto_id' => $formData['thonto_id'] ?? null,
                'n_diachi' => $formData['diachi'][$dt] ?? null,
                'n_namsinh' => $formData['ngaysinh'][$dt] ?? null,
                'is_ngoai' => $formData['is_search'][$dt] ?? '0',
            );
            if ((int) $data_chuyennganh[$dt]['id'] == 0) {
                $data_chuyennganh[$dt]['nguoitao_id'] = $user_id;
                $data_chuyennganh[$dt]['ngaytao'] = 'NOW()';
            } else {
                $data_chuyennganh[$dt]['nguoixoa_id'] = $user_id;
                $data_chuyennganh[$dt]['nguoihieuchinh_id'] = $user_id;
                $data_chuyennganh[$dt]['ngayhieuchinh'] = 'NOW()';
            }
            // var_dump($data_chuyennganh);
            // exit;
            $data_chuyennganh_insert_key[$dt] = [];
            $data_chuyennganh_insert_val[$dt] = [];
            $data_chuyennganh_update[$dt] = [];

            foreach ($data_chuyennganh[$dt] as $key => $value) {
                if ($value == '' || $value == null) {
                    $data_chuyennganh_update[$dt][] = $key . " = NULL";
                    unset($data_chuyennganh[$dt][$key]);
                } else {
                    $data_chuyennganh_insert_key[$dt][] = $key;
                    if ($value == 'NOW()') {
                        $data_chuyennganh_insert_val[$dt][] = $value;
                        $data_chuyennganh_update[$dt][] = $key . " = " . $value;
                    } else {
                        $data_chuyennganh_insert_val[$dt][] = $dbs->quote($value);
                        $data_chuyennganh_update[$dt][] = $key . " = " . $dbs->quote($value);
                    }
                }
            }

            if ((int) $data_chuyennganh[$dt]['id'] == 0) {
                $querys->insert($dbs->quoteName('vhxhytgd_giadinhvanhoa2danhhieu'))
                    ->columns($data_chuyennganh_insert_key[$dt])
                    ->values(implode(',', $data_chuyennganh_insert_val[$dt]));
            } else {
                $querys->update($dbs->quoteName('vhxhytgd_giadinhvanhoa2danhhieu'))
                    ->set(implode(',', $data_chuyennganh_update[$dt]))
                    ->where(array($dbs->quoteName('id') . '=' . $dbs->quote($data_chuyennganh[$dt]['id'])));
            }
            // echo $querys;
            $dbs->setQuery($querys);
            $dbs->execute();
        }
        // exit;
        return true;
    }
    public function getDanhSachGiaDinhVanHoa($params = array(), $startFrom = 0, $perPage = 20)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();

        $query->select('*,a.thonto_id, a.id as giadinhvanhoa_id, dh.nhankhau_id, c.diachi, COUNT(dh.id) AS so_nguoi, g.tenkhuvuc');
        $query->from('vhxhytgd_giadinhvanhoa as a');
        $query->innerJoin('vhxhytgd_giadinhvanhoa2danhhieu as dh on dh.giadinhvanhoa_id = a.id');
        $query->leftJoin('vptk_hokhau2nhankhau as b on dh.nhankhau_id = b.id');
        $query->leftJoin('vptk_hokhau AS c ON b.hokhau_id = c.id');
        $query->leftJoin('danhmuc_khuvuc AS g ON a.thonto_id = g.id');

        $query->where('a.daxoa = 0 and dh.daxoa = 0');
        $query->group('g.tenkhuvuc,a.id');
        $query->order('so_nguoi DESC');
        if (!empty($params['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }

        if (!empty($params['nam'])) {
            if (is_array($params['nam'])) {
                // Nếu nam là mảng, sử dụng IN
                $namList = array_map(array($db, 'quote'), $params['nam']);
                $query->where('a.nam IN (' . implode(',', $namList) . ')');
            } else {
                // Nếu nam là chuỗi, sử dụng =
                $query->where('a.nam = ' . $db->quote($params['nam']));
            }
        }

        if (empty($params['phuongxa_id']) && $phanquyen['phuongxa_id'] != '-1') {
            $query->where('a.phuongxa_id IN (' . str_replace("'", '', $db->quote($phanquyen['phuongxa_id'])) . ')');
        }
        if (!empty($params['thonto_id'])) {
            $query->where('c.thonto_id = ' . $db->quote($params['thonto_id']));
        }

        // Đảm bảo $perPage và $startFrom là số nguyên
        $perPage = (int)$perPage;
        $startFrom = (int)$startFrom;
        if ($perPage > 0) {
            $query->setLimit($perPage, $startFrom);
        }

        // Ghi log truy vấn để debug
        error_log('Query getDanhSachGiaDinhVanHoa: ' . (string)$query);
        // echo $query;
        $db->setQuery($query);
        return $db->loadAssocList();
    }

    public function CountDanhSachGiaDinhVanHoa($params = array())
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();

        $query->select('COUNT(DISTINCT a.id)');
        $query->from('vhxhytgd_giadinhvanhoa as a');
        $query->leftJoin('vhxhytgd_giadinhvanhoa2danhhieu as dh on dh.giadinhvanhoa_id = a.id');
        $query->leftJoin('vptk_hokhau2nhankhau as b on dh.nhankhau_id = b.id');
        $query->leftJoin('vptk_hokhau AS c ON b.hokhau_id = c.id');
        $query->leftJoin('danhmuc_tinhthanh AS tt ON c.tinhthanh_id = tt.id');
        $query->leftJoin('danhmuc_quanhuyen AS e ON c.quanhuyen_id = e.id');
        $query->leftJoin('danhmuc_phuongxa AS f ON a.phuongxa_id = f.id');
        $query->leftJoin('danhmuc_khuvuc AS g ON a.thonto_id = g.id');
        $query->leftJoin('danhmuc_dantoc AS i ON b.dantoc_id = i.id');
        $query->leftJoin('danhmuc_tongiao AS l ON b.tongiao_id = l.id');
        $query->where('a.daxoa = 0');

        if (!empty($params['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }

        if (!empty($params['nam'])) {
            if (is_array($params['nam'])) {
                // Nếu nam là mảng, sử dụng IN
                $namList = array_map(array($db, 'quote'), $params['nam']);
                $query->where('a.nam IN (' . implode(',', $namList) . ')');
            } else {
                // Nếu nam là chuỗi, sử dụng =
                $query->where('a.nam = ' . $db->quote($params['nam']));
            }
        }

        if (empty($params['phuongxa_id']) && $phanquyen['phuongxa_id'] != '-1') {
            $query->where('a.phuongxa_id IN (' . str_replace("'", '', $db->quote($phanquyen['phuongxa_id'])) . ')');
        }
        if (!empty($params['thonto_id'])) {
            $query->where('c.thonto_id = ' . $db->quote($params['thonto_id']));
        }

        // Ghi log truy vấn để debug
        error_log('Query CountDanhSachGiaDinhVanHoa: ' . (string)$query);

        $db->setQuery($query);
        // echo $query;
        $result = $db->loadResult(); // Sử dụng loadResult thay vì loadAssocList cho COUNT
        return (int)$result; // Trả về số nguyên
    }
    public function getDetailGDVH($thonto_id, $nam)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();

        $query->select('a.*, dh.*');
        $query->from('vhxhytgd_giadinhvanhoa as a');
        $query->leftJoin('vhxhytgd_giadinhvanhoa2danhhieu as dh on dh.giadinhvanhoa_id = a.id');

        $query->where('a.daxoa = 0 and dh.daxoa = 0');
        $query->where('a.thonto_id = ' . $db->quote($thonto_id));
        $query->where('a.nam = ' . $db->quote($nam));

        // echo $query;exit;

        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getEditGiaDinhVanHoa($giadinhvanhoa_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*,a.thonto_id, a.id as giadinhvanhoa_id, dh.id as gdvanhoa2, dh.nhankhau_id, c.diachi, g.tenkhuvuc, gt.tengioitinh');
        $query->from('vhxhytgd_giadinhvanhoa as a');
        $query->innerJoin('vhxhytgd_giadinhvanhoa2danhhieu as dh on dh.giadinhvanhoa_id = a.id');
        $query->leftJoin('vptk_hokhau2nhankhau as b on dh.nhankhau_id = b.id');
        $query->leftJoin('vptk_hokhau AS c ON b.hokhau_id = c.id');
        $query->leftJoin('danhmuc_khuvuc AS g ON a.thonto_id = g.id');
        $query->leftJoin('danhmuc_gioitinh AS gt ON dh.n_gioitinh_id = gt.id');

        $query->where('a.daxoa = 0 and dh.daxoa = 0');
        $query->where('dh.giadinhvanhoa_id = ' . $db->quote($giadinhvanhoa_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function delGiaDinhVanHoa($giadinh_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $user_id = Factory::getUser()->id;

        $query->update('vhxhytgd_giadinhvanhoa2danhhieu');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = ' . $db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id =' . $db->quote($giadinh_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }

    public function removeGiaDinhVanHoa($giadinh_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $user_id = Factory::getUser()->id;

        $query->update('vhxhytgd_giadinhvanhoa');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = ' . $db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id =' . $db->quote($giadinh_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function getGiaDinhVH1nam($thonto_id, $nam)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select(
            $db->quoteName(array(
                'a.id',
                'dh.nhankhau_id',
                'dh.n_hoten',
                'dh.n_cccd',
                'dh.n_dienthoai',
                'dh.n_diachi',
                'dh.n_namsinh',
                'dh.n_gioitinh_id',
                'g.tengioitinh',
                'dh.is_dat',
                'dh.is_giadinhvanhoatieubieu',
                'dh.lydokhongdat',
                'dh.ghichu',
                'a.thonto_id',
                'a.nam',
                'dh.giadinhvanhoa_id'
            ))
        );
        $query->from($db->quoteName('vhxhytgd_giadinhvanhoa', 'a'));
        $query->innerJoin($db->quoteName('vhxhytgd_giadinhvanhoa2danhhieu', 'dh') . ' ON ' . $db->quoteName('dh.giadinhvanhoa_id') . ' = ' . $db->quoteName('a.id'));
        $query->leftJoin($db->quoteName('danhmuc_gioitinh', 'g') . ' ON ' . $db->quoteName('dh.n_gioitinh_id') . ' = ' . $db->quoteName('g.id'));

        // Thêm điều kiện where
        $query->where($db->quoteName('a.thonto_id') . ' = ' . $db->quote($thonto_id));
        $query->where($db->quoteName('a.nam') . ' = ' . $db->quote($nam));
        $query->where('a.daxoa = 0 and dh.daxoa = 0');

        // Debugging - hiển thị câu truy vấn
        // echo $query; exit;

        // Thực thi truy vấn
        $db->setQuery($query);
        try {
            $items = $db->loadAssocList();
            return array(
                'success' => true,
                'data' => $items
            );
        } catch (Exception $e) {
            return array(
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách gia đình văn hóa: ' . $e->getMessage()
            );
        }
    }
    public function getThongKeGiadinhvanhoa($params = array())
    {
        $db = Factory::getDbo();

        // Subquery
        $query_left = $db->getQuery(true);
        $query_left->select('
        IF(cs.is_dat = 1,1,0) as dat,
        IF(cs.is_dat = 0,1,0) as khongdat,
        cs.nhankhau_id as nhankhau_id, a.phuongxa_id,d.tenkhuvuc AS tenphuongxa,a.thonto_id,c.tenkhuvuc AS tenthonto');
        $query_left->from('vhxhytgd_giadinhvanhoa AS a');
        $query_left->innerJoin('vhxhytgd_giadinhvanhoa2danhhieu AS cs ON a.id = cs.giadinhvanhoa_id');
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
        if (!empty($params['nam'])) {
            $query_left->where('a.nam = ' . $db->quote($params['nam']));
        }


        // Query chính
        $query = $db->getQuery(true);
        $query->select(['a.id,a.cha_id,a.tenkhuvuc,a.level, SUM(ab.dat) as datgiai,SUM(ab.khongdat) as khongdatgiai, ab.nhankhau_id'])
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
        $nam = isset($filters['nam']) ? trim($filters['nam']) : '';
        $phuongxa_id = isset($filters['phuongxa_id']) ? (int)$filters['phuongxa_id'] : 0;
        $thonto_id = isset($filters['thonto_id']) ? (int)$filters['thonto_id'] : 0;

        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        // Select fields
        $query->select([
            'tt.tenkhuvuc as thonto',
            'dh.n_hoten',
            'DATE_FORMAT(dh.n_namsinh, "%d/%m/%Y") AS namsinh',
            'gt.tengioitinh',
            'dh.n_cccd',
            'DATE_FORMAT(hk.cccd_ngaycap, "%d/%m/%Y") AS cccd_ngaycap',
            'hk.cccd_coquancap',
            'dh.n_dienthoai',
            'a.nam',
            'dh.is_dat',
            'dh.is_giadinhvanhoatieubieu',
            'dh.lydokhongdat',
        ]);


        $query->from('vhxhytgd_giadinhvanhoa as a')
            ->leftJoin('vhxhytgd_giadinhvanhoa2danhhieu as dh on dh.giadinhvanhoa_id = a.id')
            ->leftJoin($db->quoteName('vptk_hokhau2nhankhau', 'hk') . ' ON hk.id = dh.nhankhau_id AND dh.is_ngoai = 0 AND hk.daxoa = 0')
            ->leftJoin('danhmuc_khuvuc AS tt ON a.thonto_id = tt.id')
            ->leftJoin('danhmuc_gioitinh AS gt ON dh.n_gioitinh_id = gt.id')
            ->where('a.daxoa = 0')
            ->where('dh.daxoa = 0');

        // Apply filters
        $phuongxaIds = !empty($phuongxa) && is_array($phuongxa)
            ? array_map('intval', array_column($phuongxa, 'id'))
            : [];

        if (!empty($phuongxa_id)) {
            $query->where('a.phuongxa_id = ' . (int)$phuongxa_id);
        } else {
            // Không có phường xã filter → dùng danh sách phân quyền
            if (!empty($phuongxaIds)) {
                $query->where('a.phuongxa_id IN (' . implode(',', $phuongxaIds) . ')');
            } else {
                // Nếu không có phân quyền nào thì có thể lấy tất cả hoặc 1=0 tùy yêu cầu
                $query->where('a.phuongxa_id IN (SELECT id FROM danhmuc_phuongxa WHERE daxoa = 0)');
            }
        }

        if ($thonto_id > 0) {
            $query->where($db->quoteName('a.thonto_id') . ' = ' . (int)$thonto_id);
        }

        if (!empty($nam)) {
            $query->where($db->quoteName('a.nam') . ' LIKE ' . $db->quote('%' . $db->escape($nam) . '%'));
        }

        $query->order($db->quoteName('a.id') . ' DESC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
}
