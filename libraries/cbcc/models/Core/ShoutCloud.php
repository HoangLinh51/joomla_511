<?php
/**
  *@file:  Shoutcloud.php
  *@encoding:UTF-8
  *@auth: huuthanh3108
  *@date: Jan 11, 2012
  *@company: http://dnict.vn
 **/
// # ShoutCloud > Main Class ###
class Core_Model_ShoutCloud {
	var $adminUser;
	var $adminPass;
	var $msgsFile;
	var $bansFile;
	var $smiliesPath;
	var $smilies;
	var $badwords;
	var $timeFormat;
	
	// ShoutCloud Constructor
	// Sets the admin's username and password
	// Options: [shout file], [banlist file], [smilies path], [smilies config],
	// [badwords config], [time format], [admin username], [admin_password]
	function __construct($arguments) {		
		$this->msgsFile = $arguments['shoutFile'];
		$this->bansFile = $arguments['banlistFile'];
		$this->smiliesPath = $arguments['smiliesPath'];
		$this->smilies = $arguments['smiliesConfig'];
		$this->badwords = $arguments['badwords'];
		$this->timeFormat = $arguments['timeFormat'];
		$this->adminUser = $arguments['admin_user'];
		$this->adminPass = $arguments['admin_pass'];
	}
	
	// ShoutCloud Initalizer
	// Initalizes and loads the shoutbox
	function init($user) {
		$strReturn = '';
		$allsmilies = '';
		foreach ( $this->smilies as $acii => $img ) {
			$allsmilies .= '<img src="' . $this->smiliesPath . $img . '" class="ShoutCloud-Smilie" id="' . $acii . '" title="' . $acii . '" />';
		}
		$username = $user->username;
		$fullname = utf8_encode($user->name);
		// $username = (!empty($_SESSION['ShoutCloud-User'])) ?
		// $_SESSION['ShoutCloud-User'] :
		// (((!empty($_SESSION['ShoutCloud_Admin_Name'])) &&
		// (!empty($_SESSION['ShoutCloud_Admin_Loggedin']))) ?
		// $_SESSION['ShoutCloud_Admin_Name'] : '');
		$loadtype = (! empty ( $_SESSION ['ShoutCloud_Admin_Name'] )) && (! empty ( $_SESSION ['ShoutCloud_Admin_Loggedin'] )) ? 'adminhtml' : 'html';
		$swatches = '';
		$tagColors = array ('Pink', 'Purple', 'Blue', 'LightBlue', 'Teal', 'Green', 'DarkGreen', 'Lime', 'Yellow', 'Orange', 'Red', 'Default' );
		if (! empty ( $_SESSION ['ShoutCloud_Tag_Color'] )) {
			$tagColor = $_SESSION ['ShoutCloud_Tag_Color'];
		} else {
			$tagColor = 'Default';
		}
		foreach ( $tagColors as $k => $color ) {
			$swatches .= '<span class="ShoutCloud-Swatch ShoutCloud-Swatch-' . $color . (($color == $tagColor) ? ' sel' : '') . '" title="' . $color . '"></span>';
		}
		/*
		echo '<div id="ShoutCloud-Container">
	<div id="ShoutCloud-MsgBox">' . $this->loadMessages ( $loadtype ) . '</div>
	<div id="ShoutCloud-InputBox">
	<div id="ShoutCloud-Error"></div>
	<div id="ShoutCloud-Wrapper">
	<div id="ShoutCloud-Smilies-Menu">' . $allsmilies . '</div>
	<div class="ShoutCloud-Swatches">' . $swatches . '<div class="clear"></div></div>
	<div id="ShoutCloud-Input-Wrapper">
	<input readonly="true" type="text" name="ShoutCloud-User" id="ShoutCloud-User" maxlength="25" value="' . utf8_decode ( $username ) . '" />
	<span id="ShoutCloud-Color" title="Choose Color"></span>
	<input type="text" name="ShoutCloud-Msg" id="ShoutCloud-Msg" value="" /></div>
	<input type="button" name="ShoutCloud-Shout" id="ShoutCloud-Shout" value="Gửi" /><div id="ShoutCloud-Counter">0/500 ký tự</div></div>
	<div class="clear"></div>
	</div>
	' . (((! empty ( $_SESSION ['ShoutCloud_Admin_Name'] )) && (! empty ( $_SESSION ['ShoutCloud_Admin_Loggedin'] ))) ? '<div id="ShoutCloud-Admin-Panel"><span class="admin-btn shout-on" id="ShoutCloud-InputsPage">Shout</span><span class="admin-btn" id="ShoutCloud-BanList">Bans</span><span class="admin-btn" id="ShoutCloud-ClearChat">Clear All</span><span class="admin-btn" id="ShoutCloud-Admin-Logout">Logout</span></div><div class="clear"></div>' : '') . '
			</div>';
			*/
		 $strReturn= '<div id="ShoutCloud-Container">
		<div id="ShoutCloud-MsgBox">' . $this->loadMessages ( $loadtype ) . '</div>
		<div id="ShoutCloud-InputBox">
		<div id="ShoutCloud-Error"></div>
		<div id="ShoutCloud-Wrapper">		
		<div class="ShoutCloud-Swatches">' . $swatches . '<div class="clear"></div></div>
		<div id="ShoutCloud-Input-Wrapper">
		<input readonly="true" type="text" name="ShoutCloud-User" id="ShoutCloud-User" maxlength="25" value="' . utf8_decode ( $username ) . '" />
		<input type="hidden" id="ShoutCloud-UserFullName" name="fullname" value="' . utf8_decode ( $fullname ) . '" />
		<span id="ShoutCloud-Color" title="Choose Color"></span>
		<input type="text" name="ShoutCloud-Msg" id="ShoutCloud-Msg" value="" /></div>
		<input type="button" name="ShoutCloud-Shout" id="ShoutCloud-Shout" value="Gửi" /><div id="ShoutCloud-Counter">0/500 ký tự |hướng dẫn gõ: !help</div></div>
		<div class="clear"></div>
		</div>
		' . (((! empty ( $_SESSION ['ShoutCloud_Admin_Name'] )) && (! empty ( $_SESSION ['ShoutCloud_Admin_Loggedin'] ))) ? '<div id="ShoutCloud-Admin-Panel"><span class="admin-btn shout-on" id="ShoutCloud-InputsPage">Shout</span><span class="admin-btn" id="ShoutCloud-BanList">Bans</span><span class="admin-btn" id="ShoutCloud-ClearChat">Clear All</span><span class="admin-btn" id="ShoutCloud-Admin-Logout">Logout</span></div><div class="clear"></div>' : '') . '
		</div>';
		return 	$strReturn;	
	}
	
