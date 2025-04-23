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
// echo '<pre>';
// var_dump($nguoiungcu);
// echo '</pre>';


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
$tonghop['tylephieukhonghople'] = $tonghop['sophieuthuvao']>0?$tonghop['sophieukhonghople']/$tonghop['sophieuthuvao']:0;
$tonghop['tylephieuhople'] = $tonghop['sophieuthuvao']>0?$tonghop['sophieuhople']/$tonghop['sophieuthuvao']:0;
$tonghop['tylecutri'] = $tonghop['tongsocutri']>0?$tonghop['socutribophieu']/$tonghop['tongsocutri']:0;
$soluongduocbau = Core::loadResult('baucu_donvibaucu2loaiphieubau','max(loaiphieubau_id)','donvibaucu_id='.(int)$donvibaucu['id']);
$capbaucu = $this->capbaucu;
?>
<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf8">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 14">
<meta name=Originator content="Microsoft Word 14">
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;
	mso-font-charset:2;
	mso-generic-font-family:auto;
	mso-font-pitch:variable;
	mso-font-signature:0 268435456 0 0 -2147483648 0;}
@font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;
	mso-font-charset:2;
	mso-generic-font-family:auto;
	mso-font-pitch:variable;
	mso-font-signature:0 268435456 0 0 -2147483648 0;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-469750017 -1073732485 9 0 511 0;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-520081665 -1073717157 41 0 66047 0;}
@font-face
	{font-family:".VnTime";
	mso-font-alt:"Courier New";
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:3 0 0 0 1 0;}
@font-face
	{font-family:".VnCentury SchoolbookH";
	mso-font-alt:"Courier New";
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:3 0 0 0 1 0;}
@font-face
	{font-family:".VnCentury Schoolbook";
	mso-font-alt:"Courier New";
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:3 0 0 0 1 0;}
@font-face
	{font-family:".VnTimeH";
	mso-font-alt:"Courier New";
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:1 0 0 0 19 0;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin:0in;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
h1
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-link:"Heading 1 Char";
	mso-style-next:Normal;
	margin-top:12.0pt;
	margin-right:0in;
	margin-bottom:3.0pt;
	margin-left:0in;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:1;
	font-size:16.0pt;
	font-family:"Arial","sans-serif";
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	mso-font-kerning:16.0pt;
	mso-ansi-language:X-NONE;
	mso-fareast-language:X-NONE;}
h2
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-link:"Heading 2 Char";
	mso-style-next:Normal;
	margin-top:6.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	text-align:center;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:2;
	font-size:10.0pt;
	font-family:".VnCentury SchoolbookH","sans-serif";
	mso-fareast-font-family:"Times New Roman";
	letter-spacing:-.2pt;
	mso-font-kerning:14.0pt;
	mso-ansi-language:EN-AU;
	mso-fareast-language:X-NONE;
	mso-bidi-font-weight:normal;}
h3
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-link:"Heading 3 Char";
	mso-style-next:Normal;
	margin-top:6.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:215.25pt;
	margin-bottom:.0001pt;
	text-align:center;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:3;
	font-size:12.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:".VnCentury Schoolbook","sans-serif";
	mso-fareast-font-family:"Times New Roman";
	letter-spacing:-.2pt;
	mso-font-kerning:14.0pt;
	mso-ansi-language:EN-AU;
	mso-fareast-language:X-NONE;
	mso-bidi-font-weight:normal;}
h4
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-link:"Heading 4 Char";
	mso-style-next:Normal;
	margin-top:0in;
	margin-right:0in;
	margin-bottom:3.0pt;
	margin-left:0in;
	text-align:center;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:4;
	font-size:12.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:".VnTimeH","sans-serif";
	mso-fareast-font-family:"Times New Roman";
	color:blue;
	mso-ansi-language:EN-GB;
	mso-fareast-language:X-NONE;
	mso-bidi-font-weight:normal;}
h5
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-link:"Heading 5 Char";
	mso-style-next:Normal;
	margin-top:12.0pt;
	margin-right:0in;
	margin-bottom:3.0pt;
	margin-left:0in;
	mso-pagination:widow-orphan;
	mso-outline-level:5;
	font-size:13.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";
	mso-ansi-language:X-NONE;
	mso-fareast-language:X-NONE;
	font-style:italic;}
h6
	{mso-style-priority:9;
	mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-link:"Heading 6 Char";
	mso-style-next:Normal;
	margin-top:12.0pt;
	margin-right:0in;
	margin-bottom:3.0pt;
	margin-left:0in;
	mso-pagination:widow-orphan;
	mso-outline-level:6;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	mso-ansi-language:X-NONE;
	mso-fareast-language:X-NONE;}
p.MsoHeading7, li.MsoHeading7, div.MsoHeading7
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-link:"Heading 7 Char";
	mso-style-next:Normal;
	margin-top:12.0pt;
	margin-right:0in;
	margin-bottom:3.0pt;
	margin-left:0in;
	mso-pagination:widow-orphan;
	mso-outline-level:7;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";
	mso-ansi-language:X-NONE;
	mso-fareast-language:X-NONE;}
p.MsoHeading8, li.MsoHeading8, div.MsoHeading8
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-link:"Heading 8 Char";
	mso-style-next:Normal;
	margin-top:12.0pt;
	margin-right:0in;
	margin-bottom:3.0pt;
	margin-left:0in;
	mso-pagination:widow-orphan;
	mso-outline-level:8;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";
	mso-ansi-language:X-NONE;
	mso-fareast-language:X-NONE;
	font-style:italic;}
p.MsoFootnoteText, li.MsoFootnoteText, div.MsoFootnoteText
	{mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-link:"Footnote Text Char";
	margin:0in;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:".VnTime","sans-serif";
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	mso-font-kerning:14.0pt;
	mso-ansi-language:EN-AU;
	mso-fareast-language:X-NONE;}
