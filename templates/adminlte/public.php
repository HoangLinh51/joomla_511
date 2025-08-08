<?php
require_once (JPATH_THEMES.'/adminlte/CoreTemplate.php');
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

$user = Factory::getUser();
$coreTemplate = new CoreTemplate();
if ($coreTemplate->isLogin() == true) {
	require_once (JPATH_THEMES.'/adminlte/login.php');
}else{
	$params = Factory::getApplication()->getTemplate(true)->params;
	$app = Factory::getApplication();
	$doc = Factory::getDocument();
if ($user->id == null) {
	// $app->redirect('index.php?option=com_users&view=login');
	// return false;
}	
	// Load CSS và JS
	$doc = Factory::getDocument();
	$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/dist/css/adminltev3.css');
	$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/dist/css/_all-skins.min.css');
	$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/plugins/fontawesome-free/css/all.min.css');
	$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css');
	$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/plugins/icheck-bootstrap/icheck-bootstrap.min.css');
	$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/plugins/jqvmap/jqvmap.min.css');
	$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/plugins/select2/css/select2.min.css');
	$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/plugins/toastr/toastr.min.css');
	$doc->addStyleSheet(Uri::root(true) . '/media/cbcc/css/jquery.toast.css');

	$doc->addScript(Uri::root(true) . '/templates/' . $this->template . '/plugins/jquery/jquery.min.js');
	$doc->addScript(Uri::root(true) . '/media/legacy/js/jquery-noconflict.js');
	$doc->addScript(Uri::root(true) . '/templates/adminlte/plugins/jquery-ui/jquery-ui.min.js');
	$doc->addScript(Uri::root(true) . '/templates/' . $this->template . '/plugins/jquery-ui/jquery.blockUI.min.js');
	$doc->addScript(Uri::root(true) . '/templates/' . $this->template . '/plugins/jquery-mousewheel/jquery.mousewheel.js');
	$doc->addScript(Uri::root(true) . '/templates/' . $this->template . '/dist/js/adminlte.js');
	$doc->addScript(Uri::root(true) . '/templates/' . $this->template . '/plugins/raphael/raphael.min.js');
	$doc->addScript(Uri::root(true) . '/templates/' . $this->template . '/plugins/jquery-mapael/jquery.mapael.min.js');
	$doc->addScript(Uri::root(true) . '/templates/' . $this->template . '/plugins/jquery-mapael/maps/usa_states.min.js');
	$doc->addScript(Uri::root(true) . '/templates/' . $this->template . '/plugins/chart.js/Chart.min.js');
	$doc->addScript(Uri::root(true) . '/templates/' . $this->template . '/plugins/select2/js/select2.min.js');
	$doc->addScript(Uri::root(true) . '/templates/' . $this->template . '/plugins/toastr/toastr.min.js');
	$doc->addScript(Uri::root(true) . '/media/cbcc/js/jquery/jquery.toast.js');
	$doc->addScript(Uri::root(true) . '/media/cbcc/js/common.js');
// $doc->addScript(URI::root(true).'/media/cbcc/js/common.js',null,array("text/javascript",false, false,-90));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="overview &amp; stats" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>
var app = {};
var loadNoticeBoardSuccess = function(title,text){
	jQuery.gritter.add({
		title: title,
		text: text,
		class_name: 'gritter-success gritter-center gritter-light'
	});
};
var loadNoticeBoardError = function(title,text){
	jQuery.gritter.add({
		title: title,
		text: text,
		class_name: 'gritter-error gritter-light'
	});
};
</script>
<jdoc:include type="head" />
</head>
<body>
<table width="100%">
<tr>
	<td background="<?php echo URI::root(true); ?>/images/banners/banner.png" style="background-position: right;background-repeat: no-repeat;">
		<!-- <div class="navbar" style="width:100%;background: none;">
			<div class="navbar-inner" style="background: none;">
				<div class="container-fluid" style="padding-right: 0px;">
					<a href="index.php" class="brand"> <small> <i class="icon-home"></i>
				     		<?php echo $app->getCfg('sitename');?>
				        <?php if ($this->params->get('sitedescription')) { echo htmlspecialchars($this->params->get('sitedescription')) ; } ?>
				    </small>
					</a>
				</div>
			</div>
		</div> -->
	</td>
</tr>
<tr>
	<td style="vertical-align: top;padding: 0;">
		<div class="main-content" style="margin-left:0px">
			<table width="100%">
			<tr>
				<td class="span12" style="vertical-align: top;padding: 0;position: relative;" width="100%" id="main-page-content">
					<div class="page-content container-fluid">
						<jdoc:include type="modules" name="position-1" style="xhtml" />
						<jdoc:include type="message" />
						<jdoc:include type="component" />
					</div>
				</td>
			</tr>
			</table>
		</div>	
		<!--/.main-content-->		
	</td>
</tr>
</table>
<!-- Footer -->
<footer class="footer">
	<div class="container-fluid">
		<div class="row-fluid">				
			<div class="span3">
			<a href="http://dnict.vn" title="Thiết kế dnict.vn" target="_blank"><img src="<?php echo Uri::root(true);?>/images/dnict_small.png"/></a>					
			</div>
			<div class="span6 text-center">
				<jdoc:include type="modules" name="copyright" style="..." />					
			</div>				
			<div class="span3"></div>
		</div>
	</div>
	<div class="foot-fixed-bottom"></div>
	<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i></a>
</footer>
<jdoc:include type="modules" name="debug" style="none" />
</body>
</html>
<?php
} 
?>