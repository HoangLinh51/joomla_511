<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Vhytgd_Model_Thietche extends JModelLegacy
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
    public function saveThongTinThietChe($formData)
    {
        $db = Factory::getDbo();
        $user_id = Factory::getUser()->id;
        // var_dump()
        // Dữ liệu thiết chế
        $data = [
            'id' => $formData['id_thietche'],
            'phuongxa_id' => $formData['phuongxa_id'],
            'thietche_ten' => htmlentities($formData['thietche_ten'], ENT_COMPAT, 'utf-8'),
            'thietche_dientich' => $formData['thietche_dientich'],
            'thietche_vitri' => $formData['thietche_vitri'],
            'loaihinhthietche_id' => $formData['loaihinhthietche_id'],
            'trangthaihoatdong_id' => $formData['trangthaihoatdong_id'],
            'daxoa' => '0',
        ];

        if ((int)$data['id'] == 0) {
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
        if ((int)$data['id'] == 0) {
            $query->insert($db->quoteName('vhxhytgd_thietche'))
                ->columns($data_insert_key)
                ->values(implode(',', $data_insert_val));
        } else {
            $query->update($db->quoteName('vhxhytgd_thietche'))
                ->set(implode(',', $data_update))
                ->where($db->quoteName('id') . '=' . $db->quote($data['id']));
        }
        // echo $query;exit;
        $db->setQuery($query);
        $db->execute();
        $thietche_id = (int)$data['id'] == 0 ? $db->insertid() : $data['id'];

        // Lưu thông tin thiết bị
        for ($tb = 0, $m = count($formData['tenthietbi']); $tb < $m; $tb++) {
            $data_thietbi[$tb] = [
                'id' => $formData['id_thietbi'][$tb],
                'id_thietche' => $thietche_id,
                'id_loaithietbi' => $formData['loaithietbi'][$tb],
                'id_thietbi' => $formData['tenthietbi'][$tb],
                'soluong' => $formData['soluong'][$tb],
                'ghichu' => htmlentities($formData['ghichu_thietbi'][$tb], ENT_COMPAT, 'utf-8'),
                'daxoa' => '0',
            ];

            $data_thietbi_insert_key[$tb] = [];
            $data_thietbi_insert_val[$tb] = [];
            $data_thietbi_update[$tb] = [];

            foreach ($data_thietbi[$tb] as $key => $value) {
                if ($value === '' || $value === null) {
                    $data_thietbi_update[$tb][] = $key . " = NULL";
                    unset($data_thietbi[$tb][$key]);
                } else {
                    $data_thietbi_insert_key[$tb][] = $key;
                    if ($value == 'NOW()') {
                        $data_thietbi_insert_val[$tb][] = $value;
                        $data_thietbi_update[$tb][] = $key . " = " . $value;
                    } else {
                        $data_thietbi_insert_val[$tb][] = $db->quote($value);
                        $data_thietbi_update[$tb][] = $key . " = " . $db->quote($value);
                    }
                }
            }

            $querytb = $db->getQuery(true);
            if ((int)$data_thietbi[$tb]['id'] == 0) {
                $querytb->insert($db->quoteName('vhxhytgd_thongtinthietbi'))
                    ->columns($data_thietbi_insert_key[$tb])
                    ->values(implode(',', $data_thietbi_insert_val[$tb]));
            } else {
                $querytb->update($db->quoteName('vhxhytgd_thongtinthietbi'))
                    ->set(implode(',', $data_thietbi_update[$tb]))
                    ->where($db->quoteName('id') . '=' . $db->quote($data_thietbi[$tb]['id']));
            }

            $db->setQuery($querytb);
            $db->execute();
        }

        // Lưu thông tin hoạt động
        // Lưu thông tin hoạt động
        if (!empty($formData['noidung_hoatdong']) && is_array($formData['noidung_hoatdong'])) {
            foreach ($formData['noidung_hoatdong'] as $groupKey => $hoatDongsTrongNhom) {
                // Kiểm tra năm
                if (!isset($formData['nam_hoatdong'][$groupKey]) || empty($formData['nam_hoatdong'][$groupKey])) {
                    throw new Exception("Năm hoạt động cho nhóm $groupKey không được cung cấp hoặc không hợp lệ.");
                }

                foreach ($hoatDongsTrongNhom as $subIndex => $noidung) {
                    $tungay = $formData['tungay_hoatdong'][$groupKey][$subIndex] ?? null;
                    $denngay = $formData['denngay_hoatdong'][$groupKey][$subIndex] ?? null;

                    $tungay_sql = null;
                    if ($tungay) {
                        $dateObj = DateTime::createFromFormat('d/m/Y', $tungay);
                        if ($dateObj) {
                            $tungay_sql = $dateObj->format('Y-m-d');
                        } else {
                            throw new Exception("Định dạng ngày từ không hợp lệ: $tungay");
                        }
                    }

                    $denngay_sql = null;
                    if ($denngay) {
                        $dateObj = DateTime::createFromFormat('d/m/Y', $denngay);
                        if ($dateObj) {
                            $denngay_sql = $dateObj->format('Y-m-d');
                        } else {
                            throw new Exception("Định dạng ngày đến không hợp lệ: $denngay");
                        }
                    }

                    $data_hoatdong = [
                        'id' => $formData['hoatdong_id'][$groupKey][$subIndex] ?? 0,
                        'thietche_id' => $thietche_id,
                        'nam' => $formData['nam_hoatdong'][$groupKey] ?? null,
                        'noidunghoatdong' => htmlentities($noidung, ENT_COMPAT, 'utf-8'),
                        'thoigianhoatdong_tungay' => $tungay_sql,
                        'thoigianhoatdong_denngay' => $denngay_sql,
                        'nguonkinhphi_id' => $formData['nguonkinhphi'][$groupKey][$subIndex] ?? 0,
                        'kinhphi' => $formData['kinhphi'][$groupKey][$subIndex] ?? null,
                        'ghichu' => htmlentities($formData['ghichu_hoatdong'][$groupKey][$subIndex] ?? '', ENT_COMPAT, 'utf-8'),
                        'is_cha' => $formData['is_cha'][$groupKey][$subIndex] ?? 0,
                        'daxoa' => '0',
                    ];

                    // Debug dữ liệu
                    echo "<pre>Dữ liệu hoạt động (groupKey=$groupKey, subIndex=$subIndex): ";
                    var_dump($data_hoatdong);
                    echo "</pre>";

                    if ((int)$data_hoatdong['id'] == 0) {
                        $data_hoatdong['nguoitao_id'] = $user_id;
                        $data_hoatdong['ngaytao'] = 'NOW()';
                    } else {
                        $data_hoatdong['nguoihieuchinh_id'] = $user_id;
                        $data_hoatdong['ngayhieuchinh'] = 'NOW()';
                    }

                    $data_hoatdong_insert_key = [];
                    $data_hoatdong_insert_val = [];
                    $data_hoatdong_update = [];

                    foreach ($data_hoatdong as $key => $value) {
                        if ($value === null) {
                            $data_hoatdong_update[] = $db->quoteName($key) . " = NULL";
                        } else {
                            $data_hoatdong_insert_key[] = $db->quoteName($key);
                            if ($value == 'NOW()') {
                                $data_hoatdong_insert_val[] = $value;
                                $data_hoatdong_update[] = $db->quoteName($key) . " = " . $value;
                            } else {
                                $data_hoatdong_insert_val[] = $db->quote($value);
                                $data_hoatdong_update[] = $db->quoteName($key) . " = " . $db->quote($value);
                            }
                        }
                    }

                    $queryhd = $db->getQuery(true);
                    if ((int)($data_hoatdong['id'] ?? 0) == 0) {
                        if (!empty($data_hoatdong_insert_key)) {
                            $queryhd->insert($db->quoteName('vhxhytgd_thietche2hoatdong'))
                                ->columns($data_hoatdong_insert_key)
                                ->values(implode(',', $data_hoatdong_insert_val));
                            echo $queryhd . "<br>";
                        }
                    } else {
                        if (!empty($data_hoatdong_update)) {
                            $queryhd->update($db->quoteName('vhxhytgd_thietche2hoatdong'))
                                ->set($data_hoatdong_update)
                                ->where($db->quoteName('id') . '=' . $db->quote($data_hoatdong['id']));
                            echo $queryhd . "<br>";
                        }
                    }

                    $db->setQuery($queryhd);
                    $db->execute();
                }
            }
        }

        return true;
    }
    public function getDanhSachThongTinThietChe($params = array(), $startFrom = 0, $perPage = 20)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();

        // Phần SELECT, FROM, và JOIN giữ nguyên
        $query->select('DISTINCT a.id, a.phuongxa_id, a.thietche_ten, a.thietche_dientich,
                        a.thietche_vitri, a.bql_ten, b.tenloaihinhthietche, a.trangthaihoatdong_id');
        $query->from('vhxhytgd_thietche AS a');
        $query->leftJoin('danhmuc_loaihinhthietche AS b ON b.id = a.loaihinhthietche_id');

        // Phần WHERE giữ nguyên logic lọc của bạn
        if (isset($phanquyen['phuongxa_id']) && $phanquyen['phuongxa_id'] != '-1') {
            $query->where('a.phuongxa_id IN (' . $phanquyen['phuongxa_id'] . ')');
        }

        if (!empty($params['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }


        if (!empty($params['tenthietche'])) {
            $query->where('a.thietche_ten LIKE ' . $db->quote('%' . $params['tenthietche'] . '%'));
        }

        if (!empty($params['tinhtrang_id'])) {
            $query->where('a.trangthaihoatdong_id = ' . $db->quote($params['tinhtrang_id']));
        }

        if (!empty($params['loaihinhthietche_id'])) {
            $query->where('a.loaihinhthietche_id = ' . $db->quote($params['loaihinhthietche_id']));
        }

        $query->where('a.daxoa = 0');

        // Thêm sắp xếp (tùy chọn, nhưng nên có để kết quả ổn định)
        $query->order('a.thietche_ten ASC');

        // Áp dụng LIMIT để phân trang
        if ($perPage > 0) {
            $query->setLimit($perPage, $startFrom);
        }

        $db->setQuery($query);
        return $db->loadAssocList();
    }


    public function countThongTinThietChe($params = array())
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();

        // Sử dụng COUNT(DISTINCT a.id) vì câu lệnh SELECT chính dùng DISTINCT
        $query->select('COUNT(DISTINCT a.id)');

        $query->from('vhxhytgd_thietche AS a');
        $query->leftJoin('danhmuc_loaihinhthietche AS b ON b.id = a.loaihinhthietche_id');

        // Các điều kiện WHERE
        if (isset($phanquyen['phuongxa_id']) && $phanquyen['phuongxa_id'] != '-1') {
            $query->where('a.phuongxa_id IN (' . $phanquyen['phuongxa_id'] . ')');
        }

        if (!empty($params['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }


        if (!empty($params['tenthietche'])) {
            $query->where('a.thietche_ten LIKE ' . $db->quote('%' . $params['tenthietche'] . '%'));
        }

        if (!empty($params['tinhtrang_id'])) {
            $query->where('a.trangthaihoatdong_id = ' . $db->quote($params['tinhtrang_id']));
        }

        if (!empty($params['loaihinhthietche_id'])) {
            $query->where('a.loaihinhthietche_id = ' . $db->quote($params['loaihinhthietche_id']));
        }

        $query->where('a.daxoa = 0');

        $db->setQuery($query);

        // Dùng loadResult() để lấy ra một giá trị duy nhất là tổng số
        return (int) $db->loadResult();
    }
    public function getThongTinThietBi($id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id_thietche, c.ten, d.tenthietbi, d.donvitinh, a.soluong, a.ghichu, a.id, a.id_loaithietbi, id_thietbi');
        $query->from('vhxhytgd_thongtinthietbi AS a');
        $query->innerJoin('vhxhytgd_thietche as b ON a.id_thietche = b.id');
        $query->innerJoin('danhmuc_loaithietbi as c ON a.id_loaithietbi = c.id');
        $query->innerJoin('danhmuc_thietbi as d ON a.id_thietbi = d.id');
        $query->where($db->quoteName('a.id_thietche') . ' = ' . (int) $id);
        $query->where('a.daxoa = 0 AND b.daxoa = 0');
        // echo $query;    
        $db->setQuery($query);
        return  $db->loadAssocList();
    }
    public function removeThongTinThietBi($id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('vhxhytgd_thongtinthietbi', 'b')); // Đảm bảo tên bảng được trích dẫn
        $query->set('b.daxoa = 1');
        $query->where('b.id = ' . $db->quote($id)); // Sử dụng bảng định danh cho điều kiện WHERE
        $db->setQuery($query);
        return $db->execute();
    }
    public function getDanhSachThongTinThietCheByID($id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,
                        a.phuongxa_id,
                        a.thietche_ten,
                        a.thietche_dientich,
                        a.loaihinhthietche_id,
                        a.bql_qd_so,
                        a.bql_qd_dinhkem_id,
                        a.bql_qd_ngay,
                        a.thietche_vitri, a.bql_ten, b.tenloaihinhthietche, a.trangthaihoatdong_id');
        $query->from('vhxhytgd_thietche AS a');
        $query->leftJoin('danhmuc_loaihinhthietche as b ON b.id = a.loaihinhthietche_id');
        $query->where('a.id = ' . $id . '');
        $query->where('a.daxoa = 0');
        // echo $query;exit;
        // $query->group('thanhviendoanhoi_id;');
        $db->setQuery($query);
        return  $db->loadAssocList();
    }
    public function getDanhSachNamHoatDongByID($id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('count(a.nam) as ss, a.nam,  GROUP_CONCAT(a.id) as array_id');
        $query->from('vhxhytgd_thietche2hoatdong AS a');
        $query->where('a.thietche_id = ' . $id . '');
        $query->where('a.daxoa = 0');
        // $query->group('a.nam');
        // echo $query;exit;
        $query->group('a.nam order by a.nam DESC;');
        $db->setQuery($query);
        return  $db->loadAssocList();
    }
    public function getDanhSachHoatDongByID($id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,
                        a.thietche_id,
                        a.nam,
                        a.noidunghoatdong,
                        a.thoigianhoatdong_tungay,
                        a.thoigianhoatdong_denngay,
                        a.nguonkinhphi_id,
                        a.kinhphi,
                        a.ghichu,a.is_cha');
        $query->from('vhxhytgd_thietche2hoatdong AS a');
        $query->where('a.thietche_id = ' . $id . '');
        $query->where('a.daxoa = 0 order by a.id DESC');
        // echo $query;exit;
        // $query->group('thanhviendoanhoi_id;');
        $db->setQuery($query);
        return  $db->loadAssocList();
    }
    public function removeHoatDongThietChe($hoatdong_id)
    {

        $db = Factory::getDbo();
        $user_id = Factory::getUser()->id;

        $query = $db->getQuery(true);
        $query->update('vhxhytgd_thietche2hoatdong AS b');
        $query->set('b.daxoa = 1');
        $query->set('b.nguoixoa_id = ' . $db->quote($user_id) . ' ');
        $query->set('b.ngayxoa = NOW() ');
        $query->where('b.id ' . ' IN (' . str_replace("'", '', $db->quote($hoatdong_id)) . ')');
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function removeThongTinThietChe($id_thietche)
    {
        $db = Factory::getDbo();
        $user_id = Factory::getUser()->id;

        $query = $db->getQuery(true);
        $query->update('vhxhytgd_thongtinthietbi AS b, vhxhytgd_thietche2hoatdong as c, vhxhytgd_thietche as a');
        $query->set('b.daxoa = 1, a.daxoa = 1, c.daxoa = 1');
        $query->set('a.nguoixoa_id = ' . $db->quote($user_id) . ' ');
        $query->set(' c.ngayxoa = NOW(),a.ngayxoa = NOW() ');
        $query->where('a.id = ' . $db->quote($id_thietche));
        //echo $query;
        $db->setQuery($query);
        return $db->execute();
    }
    public function getThongKeThietche($params = array())
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select(" px.tenkhuvuc AS tenkhuvuc,
    COUNT(DISTINCT a.id) AS soluongthietche,
    FORMAT(SUM(CASE WHEN b.kinhphi IS NOT NULL THEN b.kinhphi ELSE 0 END), 'vi_VN') AS tongkinhphi");
        $query->from('vhxhytgd_thietche as a');
        $query->leftJoin('vhxhytgd_thietche2hoatdong AS b ON a.id = b.thietche_id and b.daxoa = 0');
        $query->innerJoin('danhmuc_khuvuc as px ON a.phuongxa_id = px.id');
        $query->where('a.daxoa =0 ');


        if ($params['phuongxa_id'] != '') {
            $query->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        }

        if (!empty($params['thietche_id'])) {
            $query->where('a.loaihinhthietche_id = ' . $db->quote($params['thietche_id']));
        }
        if (!empty($params['trangthai_id'])) {
            $query->where('a.trangthaihoatdong_id = ' . $db->quote($params['trangthai_id']));
        }
        $query->group('a.phuongxa_id');
        // echo $query;

        $db->setQuery($query);
        return  $db->loadAssocList();
    }
}
