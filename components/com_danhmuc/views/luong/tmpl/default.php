<div class="row-fluid">
    <div class="tabbable">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active">
                <a data-toggle="tab" id="luongcoso_button" href="#ds_luongcoso">
                    <i class="green icon-home bigger-110"></i>
                    Lương cơ sở
                </a>
            </li>
            <li>
                <a data-toggle="tab" id="donvitinhphucap_button" href="#donvitinhphucap">
                    <i class="green icon-home bigger-110"></i>
                    Đơn vị tính phụ cấp
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#cachtinhphucap" id="cachtinhphucap_button">
                    <i class="green icon-home bigger-110"></i>
                    Cách tính phụ cấp
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#loaiphucap" id="loaiphucap_button">
                    <i class="green icon-home bigger-110"></i>
                    Loại phụ cấp
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#phucaplinhvuc" id="phucaplinhvuc_button">
                    <i class="green icon-home bigger-110"></i>
                    Phụ cấp lĩnh vực
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="ds_luongcoso" class="tab-pane in active"></div>
            <div id="donvitinhphucap" class="tab-pane"></div>
            <div id="cachtinhphucap" class="tab-pane"></div>
            <div id="loaiphucap" class="tab-pane"></div>
            <div id="phucaplinhvuc" class="tab-pane"></div>                      
        </div>
    </div>
</div>
<div id="content"></div>
<div id="modal-form" class="modal hide" tabindex="-1" style="width:900px;left:35%;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="blue bigger" id="modal-title"></h4>
    </div>
    <div class="modal-body overflow-visible">
        <div id="modal-content" class="slim-scroll" data-height="350">

        </div>
    </div>
    <div class="modal-footer">

    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('#luongcoso_button').on('click',function(){
            $('#ds_luongcoso').load('index.php?option=com_danhmuc&view=luong&task=ds_luongcoso&format=raw');
        });
        $('#luongcoso_button').click();
        $('#donvitinhphucap_button').on('click',function(){
            $('#donvitinhphucap').load('index.php?option=com_danhmuc&view=luong&task=ds_donvitinhphucap&format=raw');
        });
        $('#cachtinhphucap_button').on('click',function(){
            $('#cachtinhphucap').load('index.php?option=com_danhmuc&view=luong&task=ds_cachtinhphucap&format=raw');
        });
        $('#loaiphucap_button').on('click',function(){
            $('#loaiphucap').load('index.php?option=com_danhmuc&view=luong&task=ds_loaiphucap&format=raw');
        });
        $('#phucaplinhvuc_button').on('click',function(){
            $('#phucaplinhvuc').load('index.php?option=com_danhmuc&view=luong&task=ds_phucaplinhvuc&format=raw');
        });
    });
</script>