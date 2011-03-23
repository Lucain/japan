<?
include 'config.php';
include 'fnc/fnc.php';
conn();
if($_POST['Submit']) {
	$login = login();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="background: white;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link href="/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/js/fancybox/jquery.fancybox-1.3.1.js"></script>
<? if($login['success']) :?>
<script language="javascript">
	parent.document.location = '/Account/';
</script>
<? endif;?>

</head>

<body id="login-form-body">
<?
	if($login['error']) {
		displayError($login['error']);
	}
?>
	<form class="login-form" id="myForm" action="/loginform.php" method="post"> 
		<a class="close-button" href="#" onclick="parent.jQuery.fancybox.close()" title="close">close</a>
		<img src="images/login-logo.png" alt="Login logo" />
		<table>
			<tr>
				<td>
					<label>Email:</label><br />
					<input type="text" name="email" class="text-input-mid" value="<? echo $_POST['email'];?>" /><br />
					<label>Password:</label><br />
					<input type="password" name="password" class="text-input-mid" value="" /><br />
					<div class="buttonrow">
						<input type="submit" name="Submit" class="submit-button" value="Submit" />
						<a href="#" onclick="parent.jQuery.fancybox.close()" class="cancel-button"/></a>
					</div>
				</td>
				<td>
					<div class="divider"></div>
					<div class="right-box">
						<a href="#">Forgot Password</a><br />
						<a href="#">Get An Account</a><br />
					</div>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>