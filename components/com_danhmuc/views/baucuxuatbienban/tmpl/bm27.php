<?php 
$donviHasKey = Core::loadAssocListHasKey('baucu_diadiemhanhchinh','*','id');
$dotbaucu_id = $this->dotbaucu_id;
$dotbaucu = Core::loadAssoc('baucu_dotbaucu','*','id='.(int)$dotbaucu_id);
$model_tonghopbaucu = Core::model('Baucu/Tonghop');
$model_kiemphieu = Core::model('Baucu/Kiemphieu');
$capbaucu = $this->capbaucu;
$donvihanhchinh = $this->donvibaucu_id;
$donvibaucus = Core::loadAssocList('baucu_donvibaucu','*','dotbaucu_id='.(int)$dotbaucu_id.' and capbaucu_id='.(int)$capbaucu['id'].' AND diaphuongbaucu_id='.(int)$donvihanhchinh);
for($i=0; $i<count($donvibaucus); $i++){
    $donvibaucu = $donvibaucus[$i];
    $donvibaucus[$i]['donvibaucu2diadiem'] = Core::loadColumn('baucu_donvibaucu2diadiem','diadiem_id','donvibaucu_id='.$donvibaucu['id']);
    if(count($donvibaucus[$i]['donvibaucu2diadiem'])>0){
        $donvibaucu2diadiem_tmp = array();
        foreach ($donvibaucus[$i]['donvibaucu2diadiem'] as $key => $value) {
            $donvibaucu2diadiem_tmp[] = $donviHasKey[$value]['ten'];
        }
        $donvibaucus[$i]['donvibaucu2diadiem_text'] = implode(', ',$donvibaucu2diadiem_tmp);
    }else{
        $donvibaucus[$i]['donvibaucu2diadiem_text'] = $donviHasKey[$donvibaucu['diaphuongbaucu_id']]['ten'];
    }
    // ----------------------
    $donvibaucus[$i]['donvibaucu2nguoiungcu'] = Core::loadColumn('baucu_donvibaucu2nguoiungcu','nguoiungcu_id','donvibaucu_id='.$donvibaucu['id']);
    $tong_donvibaucu2nguoiungcu += count($donvibaucus[$i]['donvibaucu2nguoiungcu']);
    // ..........................
    $donvibaucus[$i]['tonghopbienban'] = $model_tonghopbaucu->getTonghopBienban($dotbaucu_id, $donvibaucu['id'], 'quanhuyen');
    $donvibaucus[$i]['arr_nguoiungcu'] = $model_kiemphieu->getNguoiungcu($donvibaucu['id']);
    $nguoiungcus = $model_tonghopbaucu->getTonghopNguoiungcu($donvibaucu['id'],'quanhuyen');
    $soluongduocbau += Core::loadResult('baucu_donvibaucu2loaiphieubau','max(loaiphieubau_id)','donvibaucu_id='.(int)$donvibaucu['id']);
    $donvibaucus[$i]['soluongduocbau'] = Core::loadResult('baucu_donvibaucu2loaiphieubau','max(loaiphieubau_id)','donvibaucu_id='.(int)$donvibaucu['id'])+1;
    $songuoiungcu += count(Core::loadColumn('baucu_donvibaucu2nguoiungcu','nguoiungcu_id','donvibaucu_id='.$donvibaucu['id']));
    for($ii = 0, $n = count($nguoiungcus); $ii < $n; $ii++){
        $donvibaucus[$i]['nguoiungcu'][$nguoiungcus[$ii]['nguoiungcu_id']][$nguoiungcus[$ii]['quanhuyen_id']] = $nguoiungcus[$ii];
    }
}
?>
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf8">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:8.0pt;
	margin-left:0in;
	line-height:107%;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
.MsoChpDefault
	{font-family:"Calibri","sans-serif";}
.MsoPapDefault
	{margin-bottom:8.0pt;
	line-height:107%;}
@page WordSection1
	{size:8.5in 11.0in;
	margin:1.0in 1.0in 1.0in 1.0in;}
div.WordSection1
	{page:WordSection1;}
-->
</style>

</head>

<body lang=EN-US>

<div class=WordSection1>

<p class=MsoNormal align=right style='margin-bottom:0in;margin-bottom:.0001pt;
text-align:right;line-height:11.7pt;background:white'><a name="chuong_pl_27"><i><span
lang=VI style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Mẫu
số 27/HĐBC-HĐND</span></i></a></p>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0>
 <tr>
  <td width=223 valign=top style='width:167.4pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>ỦY
  BAN BẦU CỬ</span></b><b><span style='font-size:10.0pt;font-family:
  "Times New Roman","serif"'><br><span style="color:red"><?php echo mb_strtoupper($capbaucu['maunhaplieu'])?></span></span></b></p>
  </td>
  <td width=367 valign=top style='width:275.4pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>CỘNG
  HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM<br>
  Độc lập - Tự do - Hạnh phúc<br>
  ---------------</span></b></p>
  </td>
 </tr>
