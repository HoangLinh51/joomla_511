<form class="form-horizontal" id="form_quyetdinh" name="form_quyetdinh" action="#" method="post">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm mới quyết định liên quan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="qdlienquan_mahieu">Số QĐ liên quan</label>
                            <input type="text" class="form-control rounded-0" id="qdlienquan_mahieu" name="qdlienquan_mahieu">
                        </div>
                        <div class="form-group">
                            <label for="qdlienquan_mahieu">Ngày ban hành</label>
                            <input type="text" class="form-control rounded-0" id="qdlienquan_mahieu" name="qdlienquan_mahieu">
                        </div>
                        <div class="form-group">
                            <label for="qdlienquan_mahieu">Cơ quan ban hành</label>
                            <input type="text" class="form-control rounded-0" id="qdlienquan_mahieu" name="qdlienquan_mahieu">
                        </div>
                        <?php echo Core::inputAttachmentOneFile('attactment_qdlienquan', null, 1, date('Y'), -1) ?>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" data-id="" class="btn btn-primary btn-saveqdlienquan">Lưu</button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.input-mask-date').mask('99/99/9999');
        jQuery("#form_quyetdinh").validate({
            // Your validation rules and messages
        });
    });
   
</script>