<?php

/*****************************************************************************
 * @Author                : HueNN                                            *
 * @CreatedDate           : 2024-08-04 17:29:45                              *
 * @LastEditors           : HueNN                                            *
 * @LastEditDate          : 2024-08-04 17:29:45                              *
 * @FilePath              : Joomla_511_svn/components/com_tochuc/src/View/Tochucs/RawView.php*
 * @CopyRight             : Dnict                                            *
 ****************************************************************************/

namespace Joomla\Component\Thongbao\Site\View\Thongbao;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Pagination\Pagination;
use stdClass;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Categories view class for the Category package.
 *
 * @since  1.6
 */
class RawView extends BaseHtmlView
{
    /**
     * The pagination object
     *
     * @var    Pagination
     * @since  3.9.0
     */
    protected $pagination;
    /**
     * Display the view
     *
     * @param   string|null  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @throws  GenericDataException
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        $layout = Factory::getApplication()->input->get('task');
        $layout = ($layout == null) ? 'default' : strtoupper($layout);
        $this->setLayout(strtolower($layout));
        switch ($layout) {
            case 'DETAIL':
                $this->_getDetail();
                break;
            case 'DS_THONGBAO':
                $this->_pageTHONGBAO();
                break;
            case 'DETAIL_THONGBAO':
                $this->_pageDetailTHONGBAO();
                break;
        }
    }



    private function _getDetail()
    {
        $model = Core::model('Tochuc/Tochuc');
        $id = Factory::getApplication()->input->getInt('id');
        $row = $model->read($id);
        $quatrinh = $model->getAllQuaTrinhById($row->id);
        $khenthuongkyluat = $model->getAllKhenthuongkyluatById($row->id);
        // $quatrinh_bienche = $model->getQuatrinhBiencheByDeptId($row->id);


        $this->id =  $id;
        $this->row = $row;
        // $this->sumBienchegiao = $model->sumBienchegiao($id); 	
        // $this->sumBienchehienco = $model->sumBienchehienco($id); 	
        $this->quatrinh = $quatrinh;
        $this->khenthuongkyluat = $khenthuongkyluat;
        // $this->quatrinh_bienche = $quatrinh_bienche; 	
        parent::display();
    }
    private function _pageTHONGBAO()
    {
        $model = Core::model('Thongbao/Thongbao');
        $app = Factory::getApplication()->input;
        $params = [
            'phuongxa_id' => $app->getInt('phuongxa_id', 0),
            'hoten' => $app->getString('hoten', ''),
            'gioitinh_id' => $app->getInt('gioitinh_id', ''),
            'is_tamtru' => $app->getInt('is_tamtru', ''),
            'thonto_id' => $app->getInt('thonto_id', 0),
            'hokhau_so' => $app->getString('hokhau_so', ''),
            'cccd_so' => $app->getString('cccd_so', ''),
            'diachi' => $app->getString('diachi', ''),

            'daxoa' => $app->getInt('daxoa', 0)
        ];
        // Thêm tham số phân trang
        $startFrom = $app->getInt('start', 0); // Lấy từ query string hoặc mặc định là 0
        $perPage = 20; // Có thể lấy từ cấu hình hoặc query string
        $rows = $model->getDanhsachNhanHoKhau($params, $startFrom, $perPage);
        $countitems = $model->countitems($params);
        $this->rows = $rows;
        $this->countitems = $countitems;
        parent::display();
    }
    private function _pageDetailTHONGBAO()
    {
        $app = Factory::getApplication()->input;
        $hokhauId = $app->getInt('hokhau_id', 0);
        $model = Core::model('Thongbao/Thongbao');
    
        $details = $model->getDetailNhanHoKhau($hokhauId);
    
        if (!is_array($details) || empty($details)) {
            echo '<p class="text-danger">Không tìm thấy thông tin.</p>';
            Factory::getApplication()->close();
            return;
        }
    
        // Load Flag Icons CSS (nếu không load trong default.php)
        echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css"/>';
    
        echo '<div class="detail-container d-flex">';
    
        // Danh sách họ tên bên trái
        echo '<div class="name-list" style="width: 30%; border-right: 1px solid #ddd; padding-right: 10px;">';
        echo '<h6>Danh sách thành viên</h6>';
        echo '<ul class="list-unstyled">';
        foreach ($details as $index => $detail) {
            if (!is_array($detail) || !isset($detail['id'], $detail['hoten'])) {
                echo '<li class="text-danger">Lỗi: Bản ghi không hợp lệ tại index ' . $index . '</li>';
                continue;
            }
            $activeClass = $index === 0 ? 'active' : '';
            echo '<li><a href="#" class="name-link ' . $activeClass . '" data-id="' . htmlspecialchars($detail['id']) . '">' . htmlspecialchars($detail['hoten']) . ' (' . htmlspecialchars($detail['tenquanhenhanthan'] ?? 'Không có') . ')</a></li>';
        }
        echo '</ul>';
        echo '</div>';
    
        // Thông tin chi tiết bên phải (bảng 2 cột)
        echo '<div class="detail-content" style="width: 70%; padding-left: 10px;">';
        $firstDetail = $details[0];
        if (is_array($firstDetail) && isset($firstDetail['id'])) {
            $isTamTru = $firstDetail['is_tamtru'] ?? 0;
            $trangthai = $firstDetail['trangthaihoso'] ?? 0;
            $locationStatus = $isTamTru == 0 ? 'Thường trú' : 'Tạm trú';
            $traithaiHS = $trangthai == 0 ? 'Chưa xác thực' : 'Đã xác thực';
            $colorStyle = 'border: 1px solid green; color: green; padding: 2px;';
            // Xác định màu cho trạng thái hồ sơ
            $HosoStyle = $trangthai == 0 ? 'border: 1px solid red; color: red; padding: 2px;' : $colorStyle;
            // Xác định màu cho giới tính
            $genderStyle = $firstDetail['tengioitinh'] === 'Nữ' ? 'border: 1px solid red; color: red; padding: 2px;' : $colorStyle;
            // Xác định màu cho Thường trú/Tạm trú
            $locationStyle = $isTamTru == 0 ? 'border: 1px solid green; color: green; padding: 2px;' : 'border: 1px solid red; color: red; padding: 2px;';
            // Lấy mã ISO từ $firstDetail['icon']
            $countryCode = !empty($firstDetail['icon']) ? strtolower($firstDetail['icon']) : 'vn';
            echo '<div id="detail-' . htmlspecialchars($firstDetail['id']) . '" class="detail-item active">';
            echo '<table class="table table-sm">';
            echo '<tbody>';
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Ngày sinh:</strong> ' . htmlspecialchars($firstDetail['ngaysinh'] ?? '') . '</td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Giới tính:</strong> <span style="' . $genderStyle . '">' . htmlspecialchars($firstDetail['tengioitinh'] ?? '') . '</span></td></tr>';
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Số CCCD:</strong> ' . htmlspecialchars($firstDetail['cccd_so'] ?? '') . '</td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Ngày cấp CCCD:</strong> ' . htmlspecialchars($firstDetail['cccd_ngaycap'] ?? '') . '</td></tr>';
            echo '<tr><td colspan="2" style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Nơi cấp CCCD:</strong> ' . htmlspecialchars($firstDetail['cccd_coquancap'] ?? '') . '</td></tr>';
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Thường trú/Tạm trú:</strong> <span style="' . $locationStyle . '">' . $locationStatus . '</span></td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"></td></tr>';
            // Hiển thị địa chỉ dựa trên $isTamTru
            if ($isTamTru == 0) {
                echo '<tr><td colspan="2" style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Nơi ở hiện tại:</strong> ' . htmlspecialchars($firstDetail['diachi'] ?? '') . '</td></tr>';
            } else {
                echo '<tr><td colspan="2" style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Nơi ở hiện tại:</strong> ' . htmlspecialchars($firstDetail['diachi'] ?? '') . '</td></tr>';
                echo '<tr><td colspan="2" style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Nơi thường trú trước:</strong> ' . htmlspecialchars($firstDetail['diachi_cu'] ?? 'Chưa có') . '</td></tr>';
            }
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Số điện thoại:</strong> ' . htmlspecialchars($firstDetail['dienthoai'] ?? '') . '</td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Dân tộc:</strong> ' . htmlspecialchars($firstDetail['tendantoc'] ?? '') . '</td></tr>';
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Tôn giáo:</strong> ' . htmlspecialchars($firstDetail['tentongiao'] ?? '') . '</td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Trình độ học vấn:</strong> <span style="' . $colorStyle . '">' . htmlspecialchars($firstDetail['tentrinhdohocvan'] ?? '') . '</span></td></tr>';
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Nghề nghiệp:</strong> ' . htmlspecialchars($firstDetail['tennghenghiep'] ?? '') . '</td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Tình trạng hôn nhân:</strong> <span style="' . $colorStyle . '">' . htmlspecialchars($firstDetail['tentinhtranghonnhan'] ?? 'Chưa xác định') . '</span></td></tr>';
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Nhóm máu:</strong> <span style="' . $colorStyle . '">' . htmlspecialchars($firstDetail['tennhommau'] ?? 'Chưa xác định') . '</span></td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Quốc tịch:</strong> ' . htmlspecialchars($firstDetail['tenquoctich'] ?? 'Việt Nam') . ' <span class="fi fi-' . $countryCode . '"></span></td></tr>';
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Số hộ khẩu:</strong> ' . htmlspecialchars($firstDetail['hokhau_so'] ?? '') . '</td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Ngày cấp hộ khẩu:</strong> ' . htmlspecialchars($firstDetail['hokhau_ngaycap'] ?? '') . '</td></tr>';
            echo '<tr><td colspan="2" style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Nơi cấp hộ khẩu:</strong> ' . htmlspecialchars($firstDetail['hokhau_coquancap'] ?? '') . '</td></tr>';
            echo '<tr><td colspan="2" style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Trạng thái:</strong> <span style="' . $HosoStyle . '">' . htmlspecialchars($traithaiHS) . '</span></td></tr>';
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<p class="text-danger">Lỗi: Bản ghi đầu tiên không hợp lệ.</p>';
        }
    
        // Chi tiết các thành viên khác (ẩn)
        for ($i = 1; $i < count($details); $i++) {
            $detail = $details[$i];
            if (!is_array($detail) || !isset($detail['id'])) {
                echo '<p class="text-danger">Lỗi: Bản ghi không hợp lệ tại index ' . $i . '</p>';
                continue;
            }
            $isTamTru = $detail['is_tamtru'] ?? 0;
            $trangthai = $detail['trangthaihoso'] ?? 0;
            $locationStatus = $isTamTru == 0 ? 'Thường trú' : 'Tạm trú';
            $traithaiHS = $trangthai == 0 ? 'Chưa xác thực' : 'Đã xác thực';
            $colorStyle = 'border: 1px solid green; color: green; padding: 2px;';
            // Xác định màu cho trạng thái hồ sơ
            $HosoStyle = $trangthai == 0 ? 'border: 1px solid red; color: red; padding: 2px;' : $colorStyle;
            // Xác định màu cho giới tính
            $genderStyle = $detail['tengioitinh'] === 'Nữ' ? 'border: 1px solid red; color: red; padding: 2px;' : $colorStyle;
            // Xác định màu cho Thường trú/Tạm trú
            $locationStyle = $isTamTru == 0 ? 'border: 1px solid green; color: green; padding: 2px;' : 'border: 1px solid red; color: red; padding: 2px;';
            // Lấy mã ISO từ $detail['icon']
            $countryCode = !empty($detail['icon']) ? strtolower($detail['icon']) : 'vn';
            echo '<div id="detail-' . htmlspecialchars($detail['id']) . '" class="detail-item" style="display: none;">';
            echo '<table class="table table-sm">';
            echo '<tbody>';
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Ngày sinh:</strong> ' . htmlspecialchars($detail['ngaysinh'] ?? '') . '</td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Giới tính:</strong> <span style="' . $genderStyle . '">' . htmlspecialchars($detail['tengioitinh'] ?? '') . '</span></td></tr>';
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Số CCCD:</strong> ' . htmlspecialchars($detail['cccd_so'] ?? '') . '</td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Ngày cấp CCCD:</strong> ' . htmlspecialchars($detail['cccd_ngaycap'] ?? '') . '</td></tr>';
            echo '<tr><td colspan="2" style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Nơi cấp CCCD:</strong> ' . htmlspecialchars($detail['cccd_coquancap'] ?? '') . '</td></tr>';
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Thường trú/Tạm trú:</strong> <span style="' . $locationStyle . '">' . $locationStatus . '</span></td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"></td></tr>';
            // Hiển thị địa chỉ dựa trên $isTamTru
            if ($isTamTru == 0) {
                echo '<tr><td colspan="2" style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Nơi ở hiện tại:</strong> ' . htmlspecialchars($detail['diachi'] ?? '') . '</td></tr>';
            } else {
                echo '<tr><td colspan="2" style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Nơi ở hiện tại:</strong> ' . htmlspecialchars($detail['diachi'] ?? '') . '</td></tr>';
                echo '<tr><td colspan="2" style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Nơi thường trú trước:</strong> ' . htmlspecialchars($detail['diachi_cu'] ?? 'Chưa có') . '</td></tr>';
            }
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Số điện thoại:</strong> ' . htmlspecialchars($detail['dienthoai'] ?? '') . '</td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Dân tộc:</strong> ' . htmlspecialchars($detail['tendantoc'] ?? '') . '</td></tr>';
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Tôn giáo:</strong> ' . htmlspecialchars($detail['tentongiao'] ?? '') . '</td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Trình độ học vấn:</strong> <span style="' . $colorStyle . '">' . htmlspecialchars($detail['tentrinhdohocvan'] ?? '') . '</span></td></tr>';
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Nghề nghiệp:</strong> ' . htmlspecialchars($detail['tennghenghiep'] ?? '') . '</td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Tình trạng hôn nhân:</strong> <span style="' . $colorStyle . '">' . htmlspecialchars($detail['tentinhtranghonnhan'] ?? 'Chưa xác định') . '</span></td></tr>';
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Nhóm máu:</strong> <span style="' . $colorStyle . '">' . htmlspecialchars($detail['tennhommau'] ?? 'Chưa xác định') . '</span></td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Quốc tịch:</strong> ' . htmlspecialchars($detail['tenquoctich'] ?? 'Việt Nam') . ' <span class="fi fi-' . $countryCode . '"></span></td></tr>';
            echo '<tr><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Số hộ khẩu:</strong> ' . htmlspecialchars($detail['hokhau_so'] ?? '') . '</td><td style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Ngày cấp hộ khẩu:</strong> ' . htmlspecialchars($detail['hokhau_ngaycap'] ?? '') . '</td></tr>';
            echo '<tr><td colspan="2" style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Nơi cấp hộ khẩu:</strong> ' . htmlspecialchars($detail['hokhau_coquancap'] ?? '') . '</td></tr>';
            echo '<tr><td colspan="2" style="padding: 0.5rem;border-top: 0px solid #dee2e6"><strong>Trạng thái:</strong> <span style="' . $HosoStyle . '">' . htmlspecialchars($traithaiHS) . '</span></td></tr>';
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        }
        echo '</div>';
    
        echo '</div>';
        Factory::getApplication()->close();
    }
}