</table>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><b><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'> </span></b></p>

<p class=MsoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
text-align:center;line-height:11.7pt;background:white'><a
name="chuong_pl_27_name"><b><span lang=VI style='font-size:10.0pt;font-family:
"Arial","sans-serif";color:black'>BIÊN BẢN TỔNG KẾT
CUỘC BẦU CỬ</span></b></a><b><span lang=VI style='font-size:
10.0pt;font-family:"Arial","sans-serif";color:black'><br>
<a name="chuong_pl_27_name_name">ĐẠI BIỂU <span style="color:red"><?php echo mb_strtoupper($capbaucu['maunhaplieu'])?></span></a><br>
<a name="chuong_pl_27_name_name_name">KHÓA <span style="color:red">X, <span style="color:red"><?php echo mb_strtoupper($dotbaucu['ten'])?></span></a></span></b></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Vào
hồi .... giờ ... phút, ngày ... tháng ... năm <span style="color:red">2021</span>, Ủy ban
bầu cử <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span>
gồm có:</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>1. Ông/Bà
................................, Chủ tịch</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>2. Ông/Bà
................................, Phó Chủ tịch</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>3. Ông/Bà
................................, Phó Chủ tịch</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>4. Ông/Bà
................................, Ủy viên</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>5.
...............................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>...............................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Đã
họp tại ................ để lập biên bản
tổng kết cuộc bầu cử đại biểu
<span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span> khóa <span style="color:red">X., <span style="color:red"><?php echo ($dotbaucu['ten'])?></span>.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Theo quy
định của Luật Tổ chức chính quyền
địa phương thì <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span>
được bầu <sup>(2)</sup> ...... đại 
biểu Hội đồng nhân dân. Theo Nghị quyết
số .../NQ-UBBC ngày ... tháng ... năm <span style="color:red">2021</span> của Ủy ban
bầu cử <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span>, có tổng
cộng <span style="color:red"><?php echo $tong_donvibaucu2nguoiungcu;?></span> người ứng cử
đại biểu <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span>
khóa <span style="color:red">X, <span style="color:red"><?php echo ($dotbaucu['ten'])?></span>.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Sau khi
kiểm tra Biên bản xác định kết quả bầu
cử của các Ban bầu cử và giải quyết
khiếu nại, tố cáo (nếu có), Ủy ban bầu
cử xác nhận kết quả bầu cử đại
biểu Hội đồng nhân dân <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span>
khóa <span style="color:red">X, <span style="color:red"><?php echo ($dotbaucu['ten'])?></span> như sau:</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><b><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>1.
Số lượng đơn vị bầu cử, tổng
số cử tri, số cử tri tham gia bỏ phiếu
tại địa phương như sau:</span></b></p>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width="100%"
 style='width:100.0%'>
 <tr>
  <td width="5%" rowspan=2 valign=top style='width:5.0%;border:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>STT</span></b></p>
  </td>
  <td width="19%" rowspan=2 valign=top style='width:19.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Các
  đơn vị bầu cử</span></b></p>
  </td>
  <td width="10%" rowspan=2 valign=top style='width:10.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tổng
  số cử tri của đơn vị bầu cử</span></b></p>
  </td>
  <td width="10%" rowspan=2 valign=top style='width:10.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tổng
  số cử tri đã tham gia bỏ phiếu</span></b></p>
  </td>
  <td width="10%" rowspan=2 valign=top style='width:10.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tỷ
  lệ cử tri đã tham gia bỏ phiếu so với
  tổng số cử tri</span></b></p>
  </td>
  <td width="16%" colspan=2 valign=top style='width:16.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Phiếu
  hợp lệ</span></b></p>
  </td>
  <td width="16%" colspan=2 valign=top style='width:16.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Phiếu
  không hợp lệ</span></b></p>
  </td>
  <td width="9%" rowspan=2 valign=top style='width:9.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Ghi
  chú</span></b></p>
  </td>
 </tr>
 <tr>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>S</span></b><b><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'>ố </span></b><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>phiếu</span></b></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tỷ
  lệ % so với tổng số phiếu thu vào</span></b></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Số phiếu</span></b></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tỷ
  lệ % so với tổng số phiếu thu vào</span></b></p>
  </td>
 </tr>
 <?php for($ii=0; $ii<count($donvibaucus); $ii++){
     $donvibaucu=$donvibaucus[$ii];
     $tonghop = array();
     foreach ($donvibaucu['tonghopbienban'] as $key => $value) {
        $tonghop['tongsocutri'] += $value['tongsocutri'];
        $tonghop['socutribophieu'] += $value['socutribophieu'];
        $tonghop['sophieuthuvao'] += $value['sophieuthuvao'];
        $tonghop['sophieuhople'] += $value['sophieuhople'];
        $tonghop['sophieukhonghople'] += $value['sophieukhonghople'];
        $tmp_nguoiungcu[$donvibaucu['id']]['sophieuhople'] += $value['sophieuhople'];
     }
     $tonghop['tylecutri'] = $tonghop['tongsocutri']>0?($tonghop['socutribophieu']/$tonghop['tongsocutri']*100):0;
     $tonghop['tylephieuhople'] = $tonghop['sophieuthuvao']>0?($tonghop['sophieuhople']/$tonghop['sophieuthuvao']*100):0;
     $tonghop['tylephieukhonghople'] = $tonghop['sophieuthuvao']>0?($tonghop['sophieukhonghople']/$tonghop['sophieuthuvao']*100):0;
     $tongcong['tongsocutri'] += $tonghop['tongsocutri'];
     $tongcong['socutribophieu'] += $tonghop['socutribophieu'];
     $tongcong['sophieuthuvao'] += $tonghop['sophieuthuvao'];
     $tongcong['sophieuhople'] += $tonghop['sophieuhople'];
     $tongcong['sophieukhonghople'] += $tonghop['sophieukhonghople'];
     $tongcong['tylecutri'] = $tongcong['tongsocutri']>0?($tongcong['socutribophieu']/$tongcong['tongsocutri']*100):0;
     $tongcong['tylephieuhople'] = $tongcong['sophieuthuvao']>0?($tongcong['sophieuhople']/$tongcong['sophieuthuvao']*100):0;
     $tongcong['tylephieukhonghople'] = $tongcong['sophieuthuvao']>0?($tongcong['sophieukhonghople']/$tongcong['sophieuthuvao']*100):0;
     ?>
 <tr>
  <td width="5%" style='width:5.0%;border:solid windowtext 1.0pt;border-top:
  none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'><?php echo $ii+1;?></span></p>
  </td>
  <td width="19%" style='width:19.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><b><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo $donvibaucu['ten']?></span></span></b></p>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'>Gồm<sup>(3)</sup></span><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'> <span style="color:red"><?php echo $donvibaucu['donvibaucu2diadiem_text']?></span></span></p>
  </td>
  <td width="11%" style='width:11.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo number_format($tonghop['tongsocutri'], 0, ',', '.');?></span> </span></p>
  </td>
  <td width="11%" style='width:11.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo number_format($tonghop['socutribophieu'], 0, ',', '.');?></span> </span> </span></p>
  </td>
  <td width="11%" style='width:11.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo number_format($tonghop['tylecutri'], 2, ',', '.');?></span> </span> </span></p>
  </td>
  <td width="8%" style='width:8.0%;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo number_format($tonghop['sophieuhople'], 0, ',', '.');?></span> </span> </span></p>
  </td>
  <td width="8%" style='width:8.0%;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo number_format($tonghop['tylephieuhople'], 2, ',', '.');?></span> </span> </span></p>
  </td>
  <td width="8%" style='width:8.0%;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo number_format($tonghop['sophieukhonghople'], 0, ',', '.');?></span> </span> </span></p>
  </td>
  <td width="8%" style='width:8.0%;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo number_format($tonghop['tylephieukhonghople'], 2, ',', '.');?></span> </span> </span></p>
  </td>
  <td width="6%" style='width:6.0%;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
<?php }?>
<tr>
  <td width="5%" style='width:5.0%;border:solid windowtext 1.0pt;border-top:
  none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="19%" style='width:19.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tổng cộng:</span></b></p>
  </td>
  <td width="11%" style='width:11.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo number_format($tongcong['tongsocutri'], 0, ',', '.');?></span> </span>  </span></p>
  </td>
  <td width="11%" style='width:11.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo number_format($tongcong['socutribophieu'], 0, ',', '.');?></span> </span>  </span></p>
  </td>
  <td width="11%" style='width:11.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo number_format($tongcong['tylecutri'], 2, ',', '.');?></span> </span>  </span></p>
  </td>
  <td width="8%" style='width:8.0%;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo number_format($tongcong['sophieuhople'], 0, ',', '.');?></span> </span>  </span></p>
  </td>
  <td width="8%" style='width:8.0%;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo number_format($tongcong['tylephieuhople'], 2, ',', '.');?></span> </span>  </span></p>
  </td>
  <td width="8%" style='width:8.0%;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo number_format($tongcong['sophieukhonghople'], 0, ',', '.');?></span> </span>  </span></p>
  </td>
  <td width="8%" style='width:8.0%;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo number_format($tongcong['tylephieukhonghople'], 2, ',', '.');?></span> </span>  </span></p>
  </td>
  <td width="6%" style='width:6.0%;border-top:none;border-left:none;border-bottom:
  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><b><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>2.</span></b><span
