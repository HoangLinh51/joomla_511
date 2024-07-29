<?php 
defined('_JEXEC') or die('Restricted access');
class Services_Model_Sync4223{
	function quatrinhcongtac(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query = "select 
		hsc.e_code as SoHieuCBCCVC_BNDP, 
		qtct.start_date_ct as TuNgay, 
		qtct.end_date_ct as DenNgay, 
		dv.code_bnv as MaCoQuan, 
		qtct.inst_name_ct as TenCoQuan, 
		dmvtvl.code_bnv as ViTriViecLam
		from hosochinh_quatrinhhientai hsht
		inner join hosochinh hsc on hsc.id = hsht.hosochinh_id
		inner join quatrinhcongtac qtct ON qtct.emp_id_ct = hsht.hosochinh_id
		inner join ins_dept dv on dv.id = qtct.inst_code_ct
		INNER join quatrinhvtvl vtvl on vtvl.quatrinhcongtac_id = qtct.id_ct
		INNER JOIN danhmuc_vitrivieclam dmvtvl ON dmvtvl.id = vtvl.vtvl_id
		where hsht.hoso_trangthai ='00' and qtct.inst_code_ct>0
		AND hsc.e_code is not null
		group by qtct.id_ct
		order by hsht.congtac_donvi asc";
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	function quatrinhluong(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query = "
		SELECT
		hsc.e_code as SoHieuCBCCVC_BNDP,
		qtl.start_date_sal as TuNgay,
		qtl.end_date_sal as DenNgay,
		hs.code_bnv AS Ngach,
		qtl.sl_code_sal AS BacLuong,
		qtl.coef_sal AS HeSoLuong,
		qtl.percent AS PhanTramHuong
	FROM
		hosochinh_quatrinhhientai hsht
		INNER JOIN hosochinh hsc ON hsc.id = hsht.hosochinh_id
		INNER JOIN quatrinhluong qtl ON qtl.emp_id_sal = hsht.hosochinh_id 
		INNER JOIN cb_bac_heso hs ON hs.mangach = qtl.sta_code_sal
	WHERE
		hsht.hoso_trangthai = '00' 
		AND hsc.e_code is not null
		AND hs.code_bnv is not null
	GROUP BY
		qtl.id_sal
		order by hsht.congtac_donvi asc";
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	function quatrinhphucap(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query = "
		SELECT
			hsc.e_code as SoHieuCBCCVC_BNDP,
			qtl.ngaybatdau as TuNgay,
			qtl.ngayketthuc as DenNgay,
			dm.code_bnv AS LoaiPhuCap,
			if(dm.donvitinh=1, qtl.giatri,0) AS HeSo,
			if(dm.donvitinh=2, qtl.giatri,0) AS PhanTramHuongPhuCap,
			if(dm.donvitinh=3, qtl.giatri,0) AS GiaTri,
			'' AS HinhThucHuong
		FROM
			hosochinh_quatrinhhientai hsht
			INNER JOIN hosochinh hsc ON hsc.id = hsht.hosochinh_id
			INNER JOIN quatrinhphucap qtl ON qtl.hosochinh_id = hsht.hosochinh_id 
			INNER join danhmuc_loaiphucap dm on dm.id = qtl.loaiphucap_id
		WHERE
			hsht.hoso_trangthai = '00' 
			AND hsc.e_code is not null
			AND dm.code_bnv is not null
		GROUP BY
			qtl.id
		order by hsht.congtac_donvi asc
	";
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	function quatrinhngoaingu(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query = "
		SELECT
			hsht.e_code as SoHieuCBCCVC_BNDP,
			b.code_bnv as MaNgoaiNgu,
			c.code_bnv as TrinhDo
		FROM quatrinhboiduongnghiepvu a
		inner join hosochinh hsht on hsht.id = a.hosochinh_id
		INNER JOIN cla_sca_code c ON (a.tosc_code_dt = c.tosc_code AND a.trinhdo_code = c.code)
		INNER JOIN ls_code b ON a.chuyennganh_id = b.code
		WHERE a.tosc_code_dt = 6
		AND hsht.e_code is not null
		AND b.code_bnv is not null 
		AND c.code_bnv is not null;
	";
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	function quatrinhtinhoc(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query = "
		SELECT
			hsht.e_code as SoHieuCBCCVC_BNDP,
			c.code_bnv as TrinhDo
		FROM quatrinhboiduongnghiepvu a
		inner join hosochinh hsht on hsht.id = a.hosochinh_id
		INNER JOIN cla_sca_code c ON a.tosc_code_dt = c.tosc_code AND a.trinhdo_code = c.code
		WHERE a.tosc_code_dt = 7
		AND hsht.e_code is not null
		AND c.code_bnv is not null;
	";
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	function quatrinhdaotaoboiduong(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query = "
		SELECT
			hsht.e_code as SoHieuCBCCVC_BNDP,
			a.ngaybatdau as TuNgay,
			a.ngayketthuc as DenNgay,
			cn.code_bnv as ChuyenNganhDaoTao,
			td.code_bnv as TrinhDoDaoTao,
			a.truong as CoSoDaoTao,
			tn.name as XepLoaiTotNghiep,
			n.name as NuocDaoTao
		FROM quatrinhdaotaochuyenmon a
		inner join hosochinh hsht on hsht.id = a.hosochinh_id
		inner join cla_sca_code td on td.code = a.trinhdo_code and td.tosc_code = 2
		left join ls_code cn on cn.code = a.chuyennganh_id
		left join degree_code tn on tn.id = a.loaitotnghiep_id
		left join country_code n on n.code = a.nuocdaotao_id
		where hsht.e_code is not null AND td.code_bnv is not null
	";
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	function quatrinhdanhgiaxeploai(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query = "
		SELECT
			hsht.e_code as SoHieuCBCCVC_BNDP,
			a.hinhthuc as KetQuaDanhGia,
			year(a.ngayquyetdinh) as Nam,
			a.coquanquyetdinh as ThamQuyenDanhGia
		FROM quatrinhthidua a
		inner join hosochinh hsht on hsht.id = a.hosochinh_id
		where hsht.e_code is not null and a.ngayquyetdinh is not null
		order by a.ngayquyetdinh desc
	";
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	function hosonhansu(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$MaDonviSuDung = Core::config('sycn4223/excel/MaDonViSuDung');
		$TenDonViSuDung = Core::config('sycn4223/excel/TenDonViSuDung');
		$query = "
			SELECT
			hsc.e_code as SoHieuCBCCVC_BNDP,
			hsc.e_code as SoHieuCBCCVC,
			ldt.ten as PhanLoaiHoSo,
			dv.code_bnv as MaDonVi,
			hsht.congtac_donvi as TenDonVi,
			'$MaDonviSuDung' as MaDonviSuDung,
			'$TenDonViSuDung' as TenDonViSuDung,
			dv.code_bnv as MaDonViQuanLy,
			hsht.congtac_donvi as TenDonViQuanLy,
			hsht.hoten as HoVaTen,
			sex.code_bnv as GioiTinh,
			hsht.ngaysinh as NgaySinh,
			hsc.id_card as SoCMND,
			hsc.sodinhdanhcanhan as SoDinhDanhCaNhan,
			hsc.maso_bhxh as SoSoBaoHiemXaHoi,
			nat.id as DanToc,
			rel.code_bnv as TonGiao,
			hsc.date_in as NgayTuyenDungLanDau,
			dv.code_bnv as MaCoQuan,
			hsht.congtac_donvi as TenCoQuan,
			' ' as ViTriTuyenDung,
			hsht.congtac_ngayvaocoquanhiennay as NgayVaoCoQuanHienNay,
			(select tenvtvl from quatrinhvtvl where hosochinh_id=hsht.hosochinh_id order by ngaybatdau desc limit 0,1) as ViTriViecLam,
			hs.code_bnv as MaNgachChucDanh,
			hsht.luong_ngaybonhiemngachhiennay as TuNgayHuongNgach,
			hsht.luong_bac as BacLuong,
			hsht.luong_heso as HeSoLuong,
			hsht.luong_ngaybatdau as TuNgayHuongBac,
			hthl.phantramsotienhuong as PhanTramHuong,
			' ' as DenNgay,
			hsht.congtac_chucvu as ChucVu,
			(select start_date_ct from quatrinhcongtac where emp_id_ct = hsht.hosochinh_id and pos_sys_fk>0 order by start_date_ct asc limit 0,1 ) as NgayBoNhiemLanDau,
			hsht.congtac_ngaybonhiemlai as NgayBoNhiemLai,
			'' as NhiemKyCanBoChuyenTrach,
			(select pos_name_knbp from ct_kiemnhiembietphai where pos_sys_knbp is not null and emp_id_knbp = hsht.hosochinh_id limit 0,1) as ChucVuChucDanhKiemNhiem,
			hsht.trinhdovanhoa as HocVanPhoThong,
			cm.code_bnv as TrinhDoChuyenMon,
			llct.code_bnv as TrinhDoLyLuanChinhTri,
			qlnn.code_bnv as TrinhDoQuanLyNhaNuoc,
			anqp.code_bnv as BoiDuongQuocPhongAnNinh,
			hsc.tiengdantoc as TiengDanTocThieuSo,
			hsc.chucdanhkhoahoc as MaChucDanhKhoaHoc,
			hsc.chucdanhkhoahoc_ngayphong as NgayPhongChucDanh,
			hsc.chucdanhkhoahoc as MaHocVi,
			hsc.chucdanhkhoahoc_ngayphong as NgayQuyetDinhHocVi,
			hsc.party_j_date as NgayVaoDang,
			hsc.party_date as NgayVaoDangChinhThuc,
			hsc.sothedangvien as SoTheDang,
			hsht.dang_chucvudang as ChucVuDang
		FROM hosochinh hsc
		inner join hosochinh_quatrinhhientai hsht on hsht.hosochinh_id = hsc.id
		inner join ins_dept dv ON dv.id = hsht.congtac_donvi_id
		left join danhmuc_loaidoituong ldt on ldt.id = hsht.bienche_loaidoituong_id
		inner join sex_code sex ON sex.id = hsht.gioitinh
		inner join nat_code nat ON nat.id = hsc.nat_code
		inner join rel_code rel ON rel.id = hsc.rcs_code
		inner join whois_sal_mgr hthl ON hthl.id = hsht.luong_hinhthuc_id
		left join cla_sca_code cm on cm.code = hsht.chuyenmon_trinhdo_code and cm.tosc_code=2
		left join cla_sca_code llct on llct.code = hsht.chuyenmon_trinhdo_code and llct.tosc_code=3
		left join cla_sca_code qlnn on qlnn.code = hsht.chuyenmon_trinhdo_code and qlnn.tosc_code=5
		left join cla_sca_code anqp on anqp.code = hsht.chuyenmon_trinhdo_code and anqp.tosc_code=17
		left join cb_bac_heso hs on hs.mangach = hsht.luong_mangach
		where hsc.e_code is not null 
		and hsht.hoso_trangthai ='00'
		order by hsht.ngaysinh asc
	";
	// echo $query;die;
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	public function strDateVntoMySql($dateVN){
		if (empty($dateVN)) {
			return '';
		}
		$dateVN = explode('/', $dateVN);
		return $dateVN[2].'-'.$dateVN[1].'-'.$dateVN[0];
	}
}
