<?php
require_once(JPATH_THEMES . '/adminlte/CoreTemplate.php');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

$user = Factory::getUser();
$coreTemplate = new CoreTemplate();
if ($coreTemplate->isLogin() == true) {
	require_once(JPATH_THEMES . '/adminlte/login.php');
} else {
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
			var loadNoticeBoardSuccess = function(title, text) {
				jQuery.gritter.add({
					title: title,
					text: text,
					class_name: 'gritter-success gritter-center gritter-light'
				});
			};
			var loadNoticeBoardError = function(title, text) {
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
		<div class="page-content container-fluid">
			<jdoc:include type="modules" name="position-1" style="xhtml" />
			<jdoc:include type="message" />
			<jdoc:include type="component" />
		</div>
		<!-- Footer -->
		<jdoc:include type="modules" name="debug" style="none" />
	</body>
	</html>
<?php
}
?>