lang=VI style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'> Các
đơn vị bầu cử có số cử tri đã tham
gia bỏ phiếu chưa đạt quá một nửa
tổng số cử tri của đơn vị bầu
cử hoặc có vi phạm pháp luật nghiêm trọng,
phải tổ chức bầu cử lại gồm<sup>(5)</sup>:</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>.........................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Kết
quả cử tri tham gia bỏ phiếu bầu cử
lại như sau (nếu có):</span></p>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width="100%"
 style='width:100.0%'>
 <tr>
  <td width="5%" rowspan=2 valign=top style='width:5.0%;border:solid windowtext 1.0pt;
  border-right:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>STT</span></b></p>
  </td>
  <td width="19%" rowspan=2 valign=top style='width:19.0%;border:solid windowtext 1.0pt;
  border-right:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Đơn
  vị bầu cử</span></b></p>
  </td>
  <td width="10%" rowspan=2 valign=top style='width:10.0%;border:solid windowtext 1.0pt;
  border-right:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tổng
  số cử tri của đơn vị bầu cử</span></b></p>
  </td>
  <td width="10%" rowspan=2 valign=top style='width:10.0%;border:solid windowtext 1.0pt;
  border-right:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tổng
  số cử tri đã tham gia bỏ phiếu</span></b></p>
  </td>
  <td width="10%" rowspan=2 valign=top style='width:10.0%;border:solid windowtext 1.0pt;
  border-right:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tỷ
  lệ cử tri đã tham gia bỏ phiếu so với
  tổng số cử tri</span></b></p>
  </td>
  <td width="16%" colspan=2 style='width:16.0%;border:solid windowtext 1.0pt;
  border-right:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Phiếu
  hợp lệ</span></b></p>
  </td>
  <td width="16%" colspan=2 valign=bottom style='width:16.0%;border:solid windowtext 1.0pt;
  border-right:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Phiếu
  không hợp lệ</span></b></p>
  </td>
  <td width="9%" rowspan=2 style='width:9.0%;border:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Ghi
  chú</span></b></p>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>(ngày
  tổ chức bầu cử lại)</span></p>
  </td>
 </tr>
 <tr>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Số phiếu</span></b></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tỷ
  lệ % so với tổng số phiếu thu vào</span></b></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>S</span></b><b><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'>ố </span></b><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>phiếu</span></b></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tỷ
  lệ % so với tổng số phiếu thu vào</span></b></p>
  </td>
 </tr>
 <tr>
  <td width="5%" valign=top style='width:5.0%;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>1.</span></b></p>
  </td>
  <td width="19%" valign=top style='width:19.0%;border-top:none;border-left:
  solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:
  none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><b><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'>Đơn vị
  bầu cử số...</span></b></p>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'>Gồm </span><sup><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'>(4)</span></sup><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'> ......</span></p>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span style='font-size:10.0pt;
  font-family:"Times New Roman","serif"'>.......</span></p>
  </td>
  <td width="10%" valign=top style='width:10.0%;border-top:none;border-left:
  solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:
  none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> </span></b></p>
  </td>
  <td width="10%" valign=top style='width:10.0%;border-top:none;border-left:
  solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:
  none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> </span></b></p>
  </td>
  <td width="10%" valign=top style='width:10.0%;border-top:none;border-left:
  solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:
  none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> </span></b></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> </span></b></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> </span></b></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> </span></b></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="9%" valign=top style='width:9.0%;border:solid windowtext 1.0pt;
  border-top:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><b><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>3.