	// loadMessages function
	// Loads the messages based on the specified output
	// Options: [output (html, json, admin)]
	function loadMessages($output, $lastpost = -1) {
		$msgs = fopen ( $this->msgsFile, 'a+' );
		if (! is_writable ( $this->msgsFile )) {
			chmod ( $this->msgsFile, 0666 );
		}
		if (filesize ( $this->msgsFile ) == 0) {
			fwrite ( $msgs, serialize ( (array (0 => array ('time' => 0, 'user' => 'Admin', 'msg' => 'Type [!help] for more information.' ) )) ) );
		}
		fclose ( $msgs );
		$contents = unserialize ( file_get_contents ( $this->msgsFile ) );
		$dataout = array ();
		if (($output == 'admin') || ($output == 'adminhtml')) {
			foreach ( $contents as $pos => $data ) {
				if ($pos > $lastpost) {
					if ($data ['status'] !== 'deleted') {
						$adminControls = '<div class="ShoutCloud-Admin-User-Controls" data="ip:\'' . $data ['ip'] . '\',name:\'' . $data ['user'] . '\'">
		<span class="shout-user-ip">' . $data ['ip'] . '</span>
		<span class="shout-ban-opts">
		<b>Ban</b><span class="shout-ban" id="+1 Minute">1 Min</span>
		<span class="shout-ban" id="+10 Minutes">10 Mins</span>
		<span class="shout-ban" id="+1 Hour">1 Hour</span>
		<span class="shout-ban" id="+1 Day">1 Day</span><span class="shout-ban" id="0">Forever</span>
		</span>
		<span class="shout-user-opts"><span class="shout-del">Xóa</span><span class="ShoutCloud-Admin-Reply">Trả lời</span></span>
		</div>';
						$dataout ['msgs'] .= '<div class="' . (($data ['status'] == 'deleted') ? 'shout-deleted' : 'shout-msg') . '" id="shoutid-' . $pos . '">' . ((utf8_decode ( $data ['user'] ) == $this->adminUser) ? '' : $adminControls) . '<strong id="' . utf8_decode ( $data ['user'] ) . '"
				class="' . ((! empty ( $data ['color'] )) ? ' ShoutCloud-Swatch-' . $data ['color'] : '') . ((utf8_decode ( $data ['user'] ) == $this->adminUser) ? ' shout-admin ShoutCloud-Reply">' : ' shout-admin-user" title="Open Admin User Control">') . utf8_decode ( $data ['user'] ) . '</strong>' . (($data ['time'] == 0) ? '' : '<em>' . date ( 'g:i:sa', $data ['time'] )) . '</em>' . $this->formatMessage ( $data ['msg'] ) . '</div>';
					}
				}
			}
		} else {
			foreach ( $contents as $pos => $data ) {
				if ($pos > $lastpost) {
					if ($data ['status'] !== 'deleted') {
						$dataout ['msgs'] .= '<div class="' . (($data ['status'] == 'deleted') ? 'shout-deleted' : 'shout-msg') . '" id="shoutid-' . $pos . '">
		<strong id="' . utf8_decode ( $data ['user'] ) . '"' . (((! empty ( $_SESSION ['ShoutCloud-User'] )) && ($_SESSION ['ShoutCloud-User'] == utf8_decode ( $data ['user'] ))) ? ' class="' : ' title="Reply to ' . utf8_decode ( $data ['user'] ) . '" class="ShoutCloud-Reply') . ((! empty ( $data ['color'] )) ? ' ShoutCloud-Swatch-' . $data ['color'] : '') . ((utf8_decode ( $data ['user'] ) == $this->adminUser) ? ' shout-admin">' : '">') . utf8_decode ( $data ['fullname'] ) . '</strong>' . (($data ['time'] == 0) ? '' : '<em>' . date ( 'g:i:sa', $data ['time'] )) . '</em>' . $this->formatMessage ( $data ['msg'] ) . '</div>';
					}
				}
			}
		}
		
		if (($output == 'html') || ($output == 'adminhtml')) {
			$htmlout = '';
			foreach ( $dataout as $k => $v ) {
				$htmlout .= $v;
			}
			return $htmlout;
		} else {
			if (! empty ( $dataout )) {
				return $this->jsonEncode ( $dataout );
			} else {
				return $this->jsonEncode ( array ('msgs' => '' ) );
			}
		}
	}
	
