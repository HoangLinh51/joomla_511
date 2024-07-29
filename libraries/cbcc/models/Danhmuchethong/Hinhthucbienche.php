<?php 
	class Danhmuchethong_Model_Hinhthucbienche extends JModelLegacy{
		public function getallbc_loaihinh(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('bc_loaihinh');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function getall_thoihan_bienchehopdong(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,deadline');
			$query->from('bc_thoihanbienchehopdong');
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssocList();
		}
		public function getall_hinhthuctuyendung(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('bc_hinhthuctuyendung');
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssocList();
		}
		public function timkiemhinhthucbienchebyname($hinhthucbienche_name,$hinhthucbienche_loaihinh,$hinhthucbienche_trangthai,$hinhthucbienche_thoihan){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.id,a.name,a.status,b.name as loaihinh_name,a.text_ngaybatdau,a.text_ngayketthuc');
			$query->from('bc_hinhthuc a');
			$query->join('INNER','bc_loaihinh b ON (a.loaihinh_id=b.id)');
			$query->join('LEFT','bc_hinhthuc_thoihan c ON (a.id=c.hinhthuc_id)');
			// $query->join('INNER','bc_thoihanbienchehopdong d ON (c.thoihan_id=d.id)');
			if($hinhthucbienche_name!=null){
				$query->where('a.name LIKE '.$db->quote('%'.$hinhthucbienche_name.'%'));
			}
			if($hinhthucbienche_loaihinh!=null){
				$query->where('a.loaihinh_id='.$db->quote($hinhthucbienche_loaihinh));
			}
			if($hinhthucbienche_trangthai!=null){
				$query->where('a.status='.$db->quote($hinhthucbienche_trangthai));
			}
			if($hinhthucbienche_thoihan!=null){
				$query->where('c.thoihan_id='.$db->quote($hinhthucbienche_thoihan));
			}
			$query->group('a.name');
			$query->order('a.id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function find_thoihan_bienchehopdong_by_hinhthucbienche($hinhthuc_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('b.name');
			$query->from('bc_hinhthuc_thoihan a');
			$query->join('INNER','bc_thoihanbienchehopdong b ON(a.thoihan_id=b.id)');
			$query->where('a.hinhthuc_id='.$db->quote($hinhthuc_id));
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function luuhinhthucbienche($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']==''){
				$status = 0;
			}
			else{
				$status = $form['status'];
			}
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
					$db->quotename('text_ngaybatdau').'='.$db->quote($form['text_ngaybatdau']),
					$db->quotename('s_name').'='.$db->quote($form['s_name']),
					$db->quotename('text_ngayketthuc').'='.$db->quote($form['text_ngayketthuc']),
					$db->quotename('loaihinh_id').'='.$db->quote($form['loaihinh_id']),
					$db->quotename('is_thietlapthoihan').'='.$db->quote($form['is_thietlapthoihan']),
					$db->quotename('text_soquyetdinh').'='.$db->quote($form['text_soquyetdinh']),
					$db->quotename('text_ngaybanhanh').'='.$db->quote($form['text_ngaybanhanh']),
					$db->quotename('text_coquanraquyetdinh').'='.$db->quote($form['text_coquanraquyetdinh']),
					$db->quotename('is_hinhthuctuyendung').'='.$db->quote($form['is_hinhthuctuyendung']),
					$db->quotename('status').'='.$db->quote($status));
			$query->insert('bc_hinhthuc');
			$query->set($field);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();
		}
		public function luu_hinhthucbienche_thoihan($id_hinhthucbienche,$thoihan){
			$db = JFactory::getDbo();
			for($i=0;$i<count($thoihan);$i++){
				$query = $db->getQuery(true);
				$field = array('hinhthuc_id='.$db->quote($id_hinhthucbienche),
								'thoihan_id='.$db->quote($thoihan[$i]));
				$query->insert('bc_hinhthuc_thoihan');
				$query->set($field);
				// echo $query;die;
				$db->setQuery($query);
				$result[] = $db->query();
			}
			return $result;
		}
		public function luu_hinhthucbienche_hinhthuctuyendung($id_hinhthucbienche,$hinhthuctuyendung){
			$db = JFactory::getDbo();
			for($i=0;$i<count($hinhthuctuyendung);$i++){
				$query = $db->getQuery(true);
				$field = array('hinhthuc_id='.$db->quote($id_hinhthucbienche),
								'hinhthuctuyendung_id='.$db->quote($hinhthuctuyendung[$i]));
				$query->insert('bc_hinhthuc_hinhthuctuyendung');
				$query->set($field);
				$db->setQuery($query);
				$result[] = $db->query();
			}
			return $result;
		}
		public function delete_hinhthucbienche($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('bc_hinhthuc');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_hinhthucbienche_thoihan($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('bc_hinhthuc_thoihan');
			$query->where('hinhthuc_id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_hinhthucbienche_hinhthuctuyendung($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('bc_hinhthuc_hinhthuctuyendung');
			$query->where('hinhthuc_id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function findhinhthucbienche($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,text_ngaybatdau,text_ngayketthuc,s_name,loaihinh_id,text_ngaybanhanh,text_soquyetdinh,is_thietlapthoihan,text_soquyetdinh,text_coquanraquyetdinh,is_hinhthuctuyendung');
			$query->from('bc_hinhthuc');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function find_thoihan_by_hinhthucbienche($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('hinhthuc_id,thoihan_id');
			$query->from('bc_hinhthuc_thoihan');
			$query->where('hinhthuc_id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function find_hinhthuctuyendung_by_hinhthucbienche($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('hinhthuc_id,hinhthuctuyendung_id');
			$query->from('bc_hinhthuc_hinhthuctuyendung');
			$query->where('hinhthuc_id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function updatehinhthucbienche($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']==''){
				$status = 0;
			}
			else{
				$status = $form['status'];
			}
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
					$db->quotename('text_ngaybatdau').'='.$db->quote($form['text_ngaybatdau']),
					$db->quotename('s_name').'='.$db->quote($form['s_name']),
					$db->quotename('text_ngayketthuc').'='.$db->quote($form['text_ngayketthuc']),
					$db->quotename('loaihinh_id').'='.$db->quote($form['loaihinh_id']),
					$db->quotename('is_thietlapthoihan').'='.$db->quote($form['is_thietlapthoihan']),
					$db->quotename('text_soquyetdinh').'='.$db->quote($form['text_soquyetdinh']),
					$db->quotename('text_ngaybanhanh').'='.$db->quote($form['text_ngaybanhanh']),
					$db->quotename('text_coquanraquyetdinh').'='.$db->quote($form['text_coquanraquyetdinh']),
					$db->quotename('is_hinhthuctuyendung').'='.$db->quote($form['is_hinhthuctuyendung']),
					$db->quotename('status').'='.$db->quote($status));
			$query->update('bc_hinhthuc');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function xoanhieu_hinhthucbienche($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id);$i++){
				$this->delete_hinhthucbienche_thoihan($id[$i]);
				$this->delete_hinhthucbienche_hinhthuctuyendung($id[$i]);
				$query = $db->getQuery(true);
				$query->delete('bc_hinhthuc');
				$query->where('id='.$id[$i]);
				$db->setQuery($query);
				$result[] = $db->query();
			}
			return $result;
		}
	}
?>