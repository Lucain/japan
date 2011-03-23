<?
function checkForm() {
	if(empty($_POST['email'])) {$error[] = 'Please fill in "Email Address" field.';}
	if(!empty($_POST['email']) and (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['email']) == false)) $error[] = 'Please enter valid Email Address.';
	if(empty($_POST['message'])) $error[] =  'Please fill in the "Message" field.';
	
	if(count($error) != 0) {
		foreach($error as $e) {
			$out .= '<p>'.$e.'</p>';
		}
	} else {
		$out = false;
	}
	return $out;
}

function form() {
?>
	<form name="form" method="post" action="">
	<label>Your email:</label>
	<input type="text" name="email" class="text-input-mid" />
	<div class="clear"></div>
	<label>Message:</label>
	<textarea name="message" class="description"></textarea>
	
	<input type="button" name="Cancel" value="Cancel" class="cancelBtn" />
	<input type="submit" name="Submit" value="Submit" class="submitBtn" />
	<div class="clear"></div>
	</form>
<?
}

function sendMsg() {
	include 'includes/PHPMailer/sendMail.php';
	$mailto = $_GET['email'];
	$from = $_POST['email'];
	$subject = 'Message from ' . $from . ' via quakehousing.com' ;
	$mailcontent = nl2br($_POST['message']);
	return (send_mail($mailto, "noreply@quakehousing.com", "noreply@quakehousing.com", $subject, $mailcontent, $attachment)) ? true : false;
}
if($_POST['Submit']) {
	$errors = checkForm();
	if(!$errors) {
		if(sendMsg()) {
			$success = true;
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/popup.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(".x").click(function(){
		$('#errors').hide('slow');
	});
	$(".close").click(function(){
		parent.$.fancybox.close();
	});
	$(".cancelBtn").click(function(){
		parent.$.fancybox.close();
	});
	<? if($errors) :?>
	$('#errors').show('slow');
	<? endif;?>
})
</script>

</head>

<body id="popup">
<div id="message-form">
	<a class="close"></a>
<?
if($errors) {
	echo '<div id="errors">';
	echo '<a class="x"></a>';
	echo $errors;
	echo '</div>';
}

if($success) {
?>
<p class="success">Your message has been sent.</p>
<?
} else {
	form();
}
?>
</div>
</body>
</html>