	// formatMessage function
	// Removes bad words and adds smilies
	// Options: [message]
	function formatMessage($msg) {
		$msg = str_ireplace ( $this->badwords, '****', $msg );
		foreach ( $this->smilies as $acii => $img ) {
			$msg = str_ireplace ( $acii, '<img src="' . $this->smiliesPath . $img . '" width="16" height="16" align="absmiddle" />', $msg );
		}
		//$patterns = array ('/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i', '/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i', '/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i', '~\[@([^\]]*)\]~', '~\[([^\]]*)\]~', '~{([^}]*)}~', '~_([^_]*)_~', '/\s{2}/' );
		//$replacements = array ('$1http://$2', '<a href=\"$1\">$1</a>', '<a href=\"mailto:$1\">$1</a>', '<b class="reply">@\\1</b>', '<b>\\1</b>', '<i>\\1</i>', '<u>\\1</u>', '<br />' );
		$patterns = array ('/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i', '/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i', '/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i', '~\[@([^\]]*)\]~', '~\[([^\]]*)\]~', '~{([^}]*)}~', '~_([^_]*)_~', '/\s{3}/' );
		$replacements = array ('$1http://$2', '<a href=\"$1\">$1</a>', '<a href=\"mailto:$1\">$1</a>', '<b class="reply">@\\1</b>', '<b>\\1</b>', '<i>\\1</i>', '<u>\\1</u>', '<br />' );
		$msg = preg_replace ( $patterns, $replacements, $msg );
		return stripslashes ( stripslashes ( utf8_decode ( $msg ) ) );
	}
	
