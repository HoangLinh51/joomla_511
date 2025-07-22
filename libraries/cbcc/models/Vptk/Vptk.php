<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Vptk_Model_Vptk extends JModelLegacy
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
    public function getDanhsachNhanHoKhau($params = array(), $startFrom, $perPage = 100)
    {
        $phanquyen = $this->getPhanquyen();
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.id,
        a.hokhau_so,
        DATE_FORMAT(a.hokhau_ngaycap,"%d/%m/%Y") AS hokhau_ngaycap,
        b.hoten AS hotenchuho,
        IF(b.gioitinh_id = 1, "Nam", IF(b.gioitinh_id = 2, "Nữ", "Không xác định")) as tengioitinh,
        CONCAT(a.diachi, ", ", d.tenkhuvuc, ", ", c.tenkhuvuc) AS diachi, 
        b.dienthoai,
        DATE_FORMAT(b.ngaysinh,"%d/%m/%Y") AS namsinh');
        $query->from('vptk_hokhau AS a');
        $query->innerJoin('vptk_hokhau2nhankhau AS b ON b.quanhenhanthan_id = -1 AND b.daxoa = 0 AND a.id = b.hokhau_id');
        $query->innerJoin('danhmuc_khuvuc AS c ON c.id = a.phuongxa_id');
        $query->innerJoin('danhmuc_khuvuc AS d ON d.id = a.thonto_id');


        if (!empty($params['hokhau_so'])) {
            $query->where('a.hokhau_so = ' . $db->quote($params['hokhau_so']));
        }
        if (!empty($params['hoten'])) {
            $hoten = $db->quote('%' . $params['hoten'] . '%');
            $query->where('b.hoten LIKE ' . $hoten);
        }
        if (!empty($params['gioitinh_id'])) {
            $query->where('b.gioitinh_id = ' . $db->quote($params['gioitinh_id']));
        }
        if (!empty($params['is_tamtru'])) {
            $query->where('b.is_tamtru = ' . $db->quote($params['is_tamtru']));
        }
        if (!empty($params['thonto_id'])) {
            $query->where('a.thonto_id = ' . $db->quote($params['thonto_id']));
        }
        if (!empty($params['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        } elseif ($phanquyen['phuongxa_id'] != '-1') {
            $query->where('a.phuongxa_id = ' . $db->quote($phanquyen['phuongxa_id']));
        }
        if (isset($params['daxoa']) && $params['daxoa'] == '1') {
            $query->where('a.daxoa = 1');
        } else {
            $query->where('a.daxoa = 0');
        }
        if (!empty($params['cccd_so'])) {
            $query->where('b.cccd_so = ' . $db->quote($params['cccd_so']));
        }

        if (!empty($params['diachi'])) {
            $diachi = $db->quote('%' . $params['diachi'] . '%');
            $query->where('a.diachi LIKE ' . $diachi);
        }
        if ($startFrom !== null) {
            $query->order('id ASC')->setLimit($perPage, $startFrom);
        } else {
            $query->order('id ASC')->setLimit($perPage, 0);
        }

        // Debug query
        // echo $query->dump();
        // exit;

        $db->setQuery($query);
        try {
            return $db->loadAssocList();
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage('SQL Error: ' . $e->getMessage(), 'error');
            return [];
        }
    }
    public function countitems($params = array())
    {
        $phanquyen = $this->getPhanquyen();
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('COUNT(*) AS tongnhankhau');
        $query->from('vptk_hokhau AS a');

        if (isset($phanquyen['phuongxa_id']) && (string)$phanquyen['phuongxa_id'] !== '-1') {
            $query->where('a.phuongxa_id = ' . $db->quote($phanquyen['phuongxa_id']));
        }
        $query->where('a.daxoa = 0');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDetailNhanHoKhau($hokhauId)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.id, a.hoten, DATE_FORMAT(a.ngaysinh, "%d/%m/%Y") AS ngaysinh, DATE_FORMAT(a.cccd_ngaycap, "%d/%m/%Y") AS cccd_ngaycap,a.cccd_coquancap,a.is_tamtru, b.tengioitinh, a.cccd_so, a.dienthoai, 
            d.tendantoc, e.tentongiao, CONCAT(c.diachi, " - ", g.tenkhuvuc, " - ", f.tenkhuvuc) AS diachi, k.tennghenghiep,c.hokhau_coquancap,CONCAT(a.thuongtrucu_diachi, " - ", px.tenphuongxa, " - ", tt.tentinhthanh) AS diachi_cu,
            c.phuongxa_id, c.thonto_id, a.gioitinh_id,a.lydoxoathuongtru_id, g.tenkhuvuc as tenthonto, a.quanhenhanthan_id, h.tenquanhenhanthan, c.hokhau_so, DATE_FORMAT(c.hokhau_ngaycap, "%d/%m/%Y") AS hokhau_ngaycap, j.tentrinhdohocvan,qt.tenquoctich, qt.icon,a.trangthaihoso,nm.name as tennhommau, l.tenlydo ');
        $query->from('vptk_hokhau2nhankhau AS a');
        $query->innerJoin('danhmuc_gioitinh AS b ON a.gioitinh_id = b.id');
        $query->innerJoin('vptk_hokhau AS c ON a.hokhau_id = c.id');
        $query->innerJoin('danhmuc_dantoc AS d ON a.dantoc_id = d.id');
        $query->leftJoin('danhmuc_tongiao AS e ON a.tongiao_id = e.id');
        $query->innerJoin('danhmuc_khuvuc AS f ON c.phuongxa_id = f.id');
        $query->innerJoin('danhmuc_khuvuc AS g ON c.thonto_id = g.id');
        $query->innerJoin('danhmuc_quanhenhanthan AS h ON h.id = a.quanhenhanthan_id');
        $query->leftJoin('danhmuc_trinhdohocvan AS j ON j.id = a.trinhdohocvan_id');
        $query->leftJoin('danhmuc_nghenghiep AS k ON k.id = a.nghenghiep_id');
        $query->leftJoin('danhmuc_quoctich AS qt ON qt.id = a.quoctich_id');
        $query->leftJoin('danhmuc_phuongxa AS px ON a.thuongtrucu_phuongxa_id = px.id');
        $query->leftJoin('danhmuc_tinhthanh AS tt ON a.thuongtrucu_tinhthanh_id = tt.id');
        $query->leftJoin('danhmuc_quanhuyen AS qh ON a.thuongtrucu_quanhuyen_id = qh.id');
        $query->leftjoin('danhmuc_nhommau as nm on nm.code = a.nhommau_id');
        $query->leftjoin('danhmuc_lydoxoathuongtru as l on l.id = a.lydoxoathuongtru_id');


        $query->where('a.hokhau_id = ' . $db->quote($hokhauId));
        $query->where('a.daxoa = 0');
        $query->order('a.id ASC');
        // echo $query;
        $db->setQuery($query);
        try {
            $results = $db->loadAssocList();
            return is_array($results) ? $results : []; // Đảm bảo luôn trả về mảng
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage('SQL Error: ' . $e->getMessage(), 'error');
            return [];
        }
    }
    public function removeNhanhokhau($hokhau_id, $user_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vptk_hokhau');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = ' . $db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id =' . $db->quote($hokhau_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function removeNhankhau($nhankhau_id, $user_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vptk_hokhau2nhankhau');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = ' . $db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id =' . $db->quote($nhankhau_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function getItems($filters)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();

        $query->select('a.id,
        a.hokhau_so,
        DATE_FORMAT(a.hokhau_ngaycap,"%d/%m/%Y") AS hokhau_ngaycap,
        b.hoten,b.quanhenhanthan_id,qh.tenquanhenhanthan,b.cccd_so, DATE_FORMAT(b.cccd_ngaycap,"%d/%m/%Y") AS cccd_ngaycap,b.cccd_coquancap,
        IF(b.gioitinh_id = 1, "Nam", IF(b.gioitinh_id = 2, "Nữ", "Không xác định")) as tengioitinh,dt.tendantoc,td.tentongiao, hv.tentrinhdohocvan, nn.tennghenghiep, 
        CONCAT(a.diachi, ", ", d.tenkhuvuc, ", ", c.tenkhuvuc) AS diachi, 
        CONCAT(b.thuongtrucu_diachi, ", ", d1.tenkhuvuc, ", ", c1.tenkhuvuc) AS diachi1, ld.tenlydo,

        b.dienthoai,
        DATE_FORMAT(b.ngaysinh,"%d/%m/%Y") AS namsinh');
        $query->from('vptk_hokhau AS a');
        $query->innerJoin('vptk_hokhau2nhankhau AS b ON  b.daxoa = 0 AND a.id = b.hokhau_id');
        $query->innerJoin('danhmuc_khuvuc AS c ON c.id = a.phuongxa_id');
        $query->innerJoin('danhmuc_khuvuc AS d ON d.id = a.thonto_id');
        $query->innerJoin('danhmuc_quanhenhanthan AS qh ON qh.id = b.quanhenhanthan_id');
        $query->innerJoin('danhmuc_dantoc AS dt ON dt.id = b.dantoc_id');
        $query->leftJoin('danhmuc_tongiao AS td ON td.id = b.tongiao_id');
        $query->leftJoin('danhmuc_trinhdohocvan AS hv ON hv.id = b.trinhdohocvan_id');
        $query->leftJoin('danhmuc_nghenghiep AS nn ON nn.id = b.nghenghiep_id');
        $query->leftJoin('danhmuc_khuvuc AS c1 ON c1.id = b.thuongtrucu_phuongxa_id');
        $query->leftJoin('danhmuc_khuvuc AS d1 ON d1.id = b.thuongtrucu_thonto_id');
        $query->leftJoin('danhmuc_lydoxoathuongtru AS ld ON ld.id = b.lydoxoathuongtru_id');
        if (!empty($filters['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($filters['phuongxa_id']));
        } elseif ($phanquyen['phuongxa_id'] != '-1') {
            $query->where('a.phuongxa_id = ' . $db->quote($phanquyen['phuongxa_id']));
        }

        if (!empty($filters['hoten'])) {
            $query->where($db->quoteName('b.hoten') . ' LIKE ' . $db->quote('%' . $filters['hoten'] . '%'));
        }
        if (!empty($filters['gioitinh_id'])) {
            $query->where($db->quoteName('b.gioitinh_id') . ' = ' . $db->quote($filters['gioitinh_id']));
        }
        if ($filters['is_tamtru'] !== '') {
            $query->where($db->quoteName('b.is_tamtru') . ' = ' . $db->quote($filters['is_tamtru']));
        }
        if (!empty($filters['thonto_id'])) {
            $query->where($db->quoteName('a.thonto_id') . ' = ' . $db->quote($filters['thonto_id']));
        }
        if (!empty($filters['hokhau_so'])) {
            $query->where($db->quoteName('a.hokhau_so') . ' LIKE ' . $db->quote('%' . $filters['hokhau_so'] . '%'));
        }
        if (!empty($filters['cccd_so'])) {
            $query->where($db->quoteName('b.cccd_so') . ' LIKE ' . $db->quote('%' . $filters['cccd_so'] . '%'));
        }
        if (!empty($filters['diachi'])) {
            $query->where($db->quoteName('a.diachi') . ' LIKE ' . $db->quote('%' . $filters['diachi'] . '%'));
        }
        $query->order('id,b.quanhenhanthan_id ASC');
        $query->where('a.daxoa = 0');
        // echo $query;
        // exit;
        // $query->setLimit(1000);
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getHokhauById($hokhau_id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.hokhau_so,DATE_FORMAT(a.hokhau_ngaycap,"%d/%m/%Y") AS hokhau_ngaycap,a.hokhau_coquancap,a.tinhthanh_id,a.quanhuyen_id,a.phuongxa_id,a.thonto_id,a.diachi');
        $query->from('vptk_hokhau AS a');
        $query->where('a.id = ' . $db->quote($hokhau_id) . ' AND a.daxoa = 0');
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    public function getNhankhauByHokhauId($hokhau_id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.hokhau_id,a.trangthaihoso, a.hoten,DATE_FORMAT(a.ngaysinh,"%d/%m/%Y") AS ngaysinh,a.thuongtrucu_quanhuyen_id, a.thuongtrucu_phuongxa_id,a.gioitinh_id,a.cccd_so,DATE_FORMAT(a.cccd_ngaycap,"%d/%m/%Y") AS cccd_ngaycap,a.cccd_coquancap,a.quanhenhanthan_id,a.dienthoai,a.dantoc_id,a.tongiao_id,a.trinhdohocvan_id,a.nghenghiep_id,a.thuongtrucu_tinhthanh_id,a.thuongtrucu_quanhuyen_id,a.thuongtrucu_phuongxa_id,a.thuongtrucu_thonto_id,a.thuongtrucu_diachi,a.is_tamtru,a.lydoxoathuongtru_id, b.tenquanhenhanthan as quanhe,c.tengioitinh as gioitinh,d.tendantoc as dantoc,e.tentongiao, f.tentrinhdohocvan, g.tennghenghiep, h.tenquoctich,nm.name,a.quoctich_id,a.nhommau_id, a.tinhtranghonnhan_id, kv1.tentinhthanh as tinhthanh, kv2.tenquanhuyen as quanhuyen, kv3.tenphuongxa as phuongxa, ld.tenlydo');
        $query->from('vptk_hokhau2nhankhau AS a');
        $query->where('a.hokhau_id = ' . $db->quote($hokhau_id) . ' AND a.daxoa = 0');
        $query->innerJoin('danhmuc_quanhenhanthan as b on b.id = a.quanhenhanthan_id');
        $query->innerJoin('danhmuc_gioitinh as c on c.id = a.gioitinh_id');
        $query->innerJoin('danhmuc_dantoc as d on d.id = a.dantoc_id');
        $query->leftjoin('danhmuc_tongiao as e on e.id = a.tongiao_id');
        $query->leftjoin('danhmuc_trinhdohocvan as f on f.id = a.trinhdohocvan_id');
        $query->leftjoin('danhmuc_nghenghiep as g on g.id = a.nghenghiep_id');
        $query->leftjoin('danhmuc_quoctich as h on h.id = a.quoctich_id');
        $query->leftjoin('danhmuc_nhommau as nm on nm.code = a.nhommau_id');


        $query->leftjoin('danhmuc_tinhthanh as kv1 on kv1.id = a.thuongtrucu_tinhthanh_id');
        $query->leftjoin('danhmuc_quanhuyen as kv2 on kv2.id = a.thuongtrucu_quanhuyen_id');
        $query->leftjoin('danhmuc_phuongxa as kv3 on kv3.id = a.thuongtrucu_phuongxa_id');
        $query->leftjoin('danhmuc_lydoxoathuongtru as ld on ld.id = a.lydoxoathuongtru_id');

        $query->order('id ASC');


        // echo $query; 

        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function saveNhanhokhau($formData)
    {
        $db = JFactory::getDbo();
        $user_id = JFactory::getUser()->id;

        // Ghi log dữ liệu đầu vào
        error_log('saveNhanhokhau formData: ' . print_r($formData, true));

        // Chuẩn bị dữ liệu cho bảng vptk_hokhau
        $data = array(
            'id' => $formData['id'] ?? 0,
            'hokhau_so' => $formData['hokhau_so'] ?? '',
            'hokhau_ngaycap' => $formData['hokhau_ngaycap'] ?? '',
            'hokhau_coquancap' => $formData['hokhau_coquancap'] ?? '',
            'tinhthanh_id' => trim($formData['tinhthanh_id'] ?? ''),
            'quanhuyen_id' => trim($formData['quanhuyen_id'] ?? ''),
            'phuongxa_id' => trim($formData['phuongxa_id'] ?? ''),
            'thonto_id' => $formData['thonto_id'] ?? '',
            'diachi' => $formData['diachi'] ?? ''
        );
        if ((int) $data['id'] == 0) {
            $data['nguoitao_id'] = $user_id;
            $data['ngaytao'] = 'NOW()';
        } else {
            $data['nguoihieuchinh_id'] = $user_id;
            $data['ngayhieuchinh'] = 'NOW()';
        }

        // Chuẩn bị dữ liệu cho câu lệnh SQL
        $data_insert_key = [];
        $data_insert_val = [];
        $data_update = [];

        foreach ($data as $key => $value) {
            if ($value === '' || $value === null) {
                $data_update[] = $key . " = NULL";
                unset($data[$key]);
            } else {
                $data_insert_key[] = $key;
                if ($key == 'hokhau_ngaycap') {
                    $data_insert_val[] = "STR_TO_DATE('" . $value . "','%d/%m/%Y')";
                    $data_update[] = $key . " = STR_TO_DATE('" . $value . "','%d/%m/%Y')";
                } else if ($value == 'NOW()') {
                    $data_insert_val[] = $value;
                    $data_update[] = $key . " = " . $value;
                } else {
                    $data_insert_val[] = $db->quote($value);
                    $data_update[] = $key . " = " . $db->quote($value);
                }
            }
        }

        // Thực thi câu lệnh cho bảng vptk_hokhau
        $query = $db->getQuery(true);
        if ((int) $data['id'] == 0) {
            $query->insert($db->quoteName('vptk_hokhau'))
                ->columns($data_insert_key)
                ->values(implode(',', $data_insert_val));
        } else {
            $query->update($db->quoteName('vptk_hokhau'))
                ->set(implode(',', $data_update))
                ->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }

        $db->setQuery($query);
        if (!$db->execute()) {
            error_log('Failed to execute query for vptk_hokhau: ' . $query);
            throw new Exception('Lỗi khi lưu dữ liệu hộ khẩu');
        }

        // Lấy hokhau_id
        if ((int) $data['id'] == 0) {
            $hokhau_id = $db->insertid();
        } else {
            $hokhau_id = $data['id'];
        }

        // Khởi tạo mảng $value_insert
        $value_insert = [];


        // Xử lý dữ liệu nhân khẩu
        if (!empty($formData['nhankhau_id']) && is_array($formData['nhankhau_id'])) {
            error_log('Processing nhankhau_id: ' . print_r($formData['nhankhau_id'], true));
            for ($i = 0, $n = count($formData['nhankhau_id']); $i < $n; $i++) {
                error_log("Processing nhankhau index $i: nhankhau_id=" . $formData['nhankhau_id'][$i]);
                if ($formData['nhankhau_id'][$i] == '') {
                    // Thêm nhân khẩu mới
                    $value_insert[] = $db->quote($hokhau_id) . ',' .
                        $db->quote(trim($formData['hoten'][$i] ?? '')) . ',' .
                        'STR_TO_DATE(' . $db->quote($formData['ngaysinh'][$i] ?? '') . ',"%d/%m/%Y"),' .
                        $db->quote($formData['gioitinh_id'][$i] ?? '') . ',' .
                        $db->quote($formData['cccd_so'][$i] ?? '') . ',' .
                        'STR_TO_DATE(' . $db->quote($formData['cccd_ngaycap'][$i] ?? '') . ',"%d/%m/%Y"),' .
                        $db->quote(trim($formData['cccd_coquancap'][$i] ?? '')) . ',' .
                        $db->quote($formData['quanhenhanthan_id'][$i] ?? '') . ',' .
                        (!empty($formData['dienthoai'][$i]) ? $db->quote($formData['dienthoai'][$i]) : 'NULL') . ',' .
                        (!empty($formData['dantoc_id'][$i]) ? $db->quote($formData['dantoc_id'][$i]) : 'NULL') . ',' .
                        (!empty($formData['tongiao_id'][$i]) ? $db->quote($formData['tongiao_id'][$i]) : 'NULL') . ',' .
                        (!empty($formData['trinhdohocvan_id'][$i]) ? $db->quote($formData['trinhdohocvan_id'][$i]) : 'NULL') . ',' .
                        (!empty($formData['nghenghiep_id'][$i]) ? $db->quote($formData['nghenghiep_id'][$i]) : 'NULL') . ',' .
                        (!empty($formData['thuongtrucu_tinhthanh_id'][$i]) ? $db->quote($formData['thuongtrucu_tinhthanh_id'][$i]) : 'NULL') . ',' .
                        (!empty($formData['thuongtrucu_phuongxa_id'][$i]) ? $db->quote($formData['thuongtrucu_phuongxa_id'][$i]) : 'NULL') . ',' .
                        (!empty($formData['thuongtrucu_thonto_id'][$i]) ? $db->quote($formData['thuongtrucu_thonto_id'][$i]) : 'NULL') . ',' .
                        (!empty($formData['thuongtrucu_diachi'][$i]) ? $db->quote(trim($formData['thuongtrucu_diachi'][$i])) : 'NULL') . ',' .

                        (!empty($formData['quoctich_id'][$i]) ? $db->quote($formData['quoctich_id'][$i]) : 'NULL') . ',' .
                        (!empty($formData['nhommau_id'][$i]) ? $db->quote($formData['nhommau_id'][$i]) : 'NULL') . ',' .
                        (!empty($formData['tinhtranghonnhan_id'][$i]) ? $db->quote($formData['qhhonnhan_id'][$i]) : 'NULL') . ',' .

                        $db->quote($formData['is_tamtru'][$i] ?? '0') . ',' .
                        $db->quote('0') . ',' .

                        (!empty($formData['lydoxoathuongtru_id'][$i]) ? $db->quote($formData['lydoxoathuongtru_id'][$i]) : 'NULL') . ',' .
                        $db->quote($user_id) . ',NOW(),' .
                        $db->quote($user_id) . ',NOW()';
                    error_log("Added to value_insert: " . end($value_insert));
                } else {
                    // Cập nhật nhân khẩu hiện có
                    $query = $db->getQuery(true);
                    $query->update('vptk_hokhau2nhankhau');
                    $query->set('hoten = ' . $db->quote(trim($formData['hoten'][$i] ?? '')));
                    $query->set('ngaysinh = STR_TO_DATE(' . $db->quote($formData['ngaysinh'][$i] ?? '') . ',"%d/%m/%Y")');
                    $query->set('gioitinh_id = ' . $db->quote($formData['gioitinh_id'][$i] ?? ''));
                    $query->set('cccd_so = ' . $db->quote($formData['cccd_so'][$i] ?? ''));
                    $query->set('cccd_ngaycap = STR_TO_DATE(' . $db->quote($formData['cccd_ngaycap'][$i] ?? '') . ',"%d/%m/%Y")');
                    $query->set('cccd_coquancap = ' . $db->quote(trim($formData['cccd_coquancap'][$i] ?? '')));
                    $query->set('quanhenhanthan_id = ' . $db->quote($formData['quanhenhanthan_id'][$i] ?? ''));
                    $query->set('dienthoai = ' . (!empty($formData['dienthoai'][$i]) ? $db->quote($formData['dienthoai'][$i]) : 'NULL'));
                    $query->set('dantoc_id = ' . (!empty($formData['dantoc_id'][$i]) ? $db->quote($formData['dantoc_id'][$i]) : 'NULL'));
                    $query->set('tongiao_id = ' . (!empty($formData['tongiao_id'][$i]) ? $db->quote($formData['tongiao_id'][$i]) : 'NULL'));
                    $query->set('trinhdohocvan_id = ' . (!empty($formData['trinhdohocvan_id'][$i]) ? $db->quote($formData['trinhdohocvan_id'][$i]) : 'NULL'));
                    $query->set('nghenghiep_id = ' . (empty($formData['nghenghiep_id'][$i]) || $formData['nghenghiep_id'][$i] === 'null' ? 'NULL' : $db->quote($formData['nghenghiep_id'][$i])));

                    $query->set('thuongtrucu_tinhthanh_id = ' . (empty($formData['thuongtrucu_tinhthanh_id'][$i]) || $formData['thuongtrucu_tinhthanh_id'][$i] === 'null' ? 'NULL' : $db->quote($formData['thuongtrucu_tinhthanh_id'][$i])));
                    $query->set('thuongtrucu_phuongxa_id = ' . (empty($formData['thuongtrucu_phuongxa_id'][$i]) || $formData['thuongtrucu_phuongxa_id'][$i] === 'null' ? 'NULL' : $db->quote($formData['thuongtrucu_phuongxa_id'][$i])));

                    $query->set('thuongtrucu_thonto_id = ' . (!empty($formData['thuongtrucu_thonto_id'][$i]) ? $db->quote($formData['thuongtrucu_thonto_id'][$i]) : 'NULL'));
                    $query->set('thuongtrucu_diachi = ' . (!empty($formData['thuongtrucu_diachi'][$i]) ? $db->quote(trim($formData['thuongtrucu_diachi'][$i])) : 'NULL'));
                    $query->set('is_tamtru = ' . $db->quote($formData['is_tamtru'][$i] ?? '0'));
                    $query->set('lydoxoathuongtru_id = ' . (empty($formData['lydoxoathuongtru_id'][$i]) || $formData['lydoxoathuongtru_id'][$i] === 'null' ? 'NULL' : $db->quote($formData['lydoxoathuongtru_id'][$i])));

                    $query->set('quoctich_id = ' . (!empty($formData['quoctich_id'][$i]) ? $db->quote($formData['quoctich_id'][$i]) : 'NULL'));
                    $query->set('nhommau_id = ' . (!empty($formData['nhommau_id'][$i]) ? $db->quote($formData['nhommau_id'][$i]) : 'NULL'));
                    $query->set('tinhtranghonnhan_id = ' . (!empty($formData['qhhonnhan_id'][$i]) ? $db->quote($formData['qhhonnhan_id'][$i]) : 'NULL'));
                    $query->set('nguoihieuchinh_id = ' . $db->quote($user_id));
                    $query->set('ngayhieuchinh = NOW()');
                    $query->where('id = ' . $db->quote($formData['nhankhau_id'][$i]));
                    // echo $query;
                    // exit;
                    $db->setQuery($query);
                    if (!$db->execute()) {
                        error_log('Failed to update nhankhau: ' . $query);
                        throw new Exception('Lỗi khi cập nhật nhân khẩu');
                    }
                }
            }
        } else {
            error_log('No nhankhau_id data provided in formData');
            // Vẫn cho phép lưu hộ khẩu nếu không có nhân khẩu
        }

        // Thêm nhân khẩu mới nếu có
        error_log('value_insert before insert: ' . print_r($value_insert, true));
        if (!empty($value_insert)) {
            $query = $db->getQuery(true);
            $query->insert('vptk_hokhau2nhankhau');
            $query->columns('hokhau_id,hoten,ngaysinh,gioitinh_id,cccd_so,cccd_ngaycap,cccd_coquancap,quanhenhanthan_id,dienthoai,dantoc_id,tongiao_id,trinhdohocvan_id,nghenghiep_id,thuongtrucu_tinhthanh_id,thuongtrucu_phuongxa_id,thuongtrucu_thonto_id,thuongtrucu_diachi,quoctich_id,nhommau_id,tinhtranghonnhan_id,is_tamtru,trangthaihoso,lydoxoathuongtru_id,nguoitao_id,ngaytao,nguoihieuchinh_id,ngayhieuchinh');
            $query->values($value_insert);

            $db->setQuery($query);
            if (!$db->execute()) {
                error_log('Failed to insert nhankhau: ' . $query);
                throw new Exception('Lỗi khi thêm nhân khẩu');
            }
        }

        return true;
    }
    public function getThongKeNhanHoKhau($params = array())
    {
        $db = Factory::getDbo();
        $query_left = $db->getQuery(true);
        $query_left->select([
            'b.phuongxa_id',
            'd.tenkhuvuc AS phuongxa',
            'b.thonto_id',
            'c.tenkhuvuc AS thonto',
            'COUNT(IF(a.gioitinh_id = 1, 1, NULL)) AS nam',
            'COUNT(IF(a.gioitinh_id = 2, 1, NULL)) AS nu',
            'COUNT(IF(a.is_tamtru = 0, 1, NULL)) AS thuongtru',
            'COUNT(IF(a.is_tamtru = 1, 1, NULL)) AS tamtru',
            'COUNT(IF(DATE_ADD(a.ngaysinh, INTERVAL 18 YEAR) < CURDATE(), 1, NULL)) AS tren18'
        ]);
        $query_left->from($db->quoteName('vptk_hokhau2nhankhau', 'a'));
        $query_left->innerJoin($db->quoteName('vptk_hokhau', 'b') . ' ON a.hokhau_id = b.id');
        $query_left->innerJoin($db->quoteName('danhmuc_khuvuc', 'c') . ' ON b.thonto_id = c.id');
        $query_left->innerJoin($db->quoteName('danhmuc_khuvuc', 'd') . ' ON b.phuongxa_id = d.id');
        $query_left->group('b.thonto_id');

        if (!empty($params['phuongxa_id'])) {
            $query_left->where('b.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }
        if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
            $query_left->where('b.thonto_id IN (' . implode(',', array_map([$db, 'quote'], $params['thonto_id'])) . ')');
        }

        $query = $db->getQuery(true);
        $query->select([
            'a.id',
            'a.cha_id',
            'a.tenkhuvuc',
            'a.level',
            'SUM(ab.nam) AS nam',
            'SUM(ab.nu) AS nu',
            'SUM(ab.thuongtru) AS thuongtru',
            'SUM(ab.tamtru) AS tamtru',
            'SUM(ab.tren18) AS tren18'
        ]);
        $query->from($db->quoteName('danhmuc_khuvuc', 'a'));
        $query->leftJoin('(' . $query_left . ') AS ab ON a.id = ab.thonto_id OR a.id = ab.phuongxa_id');

        if (!empty($params['phuongxa_id'])) {
            $query->where('a.id = ' . $db->quote($params['phuongxa_id']) . ' OR a.cha_id = ' . $db->quote($params['phuongxa_id']));
        }
        if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
            $query->where('a.id IN (' . implode(',', array_map([$db, 'quote'], $params['thonto_id'])) . ')');
        }
        $query->group('a.id');
        $query->order('a.id ASC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
}
