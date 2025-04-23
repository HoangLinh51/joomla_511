<?php 
$donvibaucu = $this->donvibaucu;
$dotbaucu_id = $this->dotbaucu_id;
$dotbaucu = Core::loadAssoc('baucu_dotbaucu','*','id='.(int)$dotbaucu_id);
$donviHasKey = Core::loadAssocListHasKey('baucu_diadiemhanhchinh','*','id');
// ---------------------
$donvibaucu2diadiem = Core::loadColumn('baucu_donvibaucu2diadiem','diadiem_id','donvibaucu_id='.$donvibaucu['id']);
if(count($donvibaucu2diadiem)>0){
    foreach ($donvibaucu2diadiem as $key => $value) {
        $donvibaucu2diadiem_tmp[] = $donviHasKey[$value]['ten'];
    }
    $donvibaucu2diadiem_text = implode(', ',$donvibaucu2diadiem_tmp);
}else{
    $donvibaucu2diadiem_text = $donviHasKey[$donvibaucu['diaphuongbaucu_id']]['ten'];
}
// ----------------------
$donvibaucu2nguoiungcu = Core::loadColumn('baucu_donvibaucu2nguoiungcu','nguoiungcu_id','donvibaucu_id='.$donvibaucu['id']);
// ..........................
$model_tonghopbaucu = Core::model('Baucu/Tonghop');
$model_kiemphieu = Core::model('Baucu/Kiemphieu');
$tonghopbienban = $model_tonghopbaucu->getTonghopBienban($dotbaucu_id, $donvibaucu['id'], 'phuongxa');
$arr_nguoiungcu = $model_kiemphieu->getNguoiungcu($donvibaucu['id']);
$nguoiungcus = $model_tonghopbaucu->getTonghopNguoiungcu($donvibaucu['id'],'phuongxa');

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
$tonghop['tylephieukhonghople'] = $tonghop['sophieukhonghople']/$tonghop['sophieuthuvao'];
$tonghop['tylephieuhople'] += $tonghop['sophieuhople']/$tonghop['sophieuthuvao'];
$tonghop['tylecutri'] = $tonghop['socutribophieu']/$tonghop['tongsocutri'];
$soluongduocbau = Core::loadResult('baucu_donvibaucu2loaiphieubau','max(loaiphieubau_id)','donvibaucu_id='.(int)$donvibaucu['id']);
$capbaucu = $this->capbaucu;
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
text-align:right;line-height:11.7pt;background:white'><a name="chuong_pl_26"><i><span
lang=VI style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Mẫu
số 26/HĐBC-HĐND</span></i></a></p>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0>
 <tr>
  <td width=223 valign=top style='width:167.4pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>BAN
  BẦU CỬ ĐẠI BIỂU<br>
  </span></b></p>

  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo mb_strtoupper($capbaucu['maunhaplieu'])?></span></span><span style='font-size:10.0pt;
  font-family:"Times New Roman","serif"'></span><b><span lang=VI
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'>

  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'><span style="color:red"><?php echo mb_strtoupper($donvibaucu['ten'])?></span></span><span style='font-size:10.0pt;
  font-family:"Times New Roman","serif"'></span><b><span lang=VI
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'><br>
  <br>
  <br>
  </span></b></p>
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
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'> </span></p>

<p class=MsoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
text-align:center;line-height:11.7pt;background:white'><b><span lang=VI style='font-size:10.0pt;font-family:
"Arial","sans-serif";color:black'>BIÊN BẢN XÁC ĐỊNH KẾT
QUẢ BẦU CỬ</span></b>
<b>
<br>
ĐẠI BIỂU <span style="color:red">HỘI ĐỒNG NHÂN DÂN THÀNH PHỐ ĐÀ NẴNG </span>
<br>
Ở <span style="color:red"><?php echo mb_strtoupper($donvibaucu['ten'])?></span> </span></b></p>

