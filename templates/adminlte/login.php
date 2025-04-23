<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$app = Factory::getApplication();
$doc = Factory::getDocument();
$wa  = $this->getWebAssetManager();

// Add Stylesheet
$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/dist/css/adminlte.min.css');
$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/plugins/fontawesome-free/css/all.min.css');
$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css');
$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/plugins/icheck-bootstrap/icheck-bootstrap.min.css');
$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/plugins/jqvmap/jqvmap.min.css');
$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/dist/css/_all-skins.min.css');

// var_dump($this->template);exit;
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
	</script>
	<jdoc:include type="head" />
</head>

<body>
	<div class="box">
		<div class="login-box">
			<div class="left-panel">
				<h2>CƠ SỞ DỮ LIỆU DÙNG CHUNG CẤP XÃ/PHƯỜNG</h2>
				<img src="images\banners\login_pic2.jpg" alt="Minh họa tiếp nhận công dân">
				<div class="footer"></div>
			</div>
			<div class="line"></div>
			<div class="right-panel">
				<img class="logo-DN" src="images\banners\logo-DN.png" alt="">
				<h3>ĐĂNG NHẬP</h3>
				<jdoc:include type="message" />
				<jdoc:include type="component" />
			</div>
		</div>
	</div>
</body>

<style>
	.box {
		display: flex;
		justify-content: center;
		padding: 40px 0;
		height: 100vh;
		background: #f3f3f3;
		background-image: url('/images/banners/bg-login.jpg');
		background-repeat: no-repeat;
		background-position: center center;
		background-size: cover;
	}

	.login-box {
		background: white;
		border-radius: 12px;
		display: flex;
		align-items: center;
		width: 100%;
		height: 90%;
		max-width: 800px;
		max-height: 700px;
		margin: auto;
		overflow: hidden;
		box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
	}

	.left-panel,
	.right-panel {
		padding: 30px;
	}

	.left-panel,
	.right-panel {
		flex: 1;
		height: 100%;
		max-width: 400px;
		display: flex;
		flex-direction: column;
		align-items: center;
		text-align: center;
		justify-content: space-evenly;
	}

	.left-panel h2,
	.right-panel h3 {
		color: #269bff;
		font-weight: bold;
	}

	.left-panel img {
		width: 100%;
		margin: 20px 0;
	}


	.right-panel h3 {
		margin: 10px 0px;
	}

	.logo-DN {
		width: 100px;
		margin-top: 25px;
	}

	.line {
		width: 2px;
		height: 90%;
		background-color: #D7D7D7;
		vertical-align: middle;
	}
</style>

</html>