Số phiếu bầu cho mỗi người ứng
cử đại biểu Hội đồng nhân dân như
sau:<sup>(6)</sup></span></b></p>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width="100%"
 style='width:100.0%'>
 <tr>
  <td width="7%" valign=top style='width:7.0%;border:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>STT</span></b></p>
  </td>
  <td width="24%" valign=top style='width:24.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Đơn
  vị b</span></b><b><span style='font-size:10.0pt;font-family:"Times New Roman","serif"'>ầ</span></b><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>u
  cử</span></b></p>
  </td>
  <td width="24%" valign=top style='width:24.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Họ
  và tên người ứng cử đại biểu
  HĐND<sup>(7)</sup></span></b></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Số
  phiếu bầu</span></b></p>
  </td>
  <td width="20%" valign=top style='width:20.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tỷ
  lệ % so với tổng số phiếu hợp lệ</span></b></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Ghi
  chú</span></b></p>
  </td>
 </tr>
 <?php for($i=0; $i<count($donvibaucus); $i++){
     $donvibaucu = $donvibaucus[$i];
     ?>
 <tr>
  <td width="7%" rowspan='<?php echo 1+count($donvibaucu['arr_nguoiungcu'])?>' style='width:7.0%;border:solid windowtext 1.0pt;
  border-top:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><?php echo $i+1;?>.</span></p>
  </td>
  <td width="29%" rowspan='<?php echo 1+count($donvibaucu['arr_nguoiungcu'])?>' style='width:29.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><b><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo $donvibaucu['ten'];?></span></span></b></p>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'>Gồm<sup>(3)</sup></span><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'> <span style="color:red"><?php echo $donvibaucu['donvibaucu2diadiem_text'];?></span></span></span></p>
  </td>
  </tr>
  <?php $djkfhksjdfh=0;
    for($j=0; $j<count($donvibaucu['arr_nguoiungcu']); $j++){
        foreach ($donvibaucu['nguoiungcu'][$donvibaucu['arr_nguoiungcu'][$j]['id']] as $key => $value) {
            $tmp_nguoiungcu[$donvibaucu['arr_nguoiungcu'][$j]['id']]['sophieubau'] += $value['sophieubau'];
            // $tmp_nguoiungcu[$donvibaucu['arr_nguoiungcu'][$j]['id']]['tongsophieuhople'] = $tmp_nguoiungcu[$donvibaucu['id']]['sophieuhople'];
            # code...
        }
        $tmp_nguoiungcu[$donvibaucu['arr_nguoiungcu'][$j]['id']]['tyle'] = $tmp_nguoiungcu[$donvibaucu['id']]['sophieuhople']>0?($tmp_nguoiungcu[$donvibaucu['arr_nguoiungcu'][$j]['id']]['sophieubau']/$tmp_nguoiungcu[$donvibaucu['id']]['sophieuhople']*100):0;
        $tmp_nguoiungcu[$donvibaucu['arr_nguoiungcu'][$j]['id']]['is_trungcu'] = $tmp_nguoiungcu[$donvibaucu['arr_nguoiungcu'][$j]['id']]['tyle']>=50?1:0;
        if($tmp_nguoiungcu[$donvibaucu['arr_nguoiungcu'][$j]['id']]['tyle']>=50){
            $tyle = (int)($tmp_nguoiungcu[$donvibaucu['arr_nguoiungcu'][$j]['id']]['tyle']*1000);
            $donvibaucus[$i]['tmp_nguoitrungcu'][$tyle]['id'] = $donvibaucu['arr_nguoiungcu'][$j]['id'];
            $donvibaucus[$i]['tmp_nguoitrungcu'][$tyle]['hoten'] = $donvibaucu['arr_nguoiungcu'][$j]['hoten'];
            $donvibaucus[$i]['tmp_nguoitrungcu'][$tyle]['sophieubau'] = $tmp_nguoiungcu[$donvibaucu['arr_nguoiungcu'][$j]['id']]['sophieubau'];
            $donvibaucus[$i]['tmp_nguoitrungcu'][$tyle]['tyle'] = $tmp_nguoiungcu[$donvibaucu['arr_nguoiungcu'][$j]['id']]['tyle'];
        }
        krsort($donvibaucus[$i]['tmp_nguoitrungcu']);
      ?>
  <tr>
  <td width="20%" style='width:20.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> <?php echo ++$djkfhksjdfh;?>. <span style="color:red"><?php echo $donvibaucu['arr_nguoiungcu'][$j]['hoten'];?></span></span></p>
  </td>
  <td width="13%" style='width:13.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo number_format($tmp_nguoiungcu[$donvibaucu['arr_nguoiungcu'][$j]['id']]['sophieubau'], 0, ',', '.');?></span></span></p>
  </td>
  <td width="18%" style='width:18.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> <span style="color:red"><?php echo number_format($tmp_nguoiungcu[$donvibaucu['arr_nguoiungcu'][$j]['id']]['tyle'], 2, ',', '.');?></span> %</span></p>
  </td>
  <td width="10%" style='width:10.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'></span></p>
  </td>
 </tr>
 <?php }?>
 <?php }?>
