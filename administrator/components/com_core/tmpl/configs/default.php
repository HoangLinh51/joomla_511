<?php

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Core\Administrator\View\Configs\HtmlView;
/** @var HtmlView $this */
defined('_JEXEC') or die('Restricted access');

?>
<form action="<?php echo Route::_('index.php?option=com_core&view=configs'); ?>" method="post" name="adminForm" id="adminForm">
<div class="row-fluid" style="background-color: white;display: flex;padding: 15px;">
	<div class="col-md-3" style="background: transparent;box-shadow: none;float: left;border-right: 1px solid #ddd;padding: 0px;">
        <span><b>Cây chức năng</b></span>
        <div id="core-menu-tree"></div>
	</div>
	<div class="col-md-9" id="form-content" style="float: right;padding-left: 20px;">
	
	</div>
</div>
</div>
<?php // Load the pagination. ?>
<?php  // echo $this->pagination->getListFooter(); ?>
<input type="hidden" name="task" value="configs.delete">
<input type="hidden" id="cidhs" name="cidh" value="0">
<?php echo HTMLHelper::_('form.token'); ?>
</form>
<?php 
HTMLHelper::_('bootstrap.modal');
HTMLHelper::_('formbehavior.chosen', 'select');

?>  



<script type="text/javascript">
jQuery(document).ready(function($){

	var loadNoticeBoardSuccess = function(title,text){
        $.gritter.add({
            title: title,
            text: text,
            time: '2000',
            class_name: 'gritter-success gritter-center gritter-light'
        });
    };
    var loadNoticeBoardError = function(title,text){
        $.gritter.add({
            title: title,
            text: text,
            time: '2000',
            class_name: 'gritter-error gritter-light'
        });
    };
	var _initPage = function(){
		
	};
	var _initEditPage = function(id){
		$.get('index.php?option=com_core&view=configs&layout=list&format=raw',{"id":id},function(response){
            $('#form-content').html(response);
		});
	};
	var _initNewPage = function(parent_id){
     
		$.get('index.php?option=com_core&view=configs&layout=list&format=raw',{"parent_id":parent_id},function(response){
			$('#form-content').html(response);
		});
	};
	
	$('#core-menu-tree').jstree({
        "plugins": ["themes","crrm", "ui","types","dnd","cookies"],
        'check_callback' : true,
        "animation" : 0,
        "themes" : { "stripes" : true },
	  	"core":{
			"data" : {
                'contentType': "application/json; charset=utf-8",
				"url" : "index.php?option=com_core&controller=configs&task=getCoreMenu&format=raw",
				"data" : function(n) {
					return {
					 	"id" : n.id
					};
				}
			}
		},
        "types": {
            "default": {
                "icon": "fa fa-folder text-primary"
            },
            "file": {
                "icon": "fa fa-file  text-primary"
            }
        },      
	}).bind("select_node.jstree", function (event, data) {		    	
        var node_id = $('#core-menu-tree').jstree(true).get_selected()[0];
         _initEditPage(node_id)
	}).on('changed.jstree', function (e, data) {
        var i, j, r = [];
        for(i = 0, j = data.selected.length; i < j; i++) {
            r.push(data.instance.get_node(data.selected[i]).id);
        }
        var id = r.join(', ');
        _initEditPage(id);
        if(id > 0 || id != undefined){
            $('.button-delete').attr('disabled', false);
            $('#cidhs').val(id)
        }else{
            $('.button-delete').attr('disabled', true);
        }

    });
    $('.button-menu').click(function(){
        var node_id = $('#core-menu-tree').jstree(true).get_selected()[0];  
		if(typeof node_id == 'undefined'){			
		  	node_id = 0;
		}else{
		  	node_id = node_id;
		}
		_initNewPage(node_id);
		
	});
	

    $('body').delegate('.btnXoa', 'click', function(){
    
    var id = $(this).data('config-id');
    var mytoken= Joomla.getOptions("csrf.token", ""); 
    bootbox.confirm({
        title: "<header class='' style='font-weight:700;font-size:1.25rem;'>Cảnh báo</header>",
        message: '<section class="joomla-dialog-body" style="">Bạn có chắc chắn muốn xóa chính sách này khỏi đối tượng người có công?</section>',
        buttons: {
            confirm: { label: 'Đồng ý', className: 'button button-primary btn btn-primary' },
            cancel: { label: 'Không', className: 'button button-secondary btn btn-outline-secondary' }
        },
        callback: function (result) {
            if(result){
                $.ajax({
                    type: "POST",
                    url: 'index.php?option=com_core&task=config.deletevalue&id='+id +'&' +mytoken+ '=1',
                    success: function(data){    
                        //$('#system-message-container').html('<div id="system-message-container" aria-live="polite"><noscript><div class="alert alert-success">Xử lý thành công</div></noscript><joomla-alert type="success" close-text="Close" dismiss="true" role="alert" style="animation-name: joomla-alert-fade-in;"><button type="button" class="joomla-alert--close" aria-label="Close"><span aria-hidden="true">×</span></button><div class="alert-heading"><span class="success"></span><span class="visually-hidden">success</span></div><div class="alert-wrapper"><div class="alert-message">Xử lý thành công</div></div></joomla-alert></div>');
                        return true;
                    }
                });
                window.location.href = 'index.php?option=com_core&task=config.deletevalue&id='+id +'&' +mytoken+ '=1';	

            }else{
                return false;	
            }
        }
            
    })    
});
    

});


</script>
<style>
.col-md-12{
    padding-left: 0px;
    padding-right: 0px;
}    
</style>

