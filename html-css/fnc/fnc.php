<?
function conn() {
	mysql_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS) or die (mysql_error()) ;
	mysql_select_db(DATABASE_NAME) or die (mysql_error());
}

function safeSql($input) {
	if(get_magic_quotes_gpc()) {
		$input = stripslashes($input);
	}
	return mysql_real_escape_string($input);
}
function post($value) {
	$value = htmlspecialchars($value);
	return $value;
}
function truncate($text, $len = 120) {
	if(empty($text)) {
		 return "";
	}
	if(strlen($text)<$len) {
			return $text;
	}       
	return preg_match("/(.{1,$len})\s./ms", $text, $match) ? $match[1] ."..." : substr($text, 0, $len)."...";
}


function user() {
	if (!empty($_SESSION['user'])) {
		$data = false;
		foreach ($_SESSION['user'] as $key => $val) {
			$data -> $key = $val;
		}
		return $data;
	}
	return false;
}
function login() {
	$user = mysql_query("select * from `user` where email = '".safeSql($_POST['email'])."' and encrypted_password = '".md5(safeSql($_POST['password']))."'");
	if(mysql_num_rows($user) == '1') {
		$_SESSION['user'] = mysql_fetch_assoc($user);
		$login['success'] = true;
	} else {
		$login['error'][] = 'Invalid credentials.';
	}
	return $login;
}
function displayError($msgs) {
	$box .= '<script language="javascript">$(document).ready(function(){$("#errorBox").fadeIn("fast");$("#errorBox .x").click(function(){$("#errorBox").fadeOut("slow");});});</script>';
	$box .= '<div id="errorBox"><a class="x"></a>';
	foreach($msgs as $msg) {
		$box .= '<p>'.$msg.'</p>';
	}
	$box .= '</div>';
	echo $box;
}
function displaySuccess($msgs) {
	$box .= '<script language="javascript">$(document).ready(function(){$("#successBox").fadeIn("fast");$("#successBox .x").click(function(){$("#successBox").fadeOut("slow");});});</script>';
	$box .= '<div id="successBox"><a class="x"></a>';
	foreach($msgs as $msg) {
		$box .= '<p>'.$msg.'</p>';
	}
	$box .= '</div>';
	echo $box;
}

function checkHouseForm() {
	$checkEmail = mysql_result(mysql_query("select COUNT(*) as TOTAL from user where email = '".$_POST['email']."'"),0,"TOTAL");
	if($checkEmail != 0) {$error[] = 'User with this email address already exist. Please login and add house from your account.';}
	if($checkEmail == 0) {
		if(empty($_POST['location'])) $error[] = 'Please fill in "Location" field.';
		if(empty($_POST['description'])) $error[] = 'Please fill in "Description of Housing" field.';
		if(empty($_POST['firstname'])) $error[] = 'Please fill in "First Name" field.';
		if(empty($_POST['lastname'])) $error[] = 'Please fill in "Last Name" field.';
		if(empty($_POST['email'])) $error[] = 'Please fill in "Email Address" field.';
		if(!empty($_POST['email']) and (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['email']) == false)) $error[] = 'Please enter valid Email Address.';
		if(empty($_POST['password'])) $error[] =  'Please fill in the "Password" field.';
		if(empty($_POST['confirmpassword'])) $error[] = 'Please fill in the "Confirm Password" field.';
		if(!empty($_POST['password']) and !empty($_POST['confirmpassword']) and ($_POST['password'] != $_POST['confirmpassword'])) $error[] = 'Passwords didn\'t match';
		if(!$_POST['toc']) $error[] = 'Please agree with the Terms of Use';
	}
	if(count($error) != 0) {
		$out = $error;
	} else {
		$out = false;
	}
	return $out;
}

