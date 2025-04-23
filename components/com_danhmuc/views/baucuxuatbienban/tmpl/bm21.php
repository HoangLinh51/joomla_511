<?php
$donvibaucu = $this->donvibaucu;
$dotbaucu_id = $this->dotbaucu_id;
$dotbaucu = Core::loadAssoc('baucu_dotbaucu','*','id='.(int)$dotbaucu_id);
$donviHasKey = Core::loadAssocListHasKey('baucu_diadiemhanhchinh','*','id');
// ---------------------
$donvibaucu2diadiem = Core::loadColumn('baucu_donvibaucu2diadiem','diadiem_id','donvibaucu_id='.$donvibaucu['id']);
foreach ($donvibaucu2diadiem as $key => $value) {
    $donvibaucu2diadiem_tmp[] = $donviHasKey[$value]['ten'];
}
$donvibaucu2diadiem_text = implode(', ',$donvibaucu2diadiem_tmp);
// ----------------------
$donvibaucu2nguoiungcu = Core::loadColumn('baucu_donvibaucu2nguoiungcu','nguoiungcu_id','donvibaucu_id='.$donvibaucu['id']);
// ..........................
$model_tonghopbaucu = Core::model('Baucu/Tonghop');
$model_kiemphieu = Core::model('Baucu/Kiemphieu');
$tonghopbienban = $model_tonghopbaucu->getTonghopBienban($dotbaucu_id, $donvibaucu['id'], 'quanhuyen');
$arr_nguoiungcu = $model_kiemphieu->getNguoiungcu($donvibaucu['id']);
$nguoiungcus = $model_tonghopbaucu->getTonghopNguoiungcu($donvibaucu['id'],'quanhuyen');

for($i = 0, $n = count($nguoiungcus); $i < $n; $i++){
    $nguoiungcu[$nguoiungcus[$i]['nguoiungcu_id']][$nguoiungcus[$i]['quanhuyen_id']] = $nguoiungcus[$i];
}
foreach ($tonghopbienban as $key => $value) {
    $tonghop['tongsocutri'] += $value['tongsocutri'];
    $tonghop['socutribophieu'] += $value['socutribophieu'];
    
    $tonghop['sophieuphatra'] += $value['sophieuphatra'];
    $tonghop['sophieuthuvao'] += $value['sophieuthuvao'];
    $tonghop['sophieuhople'] += $value['sophieuhople'];
    $tonghop['sophieukhonghople'] += $value['sophieukhonghople'];
    
    $tonghop['tongsokhuvucbophieu'] += $value['tongsokhuvucbophieu'];
    $tonghop['tongphieubaucacloai'] += $value['tongphieubaucacloai'];
    $tonghop['tongphieubauungcu'] += $value['tongphieubauungcu'];
}
$tonghop['tylephieukhonghople'] = (int)$tonghop['sophieuthuvao']==0?0:$tonghop['sophieukhonghople']/$tonghop['sophieuthuvao'];
$tonghop['tylephieuhople'] = (int)$tonghop['sophieuthuvao']==0?0:$tonghop['sophieuhople']/$tonghop['sophieuthuvao'];
$tonghop['tylecutri'] = (int)$tonghop['tongsocutri']==0?0:$tonghop['socutribophieu']/$tonghop['tongsocutri'];
$soluongduocbau = Core::loadResult('baucu_donvibaucu2loaiphieubau','max(loaiphieubau_id)','donvibaucu_id='.(int)$donvibaucu['id']);
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
text-align:right;line-height:11.7pt;background:white'><a name="chuong_pl_21"><i><span
lang=VI style='font-family:"Times New Roman","serif";color:black'>Mẫu
số 21/HĐBC-QH</span></i></a></p>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width="100%"
 style='width:100.0%'>
 <tr>
  <td width="37%" valign=top style='width:37.0%;padding:0in 0in 0in 0in'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span lang=VI style='font-family:"Times New Roman","serif";
  color:black;letter-spacing:-.2pt;background:white'><br clear=all>
  </span></p>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-family:"Times New Roman","serif";letter-spacing:-.2pt;
  background:white'>BAN BẦU CỬ ĐẠI BIỂU</span></b><b><span
  style='font-family:"Times New Roman","serif";letter-spacing:-.2pt;background:
  white'><br>
  </span></b><b><span lang=VI style='font-family:"Times New Roman","serif";
  letter-spacing:-.2pt;background:white'>QUỐC HỘI</span></b></p>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='color:red; font-family:"Times New Roman","serif";letter-spacing:-.2pt;
  background:white'><?php echo mb_strtoupper($donvibaucu['ten'])?></span></p>
  </td>
  <td width="62%" valign=top style='width:62.0%;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-family:"Times New Roman","serif"'>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM<br>
  Độc lập - Tự do - Hạnh phúc<br>
  ---------------</span></b></p>
  </td>
 </tr>
