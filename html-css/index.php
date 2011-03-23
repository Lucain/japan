<?
include 'config.php';
include 'fnc/fnc.php';
conn();
$user = user();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<? include 'includes/head.php';?>
<script type="text/javascript"  src="http://maps.google.com/maps/api/js?sensor=false"></script>
<title><? echo translate("Sparkrelief");?> | Japanese Earthquake Relief</title>
<script type="text/javascript">

	$(document).ready(function() {
		initializeMap(); 
		buildQueryUrl();
		$("#filter-form #location").change(buildQueryUrl, moveToPoint);
		$("#filter-form select").change(function() {
			buildQueryUrl();
			clearHousing();
			loadHousing();
			});
		$("#filter-form :checkbox").click(function() {
			buildQueryUrl();
			clearHousing();
			loadHousing();
			});
		$("#filter-form").keypress(function(e) {
			if (e.which == 13) {
				buildQueryUrl();
				moveToPoint();
				return false;
			}
		});
	});

	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-22014441-1']);
	_gaq.push(['_trackPageview']);
	
	(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	
</script> 
<meta name="description" content="Help those displaced in the Japanese earthquake." />
</head>
<body>
<div class="wrapper">
	<div class="translate-tab">
		<form action="/" method="post">
				<input type="hidden" id="lang" name="lang" value="Japanese" />
				<input type="submit" value="" class="japan-flag <? if( $_SESSION['language'] == "Japanese"){echo 'active';}?> " />
			</form>
			<form action="/" method="post">
				<input type="hidden" id="lang" name="lang" value="English" />
				<input type="submit" value="" class="us-flag <? if( $_SESSION['language'] == "English"){echo 'active';}?> " />
			</form>
    </div>
  <div class="main <? echo translate("main-lang");?>">
  	<?php require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/mainNav.php'); ?>
  
  	<div class="filter-box">
        	 <a href="/index.php"><div class="logo"></div></a>  <h2><? echo translate("Near");?>:</h2>
				<form id="filter-form" method="post">
        	<input class="location" name="location" id="location" type="text" value="Fukushima" />        
            <h2><? echo translate("I need a room for");?>:</h2>
						<select name="people">
          	<option value="1"><? echo translate("1 person");?></option>
						<option value="2"><? echo translate("2 people");?></option>
            <option value="3"><? echo translate("3 people");?></option>
            <option value="4"><? echo translate("4 people");?></option>
            <option value="5"><? echo translate("5 people");?></option>
            <option value="6"><? echo translate("6 people");?></option>
            <option value="7"><? echo translate("7 people");?></option>
            <option value="8"><? echo translate("8 people");?></option>
            </select>
            <br />
            <select name="duration">
          	<option value="1"><? echo translate("Less than a week");?></option>
						<option value="2"><? echo translate("Less than a month");?></option>
            <option value="3"><? echo translate("More than a month");?></option>
            </select>
            <br />
            <input class="check" type="checkbox" name="children" value="1" /><label><? echo translate("Children");?></label><br />
            <input class="check" type="checkbox" name="dogs" value="1" /><label><? echo translate("Dog(s)");?></label><br />
            <input class="check" type="checkbox" name="cats" value="1" /><label><? echo translate("Cat(s)");?></label>
            <div class="divider"></div>
            <h2><? echo translate("Preferences");?>:</h2>
            <input class="check" type="checkbox" name="unoccupied" value="1" /><label><? echo translate("Unoccupied");?></label><br />
            <input class="check" type="checkbox" name="no_children" value="1" /><label><? echo translate("No Children");?></label><br />
            <input class="check" type="checkbox" name="no_dogs" value="1" /><label><? echo translate("No Dogs");?></label><br />
            <input class="check" type="checkbox" name="no_cats" value="1" /><label><? echo translate("No Cats");?></label><br />
            <input class="check" type="checkbox" name="guest_bathroom" value="1" /><label><? echo translate("Guest Bathroom");?></label><br />
            <input class="check" type="checkbox" name="parking_available" value="1" /><label><? echo translate("Parking Available");?></label><br />
            <div class="divider"></div>
            <h2><? echo translate("Other Services");?>:</h2>
            <input class="check" type="checkbox" name="baby_gear" value="1" /><label><? echo translate("Has Baby Gear");?></label><br />
            <input class="check" type="checkbox" name="pick_up" value="1" /><label><? echo translate("Can Pick Up");?></label>
					</form>
    	<div class="donate">
    		<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CBNV2DXGWUBXQ" target="_blank"><div class="donate-button <? echo translate("donate-lang");?>"></div></a>
			</div>
    </div>
    <div class="map-box">
			<div class="map-box-top"></div>
			<div class="map-box-middle">
				<div class="what-is-quakehousing"><p><? echo translate("Sparkrelief.org: Offer housing to those in need, or find housing if you are displaced.");?></p></div>
				<div id="map_canvas" style="height:370px; width: 760px;"></div> 
			</div>
			<div class="map-box-bottom"></div>
			
			<!--LIST VIEW-->
			<div class="map-box-top"></div>
			<div class="map-box-middle" id="house_list_container">
				<div id="list-view"><img src="images/ajax-loader.gif" id="loading" /></div>
			</div>
			<div class="map-box-bottom"></div>
    </div>
		
  </div>
  <div class="push"></div>
</div>
<div class="clear"></div>
<? include 'includes/footer.php';?>
</body>
</html>
