<?
include '../config.php';
include '../fnc/fnc.php';
conn();
$user = user();
$houseListing = houseListing();
if(!$user) {
	header('location: /');
	exit;
}
if($_POST['Submit']) {
	foreach($_POST as $key => $val) {
		$user->$key = $val;
	}
	$formError = checkUpdateAccount();
	if(!$formError) {
		$updateAccount = updateAccount();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<? include '../includes/head.php'; ?>
	<title>Japanese Earthquake Relief |  Sparkrelief</title>
	<link href="/Account/Account.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
	$(document).ready(function() {
		$("a.deleteconfirm").fancybox({
			type: 'iframe',
			overlayOpacity : 0.9,
			overlayColor : '#000000',
			width : 410,
			height : 190,
			modal : 'true'
		});
		$("a.addnewform").fancybox({
			type: 'iframe',
			overlayOpacity : 0.9,
			overlayColor : '#000000',
			width : 800,
			height : 500,
			modal : 'true'
		});
	});
	</script>
</head>
<body>
<div class="wrapper">
	<div class="translate-tab">
		<form action="index.php" method="post">
				<input type="hidden" id="lang" name="lang" value="Japanese" />
				<input type="submit" value="" class="japan-flag <? if( $_SESSION['language'] == "Japanese"){echo 'active';}?> " />
			</form>
			<form action="index.php" method="post">
				<input type="hidden" id="lang" name="lang" value="English" />
				<input type="submit" value="" class="us-flag <? if( $_SESSION['language'] == "English"){echo 'active';}?> " />
			</form>
	</div>
  <div class="main">
  	<? include '../includes/mainNav.php'; ?>
  	<div class="filter-box">
     <a href="/index.php"><div class="logo"></div></a>  <div class="donate">
    	<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CBNV2DXGWUBXQ" target="_blank"> <div class="donate-button <? echo translate("donate-lang");?>"></div></a>
		</div>
	</div>
	<div class="map-box">
		<div class="map-box-top"></div>
		<div class="map-box-middle" style="position:relative;">
			<?
			if($formError) {
				displayError($formError);
			}
			if($updateAccount['error']) {
				displayError($updateAccount['error']);
			}
			if($updateAccount['success']) {
				displaySuccess($updateAccount['success']);
			}
			?>

			<h2>Account Details - <span><? echo $user->email; ?></span></h2>
				<form action="" method="post" name="account-details" class="account-form">
					<table width="760px" class="account-info">
						<tr>
							<td width="185">
								<label>First Name:</label><br />
								<input type="text" name="first_name" class="text-input-mid" value="<?php echo $user->first_name; ?>" /><br />
							</td>
							<td width="195">
								<label>New Password:</label><br />
								<input type="password" name="password" class="text-input-mid" value="<?php //echo user()->getField('password'); ?>" /><br />
							</td>
							<td rowspan="3" valign="top">
								<label>Listings:</label>
									<?
									if(is_array($houseListing)) {
										foreach($houseListing as $house) {
										echo "<div class=\"listing\">";
										echo "<div class=\"listing-address\">".substr($house['location'],0,40)."</div>";
										echo "<div class=\"listing-delete\"><a class=\"deleteconfirm\" href=\"deleteconfirm.php?houseID=".$house['id']."\"><img src=\"../images/delete-icon.png\"></a></div>";
										echo "<div class=\"listing-pencil\"><a href=\"updateform.php?houseID=".$house['id']."\" class=\"fb\"><img src=\"../images/pencil-icon.png\"></a></div>";
										echo "<div class=\"clear\"></div>";
										echo "</div>";
										}
									}
								?>
							</td>
						</tr>
						<tr>
							<td>
								<label>Last Name:</label><br />
								<input type="text" name="last_name" class="text-input-mid" value="<?php echo $user->last_name; ?>" /><br />
							</td>
							<td>
								<label>Confirm New Password:</label><br />
								<input type="password" name="password_confirm" class="text-input-mid" value="" /><br />
							</td>
						</tr>
					<tr>
						<td>
							<label>Cell Phone:</label><br />
							<input type="text" name="cell_phone" class="text-input-mid" value="<?php echo $user->cell_phone; ?>" /><br />
						</td>
						<td>&nbsp;
							
						</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
						<td>
							<div class="buttonrow">
								<input type="submit" name="Submit" class="save-changes-button notext" value="Submit" />
								<a href="/Account/" class="cancel-button"/></a>
							</div>
						</td>
						<td>
							<a class="fb" href="addnew.php?user_id=<?php echo $user->id; ?>"><div class="add-new-accomodation"></div></a>
						</td>
					</tr>
				</table>
			</form>
			<!-- END CONTENT -->
		</div>
	<div class="map-box-bottom"></div>
</div>
</div>
  <div class="push"></div>
</div>
<? include '../includes/footer.php';?>

</body>
</html>
