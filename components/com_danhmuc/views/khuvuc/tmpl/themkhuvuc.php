<?php
    defined('_JEXEC') or die ('Restricted access');
    $ds_quan    = $this->ds_quan;
    $khuvuc_id = JRequest::getVar('id');
    if($khuvuc_id){
        $khuvuc     = $this->khuvuc;
    }
?>
<link rel="stylesheet" type="text/css" href="components/com_danhmuc/css/add.css"/>
<form id="form_khuvuc" class="form-horizontal" method="post">
    <?php echo JHtml::_( 'form.token' ); ?>
    <table>
        <tr>
            <td>Quận/huyện <span style="color:red">*</span></td>
            <td>
                <select id="quanhuyen_select" name="quanhuyen">
                    <option value="" >Chọn Quận/huyện</option>
                    <?php
                        
                        for($i=0;$i<count($ds_quan);$i++){
                            if($khuvuc_id){
                                $id_quanhuyen = substr($khuvuc['comm_code'],0,5);
                                if($id_quanhuyen==$ds_quan[$i]["code"]){
                                    $selected = 'selected';
                                }
                                else{
                                    $selected= '';
                                }
                            }
                            else{
                                $selected= '';
                            }
                            echo '<option value="'.$ds_quan[$i]["code"].'" '.$selected.'>'.$ds_quan[$i]["name"].'</option>';
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Phường/xã <span style="color:red">*</span></td>
            <td>
                <select id="phuongxa_select" name="phuongxa">
                    <option value="">Chọn Phường/xã</option>
                    <?php 
                        if($khuvuc_id){
                            $model = Core::model('Danhmuckieubao/Khuvuc');
                            $ds_phuongxa= $model->findphuongxabyquanhuyen($id_quanhuyen);        
                            for($i=0;$i<count($ds_phuongxa);$i++){
                                if($ds_phuongxa[$i]['code']==$khuvuc['comm_code']){
                                    $selected= 'selected';
                                }
                                else{
                                    $selected='';
                                }
                                echo  '<option value='.$ds_phuongxa[$i]['code'].' '.$selected.'>'.$ds_phuongxa[$i]['name'].'</option>';
                            }
                        }
                    ?>
                </select>               
            </td>
        </tr>
        <tr>
            <td>Mã <span style="color:red">*</span></td>
            <td>
                <input type="text" name="ma" id="ma" value="<?php if($khuvuc_id) echo $khuvuc['ma']; ?>">
                <input type="hidden" name="id" value="<?php if($khuvuc_id) echo $khuvuc['id']; ?>">
            </td>
        </tr>
        <tr>
            <td>Tên <span style="color:red">*</span></td>
            <td><input type="text" id="ten" name="ten" value="<?php if($khuvuc_id) echo $khuvuc['ten']; ?>"/></td>
        </tr>
        <tr>
            <td>Trạng thái <span style="color:red">*</span></td>
            <td>
                <label>
                    <input type="radio" name="trangthai" <?php echo ($khuvuc_id && $khuvuc['trangthai']=='1')?'checked="checked"':''; ?> value="1" placeholder="1">
                    <span class="lbl"> Đang hoạt động</span>
                </label>
                <label>
                    <input type="radio" name="trangthai" <?php echo ($khuvuc_id && $khuvuc['trangthai']=='0')?'checked="checked"':''; ?> value="0"/>
                    <span class="lbl">Không hoạt động</span>
                </label>
                
            </td>
        </tr>
    </table>
    
 </form>
 <script type="text/javascript">
    jQuery(document).ready(function($){
        $('#form_khuvuc').validate({
            rules:{
                ma: {required: true},
                ten: {required: true},
                quanhuyen:{required:true},
                phuongxa:{required:true}
            },
            messages:{
                ma: {required:"Vui lòng nhập mã"},
                ten: {required:"Vui lòng nhập tên"},
                quanhuyen: {required:"Vui lòng chọn quận huyện"},
                phuongxa: {required:"Vui lòng chọn phường xã"}
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
        $('#quanhuyen_select').on('change',function(){
            var city_id = $(this).val();
            console.log('aaa');
            $.ajax({
                type: 'post',
                url: 'index.php?option=com_danhmuc&controller=khuvuc&task=findphuongxabyquanhuyen',
                data: {id:city_id},
                success: function(data){
                    var data1 = JSON.parse(data);
                    var str = '<option>Chọn Phường/xã</option>';
                    for(i=0;i<data1.length;i++){
                        str+= '<option value="'+data1[i].code+'">'+data1[i].name+'</option>';
                    }
                    $('#phuongxa_select').html(str);  
                }
            });
        });
    });
</script>