<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$app = Factory::getApplication();
$doc = Factory::getDocument();
$wa  = $this->getWebAssetManager();

// Add Stylesheet
$doc->addStyleSheet(Uri::root(true). '/templates/' .$this->template. '/dist/css/adminlte.min.css');
$doc->addStyleSheet(Uri::root(true). '/templates/' .$this->template. '/plugins/fontawesome-free/css/all.min.css');
$doc->addStyleSheet(Uri::root(true). '/templates/' .$this->template. '/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css');
$doc->addStyleSheet(Uri::root(true). '/templates/' .$this->template. '/plugins/icheck-bootstrap/icheck-bootstrap.min.css');
$doc->addStyleSheet(Uri::root(true). '/templates/' .$this->template. '/plugins/jqvmap/jqvmap.min.css');
$doc->addStyleSheet(Uri::root(true). '/templates/' .$this->template. '/dist/css/_all-skins.min.css');


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
<style>
html, body {height: 100%;}
.inputlogin {
	height: calc(1.5em + 0.75rem + 2px) !important;
	width: 350px !important;
	font-size: 20px !important;
}
</style>
<table style="width:100%;height:100%;">
<tr>
	<td style="width:60%;height: 100%; vertical-align:middle; text-align:center;">
		<img src="<?php echo Uri::root(true); ?>/images/banners/login_pic2.jpg">
	</td>
	<td style="vertical-align: middle;width:40%;">
		<div class="login-box">								
			<div class="row-fluid">					
				<div class="row-fluid">
					<div class="widget-box transparent">
						<div class="widget-header">
							<h1 style="color:#027be3;"><i class="icon-leaf"></i> CCHC HÀ TĨNH</h1>
						</div>
						<div class="widget-body">
							<div class="widget-main">
							<jdoc:include type="message" />
							<jdoc:include type="component" />
							</div><!--/widget-main-->
						</div><!--/widget-body-->
					</div><!--/login-box-->								
				</div>					
			</div><!--/.row-fluid-->
		</div><!--/.main-container-->
	</td>
</tr>
</table>
</body>
</html>