<p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt;
background:white'><b><span lang=VI style='font-size:10.0pt;font-family:"Arial","sans-serif";
color:black'>Gồm </span></b><sup><span lang=VI style='font-size:
10.0pt;font-family:"Arial","sans-serif";color:black'>(2)</span></sup><b><span
lang=VI style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'> </span></b><span
lang=VI style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'><span style="color:red"><?php echo $donvibaucu2diadiem_text?></span></span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Vào
hồi ... giờ... phút, ngày 24 tháng 5 năm 2021, Ban bầu
cử đại biểu <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span>
gồm có:</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>1. Ông/Bà
.............................................., Trưởng Ban</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>2. Ông/Bà
..............................................., Phó Trưởng ban</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>3. Ông/Bà
........................................., Phó Trưởng ban</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>4. Ông/Bà
.........................................., Ủy viên</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Đã
họp tại ............................... để lập biên
bản xác định kết quả bầu cử
đại biểu <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span>
khóa <span style="color:red">X</span>, nhiệm kỳ 2021-2026 tại các khu vực bỏ
phiếu của <span style="color:red"><?php echo $donvibaucu['ten']?></span> gồm <span style="color:red"><?php echo $donvibaucu2diadiem_text?></span></span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Theo
Nghị quyết số 28/NQ-UBBC ngày 03 tháng 3 năm 2021
của Ủy ban bầu cử <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span> thì
<span style="color:red"><?php echo $donvibaucu['ten']?></span>
 được
bầu <sup>(3)</sup> <span style="color:red"><?php echo $soluongduocbau?></span>
 đại biểu Hội đồng nhân dân.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Theo
Nghị quyết số ..../NQ-UBBC ngày ... tháng ... năm 2021
của Ủy ban bầu cử <sup>(1)</sup> <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span>
thì <span style="color:red"><?php echo $donvibaucu['ten']?></span> có <sup>(4)</sup> <span style="color:red"><?php echo count($donvibaucu2nguoiungcu);?></span>
người ứng cử đại biểu Hội
đồng nhân dân.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Sau khi
kiểm tra và tổng hợp kết quả từ Biên
bản kết quả kiểm phiếu bầu cử do các
Tổ bầu cử chuyển đến, kết quả
bầu cử đại biểu <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span> ở <span style="color:red"><?php echo $donvibaucu['ten']?></span> như sau:</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>-
Tổng số cử tri của đơn vị bầu
cử: <span style="color:red"><?php echo number_format($tonghop['tongsocutri'], 0, ',', '.');?></span> người</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>-
Số cử tri đã tham gia bỏ phiếu:
<span style="color:red"><?php echo number_format($tonghop['socutribophieu'], 0, ',', '.');?></span> người</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>-
Tỷ lệ cử tri đã tham gia bỏ phiếu so
với tổng số cử tri của đơn vị
bầu cử: <span style="color:red"><?php echo number_format(100*$tonghop['tylecutri'], 2, ',', '.');?></span>%</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>-
Số phiếu phát ra: <span style="color:red"><?php echo number_format($tonghop['sophieuphatra'], 0, ',', '.');?></span> phiếu</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>-
Số phiếu thu vào: <span style="color:red"><?php echo number_format($tonghop['sophieuthuvao'], 0, ',', '.');?></span> phiếu</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>-
Số phiếu hợp lệ: <span style="color:red"><?php echo number_format($tonghop['sophieuhople'], 0, ',', '.');?></span> phiếu. Tỷ lệ
so với tổng số phiếu thu vào: <span style="color:red"><?php echo number_format(100*$tonghop['tylephieuhople'], 2, ',', '.');?></span>%</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>-
Số phiếu không hợp lệ: <span style="color:red"><?php echo number_format($tonghop['sophieukhonghople'], 0, ',', '.');?></span>phiếu. Tỷ
lệ so với tổng số phiếu thu vào: <span style="color:red"><?php echo number_format(100*$tonghop['tylephieukhonghople'], 2, ',', '.');?></span>%</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>-
Số phiếu bầu cho mỗi người ứng
cử như sau:</span></p>
<?php foreach ($nguoiungcu as $k_nguoiungcu => $v_nguoiungcu) {
    $v_nguoiungcu = array_values($v_nguoiungcu);
    $v_nguoiungcu[0]['tyle'] = 100*$v_nguoiungcu[0]['sophieubau']/$tonghop['sophieuhople'];
    $tmp_nguoiungcu[10000*$v_nguoiungcu[0]['sophieubau']/$tonghop['sophieuhople']] = $v_nguoiungcu;
    ?>
<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'><?php echo ++$sdfhskdjf;?>. <span style="color:red"><?php echo $v_nguoiungcu[0]['hoten']?></span> được <span style="color:red">
<?php echo number_format($v_nguoiungcu[0]['sophieubau'], 0, ',', '.');?> </span> phiếu/ <span style="color:red"><?php echo number_format($tonghop['sophieuhople'], 0, ',', '.');?> </span> phiếu hợp lệ</span></pre>
<?php }?>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><b><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Căn
cứ vào kết quả ghi trên đây, Ban bầu cử
đại biểu <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span> <sup>(1)</sup> kết
luận:</span></b></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>a)
Số cử tri đã tham gia bỏ phiếu đạt
<span style="color:red"><?php echo number_format($tonghop['socutribophieu']/$tonghop['tongsocutri']*100, 2, ',', '.')?></span>% so với tổng số cử tri của đơn
vị bầu cử.</span></p>
<?php if($tonghop['socutribophieu']/$tonghop['tongsocutri']*100 < 50){?>
<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><sup><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(5)</span></sup><span
lang=VI style='font-size:10.0pt;font-family:"Arial","sans-serif";color:red'> Vì số cử tri đi bỏ phiếu chưa đạt quá một nửa tổng số cử tri của đơn vị bầu cử, nên cuộc bầu cử đại biểu <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span> tại <span style="color:red"><?php echo $donvibaucu['ten']?></span> không có giá trị. Đề nghị Ủy ban bầu cử (1) <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span>
 xem xét, quyết định việc bầu cử lại tại đơn vị bầu cử</span></p>
<?php }?>
<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>b) Các
Ông/Bà có tên sau đây nhận được quá nửa
tổng số phiếu hợp lệ và có nhiều
phiếu hơn, đã trúng cử đại biểu
<span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span>
 khóa
