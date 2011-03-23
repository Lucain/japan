<?
include 'config.php';
include 'fnc/fnc.php';
conn();

if($_POST['Submit']) {
	$formError = checkHouseForm();
	if(!$formError) {
		$addHouse = addHouse();
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Your House to the Directory</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/popup.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 

<? if($addHouse['success']) :?>
	<script language="javascript">
	parent.document.location = '/Account/';
	</script>
<? endif;?>

<script type="text/javascript">
function maxChars(el,chr,show) {
	$(el).keyup(function() {
		var len = this.value.length;
		if (len >= chr) {
				this.value = this.value.substring(0, chr);
		}
		var txt = chr - len;
		if(txt < 0) {txt = 0}
		$(show).text(txt);
	});
}

$(document).ready(function() {
	$(".cancelBtn").click(function(){
		parent.$.fancybox.close();
	});
	$(".close").click(function(){
		parent.$.fancybox.close();
	});
	$(".location").click(function() {
		$(this).val('');
	});
})
</script>

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


</head>

<body id="popup">
	<div id="house-form">
		<a class="close"></a>
		<?
		if($formError) {
			displayError($formError);
		}
		if($addHouse['error']) {
			displayError($addHouse['error']);
		}
		?>
		<form class="house-form" id="myForm" action="" method="post"> 
		<? echo translate("Add Your House to the Directory");?>
		<table class="blue-box">
			<tr>
				<td colspan="1"><label><? echo translate("I can host");?>:</label>
					<!-- Arrangements -->
					<select tabindex="1" name="adults">
        <option value="1"<? echo ($_POST['adults'] == '1') ? ' selected' : '';?>><? echo translate("1 person");?></option>
        <option value="2"<? echo ($_POST['adults'] == '2') ? ' selected' : '';?>><? echo translate("2 people");?></option>
        <option value="3"<? echo ($_POST['adults'] == '3') ? ' selected' : '';?>><? echo translate("2 people");?></option>
        <option value="4"<? echo ($_POST['adults'] == '4') ? ' selected' : '';?>><? echo translate("4 people");?></option>
        <option value="5"<? echo ($_POST['adults'] == '5') ? ' selected' : '';?>><? echo translate("5 people");?></option>
        <option value="6"<? echo ($_POST['adults'] == '6') ? ' selected' : '';?>><? echo translate("6 people");?></option>
        <option value="7"<? echo ($_POST['adults'] == '7') ? ' selected' : '';?>><? echo translate("7 people");?></option>
        <option value="8"<? echo ($_POST['adults'] == '8') ? ' selected' : '';?>><? echo translate("8 people");?></option>
					</select><br />
				</td>
				<td colspan="2"><label><? echo translate("Duration");?>: </label>
					<select tabindex="2" name="duration">
					<option value="1"<? echo ($_POST['duration'] == '1') ? ' selected' : '';?>><? echo translate("Less than a week");?></option>
					<option value="2"<? echo ($_POST['duration'] == '2') ? ' selected' : '';?>><? echo translate("Less than a month");?></option>
					<option value="3"<? echo ($_POST['duration'] == '3') ? ' selected' : '';?>><? echo translate("More than a month");?></option>
					</select>
				</td>
			</tr>
			<tr>
				<?
				if(!$_POST['Submit']) {
					$location = translate("Example:  888 Sample Street, Sendai, Japan");
				} else {
					$location =  post($_POST['location']);
				}
				?>
				<td colspan="3"><input tabindex="3" class="text-input-long location" type="text"  name="location" value="<? echo $location;?>" /> <label class="location-label"> <? echo translate("Location");?>: </label></td>
			</tr>
			<tr>
				<td colspan="3"><div class="divider"></div></td>
			</tr>
		 <tr>
				<td colspan="3">      
					<label><? echo translate("Description of Housing");?>: (max chars: </label> <label id="Chars"><? echo MAX_DESC_CHARS;?></label><label>)</label><br />
					<textarea rows="4" tabindex="4" cols="70" class="description" name="description" onclick="maxChars(this,'<? echo MAX_DESC_CHARS;?>','#Chars')"><? echo $_POST['description'];?></textarea> 
					<br />
				</td>
			</tr>
			<tr>
				<td colspan="3"><div class="divider"></div></td>
			</tr>
			<tr >
				<td valign="top" style="padding: 4px 0 0 0;" >
					<label style="margin: 8px 0 0 10px;"><? echo translate("I allow");?>:</label>
					<div class="checkboxes" style="margin: 6px 0 0 16px;">
						<?
						if(!$_POST['Submit']) {
							$allowschildren = ' checked';
						} else {
							$allowschildren = ($_POST['allowschildren']) ? ' checked' : '';
						}
						?>
            <input type="checkbox" tabindex="5" name="allowschildren" value="1"<? echo $allowschildren;?> /> <label><? echo translate("Children");?></label><br /> 
            <input type="checkbox" tabindex="6" name="allowsdogs" value="1"<? echo ($_POST['allowsdogs']) ? ' checked' : '';?> /> <label><? echo translate("Dog(s)");?></label><br />
            <input type="checkbox" tabindex="7" name="allowscats" value="1"<? echo ($_POST['allowscats']) ? ' checked' : '';?> /> <label><? echo translate("Cat(s)");?></label><br />
					</div>
				</td>
				<td valign="top" style="padding: 4px 0 0 0;">
					<label style="margin: 8px 0 0 0;"><? echo translate("I have");?>:</label>	
					<div class="checkboxes" style="margin: 6px 0 0 4px;">
            <input type="checkbox" tabindex="8" name="haskids" value="1"<? echo ($_POST['haskids']) ? ' checked' : '';?> /> <label><? echo translate("Children");?></label><br />
            <input type="checkbox" tabindex="9" name="hasdogs" value="1"<? echo ($_POST['hasdogs']) ? ' checked' : '';?> /> <label><? echo translate("Dog(s)");?></label><br />
            <input type="checkbox" tabindex="10" name="hascats" value="1"<? echo ($_POST['hascats']) ? ' checked' : '';?> /> <label><? echo translate("Cat(s)");?></label><br />
					</div>
				</td>
				<td  valign="top" > 
					<div class="checkboxes wide-col">
        		<input type="checkbox" tabindex="11" name="airport" value="1"<? echo ($_POST['airport']) ? ' checked' : '';?> /> <label><? echo translate("Can provide initial transport");?></label><br />	  
            <input type="checkbox" tabindex="12" name="parking" value="1"<? echo ($_POST['parking']) ? ' checked' : '';?> /> <label><? echo translate("Parking available");?></label><br />          
            <input type="checkbox" tabindex="13" name="babygear" value="1"<? echo ($_POST['babygear']) ? ' checked' : '';?> /> <label><? echo translate("Baby gear is available");?></label><br />
            <input type="checkbox" tabindex="14" name="bathroom" value="1"<? echo ($_POST['bathroom']) ? ' checked' : '';?> /> <label><? echo translate("Guest bathroom");?></label><br />
            <input type="checkbox" tabindex="15" name="unoccupied" value="1"<? echo ($_POST['unoccupied']) ? ' checked' : '';?> /> <label><? echo translate("My property is unoccupied");?></label>
					</div>     
				</td>
			</tr>
			<tr>
				<td colspan="3"><div class="divider"></div></td>
			</tr>
			<tr>
        <td><label><? echo translate("First Name");?>:</label></td>
       	<td><label><? echo translate("Email Address");?>:</label></td> 
        <td><label><? echo translate("Password");?>:</label></td>
			</tr>  
			<tr>
				<td><input type="text" tabindex="16" name="firstname" class="text-input-mid" value="<? echo post($_POST['firstname']);?>" /></td>
				<td><input type="text" tabindex="18" name="email" class="text-input-mid" value="<? echo post($_POST['email']);?>" /></td>         
				<td><input type="password" tabindex="20" name="password" class="text-input-mid" value="<? echo post($_POST['password']);?>" /></td>        
			</tr>   
			<tr>
        <td><label><? echo translate("Last Name");?>:</label></td>
        <td><label><? echo translate("Mobile Phone (optional)");?>:</label></td>
       	<td><label><? echo translate("Confirm Password");?>:</label></td>
			</tr>   
			<tr>
				<td><input type="text" tabindex="17" name="lastname" class="text-input-mid" value="<? echo post($_POST['lastname']);?>" /></td>
				<td><input type="text" tabindex="19" name="cellphone" class="text-input-mid" value="<? echo post($_POST['cellphone']);?>" /></td>
				<td><input type="password" tabindex="21" name="confirmpassword" class="text-input-mid" value="<? echo post($_POST['confirmpassword']);?>" /></td>
			</tr>   
			<tr>
				<td colspan="3"><div class="divider"></div></td>
			</tr>
		</table>
		<?
		if(!$_POST['Submit']) {
			$dispemail = ' checked';
			$dispname = ' checked';
			$dispphone = ' checked';
		} else {
			$dispemail = ($_POST['dispemail']) ? ' checked' : '';
			$dispname = ($_POST['dispname']) ? ' checked' : '';
			$dispphone = ($_POST['dispphone']) ? ' checked' : '';
		}
		?>
		<div class="checkboxes">
			<div class="submit-and-toc">
				<input type="checkbox" tabindex="15" name="toc" value="1"<? echo ($_POST['toc']) ? ' checked' : '';?> /> <label><? echo translate("I agree with the ");?> <a target="_blank" href="/Disclaimer/"><? echo translate("Terms of Use");?></a></label><br />          
				<input type="button" tabindex="27" name="Cancel" value="Cancel" class="<? echo translate("cancel-lang");?> cancelBtn" /> 
				<input type="submit" tabindex="26" name="Submit" value="Submit Comment" class="<? echo translate("submit-lang");?> submitBtn" />
			</div>
				<input type="checkbox" tabindex="22" name="dispemail" value="1"<? echo $dispemail;?> /> <label><? echo translate("Display my email address for everyone to see");?></label> <br />      
				<input type="checkbox" tabindex="23" name="dispname" value="1"<? echo $dispname;?> /> <label><? echo translate("Display my name for everyone to see");?></label> <br />
				<input type="checkbox" tabindex="24" name="dispphone" value="1"<? echo $dispphone;?> /> <label><? echo translate("Display my phone number for everyone to see");?></label> <br />
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		</form>
	</div>
</body>
</html>