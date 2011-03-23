<?
include '../config.php';
include '../fnc/fnc.php';
conn();
if(!user()){
	header('location: /');
	exit;
}

$houseInfo = houseInfo();
if($_POST['Submit']) {
	$houseInfo = array();
	foreach($_POST as $key => $val) {
		$houseInfo[$key] = $val;
	}
	$formError = checkHouseFormUpdate();
	if(!$formError) {
		$updateHouse = updateHouse();
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Your House to the Directory</title>
<link href="/css/main.css" rel="stylesheet" type="text/css" />
<link href="/css/popup.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
<? if($updateHouse['success']) :?>
<script language="javascript">
self.parent.location.href = '/Account/';
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
		if($updateHouse['error']) {
			displayError($updateHouse['error']);
		}
		?>
<form class="house-form" id="myForm" action="" method="post"> 
<h1>Update Listing</h1>
<table class="blue-box">
	<tr>
    	<td colspan="1"><label>I can host: </label>
        <!-- Arrangements -->
        <select name="guest_capacity">
        <option value="1"<? echo ($houseInfo['guest_capacity'] == '1') ? ' selected' : '';?>>1 person</option>
        <option value="2"<? echo ($houseInfo['guest_capacity'] == '2') ? ' selected' : '';?>>2 people</option>
        <option value="3"<? echo ($houseInfo['guest_capacity'] == '3') ? ' selected' : '';?>>3 people</option>
        <option value="4"<? echo ($houseInfo['guest_capacity'] == '4') ? ' selected' : '';?>>4 people</option>
        <option value="5"<? echo ($houseInfo['guest_capacity'] == '5') ? ' selected' : '';?>>5 people</option>
        <option value="6"<? echo ($houseInfo['guest_capacity'] == '6') ? ' selected' : '';?>>6 people</option>
        <option value="7"<? echo ($houseInfo['guest_capacity'] == '7') ? ' selected' : '';?>>7 people</option>
        <option value="8"<? echo ($houseInfo['guest_capacity'] == '8') ? ' selected' : '';?>>8 people</option>
        <option value="9"<? echo ($houseInfo['guest_capacity'] == '9') ? ' selected' : '';?>>9 people</option>
        <option value="10"<? echo ($houseInfo['guest_capacity'] == '10') ? ' selected' : '';?>>10 people</option>
        </select><br />
			</td>
			<td colspan="2"><label>Duration: </label>
				<select name="duration">
					<option value="1"<? echo ($houseInfo['duration'] == '1') ? ' selected' : '';?>>Less than a week</option>
					<option value="2"<? echo ($houseInfo['duration'] == '2') ? ' selected' : '';?>>Less than a month</option>
					<option value="3"<? echo ($houseInfo['duration'] == '3') ? ' selected' : '';?>>More than a month</option>
				</select>
			</td>
    </tr>
		<tr>
			<td colspan="3"><label>Location: </label><input class="text-input-long location" type="text" name="location" value="<? echo post($houseInfo['location']);?>" /> </td>
		</tr>
    <tr>
    	<td colspan="3"><div class="divider"></div></td>
    </tr>
   <tr>
			<td colspan="3">      
    		<label>Description of Housing: (max chars: </label> <label id="Chars"><? echo MAX_DESC_CHARS;?></label><label>)</label><br />
    		<textarea rows="4" cols="70" class="description" name="description" onclick="maxChars(this,'<? echo MAX_DESC_CHARS;?>','#Chars')"><? echo nl2br($houseInfo['description']);?></textarea> 
				<br />
       </td>
		</tr>
    
    
     <tr>
    	<td colspan="3"><div class="divider"></div></td>
    </tr>

    <tr >
    	<td valign="top" style="padding: 4px 0 0 0;" >
        <label style="margin: 8px 0 0 10px;">I allow:</label>
        	<div class="checkboxes" style="margin: 6px 0 0 16px;">
            <input type="checkbox" name="children_ok" value="1"<? echo ($houseInfo['children_ok']) ? ' checked' : '';?> /> <label>Children</label><br /> 
            <input type="checkbox" name="dogs_ok" value="1"<? echo ($houseInfo['dogs_ok']) ? ' checked' : '';?> /> <label>Dogs</label><br />
            <input type="checkbox" name="cats_ok" value="1"<? echo ($houseInfo['cats_ok']) ? ' checked' : '';?> /> <label>Cats</label><br />
            </div>
        </td>
        <td valign="top" style="padding: 4px 0 0 0;">
            <label style="margin: 8px 0 0 0;">I have:</label>	
        	<div class="checkboxes" style="margin: 6px 0 0 4px;">
             
            <input type="checkbox" name="haskids" value="1"<? echo ($houseInfo['haskids']) ? ' checked' : '';?> /><label> Children</label><br />
            <input type="checkbox" name="hascats" value="1"<? echo ($houseInfo['hascats']) ? ' checked' : '';?> /> <label>Cats</label><br />
            <input type="checkbox" name="hasdogs" value="1"<? echo ($houseInfo['hasdogs']) ? ' checked' : '';?> /> <label>Dogs</label><br />
            </div>
        </td>
        <td  valign="top" > 
        	<div class="checkboxes wide-col">
        		<input type="checkbox" name="airport" value="1"<? echo ($houseInfo['airport']) ? ' checked' : '';?> /> <label>Can provide initial transport</label><br />	  
            <input type="checkbox" name="parking" value="1"<? echo ($houseInfo['parking']) ? ' checked' : '';?> /> <label>Parking available</label><br />          
            <input type="checkbox" name="babygear" value="1"<? echo ($houseInfo['babygear']) ? ' checked' : '';?> /> <label>Baby gear is available</label><br />
            <input type="checkbox" name="bathroom" value="1"<? echo ($houseInfo['bathroom']) ? ' checked' : '';?> /> <label>Guest bathroom</label><br />
            <input type="checkbox" name="unoccupied" value="1"<? echo ($houseInfo['unoccupied']) ? ' checked' : '';?> /><label> My property is unoccupied</label>
            </div>     
        </td>
    </tr>
	
    <tr>
    	<td colspan="3"><div class="divider"></div></td>
    </tr>
</table>
    <div class="checkboxes">
    <div class="submit-and-toc">
     <input type="checkbox" tabindex="15" name="toc" value="1"<? echo ($houseInfo['toc']) ? ' checked' : '';?> /> <label>I agree with the <a target="_blank" href="/Disclaimer/">Terms of Use</a></label><br />          
    <input type="button" tabindex="27" name="Cancel" value="Cancel" class="cancelBtn" /> 
	<input type="submit" tabindex="26" name="Submit" value="Submit Comment" class="submitBtn" />
    </div>
    <input type="checkbox" tabindex="22" name="dispemail" value="1"<? echo ($houseInfo['dispemail']) ? ' checked' : '';?> /> <label>Display my email address for everyone to see</label> <br />      
    <input type="checkbox" tabindex="23" name="dispname" value="1"<? echo ($houseInfo['dispname']) ? ' checked' : '';?> /> <label>Display my name for everyone to see</label> <br />
    <input type="checkbox" tabindex="24" name="dispphone" value="1"<? echo ($houseInfo['dispphone']) ? ' checked' : '';?> /> <label>Display my phone number for everyone to see</label> <br />
			
    	
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
    
</form>

</div>
</body>
</html>