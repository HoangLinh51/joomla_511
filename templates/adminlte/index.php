<?php

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Session\Session;

require_once(JPATH_THEMES . '/adminlte/CoreTemplate.php');
$coreTemplate = new CoreTemplate();

if ($coreTemplate->isLogin() == true) {
	require_once(JPATH_THEMES . '/adminlte/login.php');
} else {
	$user = Factory::getUser();
	if ($user->id == null) {
		if ($return == false) {
			$url = Route::_('index.php?option=com_users&view=login');
			$message = 'Bạn cần đăng nhập vào hệ thống.';
			Factory::getApplication()->enqueueMessage($message);
			Factory::getApplication()->redirect($url);
			return false;
		}
	}
	$app = Factory::getApplication();
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
	$doc->addScript(Uri::base(true) . '/media/cbcc/js/jquery/jquery.toast.js');
	$doc->addScript(Uri::root(true) . '/media/cbcc/js/common.js');
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>CỞ SỞ DỮ LIỆU PHƯỜNG XÃ DÙNG CHUNG</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome Icons -->
		<script>
			var app = {};
			var loadNoticeBoardSuccess = function(title, text) {
				// jQuery.gritter.add({
				// 	title: title,
				// 	text: text,
				// 	time: '2000',
				// 	class_name: 'gritter-success gritter-center gritter-light'
				// });
				toastr.success(text, title)
				toastr.options = {
					"closeButton": true,
					"debug": false,
					"newestOnTop": true,
					"progressBar": true,
					"positionClass": "toast-top-right",
					"preventDuplicates": false,
					"onclick": null,
					"showDuration": "300",
					"hideDuration": "1000",
					"timeOut": "5000",
					"extendedTimeOut": "1000",
					"showEasing": "swing",
					"hideEasing": "linear",
					"showMethod": "fadeIn",
					"hideMethod": "fadeOut"
				}
			};
			var loadNoticeBoardError = function(title, text) {
				toastr.error(text, title)
				toastr.options = {
					"closeButton": true,
					"debug": false,
					"newestOnTop": true,
					"progressBar": true,
					"positionClass": "toast-top-right",
					"preventDuplicates": false,
					"onclick": null,
					"showDuration": "300",
					"hideDuration": "1000",
					"timeOut": "5000",
					"extendedTimeOut": "1000",
					"showEasing": "swing",
					"hideEasing": "linear",
					"showMethod": "fadeIn",
					"hideMethod": "fadeOut"
				}
				// jQuery.gritter.add({
				// 	title: title,
				// 	text: text,
				// 	time: '2000',
				// 	class_name: 'gritter-error gritter-light'
				// });
			};
		</script>
		<jdoc:include type="head" />
	</head>

	<body class="sidebar-mini layout-fixed">
		<?php foreach (Factory::getApplication()->getMessageQueue() as $message) : ?>
			<?php var_dump($message) ?> 
			<?php if ($message['type'] == 'error') : ?>
				<div class="alert alert-<?php echo $message['type']; ?>">
					<?php echo $message['message']; ?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
		<div class="wrapper">
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
					</li>
				</ul>
				<ul class="d-flex align-items-center navbar-nav ml-auto">
					<jdoc:include type="modules" name="sidebar-right" />
				</ul>
			</nav>
			<aside class="main-sidebar sidebar-dark-primary elevation-4">
				<a href="index.php" class="d-flex align-items-center gap-3 logo-brand">
					<img src="/images/banners/logo-DN.png" alt="DNICT Logo" class="brand-image img-circle">
					<span class="brand-text font-weight-light ">CSDL Xã/Phường</span>
				</a>
				<div class="line"></div>

				<!-- Sidebar Content -->
				<div class="sidebar">
					<!-- Search -->
					<!-- <div class="input-group" data-widget="sidebar-search">
						<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
						<div class="input-group-append">
							<button class="btn btn-sidebar"><i class="fas fa-search fa-fw"></i></button>
						</div>
					</div> -->

					<!-- Results -->
					<div class="sidebar-search-results">
						<div class="list-group">
							<a href="#" class="list-group-item">
								<div class="search-title text-light"></div>
								<div class="search-path text-muted"></div>
							</a>
						</div>
					</div>

					<!-- Sidebar Navigation -->
					<nav class="mt-2">
						<div class="sidebar-menu tree" id="main-tree"></div>
						<jdoc:include type="modules" name="sidebar-nav" style="xhtml" />
					</nav>
				</div>
			</aside>
			<div class="content-wrapper">
				<jdoc:include type="message" />
				<jdoc:include type="component" style="xhtml" />
			</div>

			<!-- Footer -->
			<!-- <footer class="main-footer">
		<div class="pull-right hidden-xs">
			<b>Version</b> 2.4.13
		</div>
		<strong>Copyright © 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rightsreserved.
	</footer> -->

			<jdoc:include type="modules" name="debug" style="none" />

		</div>
	</body>

	</html>
	<style>
		body:not(.layout-fixed) .main-sidebar {
			height: inherit !important;
			min-height: 100% !important;
			position: absolute !important;
			top: 0 !important;
		}

		.nav-link.menu-open {
			background-color: rgba(255, 255, 255, .1) !important;
			color: #fff !important;
			box-shadow: 0 1px 3px rgba(0, 0, 0, .12), 0 1px 2px rgba(0, 0, 0, .24) !important;
		}

		#toast-container .toast-success {
			background-color: #3c763d;
			box-shadow: none;
			opacity: 100;
		}

		#toast-container .toast-error {
			background-color: #a94442;
			box-shadow: none;
			opacity: 100;
		}

		#toast-container>div:hover {
			box-shadow: none;
			opacity: 100;
		}

		.close-jq-toast-single {
			position: absolute;
			top: 3px;
			right: 7px;
			font-size: 14px;
			cursor: pointer;
		}

		.blockUI>h2 {
			margin-top: 1.5rem !important;
			margin-bottom: 1.5rem !important;
		}

		#system-message-container .alert-success {
			border-radius: 0px !important;
		}

		.logo-brand {
			height: 56px;
			padding: .5rem 1rem;
			color: #fff;
			font-weight: 500;
			border-bottom: 1px solid #4b545c;
		}

		a.logo-brand:hover {
			color: #fff
		}

		.logo-brand .brand-image {
			height: 90%;
		}

		.logo-brand span {
			font-size: 20px;
			color: #ffffffcc
		}

		.sidebar-hidden .main-sidebar {
			display: none !important;
		}

		.sidebar-hidden .content-wrapper {
			margin-left: 0 !important;
		}

		body.sidebar-mini.sidebar-collapse .main-sidebar:hover {
			width: 4.6rem !important;
		}

		body.sidebar-mini.sidebar-collapse .main-sidebar {
			transition: none !important;
		}

		body.sidebar-collapse .logo-brand {
			padding: .5rem 1rem;
		}

		/* Ẩn chữ tên brand khi sidebar thu gọn */
		body.sidebar-collapse .brand-text {
			display: none !important;
		}

		body.sidebar-collapse .nav-sidebar .nav-link p.menu-text {
			display: none !important;
		}

		.nav-treeview .nav-item .nav-link {
			padding: 8px 25px;
		}
	</style>

<?php
}
?>