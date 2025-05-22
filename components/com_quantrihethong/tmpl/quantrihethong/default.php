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
    background-color: #007bff;
  }
  .nav-tabs{
    border-color: #bbbbbb;
  }
</style>