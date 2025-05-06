<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

class CoreTemplate{
	public function getCategoryNameById($catid){
		if ($catid == null) {
			$catid = 2;
		}
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('title'))
		->from('jos_categories')		
		->where('id = '.$db->quote($catid));
		$db->setQuery($query);
		return $db->loadResult();
	}
	public function getContentFrontPage($catid){
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		//$catid = Core::config('core/site/catidshowlogin');
		//$catid = 0;
		if ($catid == null) {
			$catid = 2;
		}
		$query->select(array('a.id','a.title','a.fulltext','a.introtext'))
			->from('jos_content AS a')		
			->where('a.state = 1')
			->where('a.catid = '.$db->quote($catid))
			->where('a.access = 1')
			->order('a.ordering')
		;
		$db->setQuery($query,0,3);
		return $db->loadAssocList();
	}
	public function isLogin(){
		$option = Factory::getApplication()->getInput()->get('option');
		$view = Factory::getApplication()->getInput()->get('view');
		if ($option=='com_users' && ($view == 'login' || $view == 'reset' || $view == 'remind') ) {
			return true;
		}else{
			return false;
		}		
	}
	public function moduleMessage(){
		$user = Factory::getUser();
		if ($user->id == null) {
			return '';
		}
		?>
		<script type="text/javascript">
		(function($){
			$.get('<?php echo Uri::root(true);?>/index.php?option=com_chat&controller=traodoi&task=home',function(data) {
				var el = jQuery('#index-traodoi-inbox');
				if(typeof data != "undefined"){					
					if(data.inbox > 0 ){
						el.prev('i').addClass('icon-animated-vertical');
					}
					jQuery('#index-traodoi-inbox').html(data.inbox);
					var xhtml='<ul id="menu-msg" class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-closer">';
					xhtml+='<li class="nav-header">';
					xhtml+='<i class="icon-envelope-alt"></i>';
					xhtml+= data.inbox + ' Tin nhắn';
					xhtml+= '</li>';
					for (var i = 0; i < data.msg.length; i++) {
						xhtml+= '<li>';
						xhtml+= '<a href="#">';
						xhtml+= '<span class="msg-body">';
						xhtml+= '<span class="msg-title">';
						xhtml+= '<span class="blue">'+data.msg[i].username+':</span>';
						xhtml+= data.msg[i].tieude;
						xhtml+= '</span>';
						xhtml+= '<span class="msg-time">';
						xhtml+= '<i class="icon-time"></i>';
						xhtml+= '<span> '+data.msg[i].ngaygui+'</span>';
						xhtml+= '</span>';
						xhtml+= '</span>';
						xhtml+= '</a>';
						xhtml+= '</li>';
					}
					xhtml+= '<li>';
					xhtml+= '<a href="<?php echo Uri::root();?>/index.php?option=com_chat&controller=traodoi&task=default">';
					xhtml+= 'Xem thêm';
					xhtml+= '<i class="icon-arrow-right"></i>';
					xhtml+= '</a>';
					xhtml+= '</li>';
					jQuery('#index-menu-inbox').append(xhtml);
					//jQuery('#count-traodoi-send').html(data.send);
					//jQuery('#count-traodoi-draft').html(data.draft);
				}
	        });
		})(jQuery);
		</script>
		<li class="green" id="index-menu-inbox">
			<a data-toggle="dropdown" class="dropdown-toggle" href="#">
				<i class="icon-envelope icon-animated-vertical"></i>
				<span class="badge badge-success" id="index-traodoi-inbox">0</span>
			</a>
		</li>
		<?php 
	}
	public function moduleEgov(){
		$user = Factory::getUser();
		if ($user->id == null) {
			return '';
		}
		?>
		<li class="info" id="index-menu-egov">
			<a href="https://egov.danang.gov.vn"><span><i class="icon-home"></i> Trang chủ EGOV</span></a>
		</li>
		<?php 
	}
	public function moduleNhacnho(){
		$user = Factory::getUser();
		if ($user->id == null) {
			return '';
		}
		?>
		<li class="purple" id="index-menu-nhacnho">
			<a data-toggle="dropdown" class="dropdown-toggle" href="#">
				<i class="icon-bell-alt icon-animated-bell"></i>
				<span class="badge badge-important" id="index-soluong-nhacnho">0</span>
			</a>
		</li>
		<?php 
	}
	public function showModule(){
		$jinput = Factory::getApplication()->input;
		$option = $jinput->getCmd('option','default');
		$controller = $jinput->getCmd('controller','default');
		$task = $jinput->getCmd('task','default');
		$key = 'lft-bottom';
		switch ($option) {
			case 'com_hoso':
				$key = 'caydonvi-hoso';
			break;			
			default:
				$key = 'lft-bottom';
			break;
		}
		return '<jdoc:include type="modules" name="'.$key.'" style="xhtml" />';
	}
	public function breadcrumb(){
		$db = Factory::getDbo();
		$jinput = Factory::getApplication()->input;
		$option = $jinput->getCmd('option','default');
		$controller = $jinput->getCmd('controller','default');
		$task = $jinput->getCmd('task','default');
		$xhtml = '';
		$sql="SELECT parent.*
			FROM core_menu AS node,
			core_menu AS parent
			WHERE node.lft BETWEEN parent.lft AND parent.rgt
			AND node.id = (SELECT id FROM core_menu WHERE (component = ".$db->q($option).") AND (controller = ".$db->q($controller).") AND (task = ".$db->q($task).") LIMIT 1)
					AND parent.id !=1
			ORDER BY parent.lft;";
		$db->setQuery($sql);
		//echo $sql;
		$rows = $db->loadAssocList();
		$xhtml = '<ul class="breadcrumb">
						<li>
							<i class="icon-home home-icon"></i>
							<a href="index.php">Trang chủ</a>
	
							<span class="divider">
								<i class="icon-angle-right arrow-icon"></i>
							</span>
						</li>';
		for ($i = 0,$n=count($rows); $i < $n; $i++) {
			$row = $rows[$i];
			if (($n-1) == $i) {
				$xhtml .= '<li class="active">'.$row['name'].'</li>';
			}else{
				if($row['is_system'] == 1){
					$xhtml .= '<li><a href="index.php?option='.$row['component'].'&controller='.$row['controller'].'&task='.$row['task'].'">'.$row['name'].'</a>';
					$xhtml .= '<span class="divider"><i class="icon-angle-right arrow-icon"></i></span>';
					$xhtml .= '</li>';
				}else{
					if ($row['link'] == '#') {
						$xhtml .= '<li>'.$row['name'].'';
					}else{
						$xhtml .= '<li><a href="'.$row['link'].'">'.$row['name'].'</a>';
					}
					//$xhtml .= '<li><a href="'.$row['link'].'">'.$row['name'].'</a>';
					$xhtml .= '<span class="divider"><i class="icon-angle-right arrow-icon"></i></span>';
					$xhtml .= '</li>';
				}
			}
	
		}
		$xhtml .= '</ul><!--.breadcrumb-->';
		return $xhtml;
	}
	public function getMenu(){
		$user = Factory::getUser();
		if ($user->id == null) {
			return '';
		}
		$jinput = Factory::getApplication()->input;
		$option = $jinput->getCmd('option','default');
		$controller = $jinput->getCmd('controller','default');
		$task = $jinput->getCmd('task','default');
		$db = Factory::getDbo();
		$session = Factory::getSession();
		if ($session->get('menu') == null) {
		$query = ' SELECT n.icon,n.id,n.link,n.is_system,n.`name`,n.params,n.lft,n.rgt,n.published,n.component,n.controller,n.task,
         count(*)-1+(n.lft>1) AS level
		    FROM core_menu n,
		         core_menu p
		   WHERE n.lft BETWEEN p.lft AND p.rgt AND (p.id != n.id OR n.lft = 1) AND (n.published = 1)
		GROUP BY n.id
		ORDER BY n.lft;';
		$db->setQuery($query);
		$rows = $db->loadAssocList();
		$session->set('menu',$rows);
		}
		$rows = $session->get('menu');
		$sql="SELECT parent.id
			FROM core_menu AS node,
			core_menu AS parent
			WHERE node.lft BETWEEN parent.lft AND parent.rgt
			AND node.id = (SELECT id FROM core_menu WHERE (component = ".$db->q($option).") AND (controller = ".$db->q($controller).") AND (task = ".$db->q($task).") LIMIT 1)
					AND parent.id !=1
			ORDER BY parent.lft;";
		$db->setQuery($sql);
		$actives = $db->loadColumn();
		if (count($actives) > 0 ) {
			$active = end($actives);
		}else{
			$active = 0;
		}
		$user = Factory::getUser();
		$counter = 0;
		$result = '<ul class="nav nav-list">';
		$current_depth = 1;
		$index = 0;
		foreach ( $rows as $node ) {
			$index ++;
			$flag = false;
			if ($user->id != null && $node ['is_system'] == 1) {
				if (false == Core::_checkPerAction ( $user->id, $node ['component'], $node ['controller'], $node ['task'] )) {
					continue;
					$flag = true;
				}
			}
			if($node ['is_system'] == 1){
			    if($node['link'] == ''){
				    $node['link'] = 'index.php?option='.$node['component'].'&controller='.$node['controller'].'&task='.$node['task'].'&'.$node['params'];
			    }
			}
			$child = false;
			$node_depth = $node ['level'];
			$node_name = $node ['name'];
			$node_id = $node ['id'];
			if ((int)$rows[$index]['lft'] > 0) {
				$hasChild = (($node ['lft'] < (int)$rows[$index]['lft']) && ($node ['rgt'] > (int)$rows[$index]['rgt']) )?true:false;
			}
			else{
				$hasChild = false;
			}
			if ($node_depth == $current_depth) {
				if ($counter > 0)
					$result .= '</li>';
				 
			} elseif ($node_depth > $current_depth) {
				$result .= '<ul class="submenu">';
				$child = true;
				$current_depth = $current_depth + ($node_depth - $current_depth);
			} elseif ($node_depth < $current_depth) {
				$result .= str_repeat ( '</li></ul>', $current_depth - $node_depth ) . '</li>';
				$current_depth = $current_depth - ($current_depth - $node_depth);
			}
			$liKlass = '';
			if ($flag == false) {				
				$result .= '<li id="c' . $node_id . '"';
				$result .= (in_array($node['id'], $actives))? ' class="open active"' : '';
				$icon = ($node['icon']==null)?'':'<i class="'.$node['icon'].'"></i>';	
				if ($child == true) {
					$result .= '><a href="'.$node['link'].'">'.(($node['id'] == $active)? '<i class="icon-double-angle-right"></i>' : '').$node_name . '</a>';
				}else{
					if ($hasChild == true) {	
						$result .= '><a href="'.$node['link'].'" class="dropdown-toggle">'.$icon.'<span class="menu-text">' . $node_name . '</span><b class="arrow icon-angle-down"></b></a>';
					}else{	
						$result .= '><a href="'.$node['link'].'">'.$icon.(($node['id'] == $active)? '<i class="icon-double-angle-right"></i>' : '').'<span class="menu-text">' . $node_name . '</span></a>';
					}
				}
	
			}
			++ $counter;
		}
		$result .= str_repeat ( '</li></ul>', $node_depth ) . '</li>';
		$result .= '</ul>';
		return $result;
	}

	public function getAvatarUrl($user)
	{
		$db = Factory::getDbo();
		$base_url = Uri::root(true);
		$avatar_id = $user->avatar_id;
		$avatarUrl = $base_url . "/uploader/defaultImage.png";
		if (!empty($avatar_id)) {
			$query = $db->getQuery(true)
				->select($db->quoteName('code'))
				->from($db->quoteName('core_attachment'))
				->where($db->quoteName('object_id') . ' = ' . $db->quote($avatar_id))
				->order($db->quoteName('created_at') . ' DESC');
			$db->setQuery($query);
			$result = $db->loadObject();

			if (!empty($result) && !empty($result->code)) {
				$avatarUrl = $base_url . "/uploader/get_image.php?code=" . $result->code;
			}
		}
		return $avatarUrl;
	}

	public function getThongBao($itemId = null)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$today = date('Y-m-d');
		$query->select($db->quoteName(['id', 'tieude', 'noidung', 'vanbandinhkem', 'created_at']))
			->from($db->quoteName('thongbao'))
			->where('DATE(' . $db->quoteName('created_at') . ') = ' . $db->quote($today));

		if ($itemId) {
			$query->where($db->quoteName('id') . ' = ' . $db->quote($itemId));
		}
		$db->setQuery($query);
		$result = $db->loadObjectList();

		return $result;
	}

	public function getTrangThaiThongBao($userId, $thongbaoId)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true)
			->select('is_seen')
			->from($db->quoteName('trangthaithongbao'))
			->where($db->quoteName('user_id') . ' = ' . $db->quote($userId))
			->where($db->quoteName('thongbao_id') . ' = ' . $db->quote($thongbaoId))
			->setLimit(1);

		$db->setQuery($query);
		$isRead = $db->loadResult();

		if ($isRead) {
			return true; // Thông báo đã được đọc
		} else {
			return false; // Thông báo chưa được đọc
		}
	}

	public function getThongBaoCount($userId)
	{
		$db = Factory::getDbo();
		$currentDate = date('Y-m-d');

		$query = $db->getQuery(true)
			->select('COUNT(*)')
			->from($db->quoteName('thongbao', 't'))
			->leftJoin(
				$db->quoteName('trangthaithongbao', 'tt') . ' ON ' .
					$db->quoteName('t.id') . ' = ' . $db->quoteName('tt.thongbao_id') . ' AND ' .
					$db->quoteName('tt.user_id') . ' = ' . $db->quote($userId)
			)
			->where('DATE(' . $db->quoteName('t.created_at') . ') = ' . $db->quote($currentDate))
			->where($db->quoteName('t.status') . ' = 1')
			->where('(tt.id IS NULL OR tt.is_seen = 0)');

		$db->setQuery($query);
		$unreadCount = (int) $db->loadResult();
		return $unreadCount;
	}

	public function submitThongbao()
	{
		$db = Factory::getDbo();
		$input = Factory::getApplication()->input;
		$user_id = $input->getInt('user_id', 0);
		$thongbao_id = $input->getInt('thongbao_id', 0);

		// Kiểm tra dữ liệu đầu vào
		if (!$user_id || !$thongbao_id) {
			return false;
		}

		try {
			// Kiểm tra bản ghi đã tồn tại chưa
			$query = $db->getQuery(true)
				->select('id')
				->from($db->quoteName('trangthaithongbao'))
				->where($db->quoteName('user_id') . ' = ' . $db->quote($user_id))
				->where($db->quoteName('thongbao_id') . ' = ' . $db->quote($thongbao_id));
			$db->setQuery($query);
			$exists = $db->loadResult();

			if ($exists) {
				// Nếu đã có, cập nhật is_seen = 1
				$query = $db->getQuery(true)
					->update($db->quoteName('trangthaithongbao'))
					->set($db->quoteName('is_seen') . ' = 1')
					->where($db->quoteName('id') . ' = ' . $db->quote($exists));
			} else {
				// Nếu chưa có, thêm mới
				$columns = ['thongbao_id', 'user_id', 'is_seen', 'created_at'];
				$values = [
					$db->quote($thongbao_id),
					$db->quote($user_id),
					1,
					$db->quote(date('Y-m-d H:i:s'))
				];

				$query = $db->getQuery(true)
					->insert($db->quoteName('trangthaithongbao'))
					->columns($db->quoteName($columns))
					->values(implode(',', $values));
			}

			$db->setQuery($query);
			$db->execute();

			return true;
		} catch (Exception $e) {
			// Ghi log nếu cần: Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
			return false;
		}
	}
}