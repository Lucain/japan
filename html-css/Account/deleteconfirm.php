<?
include '../config.php';
include '../fnc/fnc.php';
conn();
$user = user();
if(!$user) {
	header('location: /');
	exit;
}

if($_POST['Submit']) {
	$deleteHouse = deleteHouse();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Your House to the Directory</title>
<link href="../css/main.css" rel="stylesheet" type="text/css" />
<link href="../css/popup.css" rel="stylesheet" type="text/css" />
<link href="Account.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>

<? if($deleteHouse['success']) :?>
<script language="javascript">
	parent.document.location = '/Account/';
</script>
<? endif;?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22014441-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script type="text/javascript">
$(document).ready(function() {
	$(".cancelbutton").click(function(){
		parent.$.fancybox.close();
	});
	$(".closeDel").click(function(){
		parent.$.fancybox.close();
	});
})
</script>

</head>
<body>
	<a class="closeDel"></a>
	<div class="deleteconf">
		<?
		if($deleteHouse['error']) {
			displayError($deleteHouse['error']);
		}
		?>
	<form name="form" action="" method="post">
	<p>Are you sure you want to remove <?php echo $address; ?>?</p>
	<div class="cancelbutton"></div>
	<input type="submit" name="Submit" value="Submit" class="ok-button notext" />
</form>
</div>
</body>
</html>