function addHouse() {
	$description = safeSql($_POST['description']);
	$location = safeSql($_POST['location']);
	$duration = safeSql($_POST['duration']);
	$guest_capacity = safeSql($_POST['adults']);
	$children_ok = ($_POST['allowschildren']) ? '1' : '0';
	$dogs_ok = ($_POST['allowsdogs']) ? '1' : '0';
	$cats_ok = ($_POST['allowscats']) ? '1' : '0';
	$haskids = ($_POST['haskids']) ? '1' : '0';
	$hascats = ($_POST['hascats']) ? '1' : '0';
	$hasdogs = ($_POST['hasdogs']) ? '1' : '0';
	$airport = ($_POST['airport']) ? '1' : '0';
	$babygear = ($_POST['babygear']) ? '1' : '0';
	$bathroom = ($_POST['bathroom']) ? '1' : '0';
	$unoccupied = ($_POST['unoccupied']) ? '1' : '0';
	$dispname = ($_POST['dispname']) ? '1' : '0';
	$dispemail = ($_POST['dispemail']) ? '1' : '0';
	$dispphone = ($_POST['dispphone']) ? '1' : '0';
	$parking = ($_POST['parking']) ? '1' : '0';

	$geocode = @file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.urlencode($location).'&sensor=false');
	$output= json_decode($geocode);
	$lat = $output->results[0]->geometry->location->lat;
	$long = $output->results[0]->geometry->location->lng;
	if(!$lat or !$long)  {$error[] = 'Location not found.';}

	if($lat and $long) {
		$createUser = mysql_query("insert into user (first_name, last_name, cell_phone, email, encrypted_password) values ('".safeSql($_POST['firstname'])."','".safeSql($_POST['lastname'])."','".safeSql($_POST['cellphone'])."','".safeSql($_POST['email'])."','".md5(safeSql($_POST['password']))."')");
		$userID = mysql_insert_id();
		if(!$createUser) {$error[] = 'Can not create user.';}
	}
	
	if($createUser) {
		$createHouse = mysql_query("insert into housing 
		(description, location, duration, guest_capacity, dogs_ok, cats_ok, children_ok, haskids, hascats, hasdogs, airport, babygear, bathroom, unoccupied, dispname, dispemail, dispphone, parking, `lat`, `long`) 
		values 
		('".$description."','".$location."','".$duration."','".$guest_capacity."','".$dogs_ok."','".$cats_ok."','".$children_ok."','".$haskids."','".$hascats."','".$hasdogs."','".$airport."','".$babygear."','".$bathroom."','".$unoccupied."','".$dispname."','".$dispemail."','".$dispphone."', '".$parking."','".$lat."','".$long."')");
		$houseID = mysql_insert_id();
		if(!$createHouse) {$error[] = 'Can not create house.';}
	}
	
	if($createHouse) {
		$houseref = mysql_query("insert into houseref (user_id, house_id) values ('".$userID."', '".$houseID."')");
		if(!$houseref) {$error[] = 'Can not create user house relation.';}
	}
	if(count($error) == 0) {
		$addHouse['success'] = true;
		login();
	} else {
		$addHouse['error'] = $error;
	}
	return $addHouse;
}
function checkUpdateAccount() {
	if(empty($_POST['first_name'])) $error[] = 'Please fill in "First Name" field.';
	if(empty($_POST['last_name'])) $error[] = 'Please fill in "Last Name" field.';
	if(!empty($_POST['password']) or !empty($_POST['password_confirm'])) {
		if($_POST['password'] != $_POST['password_confirm']) $error[] = 'Passwords didn\'t match';
	}
	if(count($error) != 0) {
		$out = $error;
	} else {
		$out = false;
	}
	return $out;
}
function updateAccount() {
	$sql = "update user set first_name = '".safeSql($_POST['first_name'])."', last_name = '".safeSql($_POST['last_name'])."', cell_phone = '".safeSql($_POST['cell_phone'])."'";
	if(!empty($_POST['password'])) $sql .= ", encrypted_password = '".md5(safeSql($_POST['password']))."'";
	$sql .= " where id = '".user()->id."'";
	
	$update = mysql_query($sql);
	if(!$update) {$error[] = 'Error updating Account.';}
	if(count($error) == 0) {
		$user = mysql_query("select * from `user` where id = '".user()->id."'");
		$_SESSION['user'] = mysql_fetch_assoc($user);
		$updateAccount['success'][] = 'Account has been successfully updated.';
		login();
	} else {
		$updateAccount['error'] = $error;
	}
	return $updateAccount;
}

