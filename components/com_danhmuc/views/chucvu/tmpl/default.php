<div class="row-fluid">
	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#quanlychucvutuongduong" id="quanlychucvutuongduong_button">
					<i class="green icon-home bigger-110"></i>
					Chức vụ tương đương
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="quanlychucvutuongduong" class="tab-pane in active"></div>
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
		$('#quanlychucvutuongduong_button').on('click',function(){
			$('#quanlychucvutuongduong').load('index.php?option=com_danhmuc&view=chucvu&task=ds_quanlychucvutuongduong&format=raw');
		});
		$('#quanlychucvutuongduong_button').click();
	});
</script>