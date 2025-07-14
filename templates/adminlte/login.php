<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$app = Factory::getApplication();
$doc = Factory::getDocument();
$wa  = $this->getWebAssetManager();

// Add Stylesheet
$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/dist/css/adminltev3.css');
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
		<div class="login">
			<div class="w-100 d-flex justify-content-start" style="display: flex; ">
				<button id="button-back" class="p-0 m-0 border-0 bg-white" style="display:none; color: #00000080">
					<i class="fas fa-arrow-left"></i> Quay lại
				</button>
			</div>
			<img src="images/banners/logo-DN.png" alt="Đà Nẵng" />
			<h4 class="mt-4 mb-4 text-primary">CƠ SỞ DỮ LIỆU DÙNG CHUNG CẤP XÃ/PHƯỜNG</h4>

			<div class="confirm w-100">
				<!-- Khối chứa 2 nút -->
				<div id="button-group" class="button-group">
					<button class="btn-system" id="button-system">
						Đăng nhập tài khoản hệ thống
					</button>
					<button class="btn-egov" href="https://dangnhap.danang.gov.vn/cas/login?service=http://10.49.45.84">
						Đăng nhập bằng eGov
					</button>
				</div>

				<div id="login-system" class="login-box">
					<div class="right-panel text-center">
						<jdoc:include type="component" />
					</div>
				</div>
			</div>

			<div class="banner">
				<button id="openSupportModal" class="openSupportModal" >
					Hỗ trợ kỹ thuật
				</button>
			</div>
		</div>
	</div>

	<div id="supportModal" class="modal">
		<div class="modal-content">
			<span class="close">&times;</span>
			<h3>Thông tin hỗ trợ kỹ thuật</h3>

			<div class="support-person">
				<img src="images\avatas\avatar_ThanhPC.png" alt="Châu Thành">
				<div>
					<p><strong>Họ tên:</strong> Phan Châu Thành</p>
					<p><strong>Điện thoại:</strong> 0905868493</p>
					<p><strong>Email:</strong> thanhpc1@danang.gov.vn</p>
				</div>
			</div>

			<div class="support-person">
				<img src="images\avatas\avatar_NienNVD.png" alt="Dư Niên">
				<div>
					<p><strong>Họ tên:</strong> Võ Nguyễn Dư Niên</p>
					<p><strong>Điện thoại:</strong> 0949431757</p>
					<p><strong>Email:</strong> nienvnd@danang.gov.vn</p>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const btnSystem = document.getElementById("button-system");
		const btnBack = document.getElementById("button-back");
		const btnGroup = document.getElementById("button-group");
		const loginForm = document.getElementById("form-login");
		const alertBox = document.getElementById("alert");
		const supportBox = document.getElementById("openSupportModal");

		// Hiển thị form đăng nhập
		if (btnSystem) {
			btnSystem.addEventListener("click", function() {
				btnGroup.style.display = "none";
				loginForm.style.display = "block";
				btnBack.style.display = "block";
				supportBox.style.display = "none";
			});
		}

		// Quay lại
		if (btnBack) {
			btnBack.addEventListener("click", function() {
				btnBack.style.display = "none";
				btnGroup.style.display = "flex";
				loginForm.style.display = "none";
				supportBox.style.display = "block";
			});
		}

		// Tự ẩn alert sau 5s
		if (alertBox) {
			setTimeout(() => {
				alertBox.style.transition = "opacity 0.5s ease";
				alertBox.style.opacity = "0";
				setTimeout(() => {
					alertBox.remove();
				}, 500); // đợi transition
			}, 2000);
		}
	});

	document.addEventListener('DOMContentLoaded', function() {
		const modal = document.getElementById('supportModal');
		const btn = document.getElementById('openSupportModal');
		const closeBtn = document.querySelector('.modal .close');

		btn.addEventListener('click', () => {
			modal.style.display = 'block';
		});

		closeBtn.addEventListener('click', () => {
			modal.style.display = 'none';
		});

		// Đóng modal khi click ra ngoài
		window.addEventListener('click', (event) => {
			if (event.target === modal) {
				modal.style.display = 'none';
			}
		});
	});
</script>

<style>
	.box {
		display: flex;
		height: 100vh;
		background-image: url('/images/banners/bg-login.jpg');
		background-repeat: no-repeat;
		background-position: center center;
		background-size: cover;
	}

	.login {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: space-evenly;
		text-align: center;
		background-color: #fff;
		max-width: 400px;
		border-radius: 10px;
		padding: 20px;
		margin: auto;
	}

	.login img {
		width: 100px;
	}

	.login h4 {
		font-size: 20px;
		font-weight: 600;
	}

	.button-group {
		display: flex;
		flex-direction: column;
	}

	.btn-system,
	.btn-egov {
		background: #fff;
		font-weight: 600;
		padding: 12px 20px;
		cursor: pointer;
		font-size: 15px;
		transition: 0.3s ease;
		border: 2px solid;
		border-radius: 5px;
		margin-top: 10px;
	}

	.btn-system {
		background-color: #0c9984;
		border-color: #fff;
		color: #fff
	}

	.btn-system:hover {
		border-color: #0c9984;
		color: #0c9984;
		background: #ffffff00;
	}

	.btn-egov {
		text-align: center;
		background: #2a7dc5;
		color: #fff;
	}

	.btn-egov:hover {
		text-decoration: none;
		color: #2a7dc5;
		border-color: #2a7dc5;
		background: #ffffff00;
	}

	.banner {
		border-radius: 0 0 10px 10px;
		display: flex;
		justify-content: center;
		width: 100%;
	}

	.openSupportModal {
		font-size: 14px;
		padding: 8px 12px;
		border: none;
		color: #0c9984;
		background-color: #fff;
	}

	.openSupportModal:hover {
		text-decoration: underline;
		color: #0c9984;
	}

	.modal {
		display: none;
		position: fixed;
		z-index: 9999;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.4);
		margin: 0px;
	}

	.modal-content {
		background-color: #fff;
		margin: 10% auto;
		padding: 20px;
		border-radius: 10px;
		max-width: 450px;
		position: relative;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
	}

	.close {
		color: #000;
		position: absolute;
		top: 10px;
		right: 15px;
		font-size: 24px;
		font-weight: bold;
		cursor: pointer;
	}

	.close:hover {
		color: #000;
	}

	.support-person {
		display: flex;
		align-items: center;
		gap: 10px;
		margin-top: 20px;
		padding: 20px 0px;
		border-top: 1px solid #ddd;
	}

	.support-person img {
		width: 100px;
		height: 100px;
		object-fit: cover;
		object-position: 50% 25%;
		border-radius: 50%;
		margin-right: 15px;
	}
</style>

</html>