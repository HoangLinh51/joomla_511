<?php
class Covid_Model_Covid extends JModelLegacy{
    public function checkPhanquyen($user_id = null){
        if($user_id == null) $user_id = JFactory::getUser()->id;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.khuvuc_id,b.level');
        $query->from('dmh_user2danhmuckhuvuc AS a');
        $query->innerJoin('dmh_danhmuckhuvuc AS b ON b.daxoa = 0 AND a.khuvuc_id = b.id');
        $query->where('a.user_id = '.$db->quote($user_id));
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    public function getPhanquyen(){
        $user_id = JFactory::getUser()->id;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('quanhuyen_id,phuongxa_id,thonto_id');
        $query->from('dmh_user2danhmuckhuvuc AS a');
        $query->where('a.user_id = '.$db->quote($user_id));
        $db->setQuery($query);
        $result = $db->loadAssoc();
        if($result['thonto_id'] == ''){
            echo '<div class="alert alert-error"><strong>Bạn không được phân quyền sử dụng chức năng này. Vui lòng liên hệ quản trị viên!!!</strong></div>';exit;
        }else{
            return $result;
        }
    }
    public function getThontoByPhuongxa($cha_id){
        $phanquyen = $this->getPhanquyen();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,ten,cha_id,level');
        $query->from('dmh_danhmuckhuvuc');
        if($phanquyen['thonto_id'] != '-1'){
            $query->where('id in ('.$phanquyen['thonto_id'].')');
        }
        $query->where('daxoa = 0 AND cha_id = '.$db->quote($cha_id));
        $query->order('ten ASC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDanhsachDonhang($trangthai_id, $params = array()){
        $phanquyen = $this->getPhanquyen();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id AS donhang_id,a.nguoidangky_id,b.quanhuyen_id,b.phuongxa_id,b2.ten AS phuongxa,b.thonto_id,b1.ten AS thonto,b.hovaten,b.diachi,CONCAT(b1.ten," - ",b2.ten," - ",b3.ten) AS khuvuc,b.sodienthoai,b.sokhau,DATE_FORMAT(a.ngaydangky,"%d/%m/%Y") AS ngaydangky,a.hinhthucthanhtoan_id,c2.ten AS nhacungcap,GROUP_CONCAT("- ",c1.ten," (<b class=\'red\'>SL: ",c.soluong," ",c1.dvt,"</b>)" SEPARATOR "<br/>") AS thongtindonhang,SUM(c.soluong*c1.giathamkhao) AS tongtien,a.hanghoakhac,a.maphieutonghop,a.trangthai,a.daxoa,a.nguoitonghop,DATE_FORMAT(a.ngaytonghop,"%d/%m/%Y") AS ngaytonghop,a.nguoixuatfile,DATE_FORMAT(a.ngayxuatfile,"%d/%m/%Y") AS ngayxuatfile,a.nguoicungung,DATE_FORMAT(a.ngaycungung,"%d/%m/%Y") AS ngaycungung,a.lydokhongcungung,a.nguoixoa,DATE_FORMAT(a.ngayxoa,"%d/%m/%Y") AS ngayxoa,a.lydoxoa');
        $query->from('dmh_thongtindonhang AS a');
        $query->innerJoin('dmh_thongtinnguoidangky AS b ON a.nguoidangky_id = b.id');
        $query->leftJoin('dmh_chitietdonhang AS c ON a.id = c.donhang_id');
        $query->leftJoin('dmh_danhmuchanghoa AS c1 ON c.hanghoa_id = c1.id');
        $query->leftJoin('dmh_danhmucnhacungcap AS c2 ON c1.nhacungcap_id = c2.id');
        $query->innerJoin('dmh_danhmuckhuvuc AS b1 ON b1.daxoa = 0 AND b.thonto_id = b1.id');
        $query->innerJoin('dmh_danhmuckhuvuc AS b2 ON b2.daxoa = 0 AND b.phuongxa_id = b2.id');
        $query->innerJoin('dmh_danhmuckhuvuc AS b3 ON b3.daxoa = 0 AND b.quanhuyen_id = b3.id');
        if($trangthai_id != ''){
            $query->where('a.trangthai = '.$db->quote($trangthai_id));
        }
        if($phanquyen['thonto_id'] != '-1'){
            $query->where('b.thonto_id IN ('.$phanquyen['thonto_id'].')');
        }
        if($params['daxoa'] == '1'){
            $query->where('a.daxoa = 1');
        }else{
            $query->where('a.daxoa = 0');
        }
        if($params['thonto_id'] != ''){
            $query->where('b.thonto_id = '.$db->quote($params['thonto_id']));
        }else if($params['phuongxa_id'] != ''){
            $query->where('b.phuongxa_id = '.$db->quote($params['phuongxa_id']));
        }else if($params['quanhuyen_id'] != ''){ 
            $query->where('b.quanhuyen_id = '.$db->quote($params['quanhuyen_id']));
        }
        if($params['xuatphieu'] == '1'){
            $query->where('a.nguoixuatfile IS NOT NULL');
        }else if($params['xuatphieu'] == '0'){
            $query->where('a.nguoixuatfile IS NULL');
        }
        if($params['maphieu'] != ''){
            $query->where('a.maphieutonghop = '.$db->quote($params['maphieu']));
        }
        if($params['nhacungcap_id'] != ''){
            $query->where('c1.nhacungcap_id = '.$db->quote($params['nhacungcap_id']));
        }
        $condition = array('EQ'=>'=','NEQ'=>'!=','GE'=>'>=','GT'=>'>','LE'=>'<=','LT'=>'<');
        if($params['ngaydangky_start'] != ''){
            $query->where('a.ngaydangky '.$condition[$params['ngaydangky_start_condition']].' STR_TO_DATE('.$db->quote($params['ngaydangky_start']).',"%d/%m/%Y")');
        }
        if($params['ngaydangky_end'] != ''){
            $query->where('a.ngaydangky '.$condition[$params['ngaydangky_end_condition']].' STR_TO_DATE('.$db->quote($params['ngaydangky_end']).',"%d/%m/%Y")');
        }
        $query->group('a.id');
        if($trangthai_id == '2'){
            $query->order('a.maphieutonghop,b3.ten,b2.ten,b1.ten,a.ngaydangky,b.diachi');
        }else{
            $query->order('b3.ten,b2.ten,b1.ten,a.ngaydangky,b.diachi');
        }
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDanhsachNguoidangky($thongtin, $soluongHienthi, $option = array()){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')->from('dmh_thongtinnguoidangky')->where('daxoa = 0');
        $query->where('hovaten LIKE ('.$db->quote('%'.$thongtin.'%').') OR sodienthoai LIKE ('.$db->quote('%'.$thongtin.'%').')');
        $db->setQuery($query, 0, $soluongHienthi);
        $rows = $db->loadAssocList();
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            if ($row['diachi'] !== null) {
                $row['address'] = 'Địa chỉ: '.$row['diachi'];
            }
            if ($row['sodienthoai'] !== null) {
                $row['phone'] = 'Số ĐT: '.$row['sodienthoai'];
            }
            $data[] = $row;
        }
        return $data;
    }
    public function getDanhsachTracuu($sodienthoai){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id AS donhang_id,a.nguoidangky_id,b.quanhuyen_id,b.phuongxa_id,b.thonto_id,b.hovaten,b.diachi,CONCAT(b1.ten," - ",b2.ten," - ",b3.ten) AS khuvuc,b.sodienthoai,b.sokhau,DATE_FORMAT(a.ngaydangky,"%d/%m/%Y") AS ngaydangky,a.hinhthucthanhtoan_id,c2.ten AS nhacungcap,GROUP_CONCAT("- ",c1.ten," (<b class=\'red\'>SL: ",c.soluong," ",c1.dvt,"</b>)" SEPARATOR "<br/>") AS thongtindonhang,SUM(c.soluong*c1.giathamkhao) AS tongtien,a.hanghoakhac,a.maphieutonghop,a.trangthai,a.daxoa,a.nguoitonghop,DATE_FORMAT(a.ngaytonghop,"%d/%m/%Y") AS ngaytonghop,a.nguoixuatfile,DATE_FORMAT(a.ngayxuatfile,"%d/%m/%Y") AS ngayxuatfile,a.nguoicungung,DATE_FORMAT(a.ngaycungung,"%d/%m/%Y") AS ngaycungung,a.lydokhongcungung,a.nguoixoa,DATE_FORMAT(a.ngayxoa,"%d/%m/%Y") AS ngayxoa,a.lydoxoa');
        $query->from('dmh_thongtindonhang AS a');
        $query->innerJoin('dmh_thongtinnguoidangky AS b ON a.nguoidangky_id = b.id');
        $query->leftJoin('dmh_chitietdonhang AS c ON a.id = c.donhang_id');
        $query->leftJoin('dmh_danhmuchanghoa AS c1 ON c.hanghoa_id = c1.id');
        $query->leftJoin('dmh_danhmucnhacungcap AS c2 ON c1.nhacungcap_id = c2.id');
        $query->innerJoin('dmh_danhmuckhuvuc AS b1 ON b.thonto_id = b1.id');
        $query->innerJoin('dmh_danhmuckhuvuc AS b2 ON b.phuongxa_id = b2.id');
        $query->innerJoin('dmh_danhmuckhuvuc AS b3 ON b.quanhuyen_id = b3.id');
        $query->where('b.sodienthoai = '.$db->quote($sodienthoai));
        $query->group('a.id');
        $query->order('a.ngaydangky DESC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function checkDangky($sodienthoai,$thonto_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('COUNT(*)');
        $query->from('dmh_thongtindonhang AS a');
        $query->innerJoin('dmh_thongtinnguoidangky AS b ON a.nguoidangky_id = b.id');
        $query->where('a.daxoa = 0');
        $query->where('a.trangthai IN (1,2)');
        $query->where('b.sodienthoai = '.$db->quote($sodienthoai));
        $query->where('b.thonto_id = '.$db->quote($thonto_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->loadResult();
    }
    public function saveDangky($formData){
        $db = JFactory::getDbo();
        $nguoidangky_id = $formData['nguoidangky_id'];
        if((int)$nguoidangky_id == 0){
            $data = array(
                'id' => $formData['id'],
                'hovaten' => trim($formData['hovaten']),
                'quanhuyen_id' => $formData['quanhuyen_id'],
                'phuongxa_id' => $formData['phuongxa_id'],
                'thonto_id' => $formData['thonto_id'],
                'diachi' => trim($formData['diachi']),
                'sodienthoai' => $formData['sodienthoai'],
                'sokhau' => $formData['sokhau']
            );
            foreach ($data as $key => $value) {
                if ($value == '' || $value == null) {
                    unset($data[$key]);
                    $data_update[] = $key . " = NULL";
                } else {
                    $data_insert_key[] = $key;
                    $data_insert_val[] = $db->quote($value);
                    $data_update[] = $key . " = " . $db->quote($value);
                }
            }
            $query = $db->getQuery(true);
            if ((int) $data['id'] == 0) {
                $query->insert($db->quoteName('dmh_thongtinnguoidangky'))->columns($data_insert_key)->values(implode(',', $data_insert_val));
            }else{
                $query->update($db->quoteName('dmh_thongtinnguoidangky'));
                $query->set(implode(',', $data_update));
                $query->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
            }
            $db->setQuery($query);
            if(!$db->execute()){
                return false;
            }
            $nguoidangky_id = $db->insertid();
        }
        $data_donhang = array(
            'ngaydangky' => 'NOW()',
            'nguoidangky_id' => $nguoidangky_id,
            'hinhthucthanhtoan_id' => $formData['hinhthucthanhtoan_id'],
            'nhacungcap_id' => $formData['nhacungcap_id'],
            'hanghoakhac' => trim($formData['hanghoakhac']),
            'trangthai' => '1'
		);
        foreach ($data_donhang as $key => $value) {
            if ($value == '' || $value == null) {
                unset($data_donhang[$key]);
            } else {
                $data_donhang_insert_key[] = $key;
                if($key == 'ngaydangky'){
                    $data_donhang_insert_val[] = $value;
                }else{
                    $data_donhang_insert_val[] = $db->quote($value);
                }
            }
		}
        $query = $db->getQuery(true);
        $query->insert($db->quoteName('dmh_thongtindonhang'))->columns($data_donhang_insert_key)->values(implode(',', $data_donhang_insert_val));
        $db->setQuery($query);
        if(!$db->execute()){
            return false;
        }
        $donhang_id = $db->insertid();
        $query = $db->getQuery(true);
        $query->insert('dmh_chitietdonhang')->columns(array('donhang_id','hanghoa_id','soluong'));
        for($i = 0, $n = count($formData['hanghoa_id']); $i < $n; $i++){
            $value_chitietdonhang[] = $db->quote($donhang_id).','.$db->quote($formData['hanghoa_id'][$i]).','.$db->quote($formData['soluong'][$i]);
        }
        $query->values($value_chitietdonhang);
        $db->setQuery($query);
        if(!$db->execute()){
            return false;
        }
        return true;
    }
    public function chuyenTrangthaiDonhang($idsDonhang, $trangthai_id, $lydo = ''){
        $db = JFactory::getDbo();
        $user_id = JFactory::getUser()->id;
        foreach ($idsDonhang as $key => $value) {
            $data_val[] = $db->quote($value);
		}
        $query = $db->getQuery(true);
        $query->update('dmh_thongtindonhang');
        $query->set('trangthai = '.$db->quote($trangthai_id));
        if($trangthai_id == '2'){
            $query->set('nguoitonghop = '.$db->quote($user_id));
            $query->set('ngaytonghop = NOW()');
        }else if($trangthai_id == '3'){
            $query->set('nguoicungung = '.$db->quote($user_id));
            $query->set('ngaycungung = NOW()');
        }else if($trangthai_id == '4'){
            $query->set('nguoicungung = '.$db->quote($user_id));
            $query->set('ngaycungung = NOW()');
            $query->set('lydokhongcungung = '.$db->quote($lydo));
        }
        $query->where('id IN ('.implode(',', $data_val).')');
        $db->setQuery($query);
        return $db->execute();
    }
    public function xuatPhieu($idsDonhang,$maphieu,$option = array()){
        $db = JFactory::getDbo();
        $user_id = JFactory::getUser()->id;
        if($option['refreshPhieu'] != '1'){
            foreach ($idsDonhang as $key => $value) {
                $data_val[] = $db->quote($value);
            }
            $query = $db->getQuery(true);
            $query->update('dmh_thongtindonhang');
            $query->set('maphieutonghop = '.$db->quote($maphieu));
            $query->set('nguoixuatfile = '.$db->quote($user_id));
            $query->set('ngayxuatfile = NOW()');
            $query->where('id IN ('.implode(',', $data_val).')');
            $db->setQuery($query);
            if(!$db->execute()){
                return false;
            }
        }
        $query = $db->getQuery(true);
        $query->select('b.hovaten,b.diachi,CONCAT(b1.ten," - ",b2.ten," - ",b3.ten) AS khuvuc,b.sodienthoai,b.sokhau,DATE_FORMAT(a.ngaydangky,"%d/%m/%Y") AS ngaydangky,a.hinhthucthanhtoan_id,GROUP_CONCAT("- ",c1.ten," (<b class=\'red\'>SL: ",c.soluong," ",c1.dvt,"</b>)" SEPARATOR "<br/>") AS thongtindonhang,SUM(c.soluong*c1.giathamkhao) AS tongtien,a.hanghoakhac,a.maphieutonghop,c2.ten AS nhacungcap');
        $query->from('dmh_thongtindonhang AS a');
        $query->innerJoin('dmh_thongtinnguoidangky AS b ON a.nguoidangky_id = b.id');
        $query->leftJoin('dmh_chitietdonhang AS c ON a.id = c.donhang_id');
        $query->leftJoin('dmh_danhmuchanghoa AS c1 ON c.hanghoa_id = c1.id');
        $query->leftJoin('dmh_danhmucnhacungcap AS c2 ON c1.nhacungcap_id = c2.id');
        $query->innerJoin('dmh_danhmuckhuvuc AS b1 ON b.thonto_id = b1.id');
        $query->innerJoin('dmh_danhmuckhuvuc AS b2 ON b.phuongxa_id = b2.id');
        $query->innerJoin('dmh_danhmuckhuvuc AS b3 ON b.quanhuyen_id = b3.id');
        $query->where('a.maphieutonghop = '.$db->quote($maphieu));
        $query->group('a.id');
        $query->order('a.ngaydangky,b.hovaten');
        $db->setQuery($query);
        $items = $db->loadAssocList();
        $html = '<form id="frmDanhsachDangky" name="frmDanhsachDangky" method="post" action="index.php">
        <table style="width:100%;"><tbody>
        <tr><td align="center" style="font-size: 18px;"><b>PHIẾU ĐĂNG KÝ THỰC PHẨM</b></td></tr>
        <tr><td align="center" style="font-size: 14px;"><b>'.$items[0]['khuvuc'].'</b></td></tr>
        <tr><td align="left"></td></tr>
        <tr><td align="left"><b>1. Tổng hợp chung số lượng thực phẩm</b></td></tr>
        <tr><td align="left">- Nhà cung cấp: '.$items[0]['nhacungcap'].'</td></tr>
        </tbody></table><br/>';
        $query = $db->getQuery(true);
        $query->select('a.ten,a.giathamkhao,SUM(b.soluong) AS tongso');
        $query->from('dmh_danhmuchanghoa AS a');
        $query->innerJoin('dmh_chitietdonhang AS b ON a.id = b.hanghoa_id');
        $query->innerJoin('dmh_thongtindonhang AS c ON c.maphieutonghop = '.$db->quote($maphieu).'  AND b.donhang_id = c.id');
        $query->group('a.id');
        $query->order('a.ten');
        $db->setQuery($query);
        $shops = $db->loadAssocList();
        $html.= '
        <table style="width:100%;" border="1px" cellspacing="0" cellpadding="1" bordercolor="#000000">
        <thead>
        <tr>
            <th style="text-align:center;vertical-align:middle;width:5%;"><b>STT</b></th>
            <th style="text-align:center;vertical-align:middle;width:50%;"><b>Thực phẩm</b></th>
            <th style="text-align:center;vertical-align:middle;width:10%;"><b>Đơn giá</b></th>
            <th style="text-align:center;vertical-align:middle;width:10%;"><b>Số lượng</b></th>
            <th style="text-align:center;vertical-align:middle;width:15%;"><b>Thành tiền</b></th>
            <th style="text-align:center;vertical-align:middle;width:10%;"><b>Ghi chú</b></th>
        </tr>
        </thead>
        <tbody>';
        $tongtien = 0;
        for ($i = 0, $n = count($shops); $i < $n; $i++){
            $shop = $shops[$i];
            $thanhtien = (int)$shop['giathamkhao']*(int)$shop['tongso'];
            $tongtien+= $thanhtien;
            $html.= '<tr>
                <td style="text-align:center;vertical-align:middle;width:5%;">'.($i+1).'</td>
                <td style="vertical-align:middle;width:50%;">'.$shop['ten'].'</td>
                <td style="vertical-align:middle;width:10%;text-align:right;">'.number_format($shop['giathamkhao'],0,'','.').'</td>
                <td style="vertical-align:middle;width:10%;text-align:right;">'.$shop['tongso'].'</td>
                <td style="vertical-align:middle;width:15%;text-align:right;">'.number_format($thanhtien,0,'','.').'</td>
                <td style="vertical-align:middle;width:10%;text-align:right;"></td>
            </tr>';
        }
        $html.= '</tbody>
        <tfoot>
        <tr>
            <td style="vertical-align:middle;width:75%;text-align:right;" colspan="4"><b>TỔNG CỘNG</b></td>
            <td style="vertical-align:middle;width:15%;text-align:right;"><b>'.number_format($tongtien,0,'','.').'</b></td>
            <td style="vertical-align:middle;width:10%;text-align:right;"></td>
        </tr>
        </tfoot>
        </table><br/>';
        $html.= '<table style="width:100%;"><tbody>
        <tr><td align="left"></td></tr>
        <tr><td align="left"><b>2. Chi tiết Phiếu đăng ký thực phẩm của người dân</b></td></tr>
        </tbody></table><br/>
        <table style="width:100%;" border="1px" cellspacing="0" cellpadding="1" bordercolor="#000000">
        <thead><tr>
            <th style="text-align:center;vertical-align:middle;width:5%;"><b>STT</b></th>
            <th style="text-align:center;vertical-align:middle;width:30%;"><b>Thông tin người đăng ký</b></th>
            <th style="text-align:center;vertical-align:middle;width:50%;"><b>Thông tin đơn hàng</b></th>
            <th style="text-align:center;vertical-align:middle;width:15%;"><b>Ghi chú</b></th>
        </tr></thead>
        <tbody>';
        for ($i = 0, $n = count($items); $i < $n; $i++){
            $item = $items[$i];
            $html.= '<tr>
                <td style="text-align:center;vertical-align:middle;width:5%;" rowspan="2">'.($i+1).'</td>
                <td style="vertical-align:middle;width:30%;"><b>Họ và tên: </b>'.$item['hovaten'].'<br/>
                    <b>Địa chỉ: </b>'.$item['diachi'].' - '.$item['khuvuc'].'<br/>
                    <b>Số điện thoại: </b>'.$item['sodienthoai'].'<br/>
                    <b>Số khẩu: </b>'.$item['sokhau'].'
                </td>
                <td style="vertical-align:middle;width:50%;"><b>Ngày đăng ký: </b>'.$item['ngaydangky'].'<br/>
                    <b>Hình thức thanh toán: </b>'.(($item['hinhthucthanhtoan_id'] == '1')?'Tiền mặt':'Chuyển khoản').'<br/>
                    <b>Thực phẩm đăng ký: </b><br/>'.$item['thongtindonhang'].'
                    '.(($item['hanghoakhac'] != '')?'<br/><b>Sản phẩm khác:</b><br/>'.nl2br($item['hanghoakhac']):'').'
                </td>
                <td style="vertical-align:middle;width:15%;" rowspan="2"></td>
            </tr>
            <tr>
                <td style="vertical-align:middle;width:80%;"><b>Tổng tiền dự kiến: </b>'.(($item['hanghoakhac'] != '')?'(chưa bao gồm tiền của sản phẩm khác)':'').' '.number_format($item['tongtien'],0,'','.').' VNĐ</td>
            </tr>';
        }
        $html.= '</tbody>
        </table><br/>';
        $html.= '<table style="width:100%;">
        <tr><td align="left" colspan="2"></td></tr>
        <tr>
            <td align="center" style="width:50%;"></td>
            <td align="center" style="width:50%;">Đà Nẵng, ngày '.date('d').' tháng '.date('m').' năm '.date('Y').'</td>
        </tr>
        <tr>
            <td align="center"><b></b></td>
            <td align="center"><b>Người lập</b></td>
        </tr>
        <tr>
            <td align="center"></td>
            <td align="center">(Ký và ghi rõ họ tên)</td>
        </tr>
        <tr><td align="left" colspan="2"></td></tr>
        <tr><td align="left" colspan="2"></td></tr>
        <tr><td align="left" colspan="2"></td></tr>
        <tr><td align="left" colspan="2"></td></tr>
        <tr><td align="left" colspan="2"></td></tr>
        <tr><td align="left" colspan="2"></td></tr>
        </table>
        </form>';
        $data = array(
            'code' => $maphieu,
            'noidung' => $html,
            'nguoitao' => $user_id,
            'ngaytao' => 'NOW()'
		);
		foreach ($data as $key => $value) {
            if ($value == '' || $value == null) {
                unset($data[$key]);
            } else {
                $data_insert_key[] = $key;
                if($key == 'ngaytao'){
                    $data_insert_val[] = $value;
                }else{
                    $data_insert_val[] = $db->quote($value);
                }
            }
		}
        $query = $db->getQuery(true);
        $query->insert($db->quoteName('dmh_phieutonghop'))->columns($data_insert_key)->values(implode(',', $data_insert_val));
        $db->setQuery($query);
        return $db->execute();
    }
    public function xoaDonhang($idsDonhang, $lydo){
        $db = JFactory::getDbo();
        $user_id = JFactory::getUser()->id;
        foreach ($idsDonhang as $key => $value) {
            $data_val[] = $db->quote($value);
		}
        $query = $db->getQuery(true);
        $query->update('dmh_thongtindonhang');
        $query->set('daxoa = 1');
        $query->set('nguoixoa = '.$db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->set('lydoxoa = '.$db->quote($lydo));
        $query->where('id IN ('.implode(',', $data_val).')');
        $db->setQuery($query);
        return $db->execute();
    }
    public function getPhieutonghop($maphieu){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('noidung');
        $query->from('dmh_phieutonghop');
        $query->where('code = '.$db->quote($maphieu));
        $db->setQuery($query);
        return $db->loadResult();
    }
}