</table>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><b><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>4. Danh
sách những người trúng cử đại biểu
<span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span> khóa <span style="color:red">X,
<span style="color:red"><?php echo ($dotbaucu['ten'])?></span> theo từng đơn vị bầu
cử như sau:</span></b></p>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width="100%"
 style='width:100.0%'>
 <tr>
  <td width="7%" valign=top style='width:7.0%;border:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>STT</span></b></p>
  </td>
  <td width="24%" valign=top style='width:24.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Đơn
  vị bầu cử</span></b></p>
  </td>
  <td width="24%" valign=top style='width:24.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Họ
  và tên người trúng cử đại biểu HĐND<sup>(8)</sup></span></b></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Số
  phiếu bầu</span></b></p>
  </td>
  <td width="20%" valign=top style='width:20.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tỷ
  lệ % so với tổng số phiếu hợp lệ</span></b></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Ghi
  chú</span></b></p>
  </td>
 </tr>
 <?php for($i=0; $i<count($donvibaucus); $i++){
     $donvibaucu = $donvibaucus[$i];
     if(count($donvibaucu['tmp_nguoitrungcu'])>0){?>
 <tr>
  <td width="7%" rowspan='<?php echo count($donvibaucu['tmp_nguoitrungcu'])<$donvibaucu['soluongduocbau']-1?count($donvibaucu['tmp_nguoitrungcu'])+1:$donvibaucu['soluongduocbau']?>' style='width:7.0%;border:solid windowtext 1.0pt;
  border-top:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><?php echo $i+1;?>. <?php //echo '----'.count($donvibaucu['tmp_nguoitrungcu']).'.'.($donvibaucu['soluongduocbau']-1);var_dump($donvibaucu['tmp_nguoitrungcu']);?></span></p>
  </td>
  <td width="27%" rowspan='<?php echo count($donvibaucu['tmp_nguoitrungcu'])<$donvibaucu['soluongduocbau']-1?count($donvibaucu['tmp_nguoitrungcu'])+1:$donvibaucu['soluongduocbau']?>' style='width:27.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><b><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo $donvibaucu['ten']?></span></span></b></p>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'>Gồm<sup>(3)</sup></span><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'> <span style="color:red"><?php echo $donvibaucu['donvibaucu2diadiem_text']?></span></span></p>
  </td>
  </tr>
  <?php 
    $sjdfwef =0;
      foreach ($donvibaucu['tmp_nguoitrungcu'] as $key => $value) {
        if(($sjdfwef+1)< $donvibaucu['soluongduocbau']){
      ?>
  <tr>
  <td width="22%" style='width:22.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'><?php echo ++$sjdfwef;?>. </span><span style="color:red"><?php echo $value['hoten']?></span></p>
  </td>
  <td width="13%" style='width:13.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> <span style="color:red"><?php echo number_format($value['sophieubau'], 0, ',', '.')?></span></span></p>
  </td>
  <td width="17%" style='width:17.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> <span style="color:red"><?php echo number_format($value['tyle'], 2, ',', '.')?></span> %</span></p>
  </td>
  <td width="12%" style='width:12.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
 <?php }?>
 <?php }?>
 <?php }?>
 <?php }?>
