<div class="top-nav">
<?		
$directory = array_pop(explode("/", getcwd()));
if(($_SERVER['SCRIPT_NAME'] == "/index.php") && ($directory == "httpdocs")) {
?>
	<div class="item active">
		<img src="/images/nav-house-icon.png" />
		<div class="clear"></div>
		<label><? echo translate("Housing");?></label>
	</div>
<?
} else {
?>
	<a href="/">
		<div class="item">
			<img src="/images/nav-house-icon.png" />
			<div class="clear"></div>
			<label><? echo translate("Housing");?></label>
		</div>
	</a>
<?
}
?>
	<a href="/forums/" target="_blank">
		<div class="item">
			<img src="/images/nav-chat-icon.png" />
			<div class="clear"></div>
			<label><? echo translate("Forum");?></label>
		</div>
	</a>
</div>
<div class="login-join">
<?
if($user) {
?>
	<div class="account-box">
		<a href="/Logout/" class="logout-link">Logout</a>
		<br />
		Logged in as: <a href="/Account/" class="account-link"><? echo $user->email; ?></a>
	</div>
<?
} else {
?>
	<div class="loginLink">
		<a href="/loginform.php" class="login-link"><? echo translate("Login");?></a> or 
	</div>
	<a href="/houseform.php" class="fb join-button <? echo translate("join-lang");?>"></a>
<?
}
?>
</div>
<div class="clear"></div>