<span style="color:red">X</span>, nhiệm kỳ <span style="color:red">2021-2026<sup>(6)</sup>:</span></p>
<?php krsort($tmp_nguoiungcu);?>
<?php foreach ($tmp_nguoiungcu as $tmp_k => $tmp_v) { 
    if($tmp_v[0]['tyle']>=50) $tmp['sodaibieutrungcu']++;
    else $tmp['sodaibieukhongtrungcu']++;
    {?>
<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'><?php echo++$uirhvergherui;?>. <span style="color:red"><?php echo $tmp_v[0]['hoten']?></span> số phiếu: <span style="color:red"><?php echo number_format($tmp_v[0]['sophieubau'], 0, ',', '.')?></span> đạt: <span style="color:red"><?php echo number_format($tmp_v[0]['tyle'], 0, ',', '.')?></span> % so
với tổng số phiếu hợp lệ.</span></pre>
<?php }}?>
<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>c) Theo
ấn định của Ủy ban bầu cử <sup>(1)</sup> <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span>
thì số đại biểu Hội đồng nhân dân <sup>(1)</sup> <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span>
được bầu ở đơn vị bầu
cử số <span style="color:red"><?php echo $donvibaucu['ten']?></span> là <span style="color:red"><?php echo $soluongduocbau?></span> đại biểu, nay đã bầu
được <span style="color:red"><?php echo (int)$tmp['sodaibieutrungcu']?></span> đại biểu, còn thiếu <span style="color:red"><?php echo $soluongduocbau-$tmp['sodaibieutrungcu']?></span> đại biểu.</span></p>