</table>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><b><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>5.</span></b><span
lang=VI style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'> Các
đơn vị bầu cử có số người trúng
cử ít hơn số đại biểu Hội
đồng nhân dân được bầu do Ủy ban
bầu cử ấn định, phải tổ chức
bầu cử thêm gồm <sup>(9)</sup>:</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>...................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>...................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Kết
quả cử tri tham gia bỏ phiếu bầu cử thêm
như sau:</span></p>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width="100%"
 style='width:100.0%'>
 <tr>
  <td width="5%" rowspan=2 valign=top style='width:5.0%;border:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>STT</span></b></p>
  </td>
  <td width="19%" rowspan=2 valign=top style='width:19.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Các
  đơn vị bầu cử</span></b></p>
  </td>
  <td width="10%" rowspan=2 valign=top style='width:10.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tổng
  số cử tri của đơn vị bầu cử</span></b></p>
  </td>
  <td width="10%" rowspan=2 valign=top style='width:10.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tổng
  số cử tri đã tham gia bỏ phiếu</span></b></p>
  </td>
  <td width="10%" rowspan=2 valign=top style='width:10.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tỷ
  lệ cử tri đã tham gia bỏ phiếu so với
  tổng số cử tri</span></b></p>
  </td>
  <td width="16%" colspan=2 valign=top style='width:16.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Phiếu
  hợp lệ</span></b></p>
  </td>
  <td width="16%" colspan=2 valign=top style='width:16.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Phiếu
  không hợp lệ</span></b></p>
  </td>
  <td width="9%" rowspan=2 valign=top style='width:9.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Ghi
  chú</span></b></p>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>(ngày
  tổ chức bầu cử thêm)</span></p>
  </td>
 </tr>
 <tr>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Số phiếu</span></b></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tỷ
  lệ % so với tổng số phiếu thu vào</span></b></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Số phiếu</span></b></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tỷ
  lệ % so với tổng số phiếu thu vào</span></b></p>
  </td>
 </tr>
 <tr>
  <td width="5%" valign=top style='width:5.0%;border:solid windowtext 1.0pt;
  border-top:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>1.</span></p>
  </td>
  <td width="19%" valign=top style='width:19.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><b><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'>Đơn vị
  bầu cử số...</span></b></p>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'>Gồm</span><sup><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'>(4)</span></sup><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'> .............</span></p>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span style='font-size:10.0pt;
  font-family:"Times New Roman","serif"'>..................</span></p>
  </td>
  <td width="10%" valign=top style='width:10.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="10%" valign=top style='width:10.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="10%" valign=top style='width:10.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="9%" valign=top style='width:9.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
 <tr>
  <td width="5%" valign=top style='width:5.0%;border:solid windowtext 1.0pt;
  border-top:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>2.</span></p>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'>...</span></p>
  </td>
  <td width="19%" valign=top style='width:19.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span style='font-size:10.0pt;
  font-family:"Times New Roman","serif"'>..................</span></p>
  </td>
  <td width="10%" valign=top style='width:10.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="10%" valign=top style='width:10.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="10%" valign=top style='width:10.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="9%" valign=top style='width:9.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
 <tr>
  <td width="25%" colspan=2 valign=top style='width:25.0%;border:solid windowtext 1.0pt;
  border-top:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tổng
  cộng:</span></b></p>
  </td>
  <td width="10%" valign=top style='width:10.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="10%" valign=top style='width:10.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="10%" valign=top style='width:10.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="8%" valign=top style='width:8.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="9%" valign=top style='width:9.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Kết