</table>

<p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt;
background:white'><b><span lang=VI style='font-family:"Times New Roman","serif";
color:black;letter-spacing:-.2pt;background:white'> </span></b></p>

<p class=MsoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
text-align:center;line-height:11.7pt;background:white'><a
name="chuong_pl_21_name"><b><span lang=VI style='font-family:"Times New Roman","serif";
color:black;letter-spacing:-.2pt'>BIÊN BẢN</span></b></a><b><span
lang=VI style='font-family:"Times New Roman","serif";color:black;letter-spacing:
-.2pt;background:white'><br>
</span></b><a name="chuong_pl_21_name_name"><b><span lang=VI style='font-family:
"Times New Roman","serif";color:black;letter-spacing:-.2pt'>XÁC ĐỊNH
KẾT QUẢ BẦU CỬ ĐẠI BIỂU QUỐC
HỘI KHÓA <span style="color:red"><?php echo mb_strtoupper($dotbaucu['khoa'])?></span></span></b></a><b><span lang=VI style='font-family:"Times New Roman","serif";
color:black;letter-spacing:-.2pt;background:white'><br>
</span></b><a name="chuong_pl_21_name_name_name"><b><span lang=VI
style='font-family:"Times New Roman","serif";color:red; ;letter-spacing:-.2pt'>Ở
<?php echo mb_strtoupper($donvibaucu['ten'])?></span></b></a></p>

