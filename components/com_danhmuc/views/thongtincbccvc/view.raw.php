<?php
defined('_JEXEC') or die('Restricted Access');
class DanhmucViewThongtincbccvc extends JViewLegacy
{
	function display($tpl = null)
	{
		$task = JRequest::getVar('task');
		switch ($task) {
			case 'goiluong_default':
				$this->setLayout('goiluong_default');
				break;
			case 'goiluong_danhsach':
				$this->setLayout('goiluong_danhsach');
				$this->goiluong_danhsach();
				break;
			case 'goiluong_frm':
				$this->setLayout('goiluong_frm');
				$this->goiluong_frm();
				break;
			case 'khenthuongkyluat_default':
				$this->setLayout('khenthuongkyluat_default');
				break;
			case 'khenthuongkyluat_danhsach':
				$this->setLayout('khenthuongkyluat_danhsach');
				$this->khenthuongkyluat_danhsach();
				break;
			case 'khenthuongkyluat_frm':
				$this->setLayout('khenthuongkyluat_frm');
				$this->khenthuongkyluat_frm();
				break;
			case 'ketquathidua_default':
				$this->setLayout('ketquathidua_default');
				break;
			case 'ketquathidua_danhsach':
				$this->setLayout('ketquathidua_danhsach');
				$this->ketquathidua_danhsach();
				break;
			case 'ketquathidua_frm':
				$this->setLayout('ketquathidua_frm');
				$this->ketquathidua_frm();
				break;
			case 'hinhthucthidua_default':
				$this->setLayout('hinhthucthidua_default');
				break;
			case 'hinhthucthidua_danhsach':
				$this->setLayout('hinhthucthidua_danhsach');
				$this->hinhthucthidua_danhsach();
				break;
			case 'hinhthucthidua_frm':
				$this->setLayout('hinhthucthidua_frm');
				$this->hinhthucthidua_frm();
				break;
			case 'chucdanhcongtac_default':
				$this->setLayout('chucdanhcongtac_default');
				break;
			case 'chucdanhcongtac_danhsach':
				$this->setLayout('chucdanhcongtac_danhsach');
				$this->chucdanhcongtac_danhsach();
				break;
			case 'chucdanhcongtac_frm':
				$this->setLayout('chucdanhcongtac_frm');
				$this->chucdanhcongtac_frm();
				break;
			case 'hinhthucchucdanhcongtac_default':
				$this->setLayout('hinhthucchucdanhcongtac_default');
				break;
			case 'hinhthucchucdanhcongtac_danhsach':
				$this->setLayout('hinhthucchucdanhcongtac_danhsach');
				$this->hinhthucchucdanhcongtac_danhsach();
				break;
			case 'hinhthucchucdanhcongtac_frm':
				$this->setLayout('hinhthucchucdanhcongtac_frm');
				$this->hinhthucchucdanhcongtac_frm();
				break;
			case 'detainckh_default':
				$this->setLayout('detainckh_default');
				break;
			case 'detainckh_danhsach':
				$this->setLayout('detainckh_danhsach');
				$this->detainckh_danhsach();
				break;
			case 'detainckh_frm':
				$this->setLayout('detainckh_frm');
				$this->detainckh_frm();
				break;
			case 'linhvucnckh_default':
				$this->setLayout('linhvucnckh_default');
				break;
			case 'linhvucnckh_danhsach':
				$this->setLayout('linhvucnckh_danhsach');
				$this->linhvucnckh_danhsach();
				break;
			case 'linhvucnckh_frm':
				$this->setLayout('linhvucnckh_frm');
				$this->linhvucnckh_frm();
				break;
			case 'ds_ability':
				$this->setLayout('ds_ability');
				break;
			case 'table_ability':
				$this->timkiemability();
				$this->setLayout('table_ability');
				break;
			case 'themmoiability':
				$this->setLayout('themmoiability');
				break;
			case 'chinhsuaability':
				$this->findability();
				$this->setLayout('themmoiability');
				break;
			case 'ds_awa':
				$this->setLayout('ds_awa');
				break;
			case 'table_awa':
				$this->timkiemawa();
				$this->setLayout('table_awa');
				break;
			case 'themmoiawa':
				$this->setLayout('themmoiawa');
				break;
			case 'chinhsuaawa':
				$this->findawa();
				$this->setLayout('themmoiawa');
				break;
			case 'ds_blood':
				$this->setLayout('ds_blood');
				break;
			case 'table_blood':
				$this->timkiemblood();
				$this->setLayout('table_blood');
				break;
			case 'themmoiblood':
				$this->setLayout('themmoiblood');
				break;
			case 'chinhsuablood':
				$this->findblood();
				$this->setLayout('themmoiblood');
				break;
			case 'ds_cost':
				$this->setLayout('ds_cost');
				break;
			case 'table_cost':
				$this->timkiemcost();
				$this->setLayout('table_cost');
				break;
			case 'themmoicost':
				$this->setLayout('themmoicost');
				break;
			case 'chinhsuacost':
				$this->findcost();
				$this->setLayout('themmoicost');
				break;
			case 'ds_country':
				$this->setLayout('ds_country');
				break;
			case 'table_country':
				$this->timkiemcountry();
				$this->setLayout('table_country');
				break;
			case 'themmoicountry':
				$this->setLayout('themmoicountry');
				break;
			case 'chinhsuacountry':
				$this->findcountry();
				$this->setLayout('themmoicountry');
				break;
			case 'ds_cyu':
				$this->setLayout('ds_cyu');
				break;
			case 'table_cyu':
				$this->timkiemcyu();
				$this->setLayout('table_cyu');
				break;
			case 'themmoicyu':
				$this->setLayout('themmoicyu');
				break;
			case 'chinhsuacyu':
				$this->findcyu();
				$this->setLayout('themmoicyu');
				break;
			case 'ds_defect':
				$this->setLayout('ds_defect');
				break;
			case 'table_defect':
				$this->timkiemdefect();
				$this->setLayout('table_defect');
				break;
			case 'themmoidefect':
				$this->setLayout('themmoidefect');
				break;
			case 'chinhsuadefect':
				$this->finddefect();
				$this->setLayout('themmoidefect');
				break;
			case 'ds_hea':
				$this->setLayout('ds_hea');
				break;
			case 'table_hea':
				$this->timkiemhea();
				$this->setLayout('table_hea');
				break;
			case 'themmoihea':
				$this->setLayout('themmoihea');
				break;
			case 'chinhsuahea':
				$this->findhea();
				$this->setLayout('themmoihea');
				break;
			case 'ds_maried':
				$this->setLayout('ds_maried');
				break;
			case 'table_maried':
				$this->timkiemmaried();
				$this->setLayout('table_maried');
				break;
			case 'themmoimaried':
				$this->setLayout('themmoimaried');
				break;
			case 'chinhsuamaried':
				$this->findmaried();
				$this->setLayout('themmoimaried');
				break;
			case 'ds_mil':
				$this->setLayout('ds_mil');
				break;
			case 'table_mil':
				$this->timkiemmil();
				$this->setLayout('table_mil');
				break;
			case 'themmoimil':
				$this->setLayout('themmoimil');
				break;
			case 'chinhsuamil':
				$this->findmil();
				$this->setLayout('themmoimil');
				break;
			case 'ds_nat':
				$this->setLayout('ds_nat');
				break;
			case 'table_nat':
				$this->timkiemnat();
				$this->setLayout('table_nat');
				break;
			case 'themmoinat':
				$this->setLayout('themmoinat');
				break;
			case 'chinhsuanat':
				$this->findnat();
				$this->setLayout('themmoinat');
				break;
			case 'ds_ous':
				$this->setLayout('ds_ous');
				break;
			case 'table_ous':
				$this->timkiemous();
				$this->setLayout('table_ous');
				break;
			case 'themmoious':
				$this->setLayout('themmoious');
				break;
			case 'chinhsuaous':
				$this->findous();
				$this->setLayout('themmoious');
				break;
			case 'ds_party_pos':
				$this->setLayout('ds_party_pos');
				break;
			case 'table_party_pos':
				$this->timkiemparty_pos();
				$this->setLayout('table_party_pos');
				break;
			case 'themmoiparty_pos':
				$this->setLayout('themmoiparty_pos');
				break;
			case 'chinhsuaparty_pos':
				$this->findparty_pos();
				$this->setLayout('themmoiparty_pos');
				break;
			case 'ds_ran':
				$this->setLayout('ds_ran');
				break;
			case 'table_ran':
				$this->timkiemran();
				$this->setLayout('table_ran');
				break;
			case 'themmoiran':
				$this->setLayout('themmoiran');
				break;
			case 'chinhsuaran':
				$this->findran();
				$this->setLayout('themmoiran');
				break;
			case 'ds_rank':
				$this->setLayout('ds_rank');
				break;
			case 'table_rank':
				$this->timkiemrank();
				$this->setLayout('table_rank');
				break;
			case 'themmoirank':
				$this->setLayout('themmoirank');
				break;
			case 'chinhsuarank':
				$this->findrank();
				$this->setLayout('themmoirank');
				break;
			case 'ds_rel':
				$this->setLayout('ds_rel');
				break;
			case 'table_rel':
				$this->timkiemrel();
				$this->setLayout('table_rel');
				break;
			case 'themmoirel':
				$this->setLayout('themmoirel');
				break;
			case 'chinhsuarel':
				$this->findrel();
				$this->setLayout('themmoirel');
				break;
			case 'ds_relative':
				$this->setLayout('ds_relative');
				break;
			case 'table_relative':
				$this->timkiemrelative();
				$this->setLayout('table_relative');
				break;
			case 'themmoirelative':
				$this->setLayout('themmoirelative');
				break;
			case 'chinhsuarelative':
				$this->findrelative();
				$this->setLayout('themmoirelative');
				break;
			case 'ds_sex':
				$this->setLayout('ds_sex');
				break;
			case 'table_sex':
				$this->timkiemsex();
				$this->setLayout('table_sex');
				break;
			case 'themmoisex':
				$this->setLayout('themmoisex');
				break;
			case 'chinhsuasex':
				$this->findsex();
				$this->setLayout('themmoisex');
				break;
			default:
				$this->setLayout('page_404');
				break;
		}
		parent::display($tpl);
	}
	function goiluong_danhsach()
	{
		$jinput = JFactory::getApplication()->input;
		$data = Core::loadAssocList('cb_goiluong', '*');
		$this->assignRef('data', $data);
	}
	function goiluong_frm()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$data = Core::loadAssoc('cb_goiluong', '*', 'id=' . (int) $id);
		$this->assignRef('data', $data);
	}
	function khenthuongkyluat_danhsach()
	{
		$jinput = JFactory::getApplication()->input;
		$data = Core::loadAssocList('rew_fin_code', '*');
		$this->assignRef('data', $data);
	}
	function khenthuongkyluat_frm()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$data = Core::loadAssoc('rew_fin_code', '*', 'id=' . (int) $id);
		$this->assignRef('data', $data);
	}
	function ketquathidua_danhsach()
	{
		$jinput = JFactory::getApplication()->input;
		$data = Core::loadAssocList('danhmuc_thidua_ketqua', '*');
		$this->assignRef('data', $data);
	}
	function ketquathidua_frm()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$data = Core::loadAssoc('danhmuc_thidua_ketqua', '*', 'id=' . (int) $id);
		$this->assignRef('data', $data);
	}
	function hinhthucthidua_danhsach()
	{
		$jinput = JFactory::getApplication()->input;
		$data = Core::loadAssocList('danhmuc_thidua_hinhthuc', '*', 'daxoa=0');
		$this->assignRef('data', $data);
	}
	function hinhthucthidua_frm()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$data = Core::loadAssoc('danhmuc_thidua_hinhthuc', '*', 'id=' . (int) $id);
		$this->assignRef('data', $data);
	}
	function hinhthucchucdanhcongtac_danhsach()
	{
		$jinput = JFactory::getApplication()->input;
		$data = Core::loadAssocList('danhmuc_chucdanh_hinhthucbonhiem', '*', null);
		$this->assignRef('data', $data);
	}
	function hinhthucchucdanhcongtac_frm()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$data = Core::loadAssoc('danhmuc_chucdanh_hinhthucbonhiem', '*', 'id=' . (int) $id);
		$this->assignRef('data', $data);
	}
	function chucdanhcongtac_danhsach()
	{
		$jinput = JFactory::getApplication()->input;
		$data = Core::loadAssocList('danhmuc_chucdanhcongtac', '*', null);
		$this->assignRef('data', $data);
	}
	function chucdanhcongtac_frm()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$data = Core::loadAssoc('danhmuc_chucdanhcongtac', '*', 'id=' . (int) $id);
		$this->assignRef('data', $data);
	}
	function linhvucnckh_danhsach()
	{
		$jinput = JFactory::getApplication()->input;
		$data = Core::loadAssocList('dm_linhvucnckh', '*', null);
		$this->assignRef('data', $data);
	}
	function linhvucnckh_frm()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$data = Core::loadAssoc('dm_linhvucnckh', '*', 'id=' . (int) $id);
		$this->assignRef('data', $data);
	}
	function detainckh_danhsach()
	{
		$jinput = JFactory::getApplication()->input;
		$data = Core::loadAssocList('dm_detainckh', '*', null);
		$this->assignRef('data', $data);
	}
	function detainckh_frm()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$data = Core::loadAssoc('dm_detainckh', '*', 'id=' . (int) $id);
		$this->assignRef('data', $data);
	}
	function timkiemability()
	{
		$tk_ability = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Ability');
		$kq = $model->findabilitybyname($tk_ability);
		$this->assignRef('ds_ability', $kq);
	}
	function findability()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Ability');
		$kq = $model->findability($id);
		$this->assignRef('ability', $kq);
	}
	function timkiemawa()
	{
		$tk_awa = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Awa');
		$kq = $model->findawabyname($tk_awa);
		$this->assignRef('ds_awa', $kq);
	}
	function findawa()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Awa');
		$kq = $model->findawa($id);
		$this->assignRef('awa', $kq);
	}
	function timkiemblood()
	{
		$tk_awa = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Blood');
		$kq = $model->findbloodbyname($tk_awa);
		$this->assignRef('ds_blood', $kq);
	}
	function findblood()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Blood');
		$kq = $model->findblood($id);
		$this->assignRef('blood', $kq);
	}
	function timkiemcost()
	{
		$tk_awa = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Cost');
		$kq = $model->findcostbyname($tk_awa);
		$this->assignRef('ds_cost', $kq);
	}
	function findcost()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Cost');
		$kq = $model->findcost($id);
		$this->assignRef('cost', $kq);
	}
	function timkiemcountry()
	{
		$tk_country = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Country');
		$kq = $model->findcountrybyname($tk_country);
		$this->assignRef('ds_country', $kq);
	}
	function findcountry()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Country');
		$kq = $model->findcountry($id);
		$this->assignRef('country', $kq);
	}
	function timkiemcyu()
	{
		$tk_cyu = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Cyu');
		$kq = $model->findcyubyname($tk_cyu);
		$this->assignRef('ds_cyu', $kq);
	}
	function findcyu()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Cyu');
		$kq = $model->findcyu($id);
		$this->assignRef('cyu', $kq);
	}
	function timkiemdefect()
	{
		$tk_defect = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Defect');
		$kq = $model->finddefectbyname($tk_defect);
		$this->assignRef('ds_defect', $kq);
	}
	function finddefect()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Defect');
		$kq = $model->finddefect($id);
		$this->assignRef('defect', $kq);
	}
	function timkiemhea()
	{
		$tk_hea = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Hea');
		$kq = $model->findheabyname($tk_hea);
		$this->assignRef('ds_hea', $kq);
	}
	function findhea()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Hea');
		$kq = $model->findhea($id);
		$this->assignRef('hea', $kq);
	}
	function timkiemmaried()
	{
		$tk_maried = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Maried');
		$kq = $model->findmariedbyname($tk_maried);
		$this->assignRef('ds_maried', $kq);
	}
	function findmaried()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Maried');
		$kq = $model->findmaried($id);
		$this->assignRef('maried', $kq);
	}
	function timkiemmil()
	{
		$tk_mil = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Mil');
		$kq = $model->findmilbyname($tk_mil);
		$this->assignRef('ds_mil', $kq);
	}
	function findmil()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Mil');
		$kq = $model->findmil($id);
		$this->assignRef('mil', $kq);
	}
	function timkiemnat()
	{
		$tk_nat = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Nat');
		$kq = $model->findnatbyname($tk_nat);
		$this->assignRef('ds_nat', $kq);
	}
	function findnat()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Nat');
		$kq = $model->findnat($id);
		$this->assignRef('nat', $kq);
	}
	function timkiemous()
	{
		$tk_ous = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Ous');
		$kq = $model->findousbyname($tk_ous);
		$this->assignRef('ds_ous', $kq);
	}
	function findous()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Ous');
		$kq = $model->findous($id);
		$this->assignRef('ous', $kq);
	}
	function timkiemparty_pos()
	{
		$tk_party_pos = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Party_pos');
		$kq = $model->findparty_posbyname($tk_party_pos);
		$this->assignRef('ds_party_pos', $kq);
	}
	function findparty_pos()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Party_pos');
		$kq = $model->findparty_pos($id);
		$this->assignRef('party_pos', $kq);
	}
	function timkiemran()
	{
		$tk_ran = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Ran');
		$kq = $model->findranbyname($tk_ran);
		$this->assignRef('ds_ran', $kq);
	}
	function findran()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Ran');
		$kq = $model->findran($id);
		$this->assignRef('ran', $kq);
	}
	function timkiemrank()
	{
		$tk_rank = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Rank');
		$kq = $model->findrankbyname($tk_rank);
		$this->assignRef('ds_rank', $kq);
	}
	function findrank()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Rank');
		$kq = $model->findrank($id);
		$this->assignRef('rank', $kq);
	}
	function timkiemrel()
	{
		$tk_rel = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Rel');
		$kq = $model->findrelbyname($tk_rel);
		$this->assignRef('ds_rel', $kq);
	}
	function findrel()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Rel');
		$kq = $model->findrel($id);
		$this->assignRef('rel', $kq);
	}
	function timkiemrelative()
	{
		$tk_relative = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Relative');
		$kq = $model->findrelativebyname($tk_relative);
		$this->assignRef('ds_relative', $kq);
	}
	function findrelative()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Relative');
		$kq = $model->findrelative($id);
		$this->assignRef('relative', $kq);
	}
	function timkiemsex()
	{
		$tk_sex = JRequest::getVar('ten');
		$model = Core::model('Danhmuckieubao/Sex');
		$kq = $model->findsexbyname($tk_sex);
		$this->assignRef('ds_sex', $kq);
	}
	function findsex()
	{
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id', 0, 'int');
		$model = Core::model('Danhmuckieubao/Sex');
		$kq = $model->findsex($id);
		$this->assignRef('sex', $kq);
	}
}