quả bầu cử thêm như sau:</span></p>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width="100%"
 style='width:100.0%'>
 <tr>
  <td width="7%" valign=top style='width:7.0%;border:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>STT</span></b></p>
  </td>
  <td width="24%" valign=top style='width:24.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Đơn
  vị bầu cử</span></b></p>
  </td>
  <td width="24%" valign=top style='width:24.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Họ
  và tên người ứng cử đại biểu
  HĐND<sup>(7)</sup></span></b></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>S</span></b><b><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'>ố</span></b><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> phiếu
  bầu</span></b></p>
  </td>
  <td width="20%" valign=top style='width:20.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tỷ
  lệ % so với tổng số phiếu hợp lệ</span></b></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Ghi
  chú</span></b></p>
  </td>
 </tr>
 <tr>
  <td width="7%" rowspan=4 valign=top style='width:7.0%;border:solid windowtext 1.0pt;
  border-top:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>1.</span></p>
  </td>
  <td width="24%" rowspan=4 valign=top style='width:24.0%;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><b><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'>Đơn vị
  bầu cử số...</span></b></p>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'>Gồm </span><sup><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'>(4)</span></sup><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'> .............</span></p>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span style='font-size:10.0pt;
  font-family:"Times New Roman","serif"'>..................</span></p>
  </td>
  <td width="24%" valign=top style='width:24.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'>1.</span></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="20%" valign=top style='width:20.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
 <tr>
  <td width="24%" valign=top style='width:24.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'>2.</span></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="20%" valign=top style='width:20.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
 <tr>
  <td width="24%" valign=top style='width:24.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'>3</span></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="20%" valign=top style='width:20.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
 <tr>
  <td width="24%" valign=top style='width:24.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="20%" valign=top style='width:20.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
 <tr>
  <td width="7%" rowspan=2 valign=top style='width:7.0%;border:solid windowtext 1.0pt;
  border-top:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>2.</span></p>
  </td>
  <td width="24%" rowspan=2 valign=top style='width:24.0%;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span style='font-size:10.0pt;
  font-family:"Times New Roman","serif"'>..............</span></p>
  </td>
  <td width="24%" valign=top style='width:24.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="20%" valign=top style='width:20.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
 <tr>
  <td width="24%" valign=top style='width:24.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="20%" valign=top style='width:20.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Danh sách
những người trúng cử đại biểu <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span> khóa <span style="color:red">X,
<span style="color:red"><?php echo ($dotbaucu['ten'])?></span> sau khi bầu cử thêm như sau:</span></p>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width="100%"
 style='width:100.0%'>
 <tr>
  <td width="7%" valign=top style='width:7.0%;border:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>STT</span></b></p>
  </td>
  <td width="24%" valign=top style='width:24.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Đơn
  vị bầu cử</span></b></p>
  </td>
  <td width="24%" valign=top style='width:24.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Họ
  và tên người trúng cử đại biểu HĐND<sup>(8)</sup></span></b></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Số
  phiếu bầu</span></b></p>
  </td>
  <td width="20%" valign=top style='width:20.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Tỷ
  lệ % so với tổng số phiếu hợp lệ</span></b></p>
  </td>
  <td width="11%" valign=top style='width:11.0%;border:solid windowtext 1.0pt;
  border-left:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>Ghi
  chú</span></b></p>
  </td>
 </tr>
 <?php for($i=0; $i<count($donvibaucus); $i++){
     $donvibaucu = $donvibaucus[$i];
     if(count($donvibaucu['tmp_nguoitrungcu'])>0){?>
 <tr>
  <td width="7%" rowspan='<?php echo count($donvibaucu['tmp_nguoitrungcu'])<$donvibaucu['soluongduocbau']-1?count($donvibaucu['tmp_nguoitrungcu'])+1:$donvibaucu['soluongduocbau']?>' style='width:7.0%;border:solid windowtext 1.0pt;
  border-top:none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><?php echo $i+1;?>.</span></p>
  </td>
  <td width="27%" rowspan='<?php echo count($donvibaucu['tmp_nguoitrungcu'])<$donvibaucu['soluongduocbau']-1?count($donvibaucu['tmp_nguoitrungcu'])+1:$donvibaucu['soluongduocbau']?>' style='width:27.0%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><b><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo $donvibaucu['ten']?></span></span></b></p>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'>Gồm<sup>(3)</sup></span><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'> <span style="color:red"><?php echo $donvibaucu['donvibaucu2diadiem_text']?></span></span></p>
  </td>
  </tr>
  <?php 
    $sjdfwef =0;
      foreach ($donvibaucu['tmp_nguoitrungcu'] as $key => $value) {
        if(($sjdfwef+1)< $donvibaucu['soluongduocbau']){
      ?>
  <tr>
  <td width="22%" style='width:22.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span lang=VI style='font-size:
  10.0pt;font-family:"Times New Roman","serif"'><?php echo ++$sjdfwef;?>. </span><span style="color:red"><?php echo $value['hoten']?></span></p>
  </td>
  <td width="13%" style='width:13.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> <span style="color:red"><?php echo number_format($value['sophieubau'], 0, ',', '.')?></span></span></p>
  </td>
  <td width="17%" style='width:17.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> <span style="color:red"><?php echo number_format($value['tyle'], 2, ',', '.')?></span> %</span></p>
  </td>
  <td width="12%" style='width:12.0%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
 <?php }?>
 <?php }?>
 <?php }?>
 <?php }?>
