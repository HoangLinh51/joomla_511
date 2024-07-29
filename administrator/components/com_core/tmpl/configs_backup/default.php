<?php

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Core\Administrator\View\Configs\HtmlView;
/** @var HtmlView $this */
defined('_JEXEC') or die('Restricted access');

?>
<?php echo HTMLHelper::_('form.token'); ?>

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
<input type="hidden" id="cidhs" name="cidh" value="0">

    
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
		// $('#toolbar-icon-delete').attr('data-id', id).change();
		// var mytoken= Joomla.getOptions("csrf.token"); 
		// var userToken = document.getElementsByTagName('input')[0].name;
		// console.log(userToken);
		// $('#cidh').val(id).change();
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
	

	$('body').delegate('#toolbar-icon-delete', 'click', function(result){
		var id = $(this).data('id');
		var mytoken= Joomla.getOptions("csrf.token", ""); 
		var userToken = document.getElementsByTagName('input')[0].name;
		if (confirm("Bạn có chắc chắn muốn xóa không? Việc xác nhận sẽ xóa vĩnh viễn (các) mục đã chọn!") == true) {
			window.location.href = 'index.php?option=com_core&controller=menu&task=delete&id='+id +'&' +mytoken+ '=1';	
        } else {
            return false;		
        }
		});

    
	 _initPage();	
	Array.from(document.querySelectorAll('.modal')).forEach(function (modalEl) {
        modalEl.addEventListener('hidden.bs.modal', function () {
          setTimeout(function () {
            window.parent.location.reload();
          }, 1000);
        });
    });
    // $('.btn-saveConfig').on('click', function (_ref) { 
    //     document.adminFormConfig.submit();
    //     // const joomlaAlert = document.querySelector('joomla-alert');
    //     //                 console.log(joomlaAlert);
    // });
    

});
</script>
<style>
.col-md-12{
    padding-left: 0px;
    padding-right: 0px;
}    
</style>