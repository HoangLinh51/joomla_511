<?php
/**
* @file: input.php
* @author: huuthanh3108@gmaill.com
* @date: 01-04-2015
* @company : http://dnict.vn
* 
**/
?>
	<span class="btn btn-danger btn-mini" style="line-height: 22px !important;"
    onclick='
    var ln = 0;
	var arr = document.getElementsByName("DELidfiledk<?php echo $this->idObject?>[]");
	for(var i = 0 ; i < arr.length ;i++ ){
		if(arr[i].checked == true){
			ln = 1;
		}
	}
	if(ln == 1){
		if(confirm("Bạn có muốn xóa không")){
		var names = [];
		for(var i = 0 ; i < arr.length ;i++ ){
			if(arr[i].checked == true){
				names.push(arr[i].value);
			}
		}     
			var url="index.php?option=com_core&controller=attachment&format=raw&task=delete&type=<?php echo $this->type ?>&year=<?php echo $this->year?>&iddiv=<?php echo $this->iddiv ?>&idObject=<?php echo $this->idObject?>&isTemp=<?php echo $this->isTemp ?>&from=attachment";
   			jQuery.post(url,{"DELidfiledk<?php echo $this->idObject?>[]":names},function(resp){
   				jQuery("#tftemp<?php echo $this->idObject?>").html(resp);
   			});
		}
	}
	else
	{
		alert("Bạn phải chọn ít nhất một dòng để xóa");
	}
    return false;
    '
    ><i class="icon-trash"></i></span>   
<span class="btn btn-success btn-mini" style="line-height: 22px !important;" onclick="document.getElementById('tftemp<?php echo $this->idObject?>').style.display='';
	document.getElementById('tftemp<?php echo $this->idObject?>').src ='index.php?option=com_core&controller=attachment&format=raw&task=attachment&type=-1&year=<?php echo $this->year?>&idObject=<?php echo $this->idObject?>&iddiv=<?php echo $this->iddiv ?>&isTemp=<?php echo $this->isTemp?>&pdf=<?php echo $this->pdf?>=&from=attachment';
	return false;"><i class="icon-plus"></i></span>
(<strong>Giới hạn tập tin tối đa: <?php echo (ini_get('upload_max_filesize'))?></strong>.)<br/>
<?php
//var_dump($this->data);
	//$stt=0;
    //for ($i=0,$n=count($this->data);$i<$n;$i++){
        //$item = $this->data[$i];
	//foreach ($this->data as $item)
	//{
	$stt++;
?>
		<?php if($this->isCapnhat == 1){ ?>  
		<input type="hidden" class="fileUploaded" name="idFile-<?php echo $this->iddiv; ?>[]" value=<?php echo $item['code']; ?>>
		<!-- <input type="hidden" class="fileUploaded" name="idFile-dinhkemfile[]" value=<?php //echo $item['code']; ?>> -->
		<input checked="checked" type=checkbox class="DELidfiledk<?php echo $this->idObject ?>" name='DELidfiledk<?php echo $this->idObject ?>[]' value='<?php echo $item['code']; ?>'> 
		<?php }
			else 
			echo $stt.".";
		?>
		<span class="lbl"><a target="_blank" href="index.php?option=com_core&controller=attachment&format=raw&task=download&year=<?php echo $this->year;?>&code=<?php echo $item['code']?>"><?php echo $item['filename']; ?></a></span><br/>
<?php //} ?>
<iframe style="overflow-x:visible;display:none;" allowTransparency=true BORDER=0 scrolling=no FRAMEBORDER=no  class='iframeinputfile' id="tftemp<?php echo $this->idObject?>" 
name="tftemp<?php echo $this->idObject?>" 
src="" >
</iframe>
<script type="text/javascript">
if(jQuery('.div_secured').length > 0){
	if(jQuery('.fileUploaded').length > 0 || jQuery('.btn_remove_soqd').length > 0){
		jQuery('.div_secured').show();
	}else{
		jQuery('.div_secured').hide();
	}
}
</script>