function houseListing() {
	$res = mysql_query("select h.id, h.location from housing h INNER JOIN houseref hr ON hr.house_id = h.id and user_id = '".user()->id."'");
	while($row = mysql_fetch_assoc($res)) {
		$house[] = $row;
	}
	return $house;
}

function houseInfo() {
	$house = mysql_query("select * from housing where id = '".$_GET['houseID']."'");
	return $houseInfo = mysql_fetch_assoc($house);
}

function checkHouseFormUpdate() {
	if(empty($_POST['location'])) $error[] = 'Please fill in "Location" field.';
	if(empty($_POST['description'])) $error[] = 'Please fill in "Description of Housing" field.';
	if(!$_POST['toc']) $error[] = 'Please agree with the Terms of Use';
	if(count($error) != 0) {
		$out = $error;
	} else {
		$out = false;
	}
	return $out;
}

function updateHouse() {
	$description = safeSql($_POST['description']);
	$location = safeSql($_POST['location']);
	$duration = safeSql($_POST['duration']);
	$guest_capacity = safeSql($_POST['guest_capacity']);
	$children_ok = ($_POST['children_ok']) ? '1' : '0';
	$dogs_ok = ($_POST['dogs_ok']) ? '1' : '0';
	$cats_ok = ($_POST['cats_ok']) ? '1' : '0';
	$haskids = ($_POST['haskids']) ? '1' : '0';
	$hascats = ($_POST['hascats']) ? '1' : '0';
	$hasdogs = ($_POST['hasdogs']) ? '1' : '0';
	$airport = ($_POST['airport']) ? '1' : '0';
	$babygear = ($_POST['babygear']) ? '1' : '0';
	$bathroom = ($_POST['bathroom']) ? '1' : '0';
	$unoccupied = ($_POST['unoccupied']) ? '1' : '0';
	$dispname = ($_POST['dispname']) ? '1' : '0';
	$dispemail = ($_POST['dispemail']) ? '1' : '0';
	$dispphone = ($_POST['dispphone']) ? '1' : '0';
	$parking = ($_POST['parking']) ? '1' : '0';

	$geocode = @file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.urlencode($location).'&sensor=false');
	$output= json_decode($geocode);
	$lat = $output->results[0]->geometry->location->lat;
	$long = $output->results[0]->geometry->location->lng;
	if(!$lat or !$long) $error[] = 'Location not found.';
	
	
	$sql = "UPDATE housing SET description='$description', location='$location', duration='$duration', guest_capacity='$guest_capacity', dogs_ok='$dogs_ok', cats_ok='$cats_ok', children_ok='$children_ok', haskids='$haskids', hascats='$hascats', hasdogs='$hasdogs', airport='$airport', babygear='$babygear', bathroom='$bathroom', unoccupied='$unoccupied', dispname='$dispname', dispemail='$dispemail', dispphone='$dispphone', parking='$parking', lat='$lat', `long`='$long' WHERE id='".$_GET['houseID']."'";
		
	$update = mysql_query($sql);
	if(!$update)  $error[] = 'Error updating house';
	if(count($error) == 0) {
		$updateHouse['success'] = true;
	} else {
		$updateHouse['error'] = $error;
	}
	return $updateHouse;
}

function checkHouseFormAddNew() {
	if(empty($_POST['location'])) {$error[] = 'Please fill in "Location" field.';}
	if(empty($_POST['description'])) {$error[] = 'Please fill in "Description of Housing" field.';}
	if(!$_POST['toc']) $error[] = 'Please agree with the Terms of Use';
	if(count($error) != 0) {
		$out = $error;
	} else {
		$out = false;
	}
	return $out;
}