p.MsoCommentText, li.MsoCommentText, div.MsoCommentText
	{mso-style-noshow:yes;
	mso-style-unhide:no;
	margin:0in;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{mso-style-priority:99;
	mso-style-unhide:no;
	mso-style-link:"Header Char";
	margin:0in;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	tab-stops:center 3.0in right 6.0in;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{mso-style-priority:99;
	mso-style-unhide:no;
	mso-style-link:"Footer Char";
	margin:0in;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	tab-stops:center 3.0in right 6.0in;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
span.MsoFootnoteReference
	{mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-parent:"";
	vertical-align:super;}
span.MsoCommentReference
	{mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-parent:"";
	mso-ansi-font-size:8.0pt;
	mso-bidi-font-size:8.0pt;}
p.MsoBodyText, li.MsoBodyText, div.MsoBodyText
	{mso-style-unhide:no;
	mso-style-link:"Body Text Char";
	margin:0in;
	margin-bottom:.0001pt;
	text-align:center;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:".VnCentury SchoolbookH","sans-serif";
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	mso-ansi-language:X-NONE;
	mso-fareast-language:X-NONE;
	mso-no-proof:yes;}
p.MsoBodyTextIndent, li.MsoBodyTextIndent, div.MsoBodyTextIndent
	{mso-style-link:"Body Text Indent Char";
	margin-top:0in;
	margin-right:0in;
	margin-bottom:6.0pt;
	margin-left:14.15pt;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
p.MsoBodyText2, li.MsoBodyText2, div.MsoBodyText2
	{mso-style-unhide:no;
	mso-style-link:"Body Text 2 Char";
	margin-top:0in;
	margin-right:0in;
	margin-bottom:6.0pt;
	margin-left:0in;
	line-height:200%;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";
	mso-ansi-language:X-NONE;
	mso-fareast-language:X-NONE;}
p.MsoBodyText3, li.MsoBodyText3, div.MsoBodyText3
	{mso-style-unhide:no;
	mso-style-link:"Body Text 3 Char";
	margin-top:0in;
	margin-right:0in;
	margin-bottom:6.0pt;
	margin-left:0in;
	mso-pagination:widow-orphan;
	font-size:8.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";
	mso-ansi-language:X-NONE;
	mso-fareast-language:X-NONE;}
p.MsoBodyTextIndent2, li.MsoBodyTextIndent2, div.MsoBodyTextIndent2
	{mso-style-unhide:no;
	mso-style-link:"Body Text Indent 2 Char";
	margin-top:0in;
	margin-right:0in;
	margin-bottom:6.0pt;
	margin-left:.25in;
	line-height:200%;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";
	mso-ansi-language:X-NONE;
	mso-fareast-language:X-NONE;}
p.MsoBodyTextIndent3, li.MsoBodyTextIndent3, div.MsoBodyTextIndent3
	{mso-style-unhide:no;
	mso-style-link:"Body Text Indent 3 Char";
	margin-top:0in;
	margin-right:0in;
	margin-bottom:6.0pt;
	margin-left:.25in;
	mso-pagination:widow-orphan;
	font-size:8.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";
	mso-ansi-language:X-NONE;
	mso-fareast-language:X-NONE;}
p.MsoCommentSubject, li.MsoCommentSubject, div.MsoCommentSubject
	{mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-parent:"Comment Text";
	mso-style-next:"Comment Text";
	margin:0in;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";
	font-weight:bold;}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-link:"Balloon Text Char";
	margin:0in;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	mso-ansi-language:X-NONE;
	mso-fareast-language:X-NONE;}
p.MsoRMPane, li.MsoRMPane, div.MsoRMPane
	{mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-unhide:no;
	mso-style-parent:"";
	margin:0in;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
p.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph
	{mso-style-priority:34;
	mso-style-unhide:no;
	mso-style-qformat:yes;
	margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	mso-add-space:auto;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
p.MsoListParagraphCxSpFirst, li.MsoListParagraphCxSpFirst, div.MsoListParagraphCxSpFirst
	{mso-style-priority:34;
	mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-type:export-only;
	margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	mso-add-space:auto;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
p.MsoListParagraphCxSpMiddle, li.MsoListParagraphCxSpMiddle, div.MsoListParagraphCxSpMiddle
	{mso-style-priority:34;
	mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-type:export-only;
	margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	mso-add-space:auto;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
p.MsoListParagraphCxSpLast, li.MsoListParagraphCxSpLast, div.MsoListParagraphCxSpLast
	{mso-style-priority:34;
	mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-type:export-only;
	margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	mso-add-space:auto;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
span.Heading2Char
	{mso-style-name:"Heading 2 Char";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Heading 2";
	font-family:".VnCentury SchoolbookH","sans-serif";
	mso-ascii-font-family:".VnCentury SchoolbookH";
	mso-fareast-font-family:"Times New Roman";
	mso-hansi-font-family:".VnCentury SchoolbookH";
	letter-spacing:-.2pt;
	mso-font-kerning:14.0pt;
	mso-ansi-language:EN-AU;
	font-weight:bold;
	mso-bidi-font-weight:normal;}
span.Heading3Char
	{mso-style-name:"Heading 3 Char";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Heading 3";
	mso-ansi-font-size:12.0pt;
	font-family:".VnCentury Schoolbook","sans-serif";
	mso-ascii-font-family:".VnCentury Schoolbook";
	mso-fareast-font-family:"Times New Roman";
	mso-hansi-font-family:".VnCentury Schoolbook";
	letter-spacing:-.2pt;
	mso-font-kerning:14.0pt;
	mso-ansi-language:EN-AU;
	font-weight:bold;
	mso-bidi-font-weight:normal;}
span.Heading4Char
	{mso-style-name:"Heading 4 Char";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Heading 4";
	mso-ansi-font-size:12.0pt;
	font-family:".VnTimeH","sans-serif";
	mso-ascii-font-family:".VnTimeH";
	mso-fareast-font-family:"Times New Roman";
	mso-hansi-font-family:".VnTimeH";
	color:blue;
	mso-ansi-language:EN-GB;
	font-weight:bold;
	mso-bidi-font-weight:normal;}
span.Heading5Char
	{mso-style-name:"Heading 5 Char";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Heading 5";
	mso-ansi-font-size:13.0pt;
	mso-bidi-font-size:13.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";
	font-weight:bold;
	font-style:italic;}
p.chuongten, li.chuongten, div.chuongten
	{mso-style-name:chuongten;
	mso-style-unhide:no;
	mso-style-parent:"Heading 6";
	margin-top:0in;
	margin-right:0in;
	margin-bottom:.25in;
	margin-left:0in;
	text-align:center;
	line-height:17.0pt;
	mso-line-height-rule:exactly;
	mso-pagination:none;
	page-break-after:avoid;
	mso-outline-level:6;
	font-size:12.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:".VnCentury SchoolbookH","sans-serif";
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	mso-ansi-language:X-NONE;
	mso-fareast-language:X-NONE;
	font-weight:bold;
	mso-bidi-font-weight:normal;}
span.Heading6Char
	{mso-style-name:"Heading 6 Char";
	mso-style-noshow:yes;
	mso-style-priority:9;
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Heading 6";
	mso-ansi-font-size:11.0pt;
	mso-bidi-font-size:11.0pt;
	font-family:"Calibri","sans-serif";
	mso-ascii-font-family:Calibri;
	mso-fareast-font-family:"Times New Roman";
	mso-hansi-font-family:Calibri;
	mso-bidi-font-family:"Times New Roman";
	font-weight:bold;}
span.BodyTextChar
	{mso-style-name:"Body Text Char";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Body Text";
	mso-ansi-font-size:12.0pt;
	mso-bidi-font-size:12.0pt;
	font-family:".VnCentury SchoolbookH","sans-serif";
	mso-ascii-font-family:".VnCentury SchoolbookH";
	mso-fareast-font-family:"Times New Roman";
	mso-hansi-font-family:".VnCentury SchoolbookH";
	mso-no-proof:yes;}
span.Heading1Char
	{mso-style-name:"Heading 1 Char";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Heading 1";
	mso-ansi-font-size:16.0pt;
	mso-bidi-font-size:16.0pt;
	font-family:"Arial","sans-serif";
	mso-ascii-font-family:Arial;
	mso-fareast-font-family:"Times New Roman";
	mso-hansi-font-family:Arial;
	mso-bidi-font-family:Arial;
	mso-font-kerning:16.0pt;
	font-weight:bold;}
span.FootnoteTextChar
	{mso-style-name:"Footnote Text Char";
	mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Footnote Text";
	font-family:".VnTime","sans-serif";
	mso-ascii-font-family:".VnTime";
	mso-fareast-font-family:"Times New Roman";
	mso-hansi-font-family:".VnTime";
	mso-font-kerning:14.0pt;
	mso-ansi-language:EN-AU;}
span.BodyText3Char
	{mso-style-name:"Body Text 3 Char";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Body Text 3";
	mso-ansi-font-size:8.0pt;
	mso-bidi-font-size:8.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
span.BodyTextIndent2Char
	{mso-style-name:"Body Text Indent 2 Char";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Body Text Indent 2";
	mso-ansi-font-size:12.0pt;
	mso-bidi-font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
span.BodyTextIndent3Char
	{mso-style-name:"Body Text Indent 3 Char";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Body Text Indent 3";
	mso-ansi-font-size:8.0pt;
	mso-bidi-font-size:8.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
span.BodyText2Char
	{mso-style-name:"Body Text 2 Char";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Body Text 2";
	mso-ansi-font-size:12.0pt;
	mso-bidi-font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
span.Heading7Char
	{mso-style-name:"Heading 7 Char";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Heading 7";
	mso-ansi-font-size:12.0pt;
	mso-bidi-font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
p.xl26, li.xl26, div.xl26
	{mso-style-name:xl26;
	mso-style-unhide:no;
	margin-top:5.0pt;
	margin-right:0in;
	margin-bottom:5.0pt;
	margin-left:0in;
	text-align:center;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Arial","sans-serif";
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	font-weight:bold;
	mso-bidi-font-weight:normal;}
span.Heading8Char
	{mso-style-name:"Heading 8 Char";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Heading 8";
	mso-ansi-font-size:12.0pt;
	mso-bidi-font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";
	font-style:italic;}
span.BalloonTextChar
	{mso-style-name:"Balloon Text Char";
	mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Balloon Text";
	mso-ansi-font-size:8.0pt;
	mso-bidi-font-size:8.0pt;
	font-family:"Tahoma","sans-serif";
	mso-ascii-font-family:Tahoma;
	mso-fareast-font-family:"Times New Roman";
	mso-hansi-font-family:Tahoma;
	mso-bidi-font-family:Tahoma;}
span.BodyTextIndentChar
	{mso-style-name:"Body Text Indent Char";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Body Text Indent";
	mso-ansi-font-size:12.0pt;
	mso-bidi-font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";
	mso-ansi-language:EN-US;
	mso-fareast-language:EN-US;}
span.HeaderChar
	{mso-style-name:"Header Char";
	mso-style-priority:99;
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:Header;
	mso-ansi-font-size:12.0pt;
	mso-bidi-font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";
	mso-ansi-language:EN-US;
	mso-fareast-language:EN-US;}
span.FooterChar
	{mso-style-name:"Footer Char";
	mso-style-priority:99;
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:Footer;
	mso-ansi-font-size:12.0pt;
	mso-bidi-font-size:12.0pt;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";
	mso-ansi-language:EN-US;
	mso-fareast-language:EN-US;}
p.Char, li.Char, div.Char
	{mso-style-name:" Char";
	mso-style-noshow:yes;
	mso-style-unhide:no;
	margin-top:0in;
	margin-right:0in;
	margin-bottom:8.0pt;
	margin-left:0in;
	line-height:12.0pt;
	mso-line-height-rule:exactly;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	font-family:"Arial","sans-serif";
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";}
.MsoChpDefault
	{mso-style-type:export-only;
	mso-default-props:yes;
	mso-fareast-font-family:Calibri;}
 /* Page Definitions */
@page WordSection1
	{size:595.35pt 842.0pt;
	margin:56.7pt 51.05pt .5in 79.4pt;
	mso-header-margin:28.35pt;
	mso-footer-margin:19.85pt;
	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
 /* List Definitions */
 @list l0
	{mso-list-id:-132;
	mso-list-type:simple;
	mso-list-template-ids:-842922606;}
@list l0:level1
	{mso-level-tab-stop:1.25in;
	mso-level-number-position:left;
	margin-left:1.25in;
	text-indent:-.25in;}
@list l1
	{mso-list-id:-131;
	mso-list-type:simple;
	mso-list-template-ids:462949262;}
@list l1:level1
	{mso-level-tab-stop:1.0in;
	mso-level-number-position:left;
	margin-left:1.0in;
	text-indent:-.25in;}
@list l2
	{mso-list-id:-130;
	mso-list-type:simple;
	mso-list-template-ids:986369078;}
@list l2:level1
	{mso-level-tab-stop:.75in;
	mso-level-number-position:left;
	margin-left:.75in;
	text-indent:-.25in;}
@list l3
	{mso-list-id:-129;
	mso-list-type:simple;
	mso-list-template-ids:-1859101296;}
@list l3:level1
	{mso-level-tab-stop:.5in;
	mso-level-number-position:left;
	text-indent:-.25in;}
@list l4
	{mso-list-id:-128;
	mso-list-type:simple;
	mso-list-template-ids:720560490;}
@list l4:level1
	{mso-level-number-format:bullet;
	mso-level-text:F0B7;
	mso-level-tab-stop:1.25in;
	mso-level-number-position:left;
	margin-left:1.25in;
	text-indent:-.25in;
	font-family:Symbol;}
@list l5
	{mso-list-id:-127;
	mso-list-type:simple;
	mso-list-template-ids:-216651890;}
@list l5:level1
	{mso-level-number-format:bullet;
	mso-level-text:F0B7;
	mso-level-tab-stop:1.0in;
	mso-level-number-position:left;
	margin-left:1.0in;
	text-indent:-.25in;
	font-family:Symbol;}
@list l6
	{mso-list-id:-126;
	mso-list-type:simple;
	mso-list-template-ids:-1121529118;}
@list l6:level1
	{mso-level-number-format:bullet;
	mso-level-text:F0B7;
	mso-level-tab-stop:.75in;
	mso-level-number-position:left;
	margin-left:.75in;
	text-indent:-.25in;
	font-family:Symbol;}
@list l7
	{mso-list-id:-125;
	mso-list-type:simple;
	mso-list-template-ids:1940411284;}
@list l7:level1
	{mso-level-number-format:bullet;
	mso-level-text:F0B7;
	mso-level-tab-stop:.5in;
	mso-level-number-position:left;
	text-indent:-.25in;
	font-family:Symbol;}
@list l8
	{mso-list-id:-120;
	mso-list-type:simple;
	mso-list-template-ids:1126452488;}
@list l8:level1
	{mso-level-tab-stop:.25in;
	mso-level-number-position:left;
	margin-left:.25in;
	text-indent:-.25in;}
@list l9
	{mso-list-id:-119;
	mso-list-type:simple;
	mso-list-template-ids:-997027416;}
@list l9:level1
	{mso-level-number-format:bullet;
	mso-level-text:F0B7;
	mso-level-tab-stop:.25in;
	mso-level-number-position:left;
	margin-left:.25in;
	text-indent:-.25in;
	font-family:Symbol;}
@list l10
	{mso-list-id:402916271;
	mso-list-type:hybrid;
	mso-list-template-ids:-1931860822 1709230690 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
@list l10:level1
	{mso-level-number-format:roman-upper;
	mso-level-tab-stop:1.25in;
	mso-level-number-position:left;
	margin-left:1.25in;
	text-indent:-.5in;}
@list l10:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:1.5in;
	mso-level-number-position:left;
	margin-left:1.5in;
	text-indent:-.25in;}
@list l10:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:2.0in;
	mso-level-number-position:right;
	margin-left:2.0in;
	text-indent:-9.0pt;}
@list l10:level4
	{mso-level-tab-stop:2.5in;
	mso-level-number-position:left;
	margin-left:2.5in;
	text-indent:-.25in;}
@list l10:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:3.0in;
	mso-level-number-position:left;
	margin-left:3.0in;
	text-indent:-.25in;}
@list l10:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:3.5in;
	mso-level-number-position:right;
	margin-left:3.5in;
	text-indent:-9.0pt;}
@list l10:level7
	{mso-level-tab-stop:4.0in;
	mso-level-number-position:left;
	margin-left:4.0in;
	text-indent:-.25in;}
@list l10:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:4.5in;
	mso-level-number-position:left;
	margin-left:4.5in;
	text-indent:-.25in;}
@list l10:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:5.0in;
	mso-level-number-position:right;
	margin-left:5.0in;
	text-indent:-9.0pt;}
@list l11
	{mso-list-id:442572873;
	mso-list-type:hybrid;
	mso-list-template-ids:-1493006840 1235364318 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
@list l11:level1
	{mso-level-tab-stop:1.0in;
	mso-level-number-position:left;
	margin-left:1.0in;
	text-indent:-.25in;}
@list l11:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:1.5in;
	mso-level-number-position:left;
	margin-left:1.5in;
	text-indent:-.25in;}
@list l11:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:2.0in;
	mso-level-number-position:right;
	margin-left:2.0in;
	text-indent:-9.0pt;}
@list l11:level4
	{mso-level-tab-stop:2.5in;
	mso-level-number-position:left;
	margin-left:2.5in;
	text-indent:-.25in;}
@list l11:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:3.0in;
	mso-level-number-position:left;
	margin-left:3.0in;
	text-indent:-.25in;}
@list l11:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:3.5in;
	mso-level-number-position:right;
	margin-left:3.5in;
	text-indent:-9.0pt;}
@list l11:level7
	{mso-level-tab-stop:4.0in;
	mso-level-number-position:left;
	margin-left:4.0in;
	text-indent:-.25in;}
@list l11:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:4.5in;
	mso-level-number-position:left;
	margin-left:4.5in;
	text-indent:-.25in;}
@list l11:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:5.0in;
	mso-level-number-position:right;
	margin-left:5.0in;
	text-indent:-9.0pt;}
@list l12
	{mso-list-id:1008101326;
	mso-list-type:hybrid;
	mso-list-template-ids:691197628 1787331328 67698691 67698693 67698689 67698691 67698693 67698689 67698691 67698693;}
@list l12:level1
	{mso-level-start-at:5;
	mso-level-number-format:bullet;
	mso-level-text:-;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:.75in;
	text-indent:-.25in;
	font-family:"Times New Roman","serif";
	mso-fareast-font-family:"Times New Roman";}
@list l12:level2
	{mso-level-number-format:bullet;
	mso-level-text:o;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:1.25in;
	text-indent:-.25in;
	font-family:"Courier New";}
@list l12:level3
	{mso-level-number-format:bullet;
	mso-level-text:F0A7;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:1.75in;
	text-indent:-.25in;
	font-family:Wingdings;}
@list l12:level4
	{mso-level-number-format:bullet;
	mso-level-text:F0B7;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:2.25in;
	text-indent:-.25in;
	font-family:Symbol;}
@list l12:level5
	{mso-level-number-format:bullet;
	mso-level-text:o;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:2.75in;
	text-indent:-.25in;
	font-family:"Courier New";}
@list l12:level6
	{mso-level-number-format:bullet;
	mso-level-text:F0A7;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:3.25in;
	text-indent:-.25in;
	font-family:Wingdings;}
@list l12:level7
	{mso-level-number-format:bullet;
	mso-level-text:F0B7;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:3.75in;
	text-indent:-.25in;
	font-family:Symbol;}
@list l12:level8
	{mso-level-number-format:bullet;
	mso-level-text:o;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:4.25in;
	text-indent:-.25in;
	font-family:"Courier New";}
@list l12:level9
	{mso-level-number-format:bullet;
	mso-level-text:F0A7;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:4.75in;
	text-indent:-.25in;
	font-family:Wingdings;}
ol
	{margin-bottom:0in;}
ul
	{margin-bottom:0in;}
-->
</style>
<!--[if gte mso 10]>
<style>
 /* Style Definitions */
 table.MsoNormalTable
	{mso-style-name:"Table Normal";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-parent:"";
	mso-padding-alt:0in 5.4pt 0in 5.4pt;
	mso-para-margin:0in;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";}
table.MsoTableGrid
	{mso-style-name:"Table Grid";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-unhide:no;
	border:solid windowtext 1.0pt;
	mso-border-alt:solid windowtext .5pt;
	mso-padding-alt:0in 5.4pt 0in 5.4pt;
	mso-border-insideh:.5pt solid windowtext;
	mso-border-insidev:.5pt solid windowtext;
	mso-para-margin:0in;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:shapedefaults v:ext="edit" spidmax="2049"/>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <o:shapelayout v:ext="edit">
  <o:idmap v:ext="edit" data="1"/>
 </o:shapelayout></xml><![endif]-->
</head>

<body lang=EN-US style='tab-interval:.5in'>

<div class=WordSection1>

<p class=MsoNormal align=right style='margin-bottom:6.0pt;text-align:right;
text-indent:.5in'><i><span style='font-size:10.0pt;background:white;mso-highlight:
white;mso-bidi-font-weight:bold'>Mẫu số 26/HĐBC-</span></i><i><span
lang=VI style='font-size:10.0pt;background:white;mso-highlight:white;
mso-ansi-language:VI;mso-bidi-font-weight:bold'>HĐND</span></i><i><span
style='font-size:10.0pt;background:white;mso-highlight:white;mso-bidi-font-weight:
bold'><o:p></o:p></span></i></p>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=667
 style='width:499.95pt;margin-left:-12.6pt;border-collapse:collapse;mso-padding-alt:
 0in 5.4pt 0in 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;mso-yfti-lastrow:yes'>
  <td width=336 valign=top style='width:251.9pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center;mso-pagination:none'><b
  style='mso-bidi-font-weight:normal'><span style='font-size:11.0pt;letter-spacing:
  -.2pt;background:white;mso-highlight:white'>BAN BẦU CỬ
  ĐẠI BIỂU HỘI ĐỒNG NHÂN DÂN <o:p></o:p></span></b></p>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span style='font-size:11.0pt;color:red;
  letter-spacing:-.2pt;background:white;mso-highlight:white'>THÀNH PHỐ
  ĐÀ NẴNG<o:p></o:p></span></b></p>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:11.0pt;letter-spacing:-.2pt;background:white;mso-highlight:
  white'><span style="color:red"><?php echo mb_strtoupper($donvibaucu['ten'])?></span></span><span style='letter-spacing:-.2pt;
  background:white;mso-highlight:white'><o:p></o:p></span></p>
  </td>
  <td width=331 valign=top style='width:248.05pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoHeading7 align=center style='margin:0in;margin-bottom:.0001pt;
  text-align:center'><b style='mso-bidi-font-weight:normal'><span lang=X-NONE
  style='letter-spacing:-.4pt;background:white;mso-highlight:white;mso-bidi-font-style:
  italic'>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM<o:p></o:p></span></b></p>
  <p class=MsoNormal align=center style='text-align:center;tab-stops:center 268.35pt left 394.5pt'><b><span
  style='font-size:13.0pt;mso-bidi-font-size:12.0pt;letter-spacing:-.2pt;
  background:white;mso-highlight:white'>Độc lập - Tự do
  - Hạnh phúc<o:p></o:p></span></b></p>
  <p class=MsoNormal align=center style='text-align:center;tab-stops:center 268.35pt left 394.5pt'><![if !vml]><span
  style='mso-ignore:vglayout;position:absolute;z-index:251657728;left:0px;
  margin-left:65px;margin-top:4px;width:203px;height:2px'></span><![endif]><b><span
  style='letter-spacing:-.2pt;background:white;mso-highlight:white'><o:p></o:p></span></b></p>
  </td>
 </tr>
</table>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span style='font-size:14.0pt;background:white;mso-highlight:white'><o:p> </o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span style='font-size:14.0pt;background:white;mso-highlight:white'>BIÊN
BẢN XÁC ĐỊNH KẾT QUẢ BẦU CỬ<sup><o:p></o:p></sup></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span style='font-size:14.0pt;background:white;mso-highlight:white'>ĐẠI
BIỂU HỘI ĐỒNG NHÂN DÂN <span style='color:red'>THÀNH
PHỐ ĐÀ NẴNG</span><o:p></o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span style='font-size:14.0pt;background:white;mso-highlight:white'>Ở
<span style="color:red"><?php echo mb_strtoupper($donvibaucu['ten'])?></span><o:p></o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center;mso-pagination:none'><b><span
style='font-size:13.0pt;letter-spacing:-.2pt;background:white;mso-highlight:
white'>Gồm</span></b><b><span style='font-size:13.0pt;letter-spacing:
-.2pt'> </span></b><span class=MsoFootnoteReference><span style='font-family:
Symbol;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:"Times New Roman";
mso-char-type:symbol;mso-symbol-font-family:Symbol'><span style='mso-char-type:
symbol;mso-symbol-font-family:Symbol'>(</span></span>2</span><span
class=MsoFootnoteReference><span style='font-family:Symbol;mso-ascii-font-family:
"Times New Roman";mso-hansi-font-family:"Times New Roman";mso-char-type:symbol;
mso-symbol-font-family:Symbol'><span style='mso-char-type:symbol;mso-symbol-font-family:
Symbol'>)</span></span></span><b><span style='font-size:13.0pt;letter-spacing:
-.2pt;background:white;mso-highlight:white'> </span></b><span style='font-size:
13.0pt;color:red;letter-spacing:-.3pt;mso-bidi-font-weight:bold'><span style="color:red"><?php echo $donvibaucu2diadiem_text?></span>
</span><span
style='font-size:13.0pt;letter-spacing:-.2pt;background:white;mso-highlight:
white;mso-bidi-font-weight:bold'><o:p></o:p></span></p>

<p class=MsoNormal><span style='font-size:14.0pt;background:white;mso-highlight:
white'><o:p> </o:p></span></p>
<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;text-align:justify;text-indent:17.85pt'><span style='font-size:
13.0pt;background:white;mso-highlight:white'>Vào<span
style='mso-spacerun:yes'> </span>hồi ....... giờ........phút,
ngày <span style='color:red'>24</span> tháng <span style='color:red'>5</span>
năm 2021, Ban bầu cử đại biểu Hội
đồng nhân dân <span style='color:red'>thành phố Đà Nẵng ở <?php echo $donvibaucu['ten']?></span>
gồm có:<o:p></o:p></span></p>

<?php for($i=1; $i<=12; $i++){?>
<p class=MsoNormal style='text-indent:.25in'><span style='font-size:13.0pt;
color:red;background:white;mso-highlight:white'><?php echo $i?>. ................................................................................................
</span>
</p>
<?php }?>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.25in'><span
style='font-size:13.0pt;mso-bidi-font-size:14.0pt;background:white;mso-highlight:
white'>Đã họp tại <span style='color:red'>.............</span> để lập biên bản xác định
kết quả bầu cử đại biểu Hội
đồng nhân dân <span style='color:red'>thành phố Đà
Nẵng</span> khóa <span style='color:red'>X</span>, nhiệm kỳ
2021-2026 tại các khu vực bỏ phiếu của
<span style="color:red;font-size:13.0pt"><?php echo $donvibaucu['ten']?></span> gồm</span><span
class=MsoFootnoteReference> </span><span style="color:red;font-size:13.0pt"><?php echo $donvibaucu2diadiem_text?></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:17.85pt;
mso-pagination:none'><span style='font-size:13.0pt;mso-bidi-font-size:14.0pt;
background:white;mso-highlight:white'>Theo Nghị quyết số <span
style='color:red'>28</span>/NQ-UBBC ngày <span style='color:red'>03</span>
tháng <span style='color:red'>3</span> năm 2021 của Ủy ban
bầu cử <span style='color:red'>thành phố Đà Nẵng </span>thì
<span style="color:red;font-size:13.0pt"><?php echo $donvibaucu['ten']?></span>
được bầu <span style="color:red;font-size:13.0pt"><?php echo $soluongduocbau?></span> đại
biểu Hội đồng nhân dân. <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:17.85pt;
mso-pagination:none'><span style='font-size:13.0pt;mso-bidi-font-size:14.0pt;
background:white;mso-highlight:white'>Theo Nghị quyết số <span
style='color:red'>66</span>/NQ-UBBC ngày <span style='color:red'>26</span> tháng
<span style='color:red'>4</span> năm 2021 của Ủy ban bầu
cử <span style='color:red'>thành phố Đà Nẵng</span> thì
</span><span style="color:red;font-size:13.0pt"><?php echo $donvibaucu['ten']?></span><span
style='font-size:13.0pt;mso-bidi-font-size:14.0pt'> 
có <span style="color:red;font-size:13.0pt"><?php echo count($donvibaucu2nguoiungcu);?></span> người ứng cử
đại biểu Hội đồng nhân dân.<span
style='mso-spacerun:yes'> </span><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:17.85pt;
mso-pagination:none'><span style='font-size:13.0pt;background:white;mso-highlight:
white'>Sau khi kiểm tra và tổng hợp kết quả
từ Biên bản kết quả kiểm phiếu bầu
cử do các Tổ bầu cử chuyển đến,
kết quả bầu cử đại biểu Hội
đồng nhân dân </span><span style='font-size:13.0pt;mso-bidi-font-size:
14.0pt;color:red;background:white;mso-highlight:white'>thành phố Đà
Nẵng </span><span style='font-size:13.0pt;background:white;mso-highlight:
white'>ở <span style="color:red;font-size:13.0pt"><?php echo $donvibaucu['ten']?></span> như sau: </span><span style='font-size:13.0pt;
mso-bidi-font-size:14.0pt;background:white;mso-highlight:white'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;text-align:justify;text-indent:.25in;mso-pagination:none;
tab-stops:6.5in'><span style='font-size:13.0pt;mso-bidi-font-size:14.0pt;
letter-spacing:-.2pt;background:white;mso-highlight:white'>- Tổng
số cử tri của đơn vị bầu cử:
<span style="color:red"><?php echo number_format($tonghop['tongsocutri'], 0, ',', '.');?></span> người<span
style='mso-spacerun:yes'> </span><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;text-align:justify;text-indent:.25in;mso-pagination:none;
tab-stops:6.5in'><span style='font-size:13.0pt;mso-bidi-font-size:14.0pt;
letter-spacing:-.2pt;background:white;mso-highlight:white'>- Số cử
tri đã tham gia bỏ phiếu:
<span style="color:red"><?php echo number_format($tonghop['socutribophieu'], 0, ',', '.');?></span> người<span
style='mso-spacerun:yes'> </span><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;text-align:justify;text-indent:.25in;mso-pagination:none;
tab-stops:6.5in'><span style='font-size:13.0pt;mso-bidi-font-size:14.0pt;
letter-spacing:-.2pt;background:white;mso-highlight:white'>- Tỷ lệ
cử tri đã tham gia bỏ phiếu so với tổng
số cử tri của đơn vị bầu
cử:<span style="color:red"><?php echo number_format(100*$tonghop['tylecutri'], 2, ',', '.');?></span>%<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;text-align:justify;text-indent:.25in;mso-pagination:none'><span
style='font-size:13.0pt;mso-bidi-font-size:14.0pt;letter-spacing:-.2pt;
background:white;mso-highlight:white'>- Số phiếu phát
ra: <span style="color:red"><?php echo number_format($tonghop['sophieuphatra'], 0, ',', '.');?></span> phiếu <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;text-align:justify;text-indent:.25in;mso-pagination:none'><span
style='font-size:13.0pt;mso-bidi-font-size:14.0pt;letter-spacing:-.2pt;
background:white;mso-highlight:white'>- Số phiếu thu
vào: <span style="color:red"><?php echo number_format($tonghop['sophieuthuvao'], 0, ',', '.');?></span> phiếu <o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;text-align:justify;text-indent:.25in;mso-pagination:none'><span
style='font-size:13.0pt;mso-bidi-font-size:14.0pt;letter-spacing:-.2pt;
background:white;mso-highlight:white'>- Số phiếu hợp
lệ: <span style="color:red"><?php echo number_format($tonghop['sophieuhople'], 0, ',', '.');?></span> phiếu. Tỷ lệ so với
tổng số phiếu thu vào: <span style="color:red"><?php echo number_format(100*$tonghop['tylephieuhople'], 2, ',', '.');?></span>%<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;text-align:justify;text-indent:17.85pt;mso-pagination:none'><span
style='font-size:13.0pt;mso-bidi-font-size:14.0pt;letter-spacing:-.2pt;
background:white;mso-highlight:white'>- Số phiếu không hợp
lệ: <span style="color:red"><?php echo number_format($tonghop['sophieukhonghople'], 0, ',', '.');?></span> phiếu. Tỷ lệ so với tổng
số phiếu thu vào: <span style="color:red"><?php echo number_format(100*$tonghop['tylephieukhonghople'], 2, ',', '.');?></span>%<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;text-align:justify;text-indent:.25in;mso-pagination:none'><span
style='font-size:13.0pt;mso-bidi-font-size:14.0pt;letter-spacing:-.2pt;
background:white;mso-highlight:white'>- Số phiếu bầu cho
mỗi người ứng cử như sau: <o:p></o:p></span></p>
<?php foreach ($nguoiungcu as $k_nguoiungcu => $v_nguoiungcu) {
    $sophieubau=0;
    for($iii=0; $iii<count($nguoiungcus); $iii++){
        if($k_nguoiungcu == $nguoiungcus[$iii]['nguoiungcu_id']){
            $sophieubau += $nguoiungcus[$iii]['sophieubau'];
            // echo $k_nguoiungcu.'-'.$nguoiungcus[$iii]['nguoiungcu_id'].'-'.$sophieubau.'/';
        }
    }
    
    $v_nguoiungcu = array_values($v_nguoiungcu);
    $v_nguoiungcu[0]['sophieubau'] = $sophieubau;
    $v_nguoiungcu[0]['tyle'] = $tonghop['sophieuhople']>0?100*$sophieubau/$tonghop['sophieuhople']:0;
    $tmp_nguoiungcu[10000*$sophieubau/$tonghop['sophieuhople']] = $v_nguoiungcu;
    ?>
<p class=MsoNormal style='margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;text-align:justify;text-indent:17.85pt'><span lang=VI
style='font-size:13.0pt;font-family:"Times New Roman","sans-serif";color:black'>
<?php echo ++$sdfhskdjf;?>. <span style="color:red"><?php echo $v_nguoiungcu[0]['hoten']?></span> được <span style="color:red">
<?php echo number_format($sophieubau, 0, ',', '.');?> </span> phiếu/ <span style="color:red"><?php echo number_format($tonghop['sophieuhople'], 0, ',', '.');?> </span>
 phiếu hợp lệ</span>
<?php }?>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:17.85pt;
mso-pagination:none'><b style='mso-bidi-font-weight:normal'><span
style='font-size:13.0pt;mso-bidi-font-size:14.0pt;background:white;mso-highlight:
white'>Căn cứ vào kết quả ghi trên đây, Ban
bầu cử đại biểu Hội đồng nhân dân
<span style='color:red'>thành phố Đà Nẵng</span> kết
luận:<o:p></o:p></span></b></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:17.85pt;
mso-pagination:none'><span style='font-size:13.0pt;mso-bidi-font-size:14.0pt;
background:white;mso-highlight:white'>a) Số cử tri đã tham gia
bỏ phiếu đạt <span style="color:red"><?php echo number_format(100*$tonghop['tylecutri'], 2, ',', '.');?></span>% so với tổng
số cử tri của đơn vị bầu cử</span><span
style='font-size:13.0pt;mso-bidi-font-size:14.0pt'>.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:17.85pt;
mso-pagination:none'><span style='font-size:13.0pt;mso-bidi-font-size:14.0pt;
background:white;mso-highlight:white'>b) Các Ông/bà có tên sau đây
nhận được quá nửa tổng số phiếu
hợp lệ và có nhiều phiếu hơn, đã trúng
cử đại biểu Hội đồng nhân dân <span
style='color:red'>thành phố Đà Nẵng</span> khóa <span
style='color:red'>X</span>, nhiệm kỳ 2021-2026:<o:p></o:p></span></p>

<?php krsort($tmp_nguoiungcu);?>
<?php foreach ($tmp_nguoiungcu as $tmp_k => $tmp_v) { 
    if(++$uirhvergherui==$soluongduocbau+1) break;
    if($tmp_v[0]['tyle']>=50) $tmp['sodaibieutrungcu']++;
    else $tmp['sodaibieukhongtrungcu']++;
    if($tmp_v[0]['tyle']>=50){?>
<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:17.85pt;
mso-pagination:none'><span lang=VI
style='font-size:13.0pt;font-family:"Times New Roman","sans-serif";color:black'><?php echo $uirhvergherui;?>. <span style="color:red"><?php echo $tmp_v[0]['hoten']?></span> số phiếu: <span style="color:red"><?php echo number_format($tmp_v[0]['sophieubau'], 0, ',', '.')?></span> đạt: <span style="color:red"><?php echo number_format($tmp_v[0]['tyle'], 2, ',', '.')?></span> % so
với tổng số phiếu hợp lệ.</span></p>
<?php }}?>
<?php if(($soluongduocbau-$tmp['sodaibieutrungcu'])>0){?>
<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.25in;
mso-pagination:none'><span lang=VI
style='font-size:13.0pt;mso-bidi-font-size:14.0pt;
letter-spacing:-.2pt;background:white;mso-highlight:white'>Vì số người trúng cử đại biểu Hội đồng nhân dân chưa đủ số lượng đại biểu được bầu đã ấn định cho đơn vị bầu cử nên đề nghị Ủy ban bầu cử <span style="color:red">Hội đồng nhân dân thành phố Đà nẵng</span> xem xét, quyết định việc bầu cử thêm tại đơn vị bầu cử.</span></p>
<?php }?>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.25in;
mso-pagination:none'><span style='font-size:13.0pt;mso-bidi-font-size:14.0pt;
letter-spacing:-.2pt;background:white;mso-highlight:white'>c) Theo ấn
định của Ủy ban bầu cử <span
style='color:red'>thành phố</span>, thì số đại
biểu Hội đồng nhân dân <span style='color:red'>thành
phố Đà Nẵng </span>được bầu ở
<span style="color:red"><?php echo $donvibaucu['ten']?></span> là <span style="color:red"><?php echo $soluongduocbau?></span> đại biểu, nay đã bầu
được <span style='color:red'><?php echo (int)$tmp['sodaibieutrungcu']?></span> đại
biểu, còn thiếu <span style='color:red'><?php echo $soluongduocbau-$tmp['sodaibieutrungcu']?></span> đại
biểu.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:17.85pt;
mso-pagination:none'><span style='font-size:13.0pt;mso-bidi-font-size:14.0pt;
letter-spacing:-.2pt;background:white;mso-highlight:white'>d) Tóm tắt
những việc xảy ra</span><span class=MsoFootnoteReference><span
style='font-family:Symbol;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
"Times New Roman";mso-char-type:symbol;mso-symbol-font-family:Symbol'><span
style='mso-char-type:symbol;mso-symbol-font-family:Symbol'>(</span></span>8</span><span
class=MsoFootnoteReference><span style='font-family:Symbol;mso-ascii-font-family:
"Times New Roman";mso-hansi-font-family:"Times New Roman";mso-char-type:symbol;
mso-symbol-font-family:Symbol'><span style='mso-char-type:symbol;mso-symbol-font-family:
Symbol'>)</span></span></span><span style='font-size:13.0pt;mso-bidi-font-size:
14.0pt;letter-spacing:-.2pt;background:white;mso-highlight:white'>: <span
style='color:red'>Không có</span><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:17.85pt;
mso-pagination:none'><span style='font-size:13.0pt;mso-bidi-font-size:14.0pt;
letter-spacing:-.2pt;background:white;mso-highlight:white'>đ) Những
khiếu nại, tố cáo trong quá trình bầu cử do các
Tổ bầu cử đã giải quyết</span><span
class=MsoFootnoteReference><span style='font-family:Symbol;mso-ascii-font-family:
"Times New Roman";mso-hansi-font-family:"Times New Roman";mso-char-type:symbol;
mso-symbol-font-family:Symbol'><span style='mso-char-type:symbol;mso-symbol-font-family:
Symbol'>(</span></span>9</span><span class=MsoFootnoteReference><span
style='font-family:Symbol;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
"Times New Roman";mso-char-type:symbol;mso-symbol-font-family:Symbol'><span
style='mso-char-type:symbol;mso-symbol-font-family:Symbol'>)</span></span></span><span
style='font-size:13.0pt;mso-bidi-font-size:14.0pt;letter-spacing:-.2pt;
background:white;mso-highlight:white'>: <span style='color:red'>Không có.</span><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:17.85pt;
mso-pagination:none'><span style='font-size:13.0pt;mso-bidi-font-size:14.0pt;
letter-spacing:-.2pt;background:white;mso-highlight:white'>e) Những
khiếu nại, tố cáo trong quá trình bầu cử do Ban
bầu cử đã giải quyết, cách giải quyết </span><span
class=MsoFootnoteReference><span style='font-family:Symbol;mso-ascii-font-family:
"Times New Roman";mso-hansi-font-family:"Times New Roman";mso-char-type:symbol;
mso-symbol-font-family:Symbol'><span style='mso-char-type:symbol;mso-symbol-font-family:
Symbol'>(</span></span>10</span><span class=MsoFootnoteReference><span
style='font-family:Symbol;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
"Times New Roman";mso-char-type:symbol;mso-symbol-font-family:Symbol'><span
style='mso-char-type:symbol;mso-symbol-font-family:Symbol'>)</span></span></span><span
style='font-size:13.0pt;mso-bidi-font-size:14.0pt;letter-spacing:-.2pt;
background:white;mso-highlight:white'>: <span style='color:red'>Không có.</span><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:17.85pt;
mso-pagination:none'><span style='font-size:13.0pt;mso-bidi-font-size:14.0pt;
letter-spacing:-.2pt;background:white;mso-highlight:white'>g)Những
khiếu nại, tố cáo chuyển đến Ủy ban
bầu cử </span><span class=MsoFootnoteReference><span
style='font-family:Symbol;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
"Times New Roman";mso-char-type:symbol;mso-symbol-font-family:Symbol'><span
style='mso-char-type:symbol;mso-symbol-font-family:Symbol'>(</span></span>11</span><span
class=MsoFootnoteReference><span style='font-family:Symbol;mso-ascii-font-family:
"Times New Roman";mso-hansi-font-family:"Times New Roman";mso-char-type:symbol;
mso-symbol-font-family:Symbol'><span style='mso-char-type:symbol;mso-symbol-font-family:
Symbol'>)</span></span></span><span style='font-size:13.0pt;mso-bidi-font-size:
14.0pt;letter-spacing:-.2pt;background:white;mso-highlight:white'>: <span
style='color:red'>Không có.</span><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:17.85pt;
mso-pagination:none'><span style='font-size:13.0pt;mso-bidi-font-size:12.0pt'>Biên
bản xác định kết quả bầu cử
đại biểu Hội đồng nhân dân </span><span
class=MsoFootnoteReference>(1)</span> <span style='font-size:13.0pt;mso-bidi-font-size:
12.0pt;color:red'>thành phố Đà Nẵng</span><span
style='font-size:13.0pt;mso-bidi-font-size:12.0pt'> ở <span style="color:red"><?php echo $donvibaucu['ten']?></span>
 được lập thành 04 bản và được gửi đến
Ủy ban bầu cử, Thường trực Hội
đồng nhân dân, Ủy ban nhân dân, Ban Thường
trực Ủy ban Mặt trận Tổ quốc Việt Nam
<span style='color:red'>thành phố Đà Nẵng</span></span>./.</p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.25in'><span
style='font-size:14.0pt;background:white;mso-highlight:white'><o:p> </o:p></span></p>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
 style='margin-left:5.4pt;border-collapse:collapse;mso-yfti-tbllook:480;
 mso-padding-alt:0in 5.4pt 0in 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;mso-yfti-lastrow:yes'>
  <td width=220 valign=top style='width:164.65pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span style='mso-bidi-font-size:14.0pt;
  background:white;mso-highlight:white'>TM. BAN BẦU CỬ<o:p></o:p></span></b></p>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span style='mso-bidi-font-size:14.0pt;
  background:white;mso-highlight:white'>TRƯỞNG BAN</span></b><span
  style='font-size:14.0pt;background:white;mso-highlight:white'><o:p></o:p></span></p>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:13.0pt'>(Ký, ghi rõ họ và tên,<span
  style='mso-spacerun:yes'> </span><span
  style='mso-spacerun:yes'></span><br>đóng dấu của Ban bầu
  cử)<o:p></o:p></span></p>
  </td>
  <td width=140 valign=top style='width:105.35pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:14.0pt;background:white;mso-highlight:white'><o:p> </o:p></span></p>
  </td>
  <td width=267 valign=top style='width:200.3pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span style='mso-bidi-font-size:14.0pt;
  background:white;mso-highlight:white'><o:p> </o:p></span></b></p>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span style='mso-bidi-font-size:14.0pt;
  background:white;mso-highlight:white'>CÁC PHÓ TRƯỞNG BAN <o:p></o:p></span></b></p>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:13.0pt;mso-bidi-font-size:14.0pt;background:white;
  mso-highlight:white'>(Ký, ghi rõ họ và tên)</span><b style='mso-bidi-font-weight:
  normal'><span style='font-size:14.0pt;background:white;mso-highlight:white'><o:p></o:p></span></b></p>
  </td>
 </tr>
</table>

<p class=MsoNormal><span style='font-size:14.0pt;background:white;mso-highlight:
white'><o:p> </o:p></span></p>

<p class=MsoNormal style='margin-top:13.0pt;text-align:justify;text-indent:.5in'><b
style='mso-bidi-font-weight:normal'><i><u><span style='mso-bidi-font-size:14.0pt;
letter-spacing:-.2pt;background:white;mso-highlight:white'><br
style='mso-special-character:line-break'>
<![if !supportLineBreakNewLine]><br style='mso-special-character:line-break'>
<![endif]><o:p></o:p></span></u></i></b></p>

<b style='mso-bidi-font-weight:normal'><i><u><span style='font-size:12.0pt;
mso-bidi-font-size:14.0pt;font-family:"Times New Roman","serif";mso-fareast-font-family:
"Times New Roman";letter-spacing:-.2pt;background:white;mso-highlight:white;
mso-ansi-language:EN-US;mso-fareast-language:EN-US;mso-bidi-language:AR-SA'><br
clear=all style='page-break-before:always'>
</span></u></i></b>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.5in'><b
style='mso-bidi-font-weight:normal'><i><u><span style='mso-bidi-font-size:14.0pt;
letter-spacing:-.2pt;background:white;mso-highlight:white'>Ghi chú</span></u></i></b><b
style='mso-bidi-font-weight:normal'><i><span style='mso-bidi-font-size:14.0pt;
letter-spacing:-.2pt;background:white;mso-highlight:white'>: Nhất<span
style='mso-bidi-font-weight:bold'> thiết không được
tẩy xóa trên biên bản.<o:p></o:p></span></span></i></b></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.5in'><span
style='mso-bidi-font-size:14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";
mso-hansi-font-family:"Times New Roman";background:white;mso-highlight:white;
mso-char-type:symbol;mso-symbol-font-family:Symbol'><span style='mso-char-type:
symbol;mso-symbol-font-family:Symbol'>(</span></span><span style='mso-bidi-font-size:
14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
"Times New Roman";background:white;mso-highlight:white;mso-char-type:symbol;
mso-symbol-font-family:Symbol'><span style='mso-char-type:symbol;mso-symbol-font-family:
Symbol'>1</span></span><span style='mso-bidi-font-size:14.0pt;font-family:Symbol;
mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:"Times New Roman";
background:white;mso-highlight:white;mso-char-type:symbol;mso-symbol-font-family:
Symbol'><span style='mso-char-type:symbol;mso-symbol-font-family:Symbol'>)</span></span><span
style='mso-bidi-font-size:14.0pt;background:white;mso-highlight:white'> Ghi tên
đơn vị hành chính cấp tổ chức bầu
cử đại biểu Hội đồng nhân dân.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.5in'><span
style='mso-bidi-font-size:14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";
mso-hansi-font-family:"Times New Roman";background:white;mso-highlight:white;
mso-char-type:symbol;mso-symbol-font-family:Symbol'><span style='mso-char-type:
symbol;mso-symbol-font-family:Symbol'>(</span></span><span style='mso-bidi-font-size:
14.0pt;background:white;mso-highlight:white'>2</span><span style='mso-bidi-font-size:
14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
"Times New Roman";background:white;mso-highlight:white;mso-char-type:symbol;
mso-symbol-font-family:Symbol'><span style='mso-char-type:symbol;mso-symbol-font-family:
Symbol'>)</span></span><span style='mso-bidi-font-size:14.0pt;background:white;
mso-highlight:white'> Ghi tên các đơn vị hành chính cấp
dưới hoặc thôn, tổ dân phố trong phạm vi
đơn vị bầu cử đại biểu Hội
đồng nhân dân tương ứng ở mỗi cấp.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.5in'><span
style='mso-bidi-font-size:14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";
mso-hansi-font-family:"Times New Roman";background:white;mso-highlight:white;
mso-char-type:symbol;mso-symbol-font-family:Symbol'><span style='mso-char-type:
symbol;mso-symbol-font-family:Symbol'>(</span></span><span style='mso-bidi-font-size:
14.0pt;background:white;mso-highlight:white'>3</span><span style='mso-bidi-font-size:
14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
"Times New Roman";background:white;mso-highlight:white;mso-char-type:symbol;
mso-symbol-font-family:Symbol'><span style='mso-char-type:symbol;mso-symbol-font-family:
Symbol'>)</span></span><span style='mso-bidi-font-size:14.0pt;background:white;
mso-highlight:white'> Ghi rõ số lượng đại
biểu Hội đồng nhân dân được bầu
tại đơn vị bầu cử theo Nghị quyết
của Ủy ban bầu cử đại biểu Hội
đồng nhân dân ở cấp đó.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.5in'><span
style='mso-bidi-font-size:14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";
mso-hansi-font-family:"Times New Roman";background:white;mso-highlight:white;
mso-char-type:symbol;mso-symbol-font-family:Symbol'><span style='mso-char-type:
symbol;mso-symbol-font-family:Symbol'>(</span></span><span style='mso-bidi-font-size:
14.0pt;background:white;mso-highlight:white'>4</span><span style='mso-bidi-font-size:
14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
"Times New Roman";background:white;mso-highlight:white;mso-char-type:symbol;
mso-symbol-font-family:Symbol'><span style='mso-char-type:symbol;mso-symbol-font-family:
Symbol'>)</span></span><span style='mso-bidi-font-size:14.0pt;background:white;
mso-highlight:white'> Ghi rõ số lượng người
ứng cử đại biểu Hội đồng nhân dân
theo Danh sách chính thức những người ứng cử
đại biểu Hội đồng nhân dân do Ủy ban
bầu cử đại biểu Hội đồng nhân dân
ở cấp đã được công bố.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.5in'><span
style='mso-bidi-font-size:14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";
mso-hansi-font-family:"Times New Roman";background:white;mso-highlight:white;
mso-char-type:symbol;mso-symbol-font-family:Symbol'><span style='mso-char-type:
symbol;mso-symbol-font-family:Symbol'>(</span></span><span style='mso-bidi-font-size:
14.0pt;background:white;mso-highlight:white'>5</span><span style='mso-bidi-font-size:
14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
"Times New Roman";background:white;mso-highlight:white;mso-char-type:symbol;
mso-symbol-font-family:Symbol'><span style='mso-char-type:symbol;mso-symbol-font-family:
Symbol'>)</span></span><span style='mso-bidi-font-size:14.0pt;background:white;
mso-highlight:white'> Trường hợp số cử tri đi
bỏ phiếu chưa đạt quá một nửa
tổng số cử tri của đơn vị bầu
cử thì viết thêm như sau: <i style='mso-bidi-font-style:normal'>Vì
số cử tri đi bỏ phiếu chưa đạt quá
một nửa tổng số cử tri của đơn
vị bầu cử, nên cuộc bầu cử đại
biểu Hội đồng nhân dân (1) tại
đơn vị bầu cử số ... Không có giá trị.
Đề nghị Ủy ban bầu cử (1) ......... xem
xét, quyết định việc bầu cử lại
tại đơn vị bầu cử</i>.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.5in'><span
style='mso-bidi-font-size:14.0pt;background:white;mso-highlight:white'>(6)
Xếp tên người trúng cử theo thứ tự từ
người nhiều phiếu nhất đến
người ít phiếu nhất.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.5in'><span
style='mso-bidi-font-size:14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";
mso-hansi-font-family:"Times New Roman";background:white;mso-highlight:white;
mso-char-type:symbol;mso-symbol-font-family:Symbol'><span style='mso-char-type:
symbol;mso-symbol-font-family:Symbol'>(</span></span><span style='mso-bidi-font-size:
14.0pt;background:white;mso-highlight:white'>7</span><span style='mso-bidi-font-size:
14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
"Times New Roman";background:white;mso-highlight:white;mso-char-type:symbol;
mso-symbol-font-family:Symbol'><span style='mso-char-type:symbol;mso-symbol-font-family:
Symbol'>)</span></span><span style='mso-bidi-font-size:14.0pt;background:white;
mso-highlight:white'> Trường hợp đã bầu
được đủ số lượng đại
biểu thì ghi tổng số đại biểu đã trúng
cử và ghi "0" vào số đại biểu còn thiếu. Trường
hợp Không có người ứng cử nào được
qúa nửa số phiếu hợp lệ hoặc số
người trúng cử ít hơn số đại biểu được
bầu ở đơn vị bầu cử thì ghi rõ số
lượng còn thiếu và viết</span><span style='mso-bidi-font-size:
14.0pt'> thêm như sau: <i style='mso-bidi-font-style:normal'>Vì số
người trúng cử đại biểu Hội
đồng nhân dân chưa đủ số lượng
đại biểu được bầu đã ấn
định cho đơn vị bầu cử nên đề
nghị Ủy ban bầu cử</i> <i>(1)</i>.................<i
style='mso-bidi-font-style:normal'> xem xét, quyết định việc
bầu cử thêm tại đơn vị bầu cử.<o:p></o:p></i></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.5in'><span
style='mso-bidi-font-size:14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";
mso-hansi-font-family:"Times New Roman";background:white;mso-highlight:white;
mso-char-type:symbol;mso-symbol-font-family:Symbol'><span style='mso-char-type:
symbol;mso-symbol-font-family:Symbol'>(</span></span><span style='mso-bidi-font-size:
14.0pt;background:white;mso-highlight:white'>8</span><span style='mso-bidi-font-size:
14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
"Times New Roman";background:white;mso-highlight:white;mso-char-type:symbol;
mso-symbol-font-family:Symbol'><span style='mso-char-type:symbol;mso-symbol-font-family:
Symbol'>)</span></span><span style='mso-bidi-font-size:14.0pt;background:white;
mso-highlight:white'> Ghi rõ những việc bất thường
đã xảy ra; nếu Không có việc gì xảy ra thì ghi
"Không có".<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.5in'><span
style='mso-bidi-font-size:14.0pt;background:white;mso-highlight:white'>(9),
(10), (11) Ghi rõ các đơn thư, nội dung khiếu
nại, tố cáo do Tổ bầu cử chuyển
đến; nếu Không có thì ghi "Không có".<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.5in'><span
style='mso-bidi-font-size:14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";
mso-hansi-font-family:"Times New Roman";background:white;mso-highlight:white;
mso-char-type:symbol;mso-symbol-font-family:Symbol'><span style='mso-char-type:
symbol;mso-symbol-font-family:Symbol'>(</span></span><span style='mso-bidi-font-size:
14.0pt;background:white;mso-highlight:white'>12</span><span style='mso-bidi-font-size:
14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
"Times New Roman";background:white;mso-highlight:white;mso-char-type:symbol;
mso-symbol-font-family:Symbol'><span style='mso-char-type:symbol;mso-symbol-font-family:
Symbol'>)</span></span><span style='mso-bidi-font-size:14.0pt;background:white;
mso-highlight:white'> Biên bản phải được gửi
đến các cơ quan được nêu tên chậm nhất
là 05 ngày sau ngày bầu cử.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.5in'><span
style='mso-bidi-font-size:14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";
mso-hansi-font-family:"Times New Roman";background:white;mso-highlight:white;
mso-char-type:symbol;mso-symbol-font-family:Symbol'><span style='mso-char-type:
symbol;mso-symbol-font-family:Symbol'>(</span></span><span style='mso-bidi-font-size:
14.0pt;background:white;mso-highlight:white'>13</span><span style='mso-bidi-font-size:
14.0pt;font-family:Symbol;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
"Times New Roman";background:white;mso-highlight:white;mso-char-type:symbol;
mso-symbol-font-family:Symbol'><span style='mso-char-type:symbol;mso-symbol-font-family:
Symbol'>)</span></span><span style='mso-bidi-font-size:14.0pt;background:white;
mso-highlight:white'><span style='mso-spacerun:yes'></span>Ví dụ
như các đơn khiếu nại, tố cáo hay tờ
trình, báo cáo của Tổ bầu cử.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.5in'><span
style='mso-bidi-font-size:14.0pt;background:white;mso-highlight:white'>Việc
xác định kết quả trong bầu cử lại,
bầu cử th?m được Ban bầu cử
đại biểu Hội đồng nhân dân lập thành
biên bản riêng với các nội dung theo Mẫu số 26/HĐBC-HĐND.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;text-align:justify;text-indent:.5in'><span
style='mso-bidi-font-size:14.0pt;background:white;mso-highlight:white'><o:p> </o:p></span></p>

<p class=MsoNormal style='margin-bottom:6.0pt'><i><span style='font-size:10.0pt;
letter-spacing:-.2pt;background:white;mso-highlight:white'><o:p> </o:p></span></i></p>

</div>

</body>

</html>