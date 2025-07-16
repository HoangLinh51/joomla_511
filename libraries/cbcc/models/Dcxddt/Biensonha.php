<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Dcxddt_Model_Biensonha extends JModelLegacy
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
    public function saveBiensonha($formData)
    {
        $db = Factory::getDbo();
        $user_id = Factory::getUser()->id;

        $fields_to_array = [
            'nam',
            'loaisohuu',
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
        $n = count($formData['loaisohuu']);
        if ($n === 0) {
            error_log('No valid records to process.');
            return false;
        }

        $phuongxa_id = isset($formData['phuongxa_id'][0]) ? strval($formData['phuongxa_id'][0]) : null;
        $thonto_id = isset($formData['thonto_id'][0]) ? strval($formData['thonto_id'][0]) : null;
        // Lưu vào bảng vhxhytgd_giadinhvanhoa
        $data = array(
            'id' => $formData['giadinhvanhoa'] ?? 0,
            'phuongxa_id' => $phuongxa_id ?? null,
            'thonto_id' => $thonto_id ?? null,
            'duong_id' => $formData['tuyenduong'] ?? null,
            'daxoa' => '0',
        );
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
            $query->insert($db->quoteName('dcxddtmt_thongtinsonha'))
                ->columns($data_insert_key)
                ->values(implode(',', $data_insert_val));
            // echo $query;
            // exit;
        } else {
            $query->update($db->quoteName('dcxddtmt_thongtinsonha'))
                ->set(implode(',', $data_update))
                ->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }

        $db->setQuery($query);
        $db->execute();

        if ((int) $data['id'] == 0) {
            $sonha_id = $db->insertid();
        } else {
            $sonha_id = $data['id'];
        }

        // Lưu vào bảng vhxhytgd_giadinhvanhoa2danhhieu
        for ($dt = 0; $dt < $n; $dt++) {
            // Kiểm tra trường bắt buộc (hoten hoặc cccd_so)
            if (empty($formData['loaisohuu'][$dt])) {
                continue;
            }
            $dbs = Factory::getDbo();
            $querys = $dbs->getQuery(true);

            // Convert array fields to strings or select first element
            $toado1 = is_array($formData['toado1']) ? ($formData['toado1'][$dt] ?? null) : $formData['toado1'];
            $toado2 = is_array($formData['toado2']) ? ($formData['toado2'][$dt] ?? null) : $formData['toado2'];
            $tentochuc = is_array($formData['tentochuc']) ? ($formData['tentochuc'][$dt] ?? null) : $formData['tentochuc'];
            $hinhthuccap = is_array($formData['hinhthuccap']) ? ($formData['hinhthuccap'][$dt] ?? null) : $formData['hinhthuccap'];
            $nhankhau_id = is_array($formData['nhankhau_id']) ? ($formData['nhankhau_id'][$dt] ?? null) : $formData['nhankhau_id'];
            $phuongxa_id = is_array($formData['phuongxa_id']) ? ($formData['phuongxa_id'][$dt] ?? null) : $formData['phuongxa_id'];
            $thonto_id = is_array($formData['thonto_id']) ? ($formData['thonto_id'][$dt] ?? null) : $formData['thonto_id'];
            $dienthoai = is_array($formData['dienthoai']) ? ($formData['dienthoai'][$dt] ?? null) : $formData['dienthoai'];
            $dienthoai_tochuc = is_array($formData['dienthoai_tochuc']) ? ($formData['dienthoai_tochuc'][$dt] ?? null) : $formData['dienthoai_tochuc'];
            $diachi = is_array($formData['diachi']) ? ($formData['diachi'][$dt] ?? null) : $formData['diachi'];
            $diachi_tochuc = is_array($formData['diachi_tochuc']) ? ($formData['diachi_tochuc'][$dt] ?? null) : $formData['diachi_tochuc'];
            $final_diachi = !empty($diachi) ? $diachi : $diachi_tochuc;
            $final_dienthoai = !empty($dienthoai) ? $dienthoai : $dienthoai_tochuc;




            $data_chuyennganh[$dt] = array(
                'id' => $formData['id_sonha2'][$dt] ?? 0,
                'sonha_id' => $sonha_id,
                'sonha' => $formData['sonha'][$dt] ?? null,
                'thuadatso' => $formData['thuadat'][$dt] ?? null,
                'tobandoso' => $formData['tobando'][$dt] ?? null,
                'lydothaydoi' => $formData['lydothaydoi'][$dt] ?? '',
                'ghichu' => $formData['ghichu'][$dt] ?? '',
                'toado1' => $toado1,
                'toado2' => $toado2,
                'tentochuc' => $tentochuc,
                'hinhthuccap_id' => $hinhthuccap,
                'nhankhau_id' => $nhankhau_id,
                'daxoa' => '0',
                'n_hoten' => $formData['hoten'][$dt] ?? null,
                'n_gioitinh_id' => $formData['gioitinh_id'][$dt] ?? null,
                'n_cccd' => $formData['cccd_so'][$dt] ?? null,
                'n_dienthoai' => $final_dienthoai,
                'n_diachi' => $final_diachi,

                'n_phuongxa_id' => $phuongxa_id,
                'n_thonto_id' => $thonto_id,
                'n_namsinh' => $formData['ngaysinh'][$dt] ?? null,
                'is_loai' => $formData['loaisohuu'][$dt] ?? null,
                'is_ngoai' => $formData['is_search'][$dt] ?? '0',
            );
            $data['is_ngoai'] = empty($data['nhankhau_id']) ? 1 : 0;

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
                $querys->insert($dbs->quoteName('dcxddtmt_sonha2tenduong'))
                    ->columns($data_chuyennganh_insert_key[$dt])
                    ->values(implode(',', $data_chuyennganh_insert_val[$dt]));
            } else {
                $querys->update($dbs->quoteName('dcxddtmt_sonha2tenduong'))
                    ->set(implode(',', $data_chuyennganh_update[$dt]))
                    ->where(array($dbs->quoteName('id') . '=' . $dbs->quote($data_chuyennganh[$dt]['id'])));
            }
            // exit;
            $dbs->setQuery($querys);
            $dbs->execute();
        }
        // exit;
        return true;
    }
    public function getDanhSachBienSoNha($params = array(), $startFrom = 0, $perPage = 20)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();

        $query->select('a.thonto_id, a.id, dh.nhankhau_id, dh.n_diachi, COUNT(dh.id) AS so_nguoi, g.tenkhuvuc, td.tenduong, dh.id as sonha2_id');
        $query->from('dcxddtmt_thongtinsonha as a');
        $query->innerJoin('dcxddtmt_sonha2tenduong as dh on dh.sonha_id = a.id');
        $query->leftJoin('danhmuc_khuvuc AS g ON a.thonto_id = g.id');
        $query->leftJoin('danhmuc_tenduong AS td ON a.duong_id = td.id');
        $query->where('a.daxoa = 0 and dh.daxoa = 0');
        $query->group('g.tenkhuvuc, a.id');
        $query->order('so_nguoi DESC');

        // Kiểm tra phuongxa_id trong params trước khi sử dụng phanquyen
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


    public function CountDanhSachBienSoNha($params = array())
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();

        $query->select('COUNT(DISTINCT a.id)');
        $query->from('dcxddtmt_thongtinsonha as a');
        $query->innerJoin('dcxddtmt_sonha2tenduong as dh on dh.sonha_id = a.id');
        $query->leftJoin('danhmuc_khuvuc AS g ON a.thonto_id = g.id');
        $query->where('a.daxoa = 0');

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
    public function getDetailBSN($sonha_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();

        $query->select('a.*,ht.tenhinhthuc, dh.*');
        $query->from('dcxddtmt_thongtinsonha as a');
        $query->leftJoin('dcxddtmt_sonha2tenduong as dh on dh.sonha_id = a.id');
        $query->leftJoin('danhmuc_hinhthuccapsonha AS ht ON dh.hinhthuccap_id = ht.id');

        $query->where('a.daxoa = 0 and dh.daxoa = 0');
        $query->where('a.id = ' . $db->quote($sonha_id));
        // echo $query;exit;

        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getEditBienSonha($bsn_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.thonto_id,a.phuongxa_id,a.duong_id, a.id, dh.nhankhau_id,ht.tenhinhthuc,
       dh.n_diachi,dh.*, dh.id as id_sonha2');
        $query->from('dcxddtmt_thongtinsonha as a');
        $query->innerJoin('dcxddtmt_sonha2tenduong as dh on dh.sonha_id = a.id');
        $query->leftJoin('danhmuc_khuvuc AS g ON a.thonto_id = g.id');
        $query->leftJoin('danhmuc_tenduong AS td ON a.duong_id = td.id');
        $query->leftJoin('danhmuc_hinhthuccapsonha AS ht ON dh.hinhthuccap_id = ht.id');

        $query->where('a.daxoa = 0 and dh.daxoa = 0');
        $query->where('a.id = ' . $db->quote($bsn_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function delSonha($sonha_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $user_id = Factory::getUser()->id;

        $query->update('dcxddtmt_sonha2tenduong');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = ' . $db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id =' . $db->quote($sonha_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }

    public function removeBienSoNha($sonha_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $user_id = Factory::getUser()->id;

        $query->update('dcxddtmt_thongtinsonha');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = ' . $db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id =' . $db->quote($sonha_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function checkBienSoNha($thonto_id, $tuyenduong)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.thonto_id,a.phuongxa_id,a.duong_id, a.id, dh.nhankhau_id,ht.tenhinhthuc,
       dh.n_diachi, dh.id as id_sonha2');
        $query->from('dcxddtmt_thongtinsonha as a');
        $query->innerJoin('dcxddtmt_sonha2tenduong as dh on dh.sonha_id = a.id');
        $query->leftJoin('danhmuc_khuvuc AS g ON a.thonto_id = g.id');
        $query->leftJoin('danhmuc_tenduong AS td ON a.duong_id = td.id');
        $query->leftJoin('danhmuc_hinhthuccapsonha AS ht ON dh.hinhthuccap_id = ht.id');

        $query->where('a.daxoa = 0 and dh.daxoa = 0');

        // Thêm điều kiện where
        $query->where($db->quoteName('a.thonto_id') . ' = ' . $db->quote($thonto_id));
        $query->where($db->quoteName('a.duong_id') . ' = ' . $db->quote($tuyenduong));
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
    public function getThongKeBiensonha($params = array())
    {
        $db = Factory::getDbo();

        // Subquery
        $query_left = $db->getQuery(true);
        $query_left->select([
            'a.phuongxa_id',
            'px.tenkhuvuc AS phuongxa',
            'a.thonto_id',
            'f.tenkhuvuc AS thonto',
           
            'SUM(CASE WHEN b.hinhthuccap_id = 4 THEN 1 ELSE 0 END) AS capmoi',
            'SUM(CASE WHEN b.hinhthuccap_id = 5 THEN 1 ELSE 0 END) AS caplai'
        ]);
        $query_left->from('dcxddtmt_thongtinsonha AS a')
            ->innerJoin('dcxddtmt_sonha2tenduong AS b ON a.id = b.sonha_id')
        
            ->innerJoin('danhmuc_khuvuc AS f ON a.thonto_id = f.id')
            ->innerJoin('danhmuc_khuvuc AS px ON a.phuongxa_id = px.id')
            ->where('a.daxoa = 0 AND b.daxoa = 0');

        // Điều kiện WHERE cho subquery
        if (!empty($params['phuongxa_id'])) {
            $query_left->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }

        if (!empty($params['thonto_id'])) {
            $thonto_ids = is_array($params['thonto_id']) ?
                $params['thonto_id'] :
                explode(',', $params['thonto_id']);
            $query_left->where('a.thonto_id IN (' . implode(',', array_map([$db, 'quote'], $thonto_ids)) . ')');
        }

        $query_left->group(['a.phuongxa_id', 'a.thonto_id']);

        // Query chính
        $query = $db->getQuery(true);
        $query->select([
            'a.id',
            'a.cha_id',
            'a.tenkhuvuc',
            'a.level',
           
            'IFNULL(SUM(ab.capmoi), 0) AS capmoi',
            'IFNULL(SUM(ab.caplai), 0) AS caplai'
            
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
