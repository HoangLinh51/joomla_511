<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Taichinh_Model_Nopthue extends JModelLegacy
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
    public function saveNopThueDat($formData)
    {
        $db = Factory::getDbo();
        $user_id = Factory::getUser()->id;

        // Tính số lượng bản ghi cần xử lý (dựa trên hoten thay vì nhanhokhau_id)
        $n = count($formData['maphinongnghiep']);
        if ($n === 0) {
            error_log('No valid records to process.');
            return false;
        }
        $ngaysinh = !empty($formData['input_namsinh'])
            ? DateTime::createFromFormat('d/m/Y', $formData['input_namsinh'])
            : (!empty($formData['select_namsinh']) ? DateTime::createFromFormat('d/m/Y', $formData['select_namsinh']) : false);

        $data = array(
            'id' => $formData['id_thuedat'] ?? 0,
            'nhanhokhau_id' => !empty($formData['nhanhokhau_id']) ? $formData['nhanhokhau_id'] : 0,
            'phuongxa_id' => !empty($formData['input_phuongxa_id']) ? $formData['input_phuongxa_id'] : $formData['select_phuongxa_id'] ?? null,
            'thonto_id' => !empty($formData['input_thonto_id']) ? $formData['input_thonto_id'] : $formData['select_thonto_id'] ?? null,
            'n_hoten' => $formData['hoten'][0] ?? null,
            'n_gioitinh_id' => !empty($formData['input_gioitinh_id']) ? $formData['input_gioitinh_id'] : $formData['select_gioitinh_id'] ?? null,
            'n_dantoc_id' => !empty($formData['input_dantoc_id']) ? $formData['input_dantoc_id'] : $formData['select_dantoc_id'] ?? null,
            'n_cccd' => $formData['cccd'] ?? null,
            'n_phuongxa_id' => !empty($formData['input_phuongxa_id']) ? $formData['input_phuongxa_id'] : $formData['select_phuongxa_id'] ?? null,
            'n_thonto_id' => !empty($formData['input_thonto_id']) ? $formData['input_thonto_id'] : $formData['select_thonto_id'] ?? null,
            'n_namsinh' => $ngaysinh ? $ngaysinh->format('Y-m-d') : null,
            'n_dienthoai' => $formData['dienthoai'][0] ?? null,
            'n_diachi' => $formData['diachi'][0] ?? null,
            'is_ngoai' => null,
            'masothue' => $formData['masothue'] ?? null,
            'daxoa' => '0',
        );
        $data['is_ngoai'] = empty($data['nhanhokhau_id']) ? 1 : 0;

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
            $query->insert($db->quoteName('tckt_nopthuedat'))
                ->columns($data_insert_key)
                ->values(implode(',', $data_insert_val));
            // echo $query;
            // exit;
        } else {
            $query->update($db->quoteName('tckt_nopthuedat'))
                ->set(implode(',', $data_update))
                ->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }

        $db->setQuery($query);
        $db->execute();

        if ((int) $data['id'] == 0) {
            $nopthuedat_id = $db->insertid();
        } else {
            $nopthuedat_id = $data['id'];
        }

        for ($dt = 0; $dt < $n; $dt++) {
            if (empty($formData['maphinongnghiep'][$dt])) {
                continue;
            }
            $dbs = Factory::getDbo();
            $querys = $dbs->getQuery(true);
            $ngaycap = !empty($formData['ngaycap'][$dt]) ? DateTime::createFromFormat('d/m/Y', $formData['ngaycap'][$dt]) : false;

            $data_chuyennganh[$dt] = array(
                'id' => $formData['chitiet_id'][$dt] ?? null,
                'nopthuedat_id' => $nopthuedat_id,
                'maphinongnghiep' => $formData['maphinongnghiep'][$dt] ?? null,
                'diachi' => $formData['thuadat'][$dt] ?? null,
                'tobando' => $formData['tobando'][$dt] ?? '',
                'thuadat' => $formData['thuadat'][$dt] ?? '',
                'daxoa' => '0',
                'sogcn' => $formData['sogiaychungnhan'][$dt] ?? null,
                'ngaycn' => $ngaycap ? $ngaycap->format('Y-m-d') : null,
                'tenduong_id' => $formData['tenduong'][$dt] ?? null,
                'dientich_gcn' =>  $formData['dientichcogcn'][$dt] ?? null,
                'dientich_ccn' => $formData['dientichchuacogcn'][$dt] ?? null,
                'mucdichsudung_id' => $formData['mucdichsudung'][$dt] ?? null,
                'sotienmiengiam' => $formData['miengiamthue'][$dt] ?? null,
                'tongtiennop' => $formData['tongtien'][$dt] ?? null,
                'tinhtrang' => $formData['tinhtrang'][$dt] ?? null,
                'ghichu' => $formData['ghichu'][$dt] ?? null,
                'dientich_sd' => $formData['dientichsd'][$dt] ?? null
            );
            if ((int) $data_chuyennganh[$dt]['id'] == 0) {
                $data_chuyennganh[$dt]['nguoitao_id'] = $user_id;
                $data_chuyennganh[$dt]['ngaytao'] = 'NOW()';
            } else {
                $data_chuyennganh[$dt]['nguoixoa_id'] = $user_id;
                $data_chuyennganh[$dt]['nguoihieuchinh_id'] = $user_id;
                $data_chuyennganh[$dt]['ngayhieuchinh'] = 'NOW()';
            }

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
                $querys->insert($dbs->quoteName('tckt_chitietnopthue'))
                    ->columns($data_chuyennganh_insert_key[$dt])
                    ->values(implode(',', $data_chuyennganh_insert_val[$dt]));
            } else {
                $querys->update($dbs->quoteName('tckt_chitietnopthue'))
                    ->set(implode(',', $data_chuyennganh_update[$dt]))
                    ->where(array($dbs->quoteName('id') . '=' . $dbs->quote($data_chuyennganh[$dt]['id'])));
            }
            // echo $querys;

            // exit;
            $dbs->setQuery($querys);
            $dbs->execute();
        }
        // exit;
        return true;
    }
    public function getDanhSachNopThue($params = array(), $startFrom = 0, $perPage = 20)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();
        if (!empty($phanquyen['phuongxa_id']) && (string)$phanquyen['phuongxa_id'] !== '-1') {
            $mang_id  = array_map('trim', explode(',', $phanquyen['phuongxa_id']));
            $list_id  = implode(',', array_map([$db, 'quote'], $mang_id));
        }
        $query->select('a.thonto_id,a.masothue,a.n_hoten,a.n_dienthoai,   a.id, a.nhanhokhau_id, a.n_diachi, COUNT(dh.id) AS so_nguoi, g.tenkhuvuc, td.tenduong, dh.id as chitiet_id');
        $query->from('tckt_nopthuedat as a');
        $query->innerJoin('tckt_chitietnopthue as dh on dh.nopthuedat_id = a.id');
        $query->leftJoin('danhmuc_khuvuc AS g ON a.thonto_id = g.id');
        $query->leftJoin('danhmuc_tenduong AS td ON dh.tenduong_id = td.id');
        $query->where('a.daxoa = 0 and dh.daxoa = 0');
        $query->group('g.tenkhuvuc, a.id');
        $query->order('so_nguoi DESC');

        // Kiểm tra phuongxa_id trong params trước khi sử dụng phanquyen
        if (!empty($params['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        } elseif (!empty($list_id)) {
            $query->where('a.phuongxa_id IN (' . $list_id . ')');
        }
        if (!empty($params['thonto_id'])) {
            $query->where('a.thonto_id = ' . $db->quote($params['thonto_id']));
        }
        if (!empty($params['hoten'])) {
            $query->where('a.n_hoten COLLATE utf8mb4_unicode_ci LIKE ' . $db->quote('%' . $params['hoten'] . '%'));
        }
        if (isset($params['cccd']) && $params['cccd'] !== 0) {
            $query->where('a.n_cccd COLLATE utf8mb4_unicode_ci LIKE ' . $db->quote('%' . $params['cccd'] . '%'));
        }


        // Đảm bảo $perPage và $startFrom là số nguyên
        $perPage = (int)$perPage;
        $startFrom = (int)$startFrom;
        if ($perPage > 0) {
            $query->setLimit($perPage, $startFrom);
        }
        // echo $query;

        // Ghi log truy vấn để debug
        $db->setQuery($query);
        return $db->loadAssocList();
    }


    public function CountDanhSachNopThue($params = array())
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();

        $query->select('COUNT(DISTINCT a.id)');
        $query->from('tckt_nopthuedat as a');
        $query->innerJoin('tckt_chitietnopthue as dh on dh.nopthuedat_id = a.id');
        $query->leftJoin('danhmuc_khuvuc AS g ON a.thonto_id = g.id');
        $query->leftJoin('danhmuc_tenduong AS td ON dh.tenduong_id = td.id');
        $query->where('a.daxoa = 0 and dh.daxoa = 0');

        if (!empty($params['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        } elseif (isset($phanquyen['phuongxa_id']) && (string)$phanquyen['phuongxa_id'] !== '-1') {
            $query->where('a.phuongxa_id = ' . $db->quote($phanquyen['phuongxa_id']));
        }
        if (!empty($params['tenduong'])) {
            $query->where('a.duong_id = ' . $db->quote($params['tenduong']));
        }
        if (!empty($params['thonto_id'])) {
            $query->where('a.thonto_id = ' . $db->quote($params['thonto_id']));
        }


        $db->setQuery($query);
        // echo $query;
        $result = $db->loadResult(); // Sử dụng loadResult thay vì loadAssocList cho COUNT
        return (int)$result; // Trả về số nguyên
    }
    public function getDetailthuedat($thuedat_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();

        $query->select('a.thonto_id,dh.tenduong_id,dh.mucdichsudung_id, a.id, dh.dientich_gcn,dh.tinhtrang, dh.ghichu, dh.sotienmiengiam,dh.tongtiennop, dh.dientich_ccn,md.tenmucdich, dh.dientich_sd, dh.sogcn,dh.tobando, dh.thuadat, DATE_FORMAT(dh.ngaycn, "%d/%m/%Y") AS ngaycn, a.nhanhokhau_id,a.masothue,dh.maphinongnghiep, dh.diachi, a.n_diachi,  td.tenduong, dh.id as chitiet_id');
        $query->from('tckt_nopthuedat as a');
        $query->leftJoin('tckt_chitietnopthue as dh on dh.nopthuedat_id = a.id');
        $query->leftJoin('danhmuc_mucdichsudung AS md ON dh.mucdichsudung_id = md.id');
        $query->leftJoin('danhmuc_tenduong AS td ON dh.tenduong_id = td.id');

        $query->where('a.daxoa = 0 and dh.daxoa = 0');
        $query->where('a.id = ' . $db->quote($thuedat_id));
        // echo $query;exit;

        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getEditNopThue($thuedat_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.n_hoten,a.n_gioitinh_id, a.n_cccd,a.n_dantoc_id,a.n_dienthoai,a.n_phuongxa_id, a.n_thonto_id,a.n_diachi,DATE_FORMAT(a.n_namsinh, "%d/%m/%Y") AS ngaysinh,   a.thonto_id,dh.tenduong_id,dh.mucdichsudung_id, a.id, dh.dientich_gcn,dh.tinhtrang, dh.ghichu, dh.sotienmiengiam,dh.tongtiennop, dh.dientich_ccn,md.tenmucdich, dh.dientich_sd, dh.sogcn,dh.tobando, dh.thuadat, DATE_FORMAT(dh.ngaycn, "%d/%m/%Y") AS ngaycn, a.nhanhokhau_id,a.masothue,dh.maphinongnghiep, dh.diachi, a.n_diachi,  td.tenduong, dh.id as chitiet_id');
        $query->from('tckt_nopthuedat as a');
        $query->innerJoin('tckt_chitietnopthue as dh on dh.nopthuedat_id = a.id');
        $query->leftJoin('danhmuc_khuvuc AS g ON a.thonto_id = g.id');
        $query->leftJoin('danhmuc_tenduong AS td ON dh.tenduong_id = td.id');
        $query->leftJoin('danhmuc_mucdichsudung AS md ON dh.mucdichsudung_id = md.id');

        $query->where('a.daxoa = 0 and dh.daxoa = 0');
        $query->where('a.id = ' . $db->quote($thuedat_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function delThongtinnopthue($nopthue_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $user_id = Factory::getUser()->id;

        $query->update('tckt_chitietnopthue');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = ' . $db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id =' . $db->quote($nopthue_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }

    public function removeNopThue($nopthue_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $user_id = Factory::getUser()->id;

        $query->update('tckt_nopthuedat');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = ' . $db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id =' . $db->quote($nopthue_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function checkNopThue($nhankhau_id, $table)
    {
        // Get database object
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('COUNT(*)')
            ->from($db->quoteName('tckt_nopthuedat'))
            ->where($db->quoteName('nhanhokhau_id') . ' = ' . (int)$nhankhau_id)
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
    public function getThongKeNopThue($params = array())
    {
        $db = Factory::getDbo();

        // Subquery
        $query_left = $db->getQuery(true);
        $query_left->select([
            'h.phuongxa_id',
            'px.tenkhuvuc AS phuongxa',
            'h.thonto_id',
            'f.tenkhuvuc AS thonto',
            'COUNT(b.id) AS tong',
            'SUM(b.tongtiennop) AS tongtiennop' // Thêm tổng số tiền nộp
        ]);
        $query_left->from('tckt_nopthuedat AS a')
            ->innerJoin('tckt_chitietnopthue AS b ON a.id = b.nopthuedat_id')
            ->innerJoin('vptk_hokhau2nhankhau AS d ON a.nhanhokhau_id = d.id')
            ->innerJoin('vptk_hokhau AS h ON d.hokhau_id = h.id')
            ->innerJoin('danhmuc_khuvuc AS f ON h.thonto_id = f.id')
            ->innerJoin('danhmuc_khuvuc AS px ON h.phuongxa_id = px.id')
            ->where('a.daxoa = 0 AND b.daxoa = 0');

        // Điều kiện WHERE cho subquery
        if (!empty($params['phuongxa_id'])) {
            $query_left->where($db->quoteName('a.phuongxa_id') . ' = ' . $db->quote($params['phuongxa_id']));
        }
        if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
            $query_left->where($db->quoteName('a.thonto_id') . ' IN (' . implode(',', array_map([$db, 'quote'], $params['thonto_id'])) . ')');
        }

        if (!empty($params['duong_id'])) {
            $query_left->where('b.duong_id = ' . $db->quote($params['duong_id']));
        }

        if (!empty($params['nam'])) {
            $query_left->where('b.nam = ' . $db->quote($params['nam']));
        }

        // Phân quyền


        $query_left->group(['h.phuongxa_id', 'h.thonto_id']);

        // Query chính
        $query = $db->getQuery(true);
        $query->select([
            'a.id',
            'a.cha_id',
            'a.tenkhuvuc',
            'a.level',
            'IFNULL(SUM(ab.tong), 0) AS tong',
            'IFNULL(SUM(ab.tongtiennop), 0) AS tongtiennop', // Thêm tổng số tiền nộp
            'CONCAT(FORMAT(IFNULL(SUM(ab.tongtiennop), 0), 0)) AS tongtiennop_formatted' // Định dạng số tiền
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

        // Format lại số tiền nếu muốn xử lý thêm trong PHP
        foreach ($results as &$result) {
            $result['tongtiennop_formatted_php'] = number_format($result['tongtiennop'], 0, ',', '.') . ' VNĐ';
        }

        return $results;
    }

    public function getDanhSachXuatExcel($filters, $phuongxa)
    {
        $hoten = isset($filters['hoten']) ? trim($filters['hoten']) : '';
        $cccd = isset($filters['cccd']) ? trim($filters['cccd']) : '';
        $phuongxa_id = isset($filters['phuongxa_id']) ? (int)$filters['phuongxa_id'] : 0;
        $thonto_id = isset($filters['thonto_id']) ? (int)$filters['thonto_id'] : 0;

        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        // Select fields
        $query->select([
            'a.masothue',
            'a.n_hoten',
            'dh.maphinongnghiep',
            'dh.diachi',
            'dh.sogcn',
            'DATE_FORMAT(dh.ngaycn, "%d/%m/%Y") AS ngaycn',
            'dh.thuadat',
            'dh.tobando',
            'td.tenduong',
            'dh.dientich_gcn',
            'dh.dientich_ccn',
            'dh.dientich_sd',
            'dh.sotienmiengiam',
            'dh.tongtiennop',
            'dh.tinhtrang',
        ]);

        $query->from('tckt_nopthuedat as a');
        $query->innerJoin('tckt_chitietnopthue as dh on dh.nopthuedat_id = a.id');
        $query->leftJoin('danhmuc_tenduong AS td ON dh.tenduong_id = td.id');
        $query->where('a.daxoa = 0 and dh.daxoa = 0');



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
            $query->where('a.n_hoten COLLATE utf8mb4_unicode_ci LIKE ' . $db->quote('%' . $hoten . '%'));
        }
        if (!empty($cccd)) {
            $query->where('a.n_cccd COLLATE utf8mb4_unicode_ci LIKE ' . $db->quote('%' . $cccd . '%'));
        }
        $query->order('a.id DESC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
}
