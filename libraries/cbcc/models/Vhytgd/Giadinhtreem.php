<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Vhytgd_Model_Giadinhtreem extends JModelLegacy
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
    public function checkTreem($nhankhau_id, $table)
    {
        // Get database object
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('COUNT(*)')
            ->from($db->quoteName('vhxhytgd_thongtinhogiadinh'))
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
                'nk.ngaysinh',
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
            ->where('hk.daxoa = 0 and nk.is_chuho = 1');

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


    public function saveGiadinhtreem($formData)
    {
        $db = Factory::getDbo();
        $user_id = Factory::getUser()->id;

        // Danh sách các trường cần chuyển thành mảng
        $fields_to_array = [
            'thannhan_quanhe_id',
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
        $n = count($formData['thannhan_quanhe_id']);
        $ngaysinh = !empty($formData['input_namsinh'])
            ? DateTime::createFromFormat('d/m/Y', $formData['input_namsinh'])
            : (!empty($formData['select_namsinh']) ? DateTime::createFromFormat('d/m/Y', $formData['select_namsinh']) : false);
        // var_dump($formData);exit;
        // Lưu vào bảng vhxhytgd_doituonghbtxh
        $data = array(
            'id' => $formData['giadinh_id'] ?? 0,
            'nhankhau_id' => !empty($formData['nhankhau_id']) ? $formData['nhankhau_id'] : 0,
            'phuongxa_id' => !empty($formData['input_phuongxa_id']) ? $formData['input_phuongxa_id'] : $formData['select_phuongxa_id'] ?? null,
            'thonto_id' => !empty($formData['input_thonto_id']) ? $formData['input_thonto_id'] : $formData['select_thonto_id'] ?? null,
            'makh' => $formData['mahogd'] ?? null,
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
            $query->insert($db->quoteName('vhxhytgd_thongtinhogiadinh'))
                ->columns($data_insert_key)
                ->values(implode(',', $data_insert_val));
        } else {
            $query->update($db->quoteName('vhxhytgd_thongtinhogiadinh'))
                ->set($data_update)
                ->where($db->quoteName('id') . '=' . $db->quote($data['id']));
            // echo $query;exit;
        }

        $db->setQuery($query);
        $db->execute();

        if ((int) $data['id'] == 0) {
            $hogiadinh_id = $db->insertid();
        } else {
            $hogiadinh_id = $data['id'];
        }
        // Chỉ thực hiện insert/update vào bảng vhxhytgd_thanhviengiadinh nếu nhankhau_id = 0 hoặc null

        for ($dt = 0; $dt < $n; $dt++) {
            if (empty($formData['thannhan_quanhe_id'][$dt])) {
                continue;
            }
            // var_dump($formData['nhankhau_id_nhanthan'][$dt]);

            $data_chuyennganh[$dt] = array(
                'id' => $formData['id_nhanthan'] ?? 0,
                'hogiadinh_id' => $hogiadinh_id,
                'nhankhau_id' => $formData['nhankhau_id_nhanthan'][$dt] ?? null,
                'quanhenhanthan_id' => $formData['thannhan_quanhe_id'][$dt] ?? null,
                'hoten' => $formData['thannhan_hoten'][$dt] ?? null,
                'namsinh' => $formData['thannhan_namsinh'][$dt] ?? null,
                'nghenghiep_id' => $formData['thannhan_nghenghiep'][$dt] ?? null,
                'gioitinh_id' => $formData['gioitinh_thanthan'][$dt] ?? null,

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
                $querys->insert($db->quoteName('vhxhytgd_thanhviengiadinh'))
                    ->columns($data_chuyennganh_insert_key[$dt])
                    ->values(implode(',', $data_chuyennganh_insert_val[$dt]));
                // echo $querys;exit;

            } else {
                $querys->update($db->quoteName('vhxhytgd_thanhviengiadinh'))
                    ->set($data_chuyennganh_update[$dt])
                    ->where($db->quoteName('id') . '=' . $db->quote($data_chuyennganh[$dt]['id']));
                // echo $querys;exit;

            }

            $db->setQuery($querys);
            $db->execute();
        }

        // exit;
        return true;
    }

   public function getDanhSachGiaDinhTreEm($params = array(), $startFrom = 0, $perPage = 20)
{
    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    // Chọn các trường cần thiết
    $query->select([
        'a.*',
        'SUM(CASE WHEN c.id IS NOT NULL AND c.daxoa = 0 THEN 1 ELSE 0 END) AS baoluc',
        'SUM(CASE WHEN d.id IS NOT NULL AND d.daxoa = 0 THEN 1 ELSE 0 END) AS treem'
    ]);
    // Từ bảng chính
    $query->from('vhxhytgd_thongtinhogiadinh AS a');
    $query->innerJoin('vhxhytgd_thanhviengiadinh AS b ON a.id = b.hogiadinh_id');
    $query->leftJoin('vhxhytgd_thongtinbaoluc AS c ON a.id = c.hogiadinh_id');
    $query->leftJoin('vhxhytgd_thongtinhotrotreem AS d ON a.id = d.hogiadinh_id');

    // Điều kiện lọc
    $query->where('a.daxoa = 0');
    $query->where('b.daxoa = 0');

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
    error_log('Query getDanhSachGiaDinhTreEm: ' . (string)$query);

    // Thực hiện truy vấn và trả về kết quả
    $db->setQuery($query);
    return $db->loadAssocList();
}
    public function CountGDTE($params = array())
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();
        $query->select('COUNT(DISTINCT a.id)');

        $query->from('vhxhytgd_thongtinhogiadinh AS a');
        $query->leftJoin('vhxhytgd_thanhviengiadinh AS b ON a.id = b.hogiadinh_id');


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
    public function getThanNhan($nhankhauId)
    {
        $db = Factory::getDbo();

        try {
            $query = $db->getQuery(true);
            $query->select([
                $db->quoteName('nk.id'),
                $db->quoteName('nk.hoten'),
                $db->quoteName('nk.ngaysinh', 'namsinh'), // Đổi alias để đồng bộ với bảng vhxhytgd_thanhviengiadinh
                $db->quoteName('nk.is_chuho'),
                $db->quoteName('qh.tenquanhenhanthan'),
                $db->quoteName('nk.quanhenhanthan_id'), // Thêm quanhenhanthan_id để đồng bộ
                $db->quoteName('nn.tennghenghiep'),
                $db->quoteName('nk.gioitinh_id'),
                $db->quoteName('nk.nghenghiep_id') // Thêm nghenghiep_id để đồng bộ
            ])
                ->from($db->quoteName('vptk_hokhau2nhankhau', 'nk'))
                ->innerJoin($db->quoteName('vptk_hokhau2nhankhau', 'sub') . ' ON ' . $db->quoteName('nk.hokhau_id') . ' = ' . $db->quoteName('sub.hokhau_id'))
                ->leftJoin($db->quoteName('danhmuc_quanhenhanthan', 'qh') . ' ON ' . $db->quoteName('nk.quanhenhanthan_id') . ' = ' . $db->quoteName('qh.id'))
                ->leftJoin($db->quoteName('danhmuc_nghenghiep', 'nn') . ' ON ' . $db->quoteName('nk.nghenghiep_id') . ' = ' . $db->quoteName('nn.id'))
                ->where($db->quoteName('sub.id') . ' = ' . (int)$nhankhauId)
                ->order($db->quoteName('qh.sapxep') . ' ASC');

            $db->setQuery($query);
            // echo $query;exit;
            return $db->loadObjectList();
        } catch (Exception $e) {
            error_log('Error in getThanNhan: ' . $e->getMessage());
            return []; // Trả về mảng rỗng thay vì chuỗi lỗi
        }
    }
    public function getEditGDTE($gdte_id)
    {
        $db = Factory::getDbo();

        try {
            $query = $db->getQuery(true);
            $query->select([
                'a.*, a.id as giadinh_id'
            ])
                ->from($db->quoteName('vhxhytgd_thongtinhogiadinh', 'a'))
                ->where('a.id = ' . (int)$gdte_id)
                ->where('a.daxoa = 0');

            $db->setQuery($query);
            $row = $db->loadObject();

            // Nếu không có bản ghi, trả về null hoặc mảng rỗng
            if (!$row) {
                error_log('No record found for gdte_id: ' . $gdte_id);
                return (object)['thannhan' => []];
            }

            // Nếu có bản ghi và tồn tại nhankhau_id
            if (!empty($row->nhankhau_id)) {
                $row->thannhan = $this->getThanNhan($row->nhankhau_id);
            } else {
                // Nếu không có nhankhau_id, lấy thân nhân từ bảng vhxhytgd_thanhviengiadinh
                $query = $db->getQuery(true);
                $query->select([
                    'tn.id as thanhvien_id',
                    'tn.hoten',
                    'tn.namsinh',
                    'tn.quanhenhanthan_id',
                    'tn.nghenghiep_id',
                ])
                    ->from($db->quoteName('vhxhytgd_thanhviengiadinh', 'tn'))
                    ->where('tn.hogiadinh_id = ' . (int)$gdte_id)
                    ->where('tn.daxoa = 0');

                $db->setQuery($query);
                $row->thannhan = $db->loadObjectList() ?: []; // Đảm bảo trả về mảng rỗng nếu không có dữ liệu
                // var_dump($row);exit;
            }
            // echo $query;exit;
            return $row;
        } catch (Exception $e) {
            error_log('Error in getEditGDTE: ' . $e->getMessage());
            return (object)['thannhan' => []]; // Trả về đối tượng với thannhan rỗng
        }
    }

    public function delThongtingiadinh($nhanthan_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vhxhytgd_thanhviengiadinh');
        $query->set('daxoa = 1');
        $query->where('id =' . $db->quote($nhanthan_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function removeGDTE($giadinh_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vhxhytgd_thongtinhogiadinh');
        $query->set('daxoa = 1');
        $query->where('id =' . $db->quote($giadinh_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function getThannhanBaoluc($nhankhau_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        // Lấy thông tin chủ hộ từ vhxhytgd_thongtinhogiadinh
        $query->select([
            $db->quoteName('a.nhankhau_id') . ' AS nhankhau_id',
            $db->quoteName('a.n_hoten') . ' AS hoten',
            'YEAR(' . $db->quoteName('a.n_namsinh') . ') AS namsinh',
            $db->quoteName('gt.tengioitinh') . ' AS gioitinh'
        ])
            ->from($db->quoteName('vhxhytgd_thongtinhogiadinh', 'a'))
            ->leftJoin($db->quoteName('danhmuc_gioitinh', 'gt') . ' ON ' . $db->quoteName('gt.id') . ' = ' . $db->quoteName('a.n_gioitinh_id'))
            ->where($db->quoteName('a.daxoa') . ' = 0')
            ->where($db->quoteName('a.id') . ' = ' . $db->quote($nhankhau_id));

        // Lấy thông tin thành viên từ vhxhytgd_thanhviengiadinh
        $query2 = $db->getQuery(true);
        $query2->select([
            $db->quoteName('b.nhankhau_id') . ' AS nhankhau_id',
            $db->quoteName('b.hoten') . ' AS hoten',
            $db->quoteName('b.namsinh') . ' AS namsinh',
            $db->quoteName('gt.tengioitinh') . ' AS gioitinh'
        ])
            ->from($db->quoteName('vhxhytgd_thanhviengiadinh', 'b'))
            ->leftJoin($db->quoteName('danhmuc_gioitinh', 'gt') . ' ON ' . $db->quoteName('gt.id') . ' = ' . $db->quoteName('b.gioitinh_id'))
            ->where($db->quoteName('b.daxoa') . ' = 0')
            ->where($db->quoteName('b.hogiadinh_id') . ' = ' . $db->quote($nhankhau_id));

        // Kết hợp hai truy vấn bằng UNION
        $finalQuery = $db->getQuery(true);
        $finalQuery->select('*')->from('(' . $query . ' UNION ' . $query2 . ') AS combined');

        $db->setQuery($finalQuery);
        return $db->loadAssocList();
    }
    public function getBaoLucList($giadinh_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select([
            'a.*',
            $db->quoteName('b.n_hoten', 'hoten_hogiadinh'),
            'COALESCE(' . $db->quoteName('c.hoten') . ', ' . $db->quoteName('b.n_hoten') . ') AS hoten_nguoigay',
            'COALESCE(' . $db->quoteName('gt2.tengioitinh') . ', ' . $db->quoteName('gt3.tengioitinh') . ') AS gioitinh_nguoigay',
            'COALESCE(' . $db->quoteName('c.namsinh') . ', DATE_FORMAT(' . $db->quoteName('b.n_namsinh') . ', \'%Y\')) AS namsinh_nguoigay',
            'COALESCE(' . $db->quoteName('e.hoten') . ', ' . $db->quoteName('b.n_hoten') . ') AS hoten_nannhan',
            'COALESCE(' . $db->quoteName('gt.tengioitinh') . ', ' . $db->quoteName('gt3.tengioitinh') . ') AS gioitinh_nannhan',
            'COALESCE(' . $db->quoteName('e.namsinh') . ', DATE_FORMAT(' . $db->quoteName('b.n_namsinh') . ', \'%Y\')) AS namsinh_nannhan',
            'DATE_FORMAT(' . $db->quoteName('a.ngayxuly') . ', \'%d/%m/%Y\') AS ngayxuly2',
            $db->quoteName('xuly.tenxuly', 'bienphap_text'),
            $db->quoteName('hotro.tenhotro', 'hotro_text')
        ])
            ->from($db->quoteName('vhxhytgd_thongtinbaoluc', 'a'))
            ->innerJoin($db->quoteName('vhxhytgd_thongtinhogiadinh', 'b') . ' ON b.id = a.hogiadinh_id')
            ->leftJoin($db->quoteName('vhxhytgd_thanhviengiadinh', 'c') . ' ON c.nhankhau_id = a.thanhvienbaoluc_id AND c.hogiadinh_id = a.hogiadinh_id')
            ->leftJoin($db->quoteName('vhxhytgd_thanhviengiadinh', 'e') . ' ON e.nhankhau_id = a.thanhviennanhan_id AND e.hogiadinh_id = a.hogiadinh_id')
            ->leftJoin($db->quoteName('danhmuc_bienphapxuly', 'xuly') . ' ON xuly.id = a.bienphapxulybl_id')
            ->leftJoin($db->quoteName('danhmuc_bienphaphotro', 'hotro') . ' ON hotro.id = a.bienphaphotro_id')
            ->leftJoin($db->quoteName('danhmuc_gioitinh', 'gt') . ' ON gt.id = e.gioitinh_id')
            ->leftJoin($db->quoteName('danhmuc_gioitinh', 'gt2') . ' ON gt2.id = c.gioitinh_id')
            ->leftJoin($db->quoteName('danhmuc_gioitinh', 'gt3') . ' ON gt3.id = b.n_gioitinh_id')
            ->where('a.daxoa = 0')
            ->where('b.daxoa = 0')
            ->where('(c.daxoa = 0 OR c.daxoa IS NULL)')
            ->where('(e.daxoa = 0 OR e.daxoa IS NULL)')
            ->where('a.hogiadinh_id = ' . $db->quote($giadinh_id));

        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function saveBaoLuc($data)
    {
        $db = Factory::getDbo();
        $object = new stdClass();

        // Gán các trường từ dữ liệu gửi lên
        $object->id = !empty($data['modal_baoluc_id']) ? (int)$data['modal_baoluc_id'] : 0;
        $object->hogiadinh_id = !empty($data['hogiadinh_id']) ? (int)$data['hogiadinh_id'] : 0;
        $object->thanhvienbaoluc_id = !empty($data['modal_nguoigay_id']) ? (int)$data['modal_nguoigay_id'] : 0;
        $object->thanhviennanhan_id = !empty($data['modal_nannhan_id']) ? (int)$data['modal_nannhan_id'] : 0;
        $object->bienphapxulybl_id = !empty($data['modal_bienphap']) ? (int)$data['modal_bienphap'] : null;
        $object->bienphaphotro_id = !empty($data['modal_hotro']) ? (int)$data['modal_hotro'] : null;
        $object->coquanxuly = !empty($data['modal_coquanxl']) ? $data['modal_coquanxl'] : null;
        $object->mavuviec = !empty($data['modal_mavuviec']) ? $data['modal_mavuviec'] : null;
        $object->ngayxuly = !empty($data['modal_ngayxuly']) ? date('Y-m-d', strtotime(str_replace('/', '-', $data['modal_ngayxuly']))) : null;
        $object->tinhtrang = isset($data['modal_tinhtrang']) ? (int)$data['modal_tinhtrang'] : null;
        $object->ghichu = !empty($data['modal_ghichu']) ? $data['modal_ghichu'] : null;
        $object->daxoa = 0;

        // Gán thông tin người dùng và thời gian
        $user = Factory::getUser();
        $currentTime = Factory::getDate()->toSql();
        if ($object->id) {
            $object->nguoihieuchinh_id = $user->id;
            $object->ngayhieuchinh = $currentTime;
        } else {
            $object->nguoitao_id = $user->id;
            $object->ngaytao = $currentTime;
        }

        // Thêm hoặc cập nhật bản ghi
        if ($object->id) {
            $result = $db->updateObject('vhxhytgd_thongtinbaoluc', $object, 'id');
        } else {
            $result = $db->insertObject('vhxhytgd_thongtinbaoluc', $object, 'id');
        }

        if ($result) {
            return $object->id;
        } else {
            throw new Exception('Không thể lưu dữ liệu bạo lực gia đình.');
        }
    }
    public function delThongtinBaoluc($baoluc_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vhxhytgd_thongtinbaoluc');
        $query->set('daxoa = 1');
        $query->where('id =' . $db->quote($baoluc_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function getTreEmList($giadinh_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select([
            'a.*, b.hoten, gt.tengioitinh, b.namsinh, xuly.tennhom, hotro.tenhotro,b.gioitinh_id,b.nhankhau_id',
        ])
            ->from($db->quoteName('vhxhytgd_thongtinhotrotreem', 'a'))
            ->innerJoin($db->quoteName('vhxhytgd_thanhviengiadinh', 'b') . ' ON b.nhankhau_id = a.thanhviengiadinh_id  AND b.hogiadinh_id = a.hogiadinh_id')
            ->leftJoin($db->quoteName('danhmuc_nhomhoancanh', 'xuly') . ' ON xuly.id = a.nhomhoancanh_id')
            ->leftJoin($db->quoteName('danhmuc_nhomhoancanh2trogiup', 'hotro') . ' ON hotro.id = a.trogiup_id')
            ->leftJoin($db->quoteName('danhmuc_gioitinh', 'gt') . ' ON gt.id = b.gioitinh_id')

            ->where('a.daxoa = 0')
            ->where('b.daxoa = 0')

            ->where('a.hogiadinh_id = ' . $db->quote($giadinh_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function saveTreEm($data)
    {
        $db = Factory::getDbo();
        $object = new stdClass();

        // Gán các trường từ dữ liệu gửi lên
        $object->id = !empty($data['modal_hotrotreem']) ? (int)$data['modal_hotrotreem'] : 0;
        $object->hogiadinh_id = !empty($data['hogiadinh_id']) ? (int)$data['hogiadinh_id'] : 0;
        $object->thanhviengiadinh_id = !empty($data['thanhviengiadinh_id']) ? (int)$data['thanhviengiadinh_id'] : 0;
        $object->tinhtranghoctap = !empty($data['modal_tinhtranghoctap']) ? $data['modal_tinhtranghoctap'] : null;

        $object->tinhtrangsuckhoe = !empty($data['modal_tinhtrangsuckhoe']) ? $data['modal_tinhtrangsuckhoe'] : null;
        $object->nhomhoancanh_id = !empty($data['modal_hoancanh']) ? (int)$data['modal_hoancanh'] : null;
        $object->trogiup_id = !empty($data['modal_trogiup']) ? $data['modal_trogiup'] : null;
        $object->noidunghotro = !empty($data['modal_noidung']) ? $data['modal_noidung'] : null;
        $object->tinhtrang = isset($data['modal_tinhtrang']) ? (int)$data['modal_tinhtrang'] : null;
        $object->daxoa = 0;
        
        $user = Factory::getUser();
        $currentTime = Factory::getDate()->toSql();
        if ($object->id) {
            $object->nguoihieuchinh_id = $user->id;
            $object->ngayhieuchinh = $currentTime;
        } else {
            $object->nguoitao_id = $user->id;
            $object->ngaytao = $currentTime;
        }

      
        if ($object->id) {
            $result = $db->updateObject('vhxhytgd_thongtinhotrotreem', $object, 'id');
        } else {
            $result = $db->insertObject('vhxhytgd_thongtinhotrotreem', $object, 'id');
        }
        if ($result) {
            return $object->id;
        } else {
            throw new Exception('Không thể lưu dữ liệu bạo lực gia đình.');
        }
    }

    public function delThongtinTreEm($hotrotreem_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vhxhytgd_thongtinhotrotreem');
        $query->set('daxoa = 1');
        $query->where('id =' . $db->quote($hotrotreem_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function getThongKeGiadinhtreem($params = array())
{
    $db = Factory::getDbo();

    // Subquery 1: Aggregate by thonto_id
    $query_left = $db->getQuery(true);
    $query_left->select([
        'kv.id AS khuvuc_id',
        'hgd.nhankhau_id',
        'COUNT(DISTINCT bl.id) AS tongbaoluc',
        'COUNT(DISTINCT te.id) AS tongtreem'
    ]);
    $query_left->from('vhxhytgd_thongtinhogiadinh AS hgd');
    $query_left->innerJoin('vhxhytgd_thanhviengiadinh AS tv ON hgd.id = tv.hogiadinh_id');
    $query_left->leftJoin('vhxhytgd_thongtinbaoluc AS bl ON hgd.id = bl.hogiadinh_id AND bl.daxoa = 0');
    $query_left->leftJoin('vhxhytgd_thongtinhotrotreem AS te ON hgd.id = te.hogiadinh_id AND te.daxoa = 0');
    $query_left->innerJoin('danhmuc_khuvuc AS kv ON hgd.thonto_id = kv.id');
    $query_left->innerJoin('danhmuc_khuvuc AS kv_ph ON hgd.phuongxa_id = kv_ph.id');
    $query_left->where([
        'hgd.daxoa = 0',
        'tv.daxoa = 0'
    ]);

    // Subquery 2: Aggregate by phuongxa_id
    $query_left2 = $db->getQuery(true);
    $query_left2->select([
        'kv_ph.id AS khuvuc_id',
        'hgd.nhankhau_id',
        'COUNT(DISTINCT bl.id) AS tongbaoluc',
        'COUNT(DISTINCT te.id) AS tongtreem'
    ]);
    $query_left2->from('vhxhytgd_thongtinhogiadinh AS hgd');
    $query_left2->innerJoin('vhxhytgd_thanhviengiadinh AS tv ON hgd.id = tv.hogiadinh_id');
    $query_left2->leftJoin('vhxhytgd_thongtinbaoluc AS bl ON hgd.id = bl.hogiadinh_id AND bl.daxoa = 0');
    $query_left2->leftJoin('vhxhytgd_thongtinhotrotreem AS te ON hgd.id = te.hogiadinh_id AND te.daxoa = 0');
    $query_left2->innerJoin('danhmuc_khuvuc AS kv ON hgd.thonto_id = kv.id');
    $query_left2->innerJoin('danhmuc_khuvuc AS kv_ph ON hgd.phuongxa_id = kv_ph.id');
    $query_left2->where([
        'hgd.daxoa = 0',
        'tv.daxoa = 0'
    ]);

    // Apply filters to both subqueries
   if (!empty($params['phuongxa_id'])) {
            $query_left->where('hgd.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }

        if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
            $query_left->where($db->quoteName('hgd.thonto_id') . ' IN (' . implode(',', array_map([$db, 'quote'], $params['thonto_id'])) . ')');
        }

    $query_left->group('kv.id');
    $query_left2->group('kv_ph.id');

    // Combine subqueries with UNION
    $subQuery = '(' . (string)$query_left . ' UNION ' . (string)$query_left2 . ')';

    // Main query
    $query = $db->getQuery(true);
    $query->select([
        'a.id',
        'a.cha_id',
        'a.tenkhuvuc',
        'a.level',
        'ab.nhankhau_id',
        'COALESCE(ab.tongbaoluc, 0) AS tongbaoluc',
        'COALESCE(ab.tongtreem, 0) AS tongtreem'
    ]);
    $query->from('danhmuc_khuvuc AS a');
    $query->leftJoin($subQuery . ' AS ab ON a.id = ab.khuvuc_id');

    // Conditions for main query
     if (!empty($params['phuongxa_id'])) {
            $query->where($db->quoteName('a.id') . ' = ' . $db->quote($params['phuongxa_id']) . ' OR ' . $db->quoteName('a.cha_id') . ' = ' . $db->quote($params['phuongxa_id']));
        }
        if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
            $query->where($db->quoteName('a.id') . ' IN (' . implode(',', array_map([$db, 'quote'], $params['thonto_id'])) . ')');
        }

    $query->group(['a.id', 'a.cha_id', 'a.tenkhuvuc', 'a.level']);
    $query->order('a.level ASC, a.id ASC');
    // echo $query;
    $db->setQuery($query);
    $results = $db->loadAssocList();

    return $results;
}
}
