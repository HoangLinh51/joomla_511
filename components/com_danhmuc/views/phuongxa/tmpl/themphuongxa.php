<?php 
	defined('_JEXEC') or die('Restricted Access');
	$phuongxa_id = JRequest::getVar('id');
	if($phuongxa_id){
		$phuongxa = $this->phuongxa;
	}
    $ds_thanhpho = $this->ds_thanhpho;
?>
<form id="form_phuongxa" method="post">
	<?php echo JHtml::_( 'form.token' ); ?>
	<table>
		<!-- <tr>
			<td>Mã</td>
			<td><input type="text" name="ma" id="ma" value="<?php if($phuongxa_id) echo $phuongxa['ma'] ?>">
				</td>
		</tr> -->
        <tr>
            <td>Thành phố <span style="color:red">*</span></td>
            <td>
                <select name="dc_cadc_code" id="dc_cadc_code">
                    <option value="">--Chọn thành phố--</option>
                    <?php for($i=0;$i<count($ds_thanhpho);$i++){ ?>
                        <option value="<?php echo $ds_thanhpho[$i]['code']; ?>" <?php if($phuongxa_id&&$ds_thanhpho[$i]['code']==$phuongxa['dc_cadc_code']) echo 'selected'; ?>><?php echo $ds_thanhpho[$i]['name']; ?></option>
                    <?php }?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Quận/huyện <span style="color:red">*</span></td>
            <td>
                <select id="dc_code" name="dc_code">
                    <option value="">--Chọn quận/huyện--</option>
                    <?php 
                        if($phuongxa_id){
                            $model = Core::model('Danhmuckieubao/Phuongxa');
                            $ds_quan = $model->findquanhuyenbythanhpho1($phuongxa['dc_cadc_code']);
                    ?>
                    <?php for($i=0;$i<count($ds_quan);$i++){ ?>
                        <option value="<?php echo $ds_quan[$i]['code'] ?>" <?php if($ds_quan[$i]['code']==$phuongxa['dc_code']) echo 'selected'; ?>><?php echo $ds_quan[$i]['name'] ?></option>
                    <?php }} ?>
                </select>
            </td>
        </tr>
		<tr>
			<td>Tên Phường/xã <span style="color:red">*</span></td>
			<td><input type="text" name="name" id="name" value="<?php if($phuongxa_id) echo $phuongxa['name'] ?>">
                <input type="hidden" name="code" id="code" value="<?php if($phuongxa_id) echo $phuongxa['code'] ?>">
            	<input type="hidden" name="type" id="type" value="1"></td>
		</tr>
        <tr>
            <td>Mức tương đương <span style="color:red">*</span></td>
            <td><input type="text" name="muctuongduong" id="muctuongduong" value="<?php if($phuongxa_id) echo $phuongxa['muctuongduong'] ?>"></td>
        </tr>
		<tr>
			<td>Trạng thái <span style="color:red">*</span></td>
			<td>
                <label>
                    <input type="radio" name="status" value="1" <?php echo ($phuongxa_id && $phuongxa['status']==1)?'checked':''?>>
                    <span class="lbl"> Đang hoạt động</span>
                </label>
                <label>
                    <input type="radio" name="status" value="0" <?php echo ($phuongxa_id && $phuongxa['status']==0)?'checked':''?>>
                    <span class="lbl">Không hoạt động</span>
                </label>
		</tr>
	</table>
</form>
<script>
	jQuery(document).ready(function($){
		$('#form_phuongxa').validate({
            rules:{
                name: {required: true},
                status:{required:true},
                cadc_code:{required:true}
            },
            messages:{
                name: {required:"Vui lòng nhập tên"},
                cadc_code: {required:"Vui lòng chọn thành phố"},
            },
            invalidHandler: function (event, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                        var message = errors == 1
                        ? 'Kiểm tra lỗi sau:<br/>'
                        : 'Phát hiện ' + errors + ' lỗi sau:<br/>';
                        var errors = "";
                        if (validator.errorList.length > 0) {
                            for (x=0;x<validator.errorList.length;x++) {
                                    errors += "<br/>\u25CF " + validator.errorList[x].message;
                            }
                        }
                        loadNoticeBoardError('Thông báo',message + errors);
                }
                validator.focusInvalid();
            },
            errorPlacement: function(error, element) {
            }
        });
        $('#dc_cadc_code').on('change',function(){
            var city_id = $(this).val();
            $.ajax({
                type: 'post',
                url: 'index.php?option=com_danhmuc&controller=phuongxa&task=findquanhuyenbythanhpho',
                data: {id:city_id},
                success: function(data){
                    var data1 = JSON.parse(data);
                    var str = '<option>Chọn Quận/huyện</option>';
                    for(i=0;i<data1.length;i++){
                        str+= '<option value="'+data1[i].code+'">'+data1[i].name+'</option>';
                    }
                    $('#dc_code').html(str);  
                }
            });
        });
	});
</script>