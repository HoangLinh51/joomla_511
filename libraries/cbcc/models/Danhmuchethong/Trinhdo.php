<?php 
	class Danhmuchethong_Model_Trinhdo extends JModelLegacy{
		public function timkiem_trinhdo_byname($tk_trinhdo_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$tk_trinhdo_name = $this->check_sql_injection($tk_trinhdo_name);
			$query->select('id,tosc_code,code,name,s_name,step_2,step,step_name,step_name2,istext,is_core,ls_code');
			$query->from('cla_sca_code a');
			if($tk_trinhdo_name!=null){
				$query->where('name LIKE '.$db->quote('%'.$tk_trinhdo_name.'%'));
			}
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function find_chuyennganhdaotao_byid($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('code,name');
			$query->from('ls_code');
			$query->where('code='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function find_loaitrinhdo_byid($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('code,name');
			$query->from('type_sca_code');
			$query->where('code='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function getall_loaitrinhdo(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('code,name,iscn,lim_code');
			$query->from('type_sca_code');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function getall_chuyennganhdaotao(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('code,name,lim_code');
			$query->from('ls_code');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
	    public function add_trinhdo($form){
	    	$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$s_name = $this->check_sql_injection($form['s_name']);
			$step_name = $this->check_sql_injection($form['step_name']);
			$step_name2 = $this->check_sql_injection($form['step_name2']);
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('code').'='.$db->quote($form['code']),
						$db->quotename('tosc_code').'='.$db->quote($form['tosc_code']),
						$db->quotename('s_name').'='.$db->quote($s_name),
						$db->quotename('step').'='.$db->quote($form['step']),
						$db->quotename('step_2').'='.$db->quote($form['step_2']),
						$db->quotename('step_name').'='.$db->quote($step_name),
						$db->quotename('step_name2').'='.$db->quote($step_name2),
						$db->quotename('istext').'='.$db->quote($form['istext']));
			$query->insert('cla_sca_code');
			$query->set($field);
			if($form['ls_code']&&$form['ls_code']!=null){
				$query->set($db->quotename('ls_code').'='.$db->quote($form['ls_code']));
			}
			$db->setQuery($query);
			return $db->query();
	    }
	    public function find_trinhdo_byid($id){
	    	$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.id,a.tosc_code,a.code,a.name,a.s_name,a.step_2,a.step,a.step_name,a.step_name2,a.istext,a.ls_code,b.lim_code');
			$query->from('cla_sca_code a');
			$query->join('INNER','type_sca_code b ON (b.code=a.tosc_code)');
			$query->where('a.id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
	    }
	    public function update_trinhdo($form){
	    	$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$s_name = $this->check_sql_injection($form['s_name']);
			$step_name = $this->check_sql_injection($form['step_name']);
			$step_name2 = $this->check_sql_injection($form['step_name2']);
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('code').'='.$db->quote($form['code']),
						$db->quotename('tosc_code').'='.$db->quote($form['tosc_code']),
						$db->quotename('s_name').'='.$db->quote($s_name),
						$db->quotename('step').'='.$db->quote($form['step']),
						$db->quotename('step_2').'='.$db->quote($form['step_2']),
						$db->quotename('step_name').'='.$db->quote($step_name),
						$db->quotename('step_name2').'='.$db->quote($step_name2),
						$db->quotename('istext').'='.$db->quote($form['istext']));
			$query->update('cla_sca_code');
			$query->set($field);
			if($form['ls_code']&&$form['ls_code']!=null){
				$query->set($db->quotename('ls_code').'='.$db->quote($form['ls_code']));
			}
			else{
				$query->set($db->quotename('ls_code').'=null');
			}
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
	    }
	    public function delete_trinhdo($id){
	    	$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('cla_sca_code');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
	    }
	}
?>