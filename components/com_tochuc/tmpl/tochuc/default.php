<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;

defined('_JEXEC') or die('Restricted access');
$user = Factory::getUser();
$session = Factory::getSession();
$active_tong = $session->get('active_tong');
?>
<style>
#main-content-tree{
	height: 280px;
	overflow: auto;
}
</style>

	<div class="content-header">
		<div class="container-fluid">
			
				<div class="row mb-2">
					<div class="col-sm-6">
						<h4><span class="span6" id="tochuc_current">Quản lý tổ chức <small><i class="icon-double-angle-right"></i> </small></span></h4>
					</div>
					<div class="col-sm-6" style="padding-right: 6.5px; padding-left: 6.5px;">
						<span class="pull-right inline">
						<?php if(Core::_checkPerActionArr($user->id, 'com_tochuc', 'tochuc', array('task'=>'au_tochuc_hienthitrangthai', 'location'=>'site','non_action'=>'false'))){ ?>
							<select class="form-control select2" name="active_tong" id="active_tong">
								<option value="1" <?php echo ($active_tong==1 || (int)$active_tong==0)?'selected':'';?>>Chỉ hiển thị Đang hoạt động</option>
								<option value="-1" <?php echo $active_tong==-1?'selected':'';?>>Tất cả trạng thái</option>
							</select>
						<?php }?>			
						</span>
					</div>
				</div>

			
		</div>
	</div>

	<div class="content" style="padding-bottom:1px;">
		<div class="container-fluid">
			
			<div class="card card-default" id="com_tochuc_viewdetail"></div>
			<div class="card card-default" id="com_tochuc_nghiepvu"></div>
			
		</div>
	</div>

<!-- <div class="row-fluid" id="com_tochuc_viewdetail"></div>
<div class="row-fluid" id="com_tochuc_nghiepvu"></div> -->
<script type="text/javascript">
jQuery(document).ready(function($){
	createTreeviewInMenuBar('Cây đơn vị');
	var dept_id = null;
	var _initViewDetailPage = function(id){
		var htmlLoading = '<i class="icon-spinner icon-spin blue bigger-125"></i>';
		jQuery.ajax({
			  type: "GET",
			  url: 'index.php?option=com_tochuc&view=tochuc&task=detail&format=raw&Itemid=<?php echo $this->Itemid;?>',
			  data:{"id":id},
			  beforeSend: function(){
				  //$.blockUI();
				  $('#com_tochuc_viewdetail').empty();				  
				},
			  success: function (data,textStatus,jqXHR){
				  //$.unblockUI();
				  $('#com_tochuc_viewdetail').html(data);
				  $('#com_tochuc_viewdetail').show();
				  $('#com_tochuc_nghiepvu').hide();
			  }
		});	
	};
	$('#active_tong').on('change', function(){
		window.location.href = '/index.php?option=com_tochuc&controller=tochuc&task=default&active='+$('#active_tong option:selected').val();
	})
	var com_jstree = $('#main-content-tree').jstree({
	  		"core":{		  		
		  		"data":<?php echo TochucHelper::getOneNodeJsTree((int) Core::getManageUnit($user->id, 'com_tochuc', 'tochuc', 'default'));?>,				  			
				"data" : {
					'url': 'index.php?option=com_core&controller=ajax&format=raw&task=getTree&act=tochuc',
                    'data': function(node) {					
					 	return {
                            "id" :  node['li_attr'] ? node['li_attr']['id'].replace("node_", "") : node.id,
                            'active': $('#active_tong option:selected').val()
                        };  
                    }
                }
			},	
            'types': {
                'root': {
                    'icon': 'fa fa-folder text-warning',
                    'valid_children': ['folder']
                },
                'folder': {
                    'icon': 'fa fa-folder text-primary',
                    'valid_children': ['file']
                },
                'file': {
                    'icon': 'fa fa-file',
                    'valid_children': []
                },
				
            },
			"themes": {
                    "responsive": true
            },
	        "plugins": ["themes", "json_data", "ui","types","cookies", "state"] 
	}).bind("open_node.jstree", function (e, data) {	
		if (data.node.type === 'root') {
        	data.instance.set_icon(data.node, 'fa fa-folder-open text-warning');
    	}
	}).bind("close_node.jstree", function (e, data) {
		if (data.node.type === 'root') {
        	data.instance.set_icon(data.node, 'fa fa-folder text-warning');
    	}
	}).bind("loaded.jstree", function (event, data) {
		var rootNode = data.instance.get_node(data.instance.get_json()[0].id);
        if (rootNode) {
            data.instance.select_node(rootNode);
        }
    }).bind("select_node.jstree", function (event, data) {
		 var id = data.node.id;
		 _initViewDetailPage(id);
		 dept_id = id;		
		 var selectedNodes = data.selected;
		data.instance.toggle_node(data.node);
		$('#tochuc_current').html('<small>Quản lý tổ chức  <i class="fa fa-angle-double-right"></i> '+$.trim(data.node.text)+'</small>');		
  });
  $('.sidebar-menu').on('click', function(){
	if (window.matchMedia("(min-width: 992px)").matches) {
		$('#main-content-tree').addClass('jstreeovl');
    }
  })
  $('.sidebar').on('mouseleave', function(){
	if (window.matchMedia("(min-width: 992px)").matches) {	
		$('#main-content-tree').removeClass('jstreeovl');
		$('#main-content-tree').addClass('jstreeovlaf');
    }
  })
  $('.sidebar').on('mouseenter', function(){
	if (window.matchMedia("(min-width: 992px)").matches) {	
		$('#main-content-tree').addClass('jstreeovl');
		$('#main-content-tree').removeClass('jstreeovlaf');
    }
  })

 
});
</script>
<style>
.jstree-hovered {
	/* background: #5e5e5e25 !important; */
	background: none !important;
	box-shadow:unset !important;
	/* color:dimgrey !important */
}	
.jstree-default .jstree-clicked{
	/* background: #5e5e5e25 !important; */
	background: none !important;
	box-shadow:unset !important
}
.jstree-default .jstree-clicked{
	color:white !important;
}
.jstree-hovered{
	/* background: #5e5e5e25 !important; */
	
	color:white !important;
}

.sidebar-menu.tree{
	list-style: none !important;
}


.skin-blue .sidebar a{
	white-space: normal !important;
}
.jstree-default .jstree-anchor{
	line-height: unset;
    height:unset;
}

.navbar-nav>.user-menu>.dropdown-menu{
	width: 220px !important;
}
.dropdown-menu{
	left: -50px;
}
.sidebar-menu.tree{
	padding-left: 0 !important;
}
.treeview-menu{
	list-style: none !important;
	padding-left: 0 !important;
}
#main-content-tree{
	
	scrollbar-width: thin !important;
} 
#main-content-tree>ul>li a{
	white-space: normal !important;
	scrollbar-width: thin !important;
} 
.sidebar{
	/* overflow: hidden !important; */
}
.sidebar:hover{
	/* overflow: hidden !important; */
}
/* .menu-text{
	background-color: #007bff;
    color: #fff;
} */

.nav-link.menu-open .menu-open{

    background-color: rgba(255,255,255,.1) !important;
    color: #fff;
}
/* .sidebar-collapse #main-content-tree:hover{
	display: block !important;
} */
*,
*::before,
*::after {
  box-sizing: border-box; 
}
@media (min-width: 992px) {
	.sidebar-collapse #main-content-tree{
		display: none ;
		float: left;
		transition: 2s ease;
	}
	.sidebar-collapse .jstreeovlaf{display: none !important;} 
	.sidebar-collapse .jstreeovl{display: block !important;} 
}
</style>