	// checkUsername function
	// Removes badwords and cleans up a user's name
	// Options: [user's name]
	function checkUsername($name) {
	    return $name;
		$bad_usernames = array ('admin', 'Administrator', 'administrator', 'ADMIN' );
		if ((empty ( $_SESSION ['ShoutCloud_Admin_Name'] )) && (empty ( $_SESSION ['ShoutCloud_Admin_Loggedin'] ))) {
			$bad_usernames [] = $this->adminUser;
		}
		$name = utf8_encode ( strip_tags ( $name ) );
		foreach ( $bad_usernames as $k => $n ) {
			if ($name == $n) {
				return false;
			}
		}
		return str_ireplace ( $this->badwords, '', $name );
	}
	// addMessage function
	// Cleans and applies new submitted shout
	// Options: [user], [message], [tag color]
	function addMessage($fullname,$user, $msg, $color) {
		JRequest::checkToken('get') or Core::PrintJson ( array ('error' => 'Vui lòng làm mới lại trang và thử lại!' ) );
		// return $this->jsonEncode ( array ('error' => 'Vui lòng làm mới lại trang và thử lại!' ) );
	    $fullname = utf8_encode($fullname);
	    //var_dump($fullname);exit;
		$user = $this->checkUsername ( $user );
		if ($user === false) {
			return $this->jsonEncode ( array ('error' => 'Bạn không thể sử dụng tên đó!' ) );
		}
		if (strlen ( utf8_decode ( $user ) ) > 25) {
			return $this->jsonEncode ( array ('error' => 'Tên của bạn quá dài!' ) );
		}
		$msg = utf8_encode ( addslashes ( strip_tags ( $msg ) ) );
		if (strlen ( $msg ) > 500) {
			return $this->jsonEncode ( array ('error' => 'Thông điệp của bạn quá dài! Hạn chế 500 ký tự.' ) );
		}
		if ((empty ( $user )) || ($user == 'Your Name')) {
			return $this->jsonEncode ( array ('error' => 'Xin vui lòng nhập tên của bạn!' ) );
		}
		if ((empty ( $msg )) || ($user == 'Message')) {
			return $this->jsonEncode ( array ('error' => 'Xin vui lòng nhập một tin nhắn!' ) );
		}
		if ($this->isBanned ( $_SERVER ['REMOTE_ADDR'] ) === true) {
			return $this->jsonEncode ( array ('error' => 'Bạn đang bị cấm này shoutbox.' ) );
		}
		if ((empty ( $_SESSION ['ShoutCloud-User'] )) || (! isset ( $_SESSION ['ShoutCloud-User'] )) || ($_SESSION ['ShoutCloud-User'] !== $user)) {
			$_SESSION ['ShoutCloud-User'] = $user;
		}
		if ((empty ( $_SESSION ['ShoutCloud_Tag_Color'] )) || ($_SESSION ['ShoutCloud_Tag_Color'] !== $color)) {
			$_SESSION ['ShoutCloud_Tag_Color'] = $color;
		}
		$allMsgs = unserialize ( file_get_contents ( $this->msgsFile ) );
		if (empty ( $_SESSION ['ShoutCloud-User-Flood'] )) {
			$_SESSION ['ShoutCloud-User-Flood'] = 0;
		}
		if ($_SESSION ['ShoutCloud-User-Flood'] > time ()) {
			return $this->jsonEncode ( array ('error' => 'Xin vui lòng không spam tin nhắn! Đợi 5 giây ở giữa 2 bài viết.' ) );
		}
		$_SESSION ['ShoutCloud-User-Flood'] = time () + 5;
		$allMsgs [] = array ('time' => time (), 'fullname'=>$fullname,'user' => $user, 'msg' => $msg, 'color' => $color, 'ip' => $_SERVER ['REMOTE_ADDR'] );
		$totalMsgs = count ( $allMsgs );
		if ($totalMsgs > 30) {
			$difference = ($totalMsgs - 30);
			$i = 1;
			$allMsgs = array_reverse ( $allMsgs, true );
			while ( $i <= $difference ) {
				$remove = array_pop ( $allMsgs );
				$i ++;
			}
			$allMsgs = array_reverse ( $allMsgs, true );
		} else {
			$difference = 0;
		}
		$msgFile = fopen ( $this->msgsFile, 'w' );
		if (fwrite ( $msgFile, serialize ( $allMsgs ) )) {
			fclose ( $msgFile );
			return $this->jsonEncode ( array ('status' => 'posted' ) );
		} else {
			fclose ( $msgFile );
			return $this->jsonEncode ( array ('error' => 'Thông điệp của bạn không thể được niêm yết tại thời điểm này.' ) );
		}
	}
	