<p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt;
background:white'><b><span lang=VI style='font-family:"Times New Roman","serif";
color:black;letter-spacing:-.2pt;background:white'>Gồm</span></b><b><span
lang=VI style='font-family:"Times New Roman","serif";color:black;letter-spacing:
-.2pt'> <sup>(1)</sup><span style='color:red; background:white'> <?php echo $donvibaucu2diadiem_text?></span></span></b></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black;letter-spacing:-.2pt;
background:white'>Hồi ....... giờ ... phút, ngày .......... tháng
.......... năm <span style="color:red"><?php echo date('Y');?></span>, Ban bầu cử đại biểu
Quốc hội gồm có:</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black;letter-spacing:-.2pt;
background:white'>1.
Ông/Bà...................................................................,
Trưởng ban</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black;letter-spacing:-.2pt;
background:white'>2. Ông/Bà...................................................................,
Phó Trưởng ban</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black;letter-spacing:-.2pt;
background:white'>3.
Ông/Bà..................................................................., Phó
Trưởng ban</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black;letter-spacing:-.2pt;
background:white'>4</span><span style='font-family:"Times New Roman","serif";
color:black;letter-spacing:-.2pt;background:white'>.</span><span lang=VI
style='font-family:"Times New Roman","serif";color:black;letter-spacing:-.2pt;
background:white'> Ông/Bà ................................................................,
Ủy viên</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black;letter-spacing:-.2pt;
background:white'>5.
.................................................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>Đã họp
tại <span style='letter-spacing:-.2pt;background:white'>...............................................................</span> để lập biên bản xác định kết quả bầu cử đại biểu Quốc hội khóa <span style="color:red"><?php echo ($dotbaucu['khoa'])?></span> tại các khu vực bỏ phiếu của <span style="color:red"><?php echo $donvibaucu['ten']?></span> gồm <sup>(1)</sup> <span style='letter-spacing:-.2pt;
background:white'><span style="color:red"><?php echo $donvibaucu2diadiem_text?></span></span><span
style='letter-spacing:-.2pt'> </span>thuộc tỉnh/thành
phố <span style='letter-spacing:-.2pt;background:white'> Đà Nẵng</span></span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>Theo Nghị quyết số: ............ /NQ-HĐBCQG ngày ... tháng ... năm <span style="color:red"><?php echo date('Y');?></span> của Hội đồng bầu cử quốc gia, thì <span style="color:red"><?php echo ($donvibaucu['ten'])?></span> được bầu<sup>(2)</sup> <span style="color:red"><?php echo ($soluongduocbau);?></span> đại biểu Quốc hội.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>Theo Nghị quyết số /NQ-HĐBCQG ngày .... tháng ..... năm <span style="color:red"><?php echo date('Y');?></span> của Hội đồng bầu cử quốc gia, thì <span style="color:red"><?php echo ($donvibaucu['ten'])?></span> có <sup>(3)</sup> <span style="color:red"><?php echo count($donvibaucu2nguoiungcu);?></span> người ứng cử đại biểu Quốc hội.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>Sau khi kiểm tra và tổng hợp kết quả từ Biên bản kết quả kiểm phiếu do các Tổ bầu cử chuyển đến, kết quả bầu cử đại biểu Quốc hội ở <span style="color:red"><?php echo $donvibaucu['ten']?></span> như sau:</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>- Tổng số
cử tri của đơn vị bầu cử: <span style="color:red"><?php echo number_format($tonghop['tongsocutri'], 0, ',', '.');?></span> người.</p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>- Số cử
tri đã tham gia bỏ phiếu: <span style="color:red"><?php echo number_format($tonghop['socutribophieu'], 0, ',', '.');?> </span>người.</p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>- Tỷ lệ
cử tri đã tham gia bỏ phiếu so với tổng
số cử tri của đơn vị bầu cử:
<span style="color:red"><?php echo number_format(100*$tonghop['tylecutri'], 2, ',', '.');?> </span>%</p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>- Số
phiếu phát ra: <span style="color:red"><?php echo number_format($tonghop['sophieuphatra'], 0, ',', '.');?></span> phiếu.</p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>- Số
phiếu thu vào: <span style="color:red"><?php echo number_format($tonghop['sophieuthuvao'], 0, ',', '.');?></span> phiếu.</p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>- Số
phiếu hợp lệ:<span style="color:red"> <?php echo number_format($tonghop['sophieuhople'], 0, ',', '.');?></span> phiếu. Tỷ
lệ so với tổng số phiếu thu vào: <span style="color:red"><?php echo number_format(100*$tonghop['tylephieuhople'], 2, ',', '.');?></span> %</p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>- Số
phiếu không hợp lệ: <span style="color:red"><?php echo number_format($tonghop['sophieukhonghople'], 0, ',', '.');?></span> phiếu. Tỷ lệ
so với tổng số phiếu thu vào: <span style="color:red"><?php echo number_format(100*$tonghop['tylephieukhonghople'], 2, ',', '.');?></span> %</span></p>

