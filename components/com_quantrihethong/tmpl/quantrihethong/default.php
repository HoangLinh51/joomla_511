<?php

use Joomla\CMS\Factory;

?>
<div class="main-body" style="padding: 20px;">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="true">
        <i class="fa fa-users"></i> Tài khoản
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="area-tab" data-bs-toggle="tab" data-bs-target="#area" type="button" role="tab" aria-controls="area" aria-selected="false">
        <i class="fa fa-globe-asia"></i> Khu vực
      </button>
    </li>
  </ul>

  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
      <?php include __DIR__ . '/ds_taikhoan.php'; ?>
    </div>
    <div class="tab-pane fade" id="area" role="tabpanel" aria-labelledby="area-tab">
      <?php include __DIR__ . '/ds_khuvuc.php'; ?>
    </div>
  </div>
</div>
<style>
  .main-body {
    padding: 20px;
  }

  .main-body .nav-link {
    width: 140px;
    height: 55px;
    font-size: 17px;
    font-weight: 500;
  }

  .main-body .nav-tabs .nav-link.active {
    color: #fff;
    background-color: #007b8b;
  }

  .nav-tabs {
    border-color: #bbbbbb;
  }

  .btn_hieuchinh,
  .btn_xoa {
    position: relative;
    transition: color 0.3s;
  }

  .btn_hieuchinh,
  .btn_xoa {
    cursor: pointer;
    pointer-events: auto;
    color: #999;
    padding: 10px;
  }

  .btn_hieuchinh:hover i,
  .btn_xoa:hover i {
    color: #007b8bb8;
  }

  .btn_hieuchinh::after,
  .btn_xoa::after {
    content: attr(data-title);
    position: absolute;
    bottom: 72%;
    left: 50%;
    transform: translateX(-50%);
    background-color: rgba(79, 89, 102, .08);
    color: #000000;
    padding: 6px 10px;
    font-size: 14px;
    white-space: nowrap;
    border-radius: 6px;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    border: 1px solid #ccc;
  }


  .btn_hieuchinh:hover::after,
  .btn_xoa:hover::after {
    opacity: 1;
    visibility: visible;
  }
</style>