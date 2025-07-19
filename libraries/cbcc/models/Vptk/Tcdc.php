<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Vptk_Model_Tcdc extends JModelLegacy
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
    public function getDanhsachTraCuuDanCu($params = array())
    {
        $phanquyen = $this->getPhanquyen();
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.id, a.hoten AS hotenchuho, IF(a.gioitinh_id = 1, "Nam", IF(a.gioitinh_id = 2, "Nữ", "Không xác định")) as tengioitinh
		,DATE_FORMAT(a.ngaysinh,"%d/%m/%Y") AS ngaysinh,b.diachi,a.dienthoai,a.cccd_so, a.hokhau_id');
        $query->from('vptk_hokhau2nhankhau AS a');
        $query->innerJoin('vptk_hokhau AS b ON  b.daxoa = 0 AND b.id = a.hokhau_id');
        if ($params['cccd'] != '') {
            $query->where('a.cccd_so = ' . $db->quote($params['cccd']));
        }
        if (!empty($params['phuongxa_id'])) {
            $query->where('b.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        } elseif ($phanquyen['phuongxa_id'] != '-1') {
            $ids = explode(',', $phanquyen['phuongxa_id']);
            $quotedIds = array_map([$db, 'quote'], $ids);
            $query->where('b.phuongxa_id IN (' . implode(',', $quotedIds) . ')');
        }
        if ($params['daxoa'] == '1') {
            $query->where('b.daxoa = 1');
        } else {
            $query->where('b.daxoa = 0');
        }

        $db->setQuery($query);
        // echo $query;
        // exit;
        //    var_dump($db);
        return $db->loadAssocList();
    }
    public function getThongTinTCCD($nhankhau_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id ,a.hoten,a.nghenghiep,a.hokhau_id, DATE_FORMAT(a.ngaysinh,"%d/%m/%Y") AS ngaysinh,b.tengioitinh,hv.tentrinhdohocvan ,c.hokhau_so,c.hokhau_coquancap,
        DATE_FORMAT(c.hokhau_ngaycap,"%d/%m/%Y") as hokhau_ngaycap,a.cccd_so, DATE_FORMAT(a.cccd_ngaycap,"%d/%m/%Y") AS cccd_ngaycap, a.cccd_coquancap,a.dienthoai,d.tendantoc,
        e.tentongiao,	f.tenkhuvuc,CONCAT(c.diachi," - ",g.tenkhuvuc," - ",f.tenkhuvuc) AS diachi,c.phuongxa_id,c.thonto_id, a.gioitinh_id,g.tenkhuvuc as tenthonto, nt.tenquanhenhanthan');
        $query->from('vptk_hokhau2nhankhau AS a');
        $query->innerJoin('danhmuc_gioitinh AS b ON a.gioitinh_id = b.id');
        $query->innerJoin('vptk_hokhau AS c ON a.hokhau_id = c.id');
        $query->innerJoin('danhmuc_dantoc AS d ON a.dantoc_id = d.id');
        $query->innerJoin('danhmuc_tongiao AS e ON a.tongiao_id = e.id');
        $query->innerJoin('danhmuc_khuvuc AS f ON c.phuongxa_id = f.id');
        $query->innerJoin('danhmuc_khuvuc AS g ON c.thonto_id = g.id');
        $query->leftJoin('danhmuc_trinhdohocvan AS hv ON a.trinhdohocvan_id = hv.id');
        $query->innerJoin('danhmuc_quanhenhanthan AS nt ON a.quanhenhanthan_id = nt.id');
        $query->where('a.id = ' . $db->quote($nhankhau_id));
        $query->where('a.daxoa = 0 and c.daxoa = 0 ');
        // echo $query;
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    public function getThongTinNhanThan($nhankhau_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('hoten, quanhenhanthan_id, a.id AS nhankhau_id, nghenghiep,  DATE_FORMAT(a.ngaysinh,"%d/%m/%Y") AS ngaysinh, hokhau_id, nt.tenquanhenhanthan');
        $query->from('vptk_hokhau2nhankhau AS a');
        $query->innerJoin('danhmuc_quanhenhanthan AS nt ON a.quanhenhanthan_id = nt.id');

        $query->where('a.hokhau_id = ' . $db->quote($nhankhau_id));
        $query->where('a.daxoa = 0 and a.quanhenhanthan_id != -1 ');
        // echo $query;exit;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getThongTinBanDieuHanh($nhankhau_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,
        DATE_FORMAT(a.ngaybatdau,"%d/%m/%Y") AS ngaybatdau,
        DATE_FORMAT(a.ngayketthuc,"%d/%m/%Y") AS ngayketthuc,
        a.nhankhau_id,
        c.tenchucdanh,
        d.tennhiemky, e.tentinhtrang');
        $query->from('vptk_bandieuhanh AS a');
        $query->innerJoin('vptk_hokhau2nhankhau AS b ON b.id = a.nhankhau_id');
        $query->innerJoin('danhmuc_chucdanh AS c ON c.id = a.chucdanh_id');
        $query->innerJoin('danhmuc_nhiemky AS d on d.id = a.nhiemky_id');
        $query->innerJoin('danhmuc_tinhtrang AS e on e.id = a.tinhtrang_id');
        $query->where('a.nhankhau_id = ' . $db->quote($nhankhau_id));
        $query->where('a.daxoa = 0 ');
        // echo $query;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getThongtinDoiTuongCS($nhankhau_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('DATE_FORMAT( b.huongtungay, "%d/%m/%Y" ) AS huongtungay,
            ldt.ten AS tenloaidoituong,
            ldt.sotien ,
            ld.ten AS tentrangthai,
            bd.ten AS tenbiendong,
            cs.ten AS tenchinhsach');

        $query->from('vhxhytgd_doituonghbtxh AS a');
        $query->leftJoin('vhxhytgd_huongbtxh2doituong AS b ON a.id = b.doituongbtxh_id');
        $query->leftJoin('dmloaidoituong AS ldt ON ldt.id = b.loaidoituong_id');
        $query->leftJoin('dmloaibiendong AS bd ON bd.id = b.biendong_id');
        $query->leftJoin('dmchinhsach AS cs ON cs.id = b.chinhsach_id');
        $query->leftJoin('dmlydo AS ld ON ld.id = b.trangthai_id');
        $query->where('a.daxoa = 0 AND b.daxoa = 0');
        $query->where('a.nhankhau_id = ' . $db->quote($nhankhau_id));
        // echo $query;

        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getThongTinVay($nhankhau_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('
        DATE_FORMAT(c.ngaygiaingan,"%d/%m/%Y") AS ngaygiaingan,
        DATE_FORMAT(c.ngaydenhan,"%d/%m/%Y") AS ngaydenhan,     
        c.tiengiaingan,
        d.tenchuongtrinhvay,
        nv.tennguonvon');
        $query->from('vhxhytgd_nguoivayvon as a ');
        $query->innerJoin('vhxhytgd_nguoivayvon2chuongtrinh as c on c.nguoivayvon_id = a.id');
        $query->innerJoin('danhmuc_chuongtrinhvay as d on d.id = c.chuongtrinhvay_id');
        $query->innerJoin('danhmuc_nguonvon as nv on nv.id = c.nguonvon_id');
        $query->where('a.nhankhau_id = ' . $db->quote($nhankhau_id));
        $query->where('a.daxoa = 0 ');

        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getThongTinNCC($nhankhau_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('b.is_hinhthuc,
        DATE_FORMAT(b.ngayhuong, "%d/%m/%Y") AS ngayhuong2, 
        DATE_FORMAT(c.ngayuudai, "%d/%m/%Y") AS ngayuudai, 
        ld.ten as trangthai,
        a.n_hoten, ncc.ten as tenncc, ncc.trocap, b.phucap,
        a.n_cccd, ud.ten as tenuudai,dc.tendungcu,
        b.*');

        $query->from('vhxhytgd_nguoicocong AS a');
        $query->innerJoin('vhxhytgd_huongncc2doituong AS b ON a.id = b.nguoicocong_id');
        $query->leftJoin('vhxhytgd_uudai2nguoicocong AS c ON b.id = c.huongncc_id');
        $query->innerJoin('dmnguoicocong AS ncc ON ncc.id = b.dmnguoicocong_id');
        $query->leftJoin('dmlydo AS ld ON ld.id = b.trangthai_id');
        $query->leftJoin('dmuudai AS ud ON ud.id = c.uudai_id');
        $query->leftJoin('dmdungcu AS dc ON dc.id = c.loaidungcu_id');


        $query->where('a.daxoa = 0 AND b.daxoa = 0');
        $query->where('a.nhankhau_id = ' . $db->quote($nhankhau_id));
        $query->group('b.id');

        // echo $query;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getThongTinGDVH($nhankhau_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('
        a.nam,
        c.is_dat,
        c.is_giadinhvanhoatieubieu,
        c.lydokhongdat');
        $query->from('vhxhytgd_giadinhvanhoa as a ');
        $query->innerJoin('vhxhytgd_giadinhvanhoa2danhhieu as c on c.giadinhvanhoa_id= a.id');

        $query->where('c.nhankhau_id = ' . $db->quote($nhankhau_id));
        $query->where('a.daxoa = 0 ');
        // echo $query;

        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getThongTinDHoi($nhankhau_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('
        dh.tendoanhoi,
        cd.tenchucdanh,
        DATE_FORMAT(c.thoidiem_batdau,"%d/%m/%Y") AS thoidiem_batdau,
        DATE_FORMAT(c.thoidiem_ketthuc,"%d/%m/%Y") AS thoidiem_ketthuc');
        $query->from('vhxhytgd_thanhviendoanhoi as a ');
        $query->innerJoin('vhxhytgd_thanhvien2doanhoithamgia as c on c.thanhviendoanhoi_id= a.id');
        $query->innerJoin('danhmuc_doanhoi as dh on dh.id = c.doanhoi_id');
        $query->innerJoin('danhmuc_chucdanh as cd on cd.id = c.chucvu_id');


        $query->where('a.nhankhau_id = ' . $db->quote($nhankhau_id));
        $query->where('a.daxoa = 0 ');

        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getThongTinSoNha($nhankhau_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('
        c.sonha,
        c.thuadatso,
        d.tenduong, 
        c.tobandoso');
        $query->from('dcxddtmt_thongtinsonha as a ');
        $query->innerJoin('dcxddtmt_sonha2tenduong as c on c.sonha_id= a.id');
        $query->innerJoin('danhmuc_tenduong as d on d.id = a.duong_id');
        $query->where('c.nhankhau_id = ' . $db->quote($nhankhau_id));
        $query->where('a.daxoa = 0 and c.daxoa = 0 ');

        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getThongTinDat($nhankhau_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('
       	c.thuadat,
        c.sogcn,
        c.tobando,
        c.maphinongnghiep,
        c.tinhtrang ,
        c.tongtiennop,
        c.diachi
        ');
        $query->from('tckt_nopthuedat as a');
        $query->innerJoin('tckt_chitietnopthue as c on c.nopthuedat_id= a.id');
        $query->where('a.nhanhokhau_id = ' . $db->quote($nhankhau_id));
        $query->where('a.daxoa = 0 ');

        $db->setQuery($query);
        return $db->loadAssocList();
    }
     public function getThongtinBaoluc($nhankhau_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select([
            'COALESCE(' . $db->quoteName('c.hoten') . ', ' . $db->quoteName('b.n_hoten') . ') AS hoten_nguoigay',
            'COALESCE(' . $db->quoteName('gt2.tengioitinh') . ', ' . $db->quoteName('gt3.tengioitinh') . ') AS gioitinh_nguoigay',
            'COALESCE(' . $db->quoteName('c.namsinh') . ', DATE_FORMAT(' . $db->quoteName('b.n_namsinh') . ', \'%Y\')) AS namsinh_nguoigay',
            'COALESCE(' . $db->quoteName('e.hoten') . ', ' . $db->quoteName('b.n_hoten') . ') AS hoten_nannhan',
            'COALESCE(' . $db->quoteName('gt.tengioitinh') . ', ' . $db->quoteName('gt3.tengioitinh') . ') AS gioitinh_nannhan',
            'COALESCE(' . $db->quoteName('e.namsinh') . ', DATE_FORMAT(' . $db->quoteName('b.n_namsinh') . ', \'%Y\')) AS namsinh_nannhan',
            'DATE_FORMAT(' . $db->quoteName('a.ngayxuly') . ', \'%d/%m/%Y\') AS ngayxuly2',
            $db->quoteName('xuly.tenxuly', 'bienphap_text'),
            $db->quoteName('a.coquanxuly'),
            $db->quoteName('a.mavuviec'),
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
            ->where('a.thanhvienbaoluc_id = ' . $db->quote($nhankhau_id) . ' OR a.thanhviennanhan_id = ' . $db->quote($nhankhau_id));

            // echo $query;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
      public function getThongtinTreEm($nhankhau_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select([
            'b.hoten, gt.tengioitinh, b.namsinh, xuly.tennhom, hotro.tenhotro,b.gioitinh_id,b.nhankhau_id,a.noidunghotro, a.tinhtrangsuckhoe, a.tinhtranghoctap',
        ])
            ->from($db->quoteName('vhxhytgd_thongtinhotrotreem', 'a'))
            ->innerJoin($db->quoteName('vhxhytgd_thanhviengiadinh', 'b') . ' ON b.nhankhau_id = a.thanhviengiadinh_id  AND b.hogiadinh_id = a.hogiadinh_id')
            ->leftJoin($db->quoteName('danhmuc_nhomhoancanh', 'xuly') . ' ON xuly.id = a.nhomhoancanh_id')
            ->leftJoin($db->quoteName('danhmuc_nhomhoancanh2trogiup', 'hotro') . ' ON hotro.id = a.trogiup_id')
            ->leftJoin($db->quoteName('danhmuc_gioitinh', 'gt') . ' ON gt.id = b.gioitinh_id')

            ->where('a.daxoa = 0')
            ->where('b.daxoa = 0')

            ->where('a.thanhviengiadinh_id = ' . $db->quote($nhankhau_id));
        // echo $query;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
      public function getThongtinDBDT($nhankhau_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('DATE_FORMAT( b.ngayhotro, "%d/%m/%Y" ) AS ngayhotro2,
                    ld.ten AS tentrangthai,
                    cs.tenchinhsach AS csdongbao,
                    ht.tenchinhsach AS loaihotro, b.noidung');

        $query->from('vhxhytgd_dongbao AS a');
        $query->leftJoin('vhxhytgd_dongbao2chinhsach AS b ON a.id = b.dongbao_id');
        $query->leftJoin('danhmuc_chinhsachdongbao AS cs ON cs.id = b.chinhsach_id');
        $query->leftJoin('danhmuc_loaihotro AS ht ON ht.id = b.loaihotro_id');
        $query->leftJoin('dmlydo AS ld ON ld.id = b.trangthai_id');
        $query->where('a.daxoa = 0 AND b.daxoa = 0');
        $query->where('a.nhankhau_id = ' . $db->quote($nhankhau_id));
        // echo $query;

        $db->setQuery($query);
        return $db->loadAssocList();
    }
}