<p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt;
background:white'><b><span lang=VI style='font-family:"Times New Roman","serif";
color:black'>SỐ PHIẾU BẦU CHO MỖI NGƯỜI
ỨNG CỬ<sup>(4)</sup></span></b></p>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width="100%"
 style='width:100.0%'>
 <tr style='height:71.25pt'>
  <td width="18%" style='width:18.0%;border-top:solid windowtext 1.0pt;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:none;
  background:white;padding:0in 0in 0in 0in;height:71.25pt'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-family:"Times New Roman","serif"'>Tên
  huyện/quận/ thị xã/thành phố trong phạm vi đơn vị bầu cử</span></b></p>
  </td>
  <td width="14%" style='width:14.0%;border-top:solid windowtext 1.0pt;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:none;
  background:white;padding:0in 0in 0in 0in;height:71.25pt'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-family:"Times New Roman","serif"'>Số khu vực bỏ phiếu của mỗi huyện, quận, thị
  xã, thành phố</span></b></p>
  </td>
  <?php for($i=0; $i<count($arr_nguoiungcu); $i++){?>
  <td width="10%" style='width:10.0%;border-top:solid windowtext 1.0pt;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:none;
  background:white;padding:0in 0in 0in 0in;height:71.25pt'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-family:"Times New Roman","serif"'>
  Số phiếu bầu cho <?php echo $arr_nguoiungcu[$i]['hoten']?></span></b></p>
  </td>
  <?php }?>
  <td width="16%" style='width:16.0%;border:solid windowtext 1.0pt;border-bottom:
  none;background:white;padding:0in 0in 0in 0in;height:71.25pt'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-family:"Times New Roman","serif"'>Ghi chú</span></b></p>
  </td>
 </tr>
 <?php foreach ($tonghopbienban as $key => $value) {?>
 <tr>
  <td width="18%" style='width:18.0%;border-top:solid windowtext 1.0pt;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:none;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='color: red; font-family:"Times New Roman","serif"'><?php echo $value['quanhuyen']?></span></p>
  </td>
  <td width="14%" style='width:14.0%;border-top:solid windowtext 1.0pt;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:none;
  background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='color: red; font-family:"Times New Roman","serif"'><?php echo number_format($value['tongsokhuvucbophieu'], 0, ',', '.')?></span></p>
  </td>
  <?php foreach ($nguoiungcu as $k2 => $v2) {?>
    <td width="10%" style='width:10.0%;border-top:solid windowtext 1.0pt;
    border-left:solid windowtext 1.0pt;border-bottom:none;border-right:none;
    background:white;padding:0in 0in 0in 0in'>
    <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
    margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
    lang=VI style='color: red; font-family:"Times New Roman","serif"'>
    <?php echo number_format($v2[$value['quanhuyen_id']]['sophieubau'], 0, ',', '.');?>
    <?php
     $tmp_tongphieubau[$k2]['sophieubau'] += $v2[$value['quanhuyen_id']]['sophieubau'];
     $tmp_tongphieubau[$k2]['hoten'] = $v2[$value['quanhuyen_id']]['hoten'];
     ?>
     <?php// echo '-'.$tmp_tongphieubau[$k2].'-'?>
    </span></p>
    </td>
    <?php }?>
  <td width="16%" style='width:16.0%;border:solid windowtext 1.0pt;border-bottom:
  none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='color: red; font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
 <?php }?>
 <tr>
  <td width="18%" style='width:18.0%;border:solid windowtext 1.0pt;border-right:
  none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-family:"Times New Roman","serif"'>Tổng cộng:</span></b></p>
  </td>
  <td width="14%" style='width:14.0%;border:solid windowtext 1.0pt;border-right:
  none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='color: red; font-family:"Times New Roman","serif"'> <?php echo number_format($tonghop['tongsokhuvucbophieu'], 0, ',', '.')?></span></b></p>
  </td>
  <?php foreach ($nguoiungcu as $k2 => $v2) {?>
  <td width="10%" style='width:10.0%;border:solid windowtext 1.0pt;border-right:
  none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='color: red; font-family:"Times New Roman","serif"'>
  <?php
  echo number_format($tmp_tongphieubau[$k2]['sophieubau'], 0, ',', '.');?>
  </span></b></p>
  </td>
<?php }?>
  <td width="16%" style='width:16.0%;border:solid windowtext 1.0pt;background:
  white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-family:"Times New Roman","serif"'> </span></b></p>
  </td>
 </tr>
 <tr>
  <td width="18%" style='width:18.0%;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-family:"Times New Roman","serif"'>Tỷ lệ % so với tổng số phiếu hợp lệ</span></b></p>
  </td>
  <td width="14%" style='width:14.0%;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <?php foreach ($nguoiungcu as $k2 => $v2) {?>
  <td width="10%" style='width:10.0%;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:solid windowtext 1.0pt;border-right:none;background:white;
  padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  style='color:red; font-family:"Times New Roman","serif"'><?php echo number_format($tmp_tongphieubau[$k2]['sophieubau']/$tonghop['sophieuhople']*100, 2, ',', '.')?></span><span lang=VI
  style='font-family:"Times New Roman","serif"'>%</span></p>
  </td>
  <?php }?>
  <td width="16%" style='width:16.0%;border:solid windowtext 1.0pt;border-top:
  none;background:white;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-family:"Times New Roman","serif"'> </span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><b><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>Căn cứ vào kết quả ghi trên đây, Ban bầu cử đại biểu Quốc hội kết luận:</span></b></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>a) Số cử