function AddNewHouse() {
		
	$description = safeSql($_POST['description']);
	$location = safeSql($_POST['location']);
	$duration = safeSql($_POST['duration']);
	$guest_capacity = safeSql($_POST['adults']);
	$children_ok = ($_POST['allowschildren']) ? '1' : '0';
	$dogs_ok = ($_POST['allowsdogs']) ? '1' : '0';
	$cats_ok = ($_POST['allowscats']) ? '1' : '0';
	$haskids = ($_POST['haskids']) ? '1' : '0';
	$hascats = ($_POST['hascats']) ? '1' : '0';
	$hasdogs = ($_POST['hasdogs']) ? '1' : '0';
	$airport = ($_POST['airport']) ? '1' : '0';
	$babygear = ($_POST['babygear']) ? '1' : '0';
	$bathroom = ($_POST['bathroom']) ? '1' : '0';
	$unoccupied = ($_POST['unoccupied']) ? '1' : '0';
	$dispname = ($_POST['dispname']) ? '1' : '0';
	$dispemail = ($_POST['dispemail']) ? '1' : '0';
	$dispphone = ($_POST['dispphone']) ? '1' : '0';
	$parking = ($_POST['parking']) ? '1' : '0';

	$geocode = @file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.urlencode($location).'&sensor=false');
	$output= json_decode($geocode);
	$lat = $output->results[0]->geometry->location->lat;
	$long = $output->results[0]->geometry->location->lng;
	if(!$lat or !$long)  {$error[] = 'Location not found.';}

	if($lat and $long) {
		$createHouse = mysql_query("insert into housing 
		(description, location, duration, guest_capacity, dogs_ok, cats_ok, children_ok, haskids, hascats, hasdogs, airport, babygear, bathroom, unoccupied, dispname, dispemail, dispphone, parking, `lat`, `long`) 
		values 
		('".$description."','".$location."','".$duration."','".$guest_capacity."','".$dogs_ok."','".$cats_ok."','".$children_ok."','".$haskids."','".$hascats."','".$hasdogs."','".$airport."','".$babygear."','".$bathroom."','".$unoccupied."','".$dispname."','".$dispemail."','".$dispphone."', '".$parking."','".$lat."','".$long."')");
		$houseID = mysql_insert_id();
		if(!$createHouse) {$error[] = 'Can not create house.';}
	}
	
	if($createHouse) {
		$houseref = mysql_query("insert into houseref (user_id, house_id) values ('".user()->id."', '".$houseID."')");
		if(!$houseref) {$error[] = 'Can not create user house relation.';}
	}
	
	if(count($error) == 0) {
		$addHouse['success'] = true;
		login();
	} else {
		$addHouse['error'] = $error;
	}
	return $addHouse;
}

