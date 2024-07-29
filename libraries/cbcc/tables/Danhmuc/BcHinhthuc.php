<?php
class Danhmuc_Table_BcHinhthuc extends JTable
{
	var $id					=	null;
	var $name					=	null;
	var $s_name					=	null;
	var $status					=	null;
	var $loaihinh_id			=	null;
	var $is_thietlapthoihan		=	null;
	var $is_hinhthuctuyendung	=	null;
	var $text_ngaybatdau		=	null;
	var $text_ngayketthuc		=	null;
	var $text_soquyetdinh		=	null;
	var $text_coquanraquyetdinh	=	null;
	var $text_ngaybanhanh		=	null;
    
    
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(& $db)
    {
// Tạo ánh xạ vào DB
        parent::__construct('bc_hinhthuc', 'id', $db);
    }
    function bind($array, $ignore = '')
    {
        if (key_exists( 'params', $array ) && is_array( $array['params'] ))
        {
                $registry = new JRegistry();
                $registry->loadArray($array['params']);
                $array['params'] = $registry->toString();
        }                
        return parent::bind($array, $ignore);
    }


}
