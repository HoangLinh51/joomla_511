<?php

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Session\Session;

require_once (JPATH_THEMES.'/adminlte/CoreTemplate.php');
$coreTemplate = new CoreTemplate();

if ($coreTemplate->isLogin() == true) {
	require_once (JPATH_THEMES.'/adminlte/login.php');
}else{
	$user = Factory::getUser();
	if ($user->id == null) {
		if($return==false){
			$url = Route::_('index.php?option=com_users&view=login');
			$message = 'Bạn cần đăng nhập vào hệ thống.';
			Factory::getApplication()->enqueueMessage($message);
			Factory::getApplication()->redirect($url);
			return false;
		}
	}
	$app = Factory::getApplication();
	$doc = Factory::getDocument();

	
	// $doc->addStyleSheet(Uri::root(true).'/templates/'.$this->template. '/dist/css/adminlte.min.css');
	$doc->addStyleSheet(Uri::root(true).'/templates/'.$this->template. '/dist/css/adminltev3.css');
	$doc->addStyleSheet(Uri::root(true).'/templates/'.$this->template. '/dist/css/_all-skins.min.css');
	$doc->addStyleSheet(Uri::root(true).'/templates/'.$this->template. '/plugins/fontawesome-free/css/all.min.css');
	$doc->addStyleSheet(Uri::root(true).'/templates/'.$this->template. '/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css');
	
	$doc->addStyleSheet(Uri::root(true).'/templates/'.$this->template. '/plugins/icheck-bootstrap/icheck-bootstrap.min.css');
	$doc->addStyleSheet(Uri::root(true).'/templates/'.$this->template. '/plugins/jqvmap/jqvmap.min.css');
	$doc->addStyleSheet(Uri::root(true).'/templates/'.$this->template. '/plugins/select2/css/select2.min.css');
	$doc->addStyleSheet(Uri::root(true).'/templates/'.$this->template. '/plugins/toastr/toastr.min.css');

	$doc->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery.min.js');
	$doc->addScript(Uri::root(true).'/media/cbcc/js/jquery/jquery-ui.js');
	$doc->addScript(Uri::root(true). '/templates/' .$this->template. '/plugins/jquery-validation/jquery.validate.min.js');
	$doc->addScript(Uri::root(true). '/templates/' .$this->template. '/plugins/bootstrap/js/bootstrap.bundle.min.js');
	$doc->addScript(Uri::root(true). '/templates/' .$this->template. '/plugins/jquery-mousewheel/jquery.mousewheel.js');
	$doc->addScript(Uri::root(true). '/templates/' .$this->template. '/dist/js/adminlte.js');
	$doc->addScript(Uri::root(true). '/templates/' .$this->template. '/plugins/raphael/raphael.min.js');
	$doc->addScript(Uri::root(true). '/templates/' .$this->template. '/plugins/jquery-mapael/jquery.mapael.min.js');
	$doc->addScript(Uri::root(true). '/templates/' .$this->template. '/plugins/jquery-mapael/maps/usa_states.min.js');
	$doc->addScript(Uri::root(true). '/templates/' .$this->template. '/plugins/chart.js/Chart.min.js');
	$doc->addScript(Uri::root(true). '/templates/' .$this->template. '/plugins/select2/js/select2.min.js');
	$doc->addScript(Uri::root(true). '/templates/' .$this->template. '/plugins/toastr/toastr.min.js');

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="overview &amp; stats" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AdminLTE 3 | Dashboard</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
<script>
var app = {};
var loadNoticeBoardSuccess = function(title,text){
	jQuery.gritter.add({
		title: title,
		text: text,
		time: '2000',
		class_name: 'gritter-success gritter-center gritter-light'
	});
};
var loadNoticeBoardError = function(title,text){
	jQuery.gritter.add({
		title: title,
		text: text,
		time: '2000',
		class_name: 'gritter-error gritter-light'
	});
};
</script>
<jdoc:include type="head" />
</head>
<body class="sidebar-mini layout-fixed">
<div class="wrapper">
	<div class="preloader flex-column justify-content-center align-items-center" style="height: 0px;">
		<img class="animation__shake" src="templates/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60" style="display: none;">
	</div>
	<nav class="main-header navbar navbar-expand navbar-white navbar-light">

		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="index3.html" class="nav-link">Home</a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="#" class="nav-link">Contact</a>
			</li>
		</ul>

		<ul class="navbar-nav ml-auto">
			<jdoc:include type="modules" name="sidebar-right" />
			<!-- <li class="nav-item">
				<a class="nav-link" data-widget="navbar-search" href="#" role="button">
					<i class="fas fa-search"></i>
				</a>
				<div class="navbar-search-block">
					<form class="form-inline">
						<div class="input-group input-group-sm">
							<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
							<div class="input-group-append">
								<button class="btn btn-navbar" type="submit">
									<i class="fas fa-search"></i>
								</button>
								<button class="btn btn-navbar" type="button" data-widget="navbar-search">
									<i class="fas fa-times"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</li> -->
		</ul>
	</nav>
	<aside class="main-sidebar sidebar-dark-primary elevation-4">

		<a href="index.php" class="brand-link">
			<img src="templates/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
			<span class="brand-text font-weight-light">AdminLTE 3</span>
		</a>

		<div class="sidebar">

			<div class="user-panel mt-3 pb-3 mb-3 d-flex">
				<div class="image">
					<img src="templates/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
				</div>
				<div class="info">
					<a href="#" class="d-block">Alexander Pierce</a>
				</div>
			</div>

			<div class="form-inline">
				
				<div class="input-group" data-widget="sidebar-search">
					<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
					<div class="input-group-append">
						<button class="btn btn-sidebar">
							<i class="fas fa-search fa-fw"></i>
						</button>
					</div>
				</div>
				<div class="sidebar-search-results">
				
					<div class="list-group">
						<a href="#" class="list-group-item">
							<div class="search-title"><strong class="text-light">							
								</strong>N<strong class="text-light"></strong>o<strong class="text-light"></strong> <strong class="text-light"></strong>e<strong class="text-light">
								</strong>l<strong class="text-light"></strong>e<strong class="text-light"></strong>m<strong class="text-light"></strong>e<strong class="text-light">								
								</strong>n<strong class="text-light"></strong>t<strong class="text-light"></strong> <strong class="text-light"></strong>f<strong class="text-light">								
								</strong>o<strong class="text-light"></strong>u<strong class="text-light"></strong>n<strong class="text-light"></strong>d<strong class="text-light">
								</strong>!<strong class="text-light"></strong></div><div class="search-path">
							</div>
						</a>
					</div>
					
				</div>
			</div>

			<nav class="mt-2">
				<div class="sidebar-menu tree" id="main-tree"></div>
				<jdoc:include type="modules" name="sidebar-nav" style="xhtml" />
			</nav>

		</div>
	</aside>

	<div class="content-wrapper">	
		<!-- <table width="100%"> -->
			<!-- <tr>
				<td style="vertical-align:top; padding:0;">
					<a class="menu-toggler" id="menu-toggler" href="#">
						<span class="menu-text"></span>
					</a> -->
					<!-- <div class="main-content"> -->
						<!-- <section class="">
							<ol class="breadcrumb" style="">
								<jdoc:include type="modules" name="breadcrumbs" style="xhtml" />
								
							</ol>
						</section> -->
						<!-- <section class="content"> -->
							<jdoc:include type="message" />
							<jdoc:include type="component" style="xhtml"/>
						<!-- </section> -->

					<!-- </div>	 -->
					<!--/.main-content-->		
				<!-- </td>
			</tr>
		</table> -->
	</div>

	<!-- Footer -->
	<footer class="main-footer">
		<div class="pull-right hidden-xs">
			<b>Version</b> 2.4.13
		</div>
		<strong>Copyright © 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rightsreserved.
	</footer>

	<jdoc:include type="modules" name="debug" style="none" />

</div>
</body>
</html>
<style >
body:not(.layout-fixed) .main-sidebar {
    height: inherit !important;
    min-height: 100% !important;
    position: absolute !important;
    top: 0 !important;
}
.nav-link.menu-open{
	background-color: rgba(255,255,255,.1) !important;
    color: #fff !important;
	box-shadow: 0 1px 3px rgba(0, 0, 0, .12), 0 1px 2px rgba(0, 0, 0, .24) !important;
}
</style>

<?php
}
?>