function deleteHouse() {
	$check = mysql_query("select h.* from housing h
	INNER JOIN houseref hr ON hr.house_id = h.id
	INNER JOIN user u ON u.id = hr.user_id and u.id = '".user()->id."'
	WHERE h.id = '".$_GET['houseID']."'");
	
	if(mysql_num_rows($check) == '1') {
		$delete = mysql_query("delete from housing where id = '".$_GET['houseID']."'");
		$delete = mysql_query("delete from houseref where user_id = '".user()->id."' and house_id = '".$_GET['houseID']."'");
	}
	if($delete) {
		$deleteHouse['success'] = true;
	} else {
		$deleteHouse['error'][] = 'You have no permissions to delete this house';
	}
	return $deleteHouse;
}
function translate($translateMe) {

	if($_POST['lang']) {
		$_SESSION['language'] = $_POST['lang'];
	}
	if(!isset($_SESSION['language'])){
		if(substr(strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']), 0, 2) == 'ja') {
			$_SESSION['language'] = "Japanese";
		} else {
			$_SESSION['language'] = "English";
		}
	}

	switch($_SESSION['language']) {
		case "Japanese": {
			switch ($translateMe) {
				case "main-lang": return "main-japanese";
				case "donate-lang": return "donate-japanese";
				case "join-lang": return "join-japanese";
				case "contact-details-lang": return "contact-details-japanese";
				case "subscribe-button-lang": return "subscribe-button-japanese";
				case "send-message-lang": return "send-message-japanese";
				case "cancel-lang": return "cancel-japanese";
				case "submit-lang": return "submit-japanese";
				case "Sparkrelief": return "スパーク  リリフ";
				case "Near": return "エリア";
				case "I need a room for":  return "部屋の必要があるか";
				case "1 person":  	return "一人";
				case "2 people":  	return "二人";
				case "3 people":  	return "三人";
				case "4 people":  	return "四人";
				case "5 people":  	return "五人";
				case "6 people":  	return "六人";
				case "7 people":  	return "七人";
				case "8 people":  	return "ハ人";
				case "Children":  	return "子供";
				case "Dog(s)":	  	return "犬";
				case "Cat(s)":		return "猫";
				case "Preferences":	return "優先";
				case "Unoccupied":	return "有人がいない";
				case "No Children": return "子供がいない";
				case "No Dogs":		return "犬がいない";
				case "No Cats":		return "猫がいない";
				case "Guest Bathroom": return "お客様のお手洗い";
				case "Parking Available": return "駐車場がある";
				case "Other Services": return "他の貢献";
				case "Has Baby Gear": return "赤ちゃんの装備";
				case "Can Pick Up": return "拾うことができる";
				case "Housing":		return "住宅";
				case "Forum":		return "フォーラム";
				case "Login":		return "ログイン";
				case "Join Us":		return "登録する";
				case "Up to": return "最大";
				case "people": return "人";
				case "View Contact Details": return "連絡先";
				case "Join the Relief Effort": return "救援チームに入る";
				case "Get Updates From Sparkrelief": return "電気メールを更新";
				case "Subscribe": 	return "購読する";
				case "Your Relief Team": return "救済のチーム";
				case "All Rights Reserved": return "著作権";
				case "Privacy Policy": return "プライバツーの政策";
				case "Legal Disclaimer": return "法的の免責";
				case "Terms of Use": return "法的の免責";
				case "Less than a week": return "一週間未満";
				case "Less than a month": return "一カ月みまん";
				case "More than a month": return "一カ月以上";
				case "Add Your House to the Directory": return "避難場所を提供しましょう！";
				case "I can host": return "受け入れ可能人数";
				case "Duration": return "受け入れ可能期間";
				case "Less than a week": return "一週間以内";
				case "less than a month": return "一か月以内";
				case "More than a month": return "一か月以上";
				case "Location": return "場所";
				case "Example:  888 Sample Street, Sendai, Japan": return "住所";
				case "Description of Housing": return "施設（家）の詳細";
				case "I allow": return "受け入れられます";
				case "I have": return "うちには";
				case "Can provide initial transport": return "送迎可能です";
				case "Parking available": return "駐車場があります";
				case "Baby gear is available": return "赤ちゃん用品が整っています";
				case "Guest bathroom": return "ゲスト用トイレがあります";
				case "My property is unoccupied": return "現在使っていない空き家です";
				case "First Name": return "名前";
				case "Last Name": return "苗字";
				case "Email Address": return "Eメールアドレス";
				case "Mobile Phone (optional)": return "電話（任意）";
				case "Password": return "パスワード";
				case "Confirm Password": return "パスワード確認";
				case "Guest bathroom": return "ゲスト用トイレがあります";
				case "First Name": return "パスワード";
				case "I agree with the ": return "契約する ";
				case "Display my email address for everyone to see": return "メールアドレスを全員に見えるようにする";
				case "Display my name for everyone to see": return "名前を全員に見えるようにする";
				case "Display my phone number for everyone to see": return "電話番号を全員に見えるようにする";
				case "Sparkrelief.org: Offer housing to those in need, or find housing if you are displaced.": return " 住宅を与える。避難の人は 住宅を見附る。";
			}
		}
		case "English":  {
			return $translateMe;
		}
	}
	return $translateMe;
}

?>