	// adminLogin function
	// Handles the checking of admin password
	// Options: [user], [password]
	function adminLogin($user, $pass) {
		$pass = htmlentities ( strip_tags ( $pass ) );
		$user = htmlentities ( strip_tags ( $user ) );
		if (($pass == $this->adminPass) && ($user == $this->adminUser)) {
			$_SESSION ['ShoutCloud_Admin_Name'] = $user;
			$_SESSION ['ShoutCloud_Admin_Loggedin'] = 'true';
			return $this->jsonEncode ( array ('status' => 'loggedin' ) );
		} else {
			return $this->jsonEncode ( array ('error' => 'Tên đăng nhập không chính xác và/hoặc mật khẩu' ) );
		}
	}
	
	// adminLogout function
	// Handles logging out of an admin account
	// Options: none
	function adminLogout() {
		unset ( $_SESSION ['ShoutCloud_Admin_Name'] );
		unset ( $_SESSION ['ShoutCloud_Admin_Loggedin'] );
		return $this->jsonEncode ( array ('status' => 'loggedout' ) );
	}
	
	// isAdmin function
	// Checks if user is an admin
	// Options: none
	function isAdmin() {
		if ((! empty ( $_SESSION ['ShoutCloud_Admin_Name'] )) && (! empty ( $_SESSION ['ShoutCloud_Admin_Loggedin'] ))) {
			return true;
		} else {
			$this->jsonEncode ( array ('error' => 'Bạn không phải là một quản trị viên!' ) );
		}
	}
	
	// banUser function
	// Handles user bans by admins
	// Options: [user's name], [ip address], [expire time]
	function banUser($name, $ip, $expire) {
		$allBans = file_get_contents ( $this->bansFile );
		$bans = fopen ( $this->bansFile, 'w+' );
		if (! is_writable ( $this->bansFile )) {
			chmod ( $this->bansFile, 0666 );
		}
		$allBans = (filesize ( $this->bansFile ) == 0) ? array () : unserialize ( $allBans );
		$expire = ((empty ( $expire )) || ($expire == 0)) ? 0 : strtotime ( $expire );
		$allBans [$ip] = array ('name' => $name, 'expire' => $expire );
		fwrite ( $bans, serialize ( $allBans ) );
		fclose ( $bans );
		return $this->jsonEncode ( array ('status' => 'banned' ) );
	}
	