tri đã tham gia bỏ phiếu đạt <span style="color:red"><?php echo number_format($tonghop['socutribophieu']/$tonghop['tongsocutri']*100, 2, ',', '.')?></span>% so
với tổng số cử tri của đơn vị
bầu cử.</span></p>
<?php if($tonghop['socutribophieu']/$tonghop['tongsocutri']*100 <50){?>
<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><sup><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>(5)</span></sup><span
lang=VI style='color: red; font-family:"Times New Roman","serif";color:black'>Vì số cử tri đi bỏ phiếu chưa đạt quá nửa tổng số cử tri của đơn vị bầu cử, nên cuộc bầu cử đại biểu Quốc hội tại <span style="color:red"><?php echo $donvibaucu['ten']?></span> không có giá trị. Đề nghị Ủy ban bầu cử ở tỉnh/thành phố báo cáo Hội đồng bầu cử quốc gia xem xét, quyết định việc bầu cử lại tại đơn vị bầu cử</span></p>
<?php }?>
<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>b) Các Ông/Bà có tên
sau đây nhận được quá nửa tổng số
phiếu hợp lệ và có nhiều phiếu hơn, đã
trúng cử đại biểu Quốc hội khóa <span style="color:red"><?php echo ($dotbaucu['khoa'])?></span><sup>(6)</sup>:</span></p>
<?php foreach($tmp_tongphieubau as $k3 => $v3){
    $phantram = $v3['sophieubau']/$tonghop['sophieuhople']*10000;
    $xephang[$phantram] = $v3;
    $xephang[$phantram]['phantram'] = $phantram/100;
    if($phantram/100>=50) $tmp['sodaibieutrungcu']++;
    else $tmp['sodaibieukhongtrungcu']++;
 }
 rsort($xephang);
 ?>
<?php foreach($xephang as $k3 => $v3){?>
<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'><?php echo ++$mmmmmmm?>. <?php echo $v3['hoten']?> số phiếu: <span style="color:red"><?php echo number_format($v3['sophieubau'], 0, ',', '.');?></span> đạt:
    <span style="color:red"><?php echo number_format(100*$v3['sophieubau']/ $tonghop['sophieuhople'], 2, ',', '.');?></span>% so với tổng số phiếu hợp lệ.</span></pre>
<?php }?>
<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>c) Theo ấn
định của Hội đồng bầu cử
quốc gia thì số đại biểu Quốc hội
được bầu ở đơn vị bầu
cử số <span style="color:red"><?php echo $donvibaucu['ten']?></span> là <span style="color:red"><?php echo ($soluongduocbau)?></span> đại biểu, nay
đã bầu được <span style="color:red"><?php echo $tmp['sodaibieutrungcu']?></span> đại biểu,
còn thiếu <span style="color:red"><?php echo (int)($soluongduocbau-$tmp['sodaibieutrungcu'])?></span> đại biểu.</span></p>