<?php if(($soluongduocbau-$tmp['sodaibieutrungcu'])>0){?>
<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Vì số người trúng cử đại biểu Hội đồng nhân dân chưa đủ số lượng đại biểu được bầu đã ấn định cho đơn vị bầu cử nên đề nghị Ủy ban bầu cử <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span> xem xét, quyết định việc bầu cử thêm tại đơn vị bầu cử.</span></p>
<?php }?>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>d) Tóm
tắt những việc xảy ra<sup>(8)</sup>:
......................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>........................................................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>đ)
Những khiếu nại, tố cáo trong quá trình bầu
cử do các Tổ bầu cử đã giải quyết<sup>(9)</sup>:</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>........................................................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>e)
Những khiếu nại, tố cáo trong quá trình bầu
cử do Ban bầu cử đã giải quyết, cách
giải quyết <sup>(10)</sup>:
..........................................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>........................................................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>g)
Những khiếu nại, tố cáo chuyển đến
Ủy ban bầu cử <sup>(11)</sup>:  ......................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>........................................................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Biên
bản xác định kết quả bầu cử
đại biểu Hội đồng nhân dân <sup>(1)</sup> <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span>
ở <span style="color:red"><?php echo $donvibaucu['ten']?></span>
được lập thành 04 bản và được
gửi đến Ủy ban bầu cử, Thường
trực Hội đồng nhân dân, Ủy ban nhân dân, Ban
Thường trực Ủy ban Mặt trận Tổ
quốc Việt Nam <sup>(1)</sup> <span style="color:red"><?php echo ($capbaucu['maunhaplieu'])?></span><sup>(12)</sup>.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Các tài
liệu kèm theo<sup>(13)</sup>:</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>1.
........................................................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>2. </span><span
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>........................................................................................................</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span style='font-size:
10.0pt;font-family:"Arial","sans-serif";color:black'> </span></p>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0>
 <tr>
  <td width=295 valign=top style='width:221.4pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>TM.
  BAN BẦU CỬ</span></b><b><span style='font-size:10.0pt;font-family:
  "Times New Roman","serif"'><br>
  </span></b><b><span lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>TRƯỞNG
  BAN<br>
  </span></b><span lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>(Ký,
  ghi rõ họ và tên,</span><span style='font-size:10.0pt;font-family:"Times New Roman","serif"'><br>
  </span><span lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>đóng
  dấu của Ban bầu cử)</span></p>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><span
  style='font-size:10.0pt;font-family:"Times New Roman","serif"'> </span></p>
  </td>
  <td width=295 valign=top style='width:221.4pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='margin-top:6.0pt;margin-right:0in;
  margin-bottom:6.0pt;margin-left:0in;text-align:center;line-height:11.7pt'><b><span
  lang=VI style='font-size:10.0pt;font-family:"Times New Roman","serif"'>CÁC
  PHÓ TRƯỞNG BAN<br>
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
tên các đơn vị hành chính cấp dưới hoặc
thôn, tổ dân phố trong phạm vi đơn vị
bầu cử đại biểu Hội đồng nhân dân
tương ứng ở mỗi cấp.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(3) Ghi
rõ số lượng đại biểu Hội
đồng nhân dân được bầu tại đơn
vị bầu cử theo Nghị quyết của Ủy ban
bầu cử đại biểu Hội đồng nhân dân
ở cấp đó.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(4) Ghi
rõ số lượng người ứng cử đại
biểu Hội đồng nhân dân theo Danh sách chính thức
những người ứng cử đại biểu
Hội đồng nhân dân do Ủy ban bầu cử
đại biểu Hội đồng nhân dân ở cấp
đó đã công bố.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(5)
Trường hợp số cử tri đi bỏ phiếu
chưa đạt quá một nửa tổng số cử
tri của đơn vị bầu cử thì viết thêm
như sau: <i>"Vì số cử tri đi bỏ phiếu
chưa đạt quá một nửa tổng số cử
tri của đơn vị bầu cử, nên cuộc
bầu cử đại biểu Hội đồng nhân dân
(1)...................... tại đơn vị bầu cử số
.... không có giá trị. Đề nghị Ủy ban bầu
cử (1) .................xem xét, quyết định việc bầu
cử lại tại đơn vị bầu cử"</i>.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(6)
Xếp tên người trúng cử theo thứ tự từ
người nhiều phiếu nhất đến
người ít phiếu nhất.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(7)
Trường hợp đã bầu được
đủ số lượng đại biểu thì ghi
tổng số đại biểu đã trúng cử và ghi "0"
vào số đại biểu còn thiếu. Trường
hợp không có người ứng cử nào được
quá nửa số phiếu hợp lệ hoặc số
người trúng cử ít hơn số đại biểu
được bầu ở đơn vị bầu
cử thì ghi rõ số lượng còn thiếu và viết
thêm như sau: <i>"Vì số người trúng cử
đại biểu Hội đồng nhân dân chưa
đủ số lượng đại biểu
được bầu đã ấn định cho
đơn vị bầu cử nên đề nghị Ủy
ban bầu cử (1) ................ xem xét, quyết định
việc bầu cử thêm tại đơn vị bầu
cử"</i>.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(8) Ghi
rõ những việc bất thường đã xảy ra;
nếu không có việc gì xảy ra thì ghi "Không có".</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(9),
(10), (11) Ghi rõ các đơn thư, nội dung khiếu
nại, tố cáo do Tổ bầu cử chuyển
đến; nếu không có thì ghi "Không có".</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(12) Biên
bản phải được gửi đến các cơ
quan được nêu tên chậm nhất là 05 ngày sau ngày
bầu cử.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>(13) Ví
dụ như các đơn khiếu nại, tố cáo hay
tờ trình, báo cáo của Tổ bầu cử.</span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;line-height:11.7pt;background:white'><span lang=VI
style='font-size:10.0pt;font-family:"Arial","sans-serif";color:black'>Việc
xác định kết quả trong bầu cử lại,
bầu cử thêm được Ban bầu cử
đại biểu Hội đồng nhân dân lập thành
biên bản riêng với các nội dung theo Mẫu số
26/HĐBC-HĐND.</span></p>

<p class=MsoNormal> </p>

</div>

</body>

</html>
