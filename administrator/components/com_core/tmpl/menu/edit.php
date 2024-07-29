<?php 
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Core\Administrator\Helper\CoreHelper;
/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate');
?>
<form class="form-horizontal" action="<?php echo Route::_('index.php?option=com_core&controller=menu&task=saveedit') ?>" aria-label="<?php echo Text::_('COM_CATEGORIES_FORM_TITLE_' . ((int) $this->rows->id === 0 ? 'NEW' : 'EDIT'), true); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset>
	<legend><b> Thông tin chi tiết [<?php echo (($this->rows->id == null)?'Thêm mới':'Hiệu chỉnh');?>]</b></legend>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label" for="menu_id">ID</label>
				<div class="controls">
					<input type="text" id="menu" name="jform[id]" class="form-control" value="<?php echo $this->rows->id; ?>" readonly>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label" for="menu_type">Loại menu</label>
				<div class="controls">
					<?php
					$arrMenuType = array();
					$arrMenuType[] = array('value'=>1,'text'=>'Menu chính');
					echo HTMLHelper::_('select.genericlist',$arrMenuType,'jform[menu_type]','class="form-select required"','value','text',$this->rows->menu_type);
					?>
				</div>
			</div>
		</div>		
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label" for="parent_id">Menu cha</label>
				<div class="controls">
					<!-- <span><?php //echo $this->rows->name; ?></span> -->
					<input type="text" name="jform[name]" class="form-control" value="<?php echo CoreHelper::getName($this->rows->parent_id);?>" readonly>
					<input class="form-control" type="hidden" id="parent_id" name="jform[parent_id]" value="<?php echo $this->rows->parent_id; ?>">
				</div>
			</div>
		</div>
		<div class="row-fluid">
		<div class="control-group">
			<label class="control-label" for="name">Tên</label>
			<div class="controls">
				<input class="form-control" type="text" id="name" placeholder="Nhập tên" name="jform[name]" value="<?php echo $this->rows->name; ?>">
			</div>
		</div>
		</div>
		<div class="row-fluid">	
			<div class="control-group">	
				<div class="control-label"><label id="jform_required-lbl" for="jform_required">
					Thuộc hệ thống</label>
				</div>
				<div class="controls">
					<fieldset id="jform_required">
						<legend class="visually-hidden">Required    </legend>
						<div class="switcher">
							<input type="hidden" value="0"	name="jform[is_system]"> 
							<input type="checkbox" data-target="#is_system_detail" id="is_system" name="jform[is_system]" <?php echo $this->rows->is_system == 1? "checked":"" ?> role="button" data-toggle="collapse" value="1"  class="active ">        
							<span class="toggle-outside"><span class="toggle-inside"></span></span>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
		<div class="row-fluid" id="div_link">
			<div class="control-group">
				<label class="control-label" for="link">Liên kết</label>
				<div class="controls">
					<input class="form-control" type="text" id="link" placeholder="Nhập liên kết" name="jform[link]" value="<?php echo $this->rows->link ?>">
				</div>
			</div>
		</div>
		<div id="is_system_detail" class="collapse">
			<div class="row-fluid">		
				<div class="control-group">
					<label class="control-label" for="component">Component</label>
					<div class="controls">				
						<input class="form-control" type="text" id="component" value="<?php echo $this->rows->component ?>" name="jform[component]">							
					</div>
				</div>
			</div>
			<div class="row-fluid">		
				<div class="control-group">
					<label class="control-label" for="controller">Controller</label>
					<div class="controls">				
						<input class="form-control" type="text" id="controller" value="<?php echo $this->rows->controller ?>" name="jform[controller]">							
					</div>
				</div>
			</div>
		<div class="row-fluid">		
		<div class="control-group">
		<label class="control-label" for="task">Task</label>
			<div class="controls">				
				<input class="form-control" type="text" id="task" value="<?php echo $this->rows->task ?>" name="jform[task]">							
			</div>
		</div>
		</div>
		<div class="row-fluid">		
		<div class="control-group">
		<label class="control-label" for="params">Tham số</label>
			<div class="controls">				
				<input class="form-control" type="text" id="params" value="<?php echo $this->rows->params ?>" name="jform[params]">							
			</div>
		</div>
		</div>		
		</div>
		<div class="row-fluid">
		<div class="control-group">
			<label class="control-label" for="icon">icon</label>
			<div class="controls">
				<input class="form-control" type="text" id="icon" placeholder="Nhập class icon" name="jform[icon]" value="<?php echo $this->rows->icon ?>">
			</div>
		</div>
		</div>
		<div class="row-fluid">	
		<div class="control-group">
			<div class="control-label"><label id="jform_required-lbl" for="jform_required">
				Published</label>
			</div>
			<div class="controls">
				<fieldset id="jform_required">
					<legend class="visually-hidden">Published    </legend>
					<div class="switcher">
						<input type="radio" id="jform_required0" name="jform[published]" value="0" checked="" class="active ">        
						<label for="jform_required0">No</label>                    
						<input type="radio" id="jform_required1" <?php echo $this->rows->published == 1? "checked":"" ?>  name="jform[published]" value="1">        
						<label for="jform_required1">Yes</label>        
						<span class="toggle-outside"><span class="toggle-inside"></span></span>
					</div>
				</fieldset>
			</div>
		</div>	
		<!-- <div class="control-group">
			<div class="controls">
				<label class="checkbox"> <input type="hidden" value="0"	name="jform[published]"> 
				<input type="checkbox" value="1" name="jform[published]" >
					Published
				</label>				
			</div>
		</div> -->
		</div>		
	</fieldset>

<?php echo HTMLHelper::_( 'form.token' ); ?> 
</form>
<script type="text/javascript">
jQuery(document).ready(function ($){
	$('.btn_luu').on('click',function(e){
		if (document.adminForm.submit()) {    
           return true;
        } 
        return false;
	})
	$('#is_system').click(function(){
		if(this.checked == true){
			$('#is_system_detail').addClass('show');
			$('#div_link').hide();
		}else{
			$('#is_system_detail').removeClass('show');
			$('#div_link').show();
		}
	});
	<?php
 		if($this->rows->is_system == 1) {
 			?>
 			$('#is_system_detail').addClass('show');
 			$('#div_link').hide();
 			<?php 
 		}else{
 			?>
			
 			$('#div_link').show();
 			<?php 
 		}
 	?> 	 	
});
</script>