<?php if(($soluongduocbau-$tmp['sodaibieutrungcu'])>0){?>
<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><sup><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>(7)</span></sup><span
lang=VI style='color:red; font-family:"Times New Roman","serif";color:red'> Vì số người trúng cử đại biểu Quốc hội chưa đủ số lượng đại biểu được bầu đã ấn định cho đơn vị bầu cử nên đề nghị Ủy ban bầu cử ở tỉnh/thành phố Đà Nẵng báo cáo Hội đồng bầu cử quốc gia để xem xét, quyết định việc bầu cử thêm tại đơn vị bầu cử</span></p>
<?php }?>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>d) Tóm tắt
những việc xảy ra <sup>(8)</sup>: ...........................................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>...............................................................................................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>đ) Những
khiếu nại, tố cáo trong quá trình bầu cử do các
Tổ bầu cử đã giải quyết<sup>(9)</sup>:</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>...............................................................................................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>e) Những
khiếu nại, tố cáo trong quá trình bầu cử do Ban bầu
cử đã giải quyết, cách giải quyết<sup>(10)</sup>:
........................................................................................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>g) Những
khiếu nại, tố cáo chuyển đến Ủy ban
bầu cử ở tỉnh/thành phố trực thuộc
trung ương, Hội đồng bầu cử quốc
gia<sup>(11)</sup>:
...........................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>Biên bản xác
định kết quả bầu cử đại
biểu Quốc hội khóa <span style="color:red"><?php echo ($dotbaucu['khoa'])?></span> ở <span style="color:red"><?php echo $donvibaucu['ten']?></span>  được lập thành
03 bản và được gửi đến Hội
đồng bầu cử quốc gia, Ủy ban bầu
cử ở tỉnh/thành phố trực thuộc trung
ương, Ủy ban Mặt trận Tổ quốc
Việt Nam cấp tỉnh.<sup>(12)</sup></span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>Các tài liệu
kèm theo gồm<sup>(13)</sup>:</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>1 </span><span
style='font-family:"Times New Roman","serif";color:black'>...............................................................................................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>2 </span><span
style='font-family:"Times New Roman","serif";color:black'>...............................................................................................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span style='font-family:
"Times New Roman","serif";color:black'> </span></p>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width="100%"
 style='width:100.0%'>
 <tr>
  <td width="50%" valign=top style='width:50.0%;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-family:"Times New Roman","serif"'>TM. BAN BẦU
  CỬ</span></b><b><span style='font-family:"Times New Roman","serif"'><br>
  </span></b><b><span lang=VI style='font-family:"Times New Roman","serif"'>TRƯỞNG
  BAN</span></b><span style='font-family:"Times New Roman","serif"'><br>
  </span><span lang=VI style='font-family:"Times New Roman","serif"'>(Ký, ghi
  rõ họ và tên,</span><span style='font-family:"Times New Roman","serif"'><br>
  </span><span lang=VI style='font-family:"Times New Roman","serif"'>đóng
  dấu của Ban bầu cử)</span></p>
  <p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:
  6.0pt;margin-left:0in;line-height:11.7pt'><span style='font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width="50%" valign=top style='width:50.0%;padding:0in 0in 0in 0in'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-family:"Times New Roman","serif"'>CÁC PHÓ
  TRƯỞNG BAN B</span></b><b><span style='font-family:"Times New Roman","serif"'>Ầ</span></b><b><span
  lang=VI style='font-family:"Times New Roman","serif"'>U CỬ</span></b><b><span
  style='font-family:"Times New Roman","serif"'><br>
  </span></b><span lang=VI style='font-family:"Times New Roman","serif"'>(Ký,
  ghi rõ họ và tên)</span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><b><i><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>Ghi chú: Nhất
