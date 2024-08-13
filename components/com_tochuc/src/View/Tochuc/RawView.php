<?php 
/*****************************************************************************
 * @Author                : HueNN                                            *
 * @CreatedDate           : 2024-08-04 17:29:45                              *
 * @LastEditors           : HueNN                                            *
 * @LastEditDate          : 2024-08-04 17:29:45                              *
 * @FilePath              : Joomla_511_svn/components/com_tochuc/src/View/Tochucs/RawView.php*
 * @CopyRight             : Dnict                                            *
 ****************************************************************************/

 namespace Joomla\Component\Tochuc\Site\View\Tochuc;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Pagination\Pagination;
use Joomla\Component\Tochuc\Site\Helper\TochucHelper;
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
    	$layout = ($layout == null)?'default':strtoupper($layout);  
        $this->setLayout(strtolower($layout));    
        switch($layout){
        case 'DETAIL':
            $this->_getDetail();
            break;
        case 'QUATRINH':
            $this->_pageQuaTrinh();
            break; 
        case 'GIAOBIENCHE':
            $this->_pageGiaobienche();
            break;   
        case 'KHENTHUONGKYLUAT':
            $this->_pageKhenthuongkyluat();
            break;
        case 'GIAOUOCTHIDUA':
            $this->_pageGiaouocthidua();
            break;
        case 'PHANHANGDONVI':
            $this->_pagePhanhangdonvi();
            break;
        case 'QUYDINHCAPPHO':
            $this->_pageQuydinhcappho();
            break;   
        case 'EDIT_TOCHUC':
            $this->_pageEditTochuc();
            break;
        case 'EDIT_PHONG':
            $this->_pageEditPhong();
            break;  
        case 'EDIT_VOCHUA':
            $this->_pageEditVochua();
            break;     	
        case 'THANHLAP':
            $this->_pageQuaTrinh();
            break;
        case 'FRMQUYETDINH':
            $this->_formquyetdinh();
            break;
        case 'ADDQUYETDINH':
            $this->_addquyetdinh();
            break;
        case 'default':
     		$this->_pageList();
         	break;
        }
    }

    private function _pageList(){   
        $id      = Factory::getApplication()->input->getInt('id'); 
        $rows = null;
        if($id > 0){
            $model = Core::model('Tochuc/Tochuc');
            $rows = $model->read($id);
        }
        // $caybaocao	=	$model->getCayBaocao($rows->id);
    	// $this->caybaocao = $caybaocao;
    }

    private function _getDetail(){
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

    private function _pageQuaTrinh(){
    	$model = Core::model('Tochuc/Tochuc');
        $app = Factory::getApplication()->input;
        $id = $app->getInt('id',0);     
    	$rows = $model->getAllQuaTrinhById($id);
    	$item = $model->read($id);
        $this->id = $id; 	
        $this->rows = $rows; 	
        $this->item = $item; 	
        parent::display();
    }

    private function _pageGiaobienche(){
    	$model = Core::model('Tochuc/Tochuc');
        $app = Factory::getApplication()->input;
    	$id = $app->getInt('id',0);

    	$item = $model->read($id);    	
    	$quatrinh_bienche = $model->getQuatrinhBiencheByDeptId($item->id);
    	
        $this->id = $id;        
    	$this->quatrinh_bienche = $quatrinh_bienche ;
    	$this->item = $item;
        parent::display();
    }

    private function _pageKhenthuongkyluat(){
    	$model = Core::model('Tochuc/Tochuc');
        $app = Factory::getApplication()->input;
    	$id = $app->getInt('id',0);
    	$item = $model->read($id);    	// select * from ins_dept where id=$id
    	$quatrinh_khenthuong = $model->getAllKhenthuongById($item->id);
    	$quatrinh_kyluat = $model->getAllKyluatById($item->id);
    	$this->id = $id;    	
    	$this->quatrinh_khenthuong = $quatrinh_khenthuong;
    	$this->quatrinh_kyluat = $quatrinh_kyluat;
    	$this->item = $item;
        parent::display();
    }

    public function _Pagegiaouocthidua(){
        $app = Factory::getApplication()->input;
    	$donvi_id = $app->getInt('id',0);
        $datas = Core::loadAssocList('ins_dept_giaouocthidua', '*', 'donvi_id = '.(int)$donvi_id,'nam DESC');
        $this->datas = $datas;
        $this->donvi_id = $donvi_id;
        parent::display();
    }

    function _pagePhanhangdonvi(){
		$jinput = Factory::getApplication()->input;
		$donvi_id = $jinput->get('id', 0, 'int');
		$data = Core::loadAssocList('ins_dept_phanhangdonvi','*','donvi_id='.$donvi_id, 'ngaybatdau desc');
		$this->data = $data;
		$this->donvi_id = $donvi_id;
		parent::display();
	}
    function _pageQuydinhcappho(){ 
        $jinput = Factory::getApplication()->input;
		$donvi_id = $jinput->get('id', 0, 'int');
		$data = Core::loadAssocList('ins_dept_quydinhcappho','*','donvi_id='.$donvi_id, 'nam desc');
		$this->data = $data;
		$this->donvi_id = $donvi_id;
		parent::display();
    }
    private function _pageEditTochuc(){
    	$inArray = TochucHelper::collect('ins_cap', array('id','parent_id','name',"IF((rgt-lft) = 1,'item','folder') AS type"),array('status = 1'));
    	$tree_data_ins_cap = array();
    	TochucHelper::makeDataForTree($inArray, $tree_data_ins_cap,TochucHelper::getRootCapTochuc());
    	unset($inArray);    	
    	$model = Core::model('Tochuc/Tochuc');
    	
    	$dept_id = Factory::getApplication()->input->getInt('id',0);
    	// $row = null;
        $row = new stdClass();
    	$arr_ins_created =  TochucHelper::collect('ins_dept', array('id AS value','name AS text'),array('type IN (1,3)'),'lft ASC');
    	$arr_ins_created = array_merge(array(array('value'=>'','text'=>'')),$arr_ins_created);
    	if((int)$dept_id > 0){
    		$row = $model->read($dept_id);
    	}    	
        if ($row && (int)$row->id == 0) {
    		$vanban_created = array();
    		$trangthai = array();
    		$file_created = array();
    		$file_trangthai = array();    	
    		$row->active = 1;
            $row->type = Factory::getApplication()->input->getInt("type", null); // Assign null if no type is provided
    		$linhvuc = array();
    		$title	=	'Bổ sung đơn vị vừa tạo vào cấu hình báo cáo';
    	}else{
    		$vanban_created = $model->getVanbanById($row->vanban_created);
    		$trangthai = $model->getVanbanById($row->vanban_active);
    		$file_created = $model->getFilebyIdVanban($row->vanban_created);
    		$file_trangthai = $model->getFilebyIdVanban($row->vanban_active);
    		$linhvuc = $model->getLinhvucByIdDept($row->id);
            $row->type = Factory::getApplication()->input->getInt("type", null); // Assign null if no type is provided
    		$title	=	'Cập nhật thông tin đơn vị vào cấu hình báo cáo';
    	}
    	$ins_dept_vanban = $model->danhsachIns_dept_vanban($row->id);
    	for($i=0; $i<count($ins_dept_vanban); $i++){
            $ins_dept_vanban[$i]->taptin = $model->taptindinhkem($ins_dept_vanban[$i]->ins_vanban_id);    		
    	}
    	$caybaocao	=	$model->getCayBaocao($row->id);

        $this->title = $title;
        $this->caybaocao = $caybaocao;
        $this->tree_data_ins_cap = json_encode($tree_data_ins_cap);
        $this->row = $row;
        $this->ins_dept_vanban = $ins_dept_vanban;
        $this->vanban_created = $vanban_created;
        $this->trangthai = $trangthai;
        $this->linhvuc = $linhvuc;
        $this->file_created = $file_created;
        $this->file_trangthai = $file_trangthai;
        $this->arr_ins_created = $arr_ins_created;
        $this->loaidonvihanhchinh = Core::loadAssocList('ins_loaidonvihanhchinh', '*', 'trangthai=1', 'sapxep asc');
        $this->phancaptochuc = Core::loadAssocList('ins_phancap', '*', 'trangthai=1 and daxoa=0', 'sapxep asc');
        $this->hangtochuc = Core::loadAssocList('ins_hang', '*', 'trangthai=1 and daxoa=0', 'sapxep asc');
        $this->loaihachtoan = Core::loadAssocList('ins_loaihachtoan', '*', 'trangthai=1 and daxoa=0', 'sapxep asc');
        $this->mucdotuchu = Core::loadAssocList('ins_mucdotuchu', '*', 'trangthai=1 and daxoa=0', 'sapxep asc');

        parent::display();
    }

    private function _pageEditPhong(){
    	$deptRoot = TochucHelper::getRoot();
    	$inArray = TochucHelper::collect('ins_dept', array('id','parent_id','name',"IF((type = 1),'item','folder') AS type"),array('type IN (1,2,3)'),'lft ASC');
    	$tree_data_ins_dept = array();

    	TochucHelper::makeDataForTree($inArray, $tree_data_ins_dept);
    	unset($inArray);
        $this->Itemid = Factory::getApplication()->input->get('Itemid');
    	$this->tree_data_ins_dept = json_encode($tree_data_ins_dept);

    	$model = Core::model('Tochuc/Tochuc');		
    	$dept_id = Factory::getApplication()->input->getInt('id',0);
    	$row = new stdClass;
    	$arr_ins_created =  TochucHelper::collect('ins_dept', array('id AS value','name AS text'),array('type IN (1,3)'),'lft ASC');
    	$arr_ins_created = array_merge(array(array('value'=>'','text'=>'')),$arr_ins_created);
    	if((int)$dept_id > 0){
    		$row = $model->read($dept_id);
    	}

    	if ($row->id == null) {
    		$vanban_created = array();
    		$trangthai = array();
    		$file_created = array();
    		$file_trangthai = array();    		
    		$row->active = 1;
    		$row->type = Factory::getApplication()->input->getInt("type",0);
    		$linhvuc = array();
    		$title	=	'Bổ sung đơn vị vừa tạo vào cấu hình báo cáo';
    	}else{
    		$vanban_created = $model->getVanbanById($row->vanban_created);
    		$trangthai = $model->getVanbanById($row->vanban_active);
    		$file_created = $model->getFilebyIdVanban($row->vanban_created);
    		$file_trangthai = $model->getFilebyIdVanban($row->vanban_active);
    		$linhvuc = $model->getLinhvucByIdDept($row->id);
    		$row->type = Factory::getApplication()->input->getInt("type",0);
    		$title	=	'Cập nhật thông tin đơn vị vào cấu hình báo cáo';
    	}
    	
    	$caybaocao	=	$model->getCayBaocao($row->id);
        $this->caybaocao = $caybaocao;
        $this->title = $title;
        $this->row = $row;

        $this->vanban_created = $vanban_created;
        $this->trangthai = $trangthai;
        $this->file_created = $file_created;
        $this->file_trangthai = $file_trangthai;
        $this->linhvuc = $linhvuc;
        $this->arr_ins_created = $arr_ins_created;

     	unset($tree_data_ins_linhvuc);    	
    	unset($tree_data_ins_dept);
    	unset($row);
    	unset($vanban_created);
    	unset($file_created);
    	unset($trangthai);
    	unset($file_trangthai);
        parent::display();
    }

    private function _pageEditVochua()
    {
        // Get the root department using the TochucHelper class
        $deptRoot = TochucHelper::getRoot();

        // Get the application and input objects
        $app = Factory::getApplication();
        $input = $app->input;

        // Assign Itemid to class property
        $this->Itemid = $input->getInt('Itemid');

        // Obtain the model using the new Core API
        $model = Core::model('Tochuc/Tochuc');

        // Get the department ID from the request
        $dept_id = $input->getInt('id', 0);

        $row = null;
        if ($dept_id > 0) {
            // Read the row data from the model
            $row = $model->read($dept_id);
            $row->type = $input->getInt('type', 0);
            $title = 'Cập nhật thông tin đơn vị vào cấu hình báo cáo';
        } else {
            // Initialize a new row if no ID is provided
            $row = new \stdClass(); // Create a new stdClass object if necessary
            $row->active = 1;
            $row->type = $input->getInt('type', 0);
            $title = 'Bổ sung đơn vị vừa tạo vào cấu hình báo cáo';
        }

        // Get the tree structure for the report
        $caybaocao = $model->getCayBaocao($dept_id);
        $this->caybaocao =  $caybaocao;
        $this->title = $title;

        // Initialize arrays for additional data
        $vanban_created = array();
        $trangthai = array();
        $file_created = array();
        $file_trangthai = array();

        // Assign additional data to the view
        $this->row = $row;
        $this->vanban_created = $vanban_created;
        $this->trangthai = $trangthai;
        $this->file_created = $file_created;
        $this->file_trangthai = $file_trangthai;

        // Call the parent display method
        parent::display();
    }

    public function _formquyetdinh(){
        $id = Factory::getApplication()->input->getInt('id',0);
        $this->donvi_id = $id;
        parent::display();
    }

    public function _addQuyetDinh() {
        // Retrieve and sanitize GET parameters
        $app = Factory::getApplication()->input;
        $mahieu = htmlspecialchars($app->get('qdlienquan_mahieu'), ENT_QUOTES, 'UTF-8');
        
        $ngaybanhanh = $app->getVar('qdlienquan_ngaybanhanh');
        $coquan_banhanh = htmlspecialchars($app->get('qdlienquan_coquan'), ENT_QUOTES, 'UTF-8');
        $idFileQDlienquan = $app->get('qdlienquan_file');
        
        // Initialize model
        $model = Core::model('Tochuc/Tochuc');
        // Save document into database
        $vanban_id = $model->saveVanban([
            'tieude' => "Quyết định liên quan",
            'mahieu' => $mahieu,
            'ngaybanhanh' => $ngaybanhanh,
            'coquan_banhanh' => $coquan_banhanh
        ]);
    
        if (!$vanban_id) {
            // Handle the error when saving the document fails
            Core::PrintJson(['error' => 'Failed to save document']);
            die;
        }
    
        // Update attachments
        $mapperAttachment = Core::model('Core/Attachment');
        $fileNames = [];
        
        $mapperAttachment->updateTypeIdByCode($idFileQDlienquan, 1, true, $vanban_id);
        $attachment = $model->taptindinhkem1($idFileQDlienquan);
        
        if ($attachment && isset($attachment[0]->filename)) {
            $fileNames[] = $attachment[0]->filename;
        }

        // Prepare response data
        $response = [
            'mahieu' => $mahieu,
            'ngaybanhanh' => $ngaybanhanh,
            'coquan_banhanh' => $coquan_banhanh,
            'vanban_id' => $vanban_id,
            'tenfile' => $fileNames,
            'code' => $idFileQDlienquan
        ];
    
        // Return JSON response
        Core::PrintJson($response);
        die;
    }
    


   
    

}
