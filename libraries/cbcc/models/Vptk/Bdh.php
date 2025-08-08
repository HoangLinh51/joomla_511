<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Vptk_Model_Bdh extends JModelLegacy
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
    public function getDanhSachBanDieuHanh($params = array(), $startFrom = 0, $perPage = 20)
    {
        $db = Factory::getDbo();
        $phanquyen = $this->getPhanquyen();

        $query = $db->getQuery(true);
        $query->select('a.id, a.thonto_id, c.tenkhuvuc AS thonto, a.nhiemky_id, f.tennhiemky, 
                    CASE WHEN a.is_ngoai = 1 THEN a.n_hoten ELSE b.hoten END AS hoten,
                    a.chucdanh_id, a.id_llct, d.tenchucdanh, b.dienthoai,
                    CONCAT_WS(" - ", DATE_FORMAT(a.ngaybatdau, "%d/%m/%Y"), DATE_FORMAT(a.ngayketthuc, "%d/%m/%Y")) AS thoigian,
                    a.tinhtrang_id, e.tentinhtrang, a.lydoketthuc');
        $query->from('vptk_bandieuhanh AS a');
        $query->leftJoin('vptk_hokhau2nhankhau AS b ON a.nhankhau_id = b.id AND b.daxoa = 0');
        $query->innerJoin('danhmuc_khuvuc AS c ON a.thonto_id = c.id');
        $query->innerJoin('danhmuc_chucdanh AS d ON a.chucdanh_id = d.id');
        $query->innerJoin('danhmuc_tinhtrang AS e ON a.tinhtrang_id = e.id');
        $query->innerJoin('danhmuc_nhiemky AS f ON a.nhiemky_id = f.id AND f.daxoa = 0');

        if ($params['daxoa'] == '1') {
            $query->where('a.daxoa = 1');
        } else {
            $query->where('a.daxoa = 0');
        }
        if (!empty($params['hoten'])) {
            $query->where('b.hoten LIKE ' . $db->quote('%' . $params['hoten'] . '%'));
        }
        if (!empty($params['chucdanh_id'])) {
            $query->where('a.chucdanh_id = ' . $db->quote($params['chucdanh_id']));
        }
        if (!empty($params['chucvukn_id'])) {
            $query->where('a.chucvukn_id = ' . $db->quote($params['chucvukn_id']));
        }
        if (!empty($params['tinhtrang_id'])) {
            $query->where('a.tinhtrang_id = ' . $db->quote($params['tinhtrang_id']));
        }
        if (!empty($params['thonto_id'])) {
            $query->where('a.thonto_id = ' . $db->quote($params['thonto_id']));
        }
        if (!empty($params['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        } elseif ($phanquyen['phuongxa_id'] != '-1') {
            $query->where('a.phuongxa_id = ' . $db->quote($phanquyen['phuongxa_id']));
        }

        $query->order('c.tenkhuvuc ASC, f.tungay DESC, d.sapxep ASC, b.hoten ASC, a.ngaybatdau DESC');
        $query->setLimit($perPage, $startFrom);

        $db->setQuery($query);
        $rows = $db->loadAssocList();
        // echo $query;
        $result = [];
        foreach ($rows as $row) {
            $result[$row['thonto']][$row['tennhiemky']][] = $row;
        }

        return $result;
    }

    public function countitems($params = array())
    {
        $phanquyen = $this->getPhanquyen();
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('COUNT(*) AS tongbandieudanh');
        $query->from('vptk_bandieuhanh AS a');
        $query->leftJoin('vptk_hokhau2nhankhau AS b ON a.nhankhau_id = b.id AND b.daxoa = 0');
        // Thêm các join cần thiết cho việc lọc
        $query->innerJoin('danhmuc_nhiemky AS f ON a.nhiemky_id = f.id AND f.daxoa = 0');

        // Thêm các join cần thiết cho việc lọc
        if ($params['daxoa'] == '1') {
            $query->where('a.daxoa = 1');
        } else {
            $query->where('a.daxoa = 0');
        }
        if (!empty($params['hoten'])) {
            $hotenCondition = '(CASE WHEN a.is_ngoai = 1 THEN a.n_hoten ELSE b.hoten END) LIKE ' . $db->quote('%' . $params['hoten'] . '%');
            $query->where($hotenCondition);
        }
        if (isset($phanquyen['phuongxa_id']) && (string)$phanquyen['phuongxa_id'] !== '-1') {
            $query->where('a.phuongxa_id = ' . $db->quote($phanquyen['phuongxa_id']));
        }
        $query->where('a.daxoa = 0');

        if (!empty($params['hoten'])) {
            $query->where('b.hoten LIKE ' . $db->quote('%' . $params['hoten'] . '%'));
        }
        if (!empty($params['chucdanh_id'])) {
            $query->where('a.chucdanh_id = ' . $db->quote($params['chucdanh_id']));
        }
        if (!empty($params['thonto_id'])) {
            $query->where('a.thonto_id = ' . $db->quote($params['thonto_id']));
        }
        if (!empty($params['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }

        $db->setQuery($query);
        $total = $db->loadResult();

        // Trả về một mảng có cấu trúc giống ban đầu để không làm vỡ code view
        return [['tongbandieudanh' => $total]];
    }
    public function getThanhVienBanDieuHanh($thonto_id, $nhiemky_id, $search = '')
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
            ->innerJoin('vptk_hokhau AS c ON a.hokhau_id = c.id AND c.thonto_id = ' . $db->quote($thonto_id));

        if (!empty($search)) {
            $query->where('(' . $db->quoteName('a.hoten') . ' LIKE ' . $db->quote('%' . $db->escape($search) . '%') .
                ' OR ' . $db->quoteName('a.cccd_so') . ' LIKE ' . $db->quote('%' . $db->escape($search) . '%') . ')');
        }

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
            'a.nhankhau_id',
            'a.phuongxa_id',
            'a.thonto_id',
            'a.nhiemky_id',
            'a.chucdanh_id',
            'a.chucvukn_id',
            'a.id_llct',
            'a.is_dangvien',
            'DATE_FORMAT(a.ngaybatdau, "%d/%m/%Y") AS tungay',
            'DATE_FORMAT(a.ngayketthuc, "%d/%m/%Y") AS denngay',
            'a.tinhtrang_id'
        ])
            ->from('vptk_bandieuhanh AS a')
            ->where('a.daxoa = 0 AND a.thonto_id = ' . $db->quote($thonto_id) . ' AND a.nhiemky_id = ' . $db->quote($nhiemky_id))
            ->order('a.ngaybatdau DESC');

        try {
            $db->setQuery($query);
            $bandieuhanh = $db->loadAssocList();
        } catch (Exception $e) {
            return ['error' => 'Lỗi khi truy vấn ban điều hành: ' . $e->getMessage()];
        }

        // Gộp dữ liệu
        for ($i = 0, $n = count($result); $i < $n; $i++) {
            $result[$i]['bandieuhanh'] = [];
            for ($j = 0, $m = count($bandieuhanh); $j < $m; $j++) {
                if ($result[$i]['nhankhau_id'] == $bandieuhanh[$j]['nhankhau_id']) {
                    $result[$i]['bandieuhanh'][] = $bandieuhanh[$j];
                }
            }
            if (empty($result[$i]['bandieuhanh'])) {
                $result[$i]['bandieuhanh'] = [[
                    'id' => '',
                    'nhankhau_id' => $result[$i]['nhankhau_id'],
                    'chucdanh_id' => '',
                    'chucvukn_id' => '',
                    'id_llct' => '',
                    'is_dangvien' => '0',
                    'tungay' => '',
                    'denngay' => '',
                    'tinhtrang_id' => ''
                ]];
            }
        }

        return $result;
    }
    public function getThanhVienBanDieuHanhID($thonto_id, $nhiemky_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        // Truy vấn để lấy thông tin ban điều hành
        $query->select([
            'a.id',
            'a.nhankhau_id',
            'a.phuongxa_id',
            'a.thonto_id',
            'a.nhiemky_id',
            'a.chucdanh_id',
            'a.chucvukn_id',
            'a.id_llct',
            'a.is_dangvien',
            'a.is_ngoai',
            'DATE_FORMAT(a.ngaybatdau, "%d/%m/%Y") AS tungay',
            'DATE_FORMAT(a.ngayketthuc, "%d/%m/%Y") AS denngay',
            'a.tinhtrang_id',
            'a.lydoketthuc',
            'a.n_hoten',
            'a.n_cccd',
            'a.n_dienthoai',
            'a.n_gioitinh_id',
            'a.n_phuongxa_id',
            'a.n_thonto_id',
            'a.n_diachi',
            'b.tengioitinh AS gioitinh_text',
            'c.tenchucdanh AS chucdanh_text',
            'd.tenchucdanh AS chucvukn_text',
            'e.tentrinhdo AS trinhdolyluanchinhtri_text',
            'f.tentinhtrang AS tinhtrang_text'
        ]);
        $query->from('vptk_bandieuhanh AS a');
        $query->leftJoin('danhmuc_gioitinh AS b ON a.n_gioitinh_id = b.id');
        $query->leftJoin('danhmuc_chucdanh AS c ON a.chucdanh_id = c.id');
        $query->leftJoin('danhmuc_chucdanh AS d ON a.chucvukn_id = d.id');
        $query->leftJoin('danhmuc_lyluanchinhtri AS e ON a.id_llct = e.id');
        $query->leftJoin('danhmuc_tinhtrang AS f ON a.tinhtrang_id = f.id');
        $query->where('a.daxoa = 0 AND a.thonto_id = ' . $db->quote($thonto_id) . ' AND a.nhiemky_id = ' . $db->quote($nhiemky_id));
        $query->order('a.ngaybatdau DESC');
        // echo $query;
        $db->setQuery($query);
        $result = $db->loadAssocList();

        return $result;
    }
    public function getPhuongxa_thontoID($thonto_id, $nhiemky_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        // Truy vấn để lấy thông tin ban điều hành
        $query->select([
            'a.id',
            'a.nhankhau_id',
            'a.phuongxa_id',
            'a.thonto_id',
            'a.nhiemky_id'
        ]);

        $query->from('vptk_bandieuhanh AS a');
        $query->where('a.daxoa = 0 AND a.thonto_id = ' . $db->quote($thonto_id) . ' AND a.nhiemky_id = ' . $db->quote($nhiemky_id));

        $db->setQuery($query);
        $result = $db->loadAssocList();

        return $result;
    }
    public function getNhanKhauByThonToId($thonto_id = null)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.hoten,b.tengioitinh,a.cccd_so,a.dienthoai');
        $query->from('vptk_hokhau2nhankhau AS a');
        $query->innerJoin('danhmuc_gioitinh AS b ON a.gioitinh_id = b.id');
        $query->innerJoin('vptk_hokhau AS c ON a.hokhau_id = c.id');
        if ($thonto_id != null && $thonto_id != '') {
            $query->where('c.thonto_id = ' . $db->quote($thonto_id));
        } else {
            $phanquyen = $this->getPhanquyen();
            if ($phanquyen['phuongxa_id'] != '-1') {
                $query->where('c.phuongxa_id = ' . $db->quote($phanquyen['phuongxa_id']));
            }
        }

        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function saveBanDieuHanh($formData)
    {
        $db = Factory::getDbo();
        $user_id = Factory::getUser()->id;
        for ($i = 0, $n = count($formData['nhankhau_id']); $i < $n; $i++) {
            // Xác định chế độ nhập tay hay tìm kiếm
            $is_ngoai = isset($formData['is_search'][$i]) && $formData['is_search'][$i] == '0' ? 1 : 0;

            // Chuẩn bị dữ liệu cho bảng vptk_bandieuhanh
            $data[$i] = [
                'id' => isset($formData['bandieuhanh_id'][$i]) ? (int)$formData['bandieuhanh_id'][$i] : 0,
                'phuongxa_id' => (int)$formData['phuongxa_id'],
                'thonto_id' => (int)$formData['thonto_id'],
                'nhiemky_id' => (int)$formData['nhiemky_id'],
                'nhankhau_id' => $is_ngoai == 1 ? 0 : (!empty(trim($formData['nhankhau_id'][$i] ?? '')) ? trim($formData['nhankhau_id'][$i]) : 0),
                'chucdanh_id' => trim($formData['chucdanh_id'][$i] ?? ''),
                'chucvukn_id' => trim($formData['chucdanh_kiemnhiem_id'][$i] ?? ''),
                'id_llct' => trim($formData['trinhdolyluanchinhtri_id'][$i] ?? ''),
                'ngaybatdau' => trim($formData['tungay'][$i] ?? ''),
                'ngayketthuc' => trim($formData['denngay'][$i] ?? ''),
                'tinhtrang_id' => trim($formData['tinhtrang_id'][$i] ?? ''),
                'lydoketthuc' => trim($formData['lydoketthuc_id'][$i] ?? ''),
                'is_dangvien' => isset($formData['is_dangvien'][$i]) && $formData['is_dangvien'][$i] == '1' ? 1 : 0,
                'is_ngoai' => $is_ngoai,
                'n_hoten' => null,
                'n_cccd' => null,
                'n_dienthoai' => null,
                'n_gioitinh_id' => null,
                'n_phuongxa_id' => null,
                'n_thonto_id' => null,
                'n_diachi' => null
            ];

            // Nếu is_ngoai = 0 và nhankhau_id có giá trị, lấy dữ liệu từ vptk_hokhau2nhankhau và vptk_hokhau
            if ($is_ngoai == 0 && !empty($data[$i]['nhankhau_id'])) {
                $query = $db->getQuery(true);
                $query->select([
                    $db->quoteName('nk.hoten'),
                    $db->quoteName('nk.gioitinh_id'),
                    $db->quoteName('nk.cccd_so'),
                    $db->quoteName('nk.dienthoai'),
                    $db->quoteName('hk.diachi')
                ])
                    ->from($db->quoteName('vptk_hokhau2nhankhau', 'nk'))
                    ->join('INNER', $db->quoteName('vptk_hokhau', 'hk') . ' ON ' . $db->quoteName('nk.hokhau_id') . ' = ' . $db->quoteName('hk.id'))
                    ->where($db->quoteName('nk.id') . ' = ' . $db->quote($data[$i]['nhankhau_id']));

                $db->setQuery($query);
                $nhankhau = $db->loadObject();

                if ($nhankhau) {
                    $data[$i]['n_hoten'] = $nhankhau->hoten;
                    $data[$i]['n_gioitinh_id'] = $nhankhau->gioitinh_id;
                    $data[$i]['n_cccd'] = $nhankhau->cccd_so;
                    $data[$i]['n_dienthoai'] = $nhankhau->dienthoai;
                    $data[$i]['n_phuongxa_id'] = $formData['phuongxa_id'];
                    $data[$i]['n_thonto_id'] = $formData['thonto_id'];
                    $data[$i]['n_diachi'] = $nhankhau->diachi;
                }
            } elseif ($is_ngoai == 1) {

                // Nếu is_ngoai = 1, lấy dữ liệu từ formData
                $data[$i]['n_hoten'] = trim($formData['hoten'][$i] ?? '');
                $data[$i]['n_cccd'] = trim($formData['cccd_so'][$i] ?? '');
                $data[$i]['n_dienthoai'] = trim($formData['dienthoai'][$i] ?? '');
                $data[$i]['n_gioitinh_id'] = trim($formData['gioitinh_id'][$i] ?? '');
                $data[$i]['n_phuongxa_id'] = trim($formData['phuongxa_id'] ?? '');
                $data[$i]['n_thonto_id'] = trim($formData['thonto_id'] ?? '');
                $data[$i]['n_diachi'] = trim($formData['diachi'][$i] ?? '');
            }

            // Thêm thông tin người tạo/sửa
            if ($data[$i]['id'] == 0) {
                $data[$i]['nguoitao_id'] = $user_id;
                $data[$i]['ngaytao'] = 'NOW()';
            } else {
                $data[$i]['nguoihieuchinh_id'] = $user_id;
                $data[$i]['ngayhieuchinh'] = 'NOW()';
            }

            // Chuẩn bị câu query
            $data_insert_key[$i] = [];
            $data_insert_val[$i] = [];
            $data_update[$i] = [];

            foreach ($data[$i] as $key => $value) {
                if ($value === '' || $value === null) {
                    $data_update[$i][] = $key . " = NULL";
                    continue; // Bỏ qua các trường rỗng khi insert
                }

                $data_insert_key[$i][] = $key;
                if ($key === 'ngaybatdau' || $key === 'ngayketthuc') {
                    // Chuyển đổi định dạng ngày từ dd/mm/yyyy sang YYYY-MM-DD
                    if (!empty($value)) {
                        $date = DateTime::createFromFormat('d/m/Y', $value);
                        if ($date !== false) {
                            $formatted_date = $date->format('Y-m-d');
                            $data_insert_val[$i][] = $db->quote($formatted_date);
                            $data_update[$i][] = $key . " = " . $db->quote($formatted_date);
                        } else {
                            $data_update[$i][] = $key . " = NULL";
                            continue;
                        }
                    } else {
                        $data_update[$i][] = $key . " = NULL";
                        continue;
                    }
                } elseif ($value === 'NOW()') {
                    $data_insert_val[$i][] = $value;
                    $data_update[$i][] = $key . " = " . $value;
                } else {
                    $data_insert_val[$i][] = $db->quote($value);
                    $data_update[$i][] = $key . " = " . $db->quote($value);
                }
            }

            // Lưu vào bảng vptk_bandieuhanh
            $query = $db->getQuery(true);
            if ($data[$i]['id'] == 0) {
                $query->insert($db->quoteName('vptk_bandieuhanh'))
                    ->columns($data_insert_key[$i])
                    ->values(implode(',', $data_insert_val[$i]));
            } else {
                $query->update($db->quoteName('vptk_bandieuhanh'))
                    ->set($data_update[$i])
                    ->where($db->quoteName('id') . '=' . $db->quote($data[$i]['id']));
            }

            $db->setQuery($query);
            if (!$db->execute()) {
                return false;
            }
        }

        return true;
    }

    public function checkBanDieuHanhExists($thonto_id, $nhiemky_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('COUNT(*)')
            ->from($db->quoteName('vptk_bandieuhanh'))
            ->where($db->quoteName('thonto_id') . ' = ' . (int)$thonto_id)
            ->where($db->quoteName('nhiemky_id') . ' = ' . (int)$nhiemky_id)
            ->where('daxoa = 0');
        $db->setQuery($query);
        $count = $db->loadResult();

        return $count > 0;
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
    public function removeBanDieuHanh($nhankhau_id, $user_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vptk_bandieuhanh');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = ' . $db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id =' . $db->quote($nhankhau_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function removeDSBanDieuHanh($thonto_id, $nhiemky_id)
    {
        $db = Factory::getDbo();
        $user_id = Factory::getUser()->id;
        $query = $db->getQuery(true);
        $query->update('vptk_bandieuhanh');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = ' . $db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where($db->quoteName('thonto_id') . ' = ' . (int)$thonto_id)
            ->where($db->quoteName('nhiemky_id') . ' = ' . (int)$nhiemky_id);
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function getThongKeBanDieuHanh($params = [])
    {
        $db = Factory::getDbo();
        $query_left = $db->getQuery(true);

        // Subquery cho thôn/tổ
        $query_left->select([
            $db->quoteName('a.phuongxa_id'),
            $db->quoteName('d.tenkhuvuc', 'phuongxa'),
            $db->quoteName('a.thonto_id'),
            $db->quoteName('c.tenkhuvuc', 'thonto'),
            'COUNT(IF(b.gioitinh_id = 1 AND a.chucdanh_id IN (1,3), 1, NULL)) AS totruongnam',
            'COUNT(IF(b.gioitinh_id = 2 AND a.chucdanh_id IN (1,3), 1, NULL)) AS totruongnu',
            'COUNT(IF(b.gioitinh_id = 1 AND a.chucdanh_id IN (2,4), 1, NULL)) AS tophonam',
            'COUNT(IF(b.gioitinh_id = 2 AND a.chucdanh_id IN (2,4), 1, NULL)) AS tophonu'
        ]);
        $query_left->from($db->quoteName('vptk_bandieuhanh', 'a'));
        $query_left->innerJoin($db->quoteName('vptk_hokhau2nhankhau', 'b') . ' ON a.nhankhau_id = b.id');
        $query_left->innerJoin($db->quoteName('danhmuc_khuvuc', 'c') . ' ON a.thonto_id = c.id');
        $query_left->innerJoin($db->quoteName('danhmuc_khuvuc', 'd') . ' ON a.phuongxa_id = d.id');
        $query_left->group($db->quoteName('a.thonto_id'));
        $query_left->where('a.daxoa = 0 AND b.daxoa = 0');

        // Điều kiện lọc
        if (!empty($params['phuongxa_id'])) {
            $query_left->where($db->quoteName('a.phuongxa_id') . ' = ' . $db->quote($params['phuongxa_id']));
        }
        if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
            $query_left->where($db->quoteName('a.thonto_id') . ' IN (' . implode(',', array_map([$db, 'quote'], $params['thonto_id'])) . ')');
        }
        if (!empty($params['nhiemky_id'])) {
            $query_left->where($db->quoteName('a.nhiemky_id') . ' = ' . $db->quote($params['nhiemky_id']));
        }
        if (!empty($params['chucdanh_id'])) {
            $query_left->where($db->quoteName('a.chucdanh_id') . ' = ' . $db->quote($params['chucdanh_id']));
        }

        // Query chính
        $query = $db->getQuery(true);
        $query->select([
            $db->quoteName('a.id'),
            $db->quoteName('a.cha_id'),
            $db->quoteName('a.tenkhuvuc'),
            $db->quoteName('a.level'),
            'COALESCE(SUM(ab.totruongnam), 0) AS totruongnam',
            'COALESCE(SUM(ab.totruongnu), 0) AS totruongnu',
            'COALESCE(SUM(ab.tophonam), 0) AS tophonam',
            'COALESCE(SUM(ab.tophonu), 0) AS tophonu'
        ]);
        $query->from($db->quoteName('danhmuc_khuvuc', 'a'));
        $query->leftJoin('(' . $query_left . ') AS ab ON a.id = ab.thonto_id OR a.id = ab.phuongxa_id');

        // Điều kiện lọc
        if (!empty($params['phuongxa_id'])) {
            $query->where($db->quoteName('a.id') . ' = ' . $db->quote($params['phuongxa_id']) . ' OR ' . $db->quoteName('a.cha_id') . ' = ' . $db->quote($params['phuongxa_id']));
        }
        if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
            $query->where($db->quoteName('a.id') . ' IN (' . implode(',', array_map([$db, 'quote'], $params['thonto_id'])) . ')');
        }

        // Nhóm và sắp xếp
        $query->group($db->quoteName('a.id'));
        $query->order('a.level, a.id ASC');

        // echo $query;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDanhSachBanDieuHanhExel($filters)
    {
        $db = Factory::getDbo();
        $phanquyen = $this->getPhanquyen();

        $query = $db->getQuery(true);
        $query->select('c.tenkhuvuc AS thonto, f.tennhiemky, 
                    CASE WHEN a.is_ngoai = 1 THEN a.n_hoten ELSE b.hoten END AS hoten,DATE_FORMAT( b.ngaysinh, "%d/%m/%Y" ) as ngaysinh,
                    a.chucdanh_id, a.id_llct, d.tenchucdanh, b.dienthoai,gt.tengioitinh,b.cccd_so,DATE_FORMAT( b.cccd_ngaycap, "%d/%m/%Y" ) as cccd_ngaycap, b.cccd_coquancap,
                    	DATE_FORMAT( a.ngaybatdau, "%d/%m/%Y" ) as ngaybatdau, DATE_FORMAT( a.ngayketthuc, "%d/%m/%Y" ) as ngayketthuc,llct.tentrinhdo,tt.tentinhtrang,a.lydoketthuc,
                         CASE 
        WHEN a.is_dangvien = 1 THEN "Có" 
        ELSE "Không" 
    END AS dangvien,
                    a.tinhtrang_id, e.tentinhtrang, a.lydoketthuc');
        $query->from('vptk_bandieuhanh AS a');
        $query->leftJoin('vptk_hokhau2nhankhau AS b ON a.nhankhau_id = b.id AND b.daxoa = 0');
        $query->innerJoin('danhmuc_khuvuc AS c ON a.thonto_id = c.id');
        $query->innerJoin('danhmuc_chucdanh AS d ON a.chucdanh_id = d.id');
        $query->innerJoin('danhmuc_tinhtrang AS e ON a.tinhtrang_id = e.id');
        $query->innerJoin('danhmuc_nhiemky AS f ON a.nhiemky_id = f.id AND f.daxoa = 0');
        $query->leftJoin('danhmuc_gioitinh AS gt ON b.gioitinh_id = gt.id');
        $query->leftJoin('danhmuc_lyluanchinhtri AS llct ON llct.id = a.id_llct');
        $query->leftJoin('danhmuc_tinhtrang AS tt ON tt.id = a.tinhtrang_id');




        if ($filters['daxoa'] == '1') {
            $query->where('a.daxoa = 1');
        } else {
            $query->where('a.daxoa = 0');
        }
        if (!empty($filters['hoten'])) {
            $query->where('b.hoten LIKE ' . $db->quote('%' . $filters['hoten'] . '%'));
        }
        if (!empty($filters['chucdanh_id'])) {
            $query->where('a.chucdanh_id = ' . $db->quote($filters['chucdanh_id']));
        }
        if (!empty($filters['chucvukn_id'])) {
            $query->where('a.chucvukn_id = ' . $db->quote($filters['chucvukn_id']));
        }
        if (!empty($filters['tinhtrang_id'])) {
            $query->where('a.tinhtrang_id = ' . $db->quote($filters['tinhtrang_id']));
        }
        if (!empty($filters['thonto_id'])) {
            $query->where('a.thonto_id = ' . $db->quote($filters['thonto_id']));
        }
        if (!empty($filters['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($filters['phuongxa_id']));
        } elseif ($phanquyen['phuongxa_id'] != '-1') {
            $query->where('a.phuongxa_id = ' . $db->quote($phanquyen['phuongxa_id']));
        }

        $query->order('c.tenkhuvuc ASC, f.tungay DESC, d.sapxep ASC, b.hoten ASC, a.ngaybatdau DESC');
        // echo $query;
        // exit;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
}