	// unbanUser function
	// Handles unbanning users
	// Options: [ip address], [type]
	function unbanUser($ip, $type = 'box') {
		$allBans = file_get_contents ( $this->bansFile );
		$bans = fopen ( $this->bansFile, 'w+' );
		if (! is_writable ( $this->bansFile )) {
			chmod ( $this->bansFile, 0666 );
		}
		$allBans = (filesize ( $this->bansFile ) == 0) ? array () : unserialize ( $allBans );
		if (array_key_exists ( $ip, $allBans )) {
			unset ( $allBans [$ip] );
		}
		fwrite ( $bans, serialize ( $allBans ) );
		fclose ( $bans );
		if ($type == 'box') {
			return $this->jsonEncode ( array ('status' => 'removed' ) );
		}
	}
	
	// isBanned function
	// Checks if user's IP is banned by an admin
	// Options: [ip address]
	function isBanned($ip) {
		$bans = fopen ( $this->bansFile, 'a+' );
		if (! is_writable ( $this->bansFile )) {
			chmod ( $this->bansFile, 0666 );
		}
		if (filesize ( $this->bansFile ) > 0) {
			$allBans = unserialize ( fread ( $bans, filesize ( $this->bansFile ) ) );
			fclose ( $bans );
			if (array_key_exists ( $ip, $allBans )) {
				if (($allBans [$ip] ['expire'] !== 0) && ($allBans [$ip] ['expire'] < time ())) {
					$this->unbanUser ( $ip, 'internal' );
					return false;
				}
				return true;
			} else {
				return false;
			}
		}
	}
	
	// deleteMessage function
	// Deletes specific message from the shout box
	// Options: [shout id]
	function deleteMessage($id) {
		$allMsgs = unserialize ( file_get_contents ( $this->msgsFile ) );
		$id = str_ireplace ( 'shoutid-', '', $id );
		$allMsgs [$id] = array ('time' => time (), 'user' => $user, 'msg' => $msg, 'color' => $color, 'ip' => $_SERVER ['REMOTE_ADDR'], 'status' => 'deleted' );
		$msgFile = fopen ( $this->msgsFile, 'w' );
		if (fwrite ( $msgFile, serialize ( $allMsgs ) )) {
			fclose ( $msgFile );
			return $this->jsonEncode ( array ('status' => 'deleted' ) );
		} else {
			fclose ( $msgFile );
			return $this->jsonEncode ( array ('error' => 'Không thể xóa tin nhắn. Xin vui lòng thử lại.' ) );
		}
	}
	
	// clearShoutbox function
	// Clears all the messages from the shoutbox
	// Options: none
	function clearShoutbox() {
		$msgFile = fopen ( $this->msgsFile, 'w+' );
		fwrite ( $msgFile, serialize ( (array (0 => array ('time' => 0, 'user' => 'Admin', 'msg' =>  utf8_encode('Kính chào các Anh Chị!. Chúng tôi rất trân trọng những ý kiến đóng góp của các Anh Chị trong quá trình sử dụng Phần mềm bằng cách: gửi email đến phuclh@danang.gov.vn, hoặc gọi điện [0511-3561344]. Trân trọng.') ) )) ) );
		fclose ( $msgFile );
		return $this->jsonEncode ( array ('status' => 'cleared' ) );
	}
	
	// formatTime function
	// Formats time for the Ban List
	// Options: [timestamp]
	function formatTime($ts) {
		$current = time ();
		$seconds = $ts - $current;
		if ($seconds < 1) {
			return false;
		}
		switch ($seconds) {
			case ($seconds < 60) :
				$unit = $var = $seconds;
				$var .= " second";
				break;
			case ($seconds < 3600) :
				$unit = $var = round ( $seconds / 60 );
				$var .= " minute";
				break;
			case ($seconds < 86400) :
				$unit = $var = round ( $seconds / 3600 );
				$var .= " hour";
				break;
			case ($seconds < 2629744) :
				$unit = $var = round ( $seconds / 86400 );
				$var .= " day";
				break;
			case ($seconds < 31556926) :
				$unit = $var = round ( $seconds / 2629744 );
				$var .= " month";
				break;
			default :
				$unit = $var = round ( $seconds / 31556926 );
				$var .= " year";
		}
		if ($unit > 1) {
			$var .= "s";
		}
		return $var;
	}
	
	function jsonEncode($var) {
		return json_encode ( $var );
	}
}