</table>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><b><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>6. Những
việc quan trọng đã xảy ra và kết quả
giải quyết:</span></b></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><b><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>...................................................................</span></b></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><b><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>...................................................................</span></b></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><b><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>7.
Những khiếu nại, tố cáo do Ủy ban bầu
cử đã giải quyết:</span></b></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>...................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>...................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Biên
bản tổng kết cuộc bầu cử đại
biểu Hội đồng nhân dân <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span>
khóa <span style="color:red">X, <span style="color:red"><?php echo ($dotbaucu['ten'])?></span> được lập thành
06 bản và được gửi đến ...............<sup>(10)</sup></span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'> </span></p>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0>
 <tr>
  <td width=295 valign=top style='width:221.4pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>TM.
  ỦY BAN BẦU CỬ<br>
  CHỦ TỊCH</span></b><span lang=VI style='font-size:10.0pt;
  font-family:"Times New Roman","serif"'><br>
  (Ký, ghi rõ họ và tên,<br>
  đóng dấu của Ủy ban bầu cử)</span></p>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width=295 valign=top style='width:221.4pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>CÁC
  PHÓ CHỦ TỊCH<br>
  </span></b><span lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>(Ký,
  ghi rõ họ và tên)</span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><b><i><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Ghi chú:
Nhất thiết không được tẩy xóa trên biên
bản.</span></i></b></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(1) Ghi
tên đơn vị hành chính cấp tổ chức bầu
cử đại biểu Hội đồng nhân dân.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(2) Ghi
rõ số lượng đại biểu Hội
đồng nhân dân được bầu tại đơn
vị bầu cử theo Nghị quyết của Ủy ban
bầu cử ở cấp đó.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(3) Ghi
rõ số lượng người ứng cử đại
biểu Hội đồng nhân dân ở cấp tổ
chức bầu cử theo Danh sách chính thức những
người ứng cử đại biểu Hội
đồng nhân dân do Ủy ban bầu cử đó công
bố.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(4) Ghi
tên các đơn vị hành chính cấp dưới hoặc
thôn, tổ dân phố trong phạm vi đơn vị
bầu cử đại biểu Hội đồng nhân dân
tương ứng ở mỗi cấp.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(5)
Nếu không có đơn vị nào phải tổ chức
bầu cử lại thì ghi "Không có" và không
điền nội dung trong bảng thống kê kết
quả kèm theo mục này.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(6) Ghi
kết quả phiếu bầu cho mỗi người
ứng cử đại biểu Hội đồng nhân dân
cấp mình theo bảng kèm theo. Trường hợp
đơn vị bầu cử phải tổ chức
bầu cử lại thì ghi kết quả bầu cử
lại.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(7) Ghi
theo danh sách trên phiếu bầu cử đại biểu
Hội đồng nhân dân.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(8)
Xếp theo thứ tự từ người nhiều
phiếu nhất đến người ít phiếu
nhất.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(9)
Nếu không có đơn vị nào phải tổ chức
bầu cử thêm thì ghi "Không có".</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(10)
Đối với Biên bản tổng kết cuộc
bầu cử đại biểu Hội đồng nhân dân
cấp huyện, cấp xã thì ghi gửi đến <i>"Hội
đồng nhân dân, Ủy ban nhân dân, Ban Thường
trực Ủy ban Mặt trận Tổ quốc Việt Nam
cung cấp và cấp trên trực tiếp"</i>.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Đối
với Biên bản tổng kết cuộc bầu cử
đại biểu Hội đồng nhân dân cấp
tỉnh thì ghi gửi đến <i>"Hội
đồng nhân dân, Ủy ban nhân dân, Ban Thường
trực Ủy ban Mặt trận Tổ quốc Việt Nam
cung cấp, Ủy ban Thường vụ Quốc hội,
Chính phủ, Ủy ban Trung ương Mặt trận
Tổ quốc Việt Nam".</i></span></p>

<p class=MsoNormal> </p>

</div>

</body>

</html>
