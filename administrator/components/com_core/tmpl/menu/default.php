<?php

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted access');
//JHtml::_('formbehavior.chosen');
$main_url = 'index.php?option=com_core&view=menu';
?>
<?php echo HTMLHelper::_('form.token'); ?>
<div class="row-fluid" style="background-color: white;display: flex;padding: 15px;">
	<div class="col-md-4" style="background: transparent;box-shadow: none;float: left;border-right: 1px solid #ddd;padding: 0px;">
		<div id="core-menu-tree"></div>
	</div>
	<div class="col-md-8" id="form-content" style="float: right;padding-left: 20px;">
	
	</div>
</div>
</div>
<!-- <input type="hidden" name="task" value=""> -->
<input type="hidden" id="cidhs" name="cidh" value="0">
<!-- <input type="hidden" name="boxchecked" value="0"> -->
              

<script type="text/javascript">
jQuery(document).ready(function($){
	var _initPage = function(){
		
	};
	var _initEditPage = function(id){
        //console.log(id);
		$.get('<?php echo $main_url;?>&task=edit&format=raw',{"id":id},function(response){
            $('#form-content').html(response);
		});
	};
	var _initNewPage = function(parent_id){
     
		$.get('<?php echo $main_url;?>&task=edit&format=raw',{"parent_id":parent_id},function(response){
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
				// the URL to fetch the data
				"url" : "index.php?option=com_core&controller=menu&task=getCoreMenu&format=raw",
				"data" : function(n) {
                    // console.log(n)
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
	}).on("open_node.jstree", function (e, data) {		
		 //data.inst.check_node("#node_11", true);		 
	}).on('changed.jstree', function (e, data) {
        var i, j, r = [];
        for(i = 0, j = data.selected.length; i < j; i++) {
            r.push(data.instance.get_node(data.selected[i]).id);
        }
        var id = r.join(', ');
        _initEditPage(id);
		$('#toolbar-icon-delete').attr('data-id', id).change();
		var mytoken= Joomla.getOptions("csrf.token"); 
		var userToken = document.getElementsByTagName('input')[0].name;
		// console.log(userToken);
		$('#cidh').val(id).change();
        //$('#toolbar-icon-delete').attr('href', 'index.php?option=com_core&controller=menu&task=delete&id='+id +'&'+ mytoken +'=1').change();
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

    // $('#toolbar-icon-delete').click(function(){
    //     var node_id = $('#core-menu-tree').jstree(true).get_selected()[0];  
	// 	if(node_id == '' || node_id == 1){			
	// 	  	alert('Không thể xóa menu Root!');
    //         return false;
	// 	}else{
    //         if (confirm("Bạn có chắc chắn muốn xóa không? Việc xác nhận sẽ xóa vĩnh viễn (các) mục đã chọn!") == true) {
    //             return true
    //         } else {
    //             return false;
    //         }
	// 	}
    //     return true;
		
	// });
    
	 _initPage();		
}); // end document.ready
</script>
<style>
.col-md-12{
    padding-left: 0px;
    padding-right: 0px;
}    
</style>