thiết không được tẩy xóa trên biên bản.</span></i></b></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>(1) Ghi tên các
đơn vị hành chính cấp huyện trong phạm vi
đơn vị bầu cử đại biểu Quốc
hội (có thể bao gồm huyện, quận, thị xã,
thành phố thuộc tỉnh, thành phố thuộc thành
phố trực thuộc trung ương).</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>(2) Ghi rõ số
lượng đại biểu Quốc hội
được bầu tại đơn vị bầu
cử theo Nghị quyết của Hội đồng
bầu cử quốc gia.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>(3) Ghi rõ số
lượng người ứng cử đại biểu
Quốc hội tại đơn vị bầu cử theo
Danh sách chính thức những người ứng cử
đại biểu Quốc hội do Hội đồng
bầu cử quốc gia công bố.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>(4) Xếp các
cột và số phiếu bầu cho từng người
ứng cử bắt đầu từ trái sang phải theo
thứ tự trong Danh sách chính thức những
người ứng cử đại biểu Quốc
hội đã công bố.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>(5) Trường
hợp số cử tri đi bỏ phiếu chưa
đạt quá nửa tổng số cử tri của
đơn vị bầu cử thì viết thêm như
sau: <i>"Vì số cử tri đi bỏ phiếu chưa
đạt quá nửa tổng số cử tri của
đơn vị bầu cử, nên cuộc bầu cử
đại biểu Quốc hội tại đơn vị
bầu cử đại biểu Quốc hội số ....
không có giá trị. Đề nghị Ủy ban bầu
cử ở tỉnh/thành phố báo cáo Hội đồng
bầu cử quốc gia xem xét, quyết định
việc bầu cử lại tại đơn vị
bầu cử".</i></span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>(6) Xếp tên
người trúng cử theo thứ tự từ
người nhiều phiếu nhất đến
người ít phiếu nhất.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>(7) Trường
hợp đã bầu được đủ số
lượng đại biểu thì ghi tổng số
đại biểu đã trúng cử và ghi "0" vào số
đại biểu còn thiếu. Trường hợp không có
người ứng cử nào được quá nửa
tổng số phiếu hợp lệ hoặc số
người trúng cử ít hơn số đại biểu được
bầu ở đơn vị bầu cử thì ghi rõ số
lượng còn thiếu và viết thêm như sau: <i>"Vì
số người trúng cử đại biểu Quốc
hội chưa đủ số lượng đại
biểu được bầu đã ấn định cho
đơn vị bầu cử nên đề nghị Ủy
ban bầu cử ở tỉnh/thành phố
....................... báo cáo Hội đồng bầu cử
quốc gia để xem xét, quyết định việc
bầu cử thêm tại đơn vị bầu cử".</i></span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>(8) Ghi rõ
những việc bất thường đã xảy ra;
nếu không có việc gì xảy ra thì ghi "Không có".</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>(9) , (10), (11) Ghi
rõ các đơn thư, nội dung khiếu nại, tố
cáo do Tổ bầu cử chuyển đến; nếu không
có thì ghi "Không có".</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>(12) Biên bản
phải được gửi đến các cơ quan
được nêu tên chậm nhất là 05 ngày sau ngày
bầu cử.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>(13) Ví dụ
như các đơn khiếu nại, tố cáo hay tờ
trình, báo cáo của Tổ bầu cử.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-family:"Times New Roman","serif";color:black'>Việc xác
định kết quả trong bầu cử lại,
bầu cử thêm được Ban bầu cử
đại biểu Quốc hội lập thành biên bản
riêng với các nội dung theo Mẫu số 21/HĐBC-QH.</span></p>

<p class=MsoNormal><span style='font-size:12.0pt;line-height:107%;font-family:
"Times New Roman","serif"'> </span></p>

</div>

</body>

</html>
