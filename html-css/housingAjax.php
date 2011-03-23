<?
include 'config.php';
include 'fnc/fnc.php';
conn();

function calculateDistance($lat1, $lon1, $lat2, $lon2, $unit) {
	if($lat1 and $lon1 and $lat2 and $lon2) {
		$theta = $lon1 - $lon2; 
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
		$dist = acos($dist); 
		$dist = rad2deg($dist); 
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);
		if ($unit == "K") {
			return ($miles * 1.609344); 
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
	} else {
		return false;
	}
}

function array_sort($array, $on, $order=SORT_ASC) {
	$new_array = array();
	$sortable_array = array();

	if (count($array) > 0) {
		foreach ($array as $k => $v) {
			if (is_array($v)) {
				foreach ($v as $k2 => $v2) {
					if ($k2 == $on) {
						$sortable_array[$k] = $v2;
					}
				}
			} else {
				$sortable_array[$k] = $v;
			}
		}

		switch ($order) {
			case SORT_ASC:
				asort($sortable_array);
			break;
			case SORT_DESC:
				arsort($sortable_array);
			break;
		}

		foreach ($sortable_array as $k => $v) {
			$new_array[$k] = $array[$k];
		}
	}
	
	return $new_array;
}

$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.urlencode($_GET['location']).'&sensor=false');
$output= json_decode($geocode);
$lat1 = $output->results[0]->geometry->location->lat;
$long1 = $output->results[0]->geometry->location->lng;
if($_GET['houseID']) {
	$sql = "SELECT h.*, u.first_name, u.last_name, u.cell_phone, u.email FROM housing h
	INNER JOIN houseref hr ON hr.house_id = h.id
	INNER JOIN user u ON u.id = hr.user_id
	WHERE h.id = '".$_GET['houseID']."'";
} else {
	$sql = "SELECT h.*, u.first_name, u.last_name, u.cell_phone, u.email FROM housing h
	INNER JOIN houseref hr ON hr.house_id = h.id
	INNER JOIN user u ON u.id = hr.user_id
	WHERE h.guest_capacity >= '".$_GET['people']."'";
	$sql .= isset($_GET['duration']) && $_GET['duration'] ? " AND h.duration >= '".$_GET['duration']."'" : '';
	$sql .= isset($_GET['children']) && $_GET['children'] ? " AND h.children_ok  = '1'" : '';
	$sql .= isset($_GET['dogs']) && $_GET['dogs'] ? " AND h.dogs_ok = '1'" : '';
	$sql .= isset($_GET['cats']) && $_GET['cats'] ? " AND h.cats_ok = '1'" : '';
	$sql .= isset($_GET['unoccupied']) && $_GET['unoccupied'] ? " AND h.unoccupied  != '1'" : '';
	$sql .= isset($_GET['no_children']) && $_GET['no_children'] ? " AND h.haskids != '1'" : '';
	$sql .= isset($_GET['no_dogs']) && $_GET['no_dogs'] ? " AND h.hasdogs != '1'" : '';
	$sql .= isset($_GET['no_cats']) && $_GET['no_cats'] ? " AND h.hascats != '1'" : '';
	$sql .= isset($_GET['guest_bathroom']) && $_GET['guest_bathroom'] ? " AND h.bathroom = '1'" : '';
	$sql .= isset($_GET['parking_available']) && $_GET['parking_available'] ? " AND h.parking = '1'" : '';
	$sql .= isset($_GET['baby_gear']) && $_GET['baby_gear'] ? " AND h.babygear = '1'" : '';
	$sql .= isset($_GET['pick_up']) && $_GET['pick_up'] ? " AND h.airport = '1'" : '';
}

$res = mysql_query($sql);
$i = 0;
while($row = mysql_fetch_assoc($res)) {
	$list[$i] = $row;
	$list[$i]['Distance'] = calculateDistance($lat1, $long1, $row['lat'], $row['long'], "K");
	$i++;
}
	
$ordByDistance = array_sort($list, 'Distance', SORT_ASC);

$limit = 8;
$leftright = 4;
$page = ($_GET['page']) ? $_GET['page'] : 1;
$start =  $page * $limit - ($limit);
$totalPages = ceil(count($ordByDistance) / $limit);
$list = array_slice($ordByDistance,$start,$limit);

foreach($_GET as $key => $val) {
	if($key == 'page') continue;
	if($key == 'houseID') continue;
	$url[] = $key.'='.$val;
}
$qUrl = implode('&',$url);
?>	
	
<? if(count($list) != 0) :?>
<div id="list-view">
	<img src="images/ajax-loader.gif" id="loading" />
	<? $n = 1;?>
	<? foreach($list as $item) :?>
		<div class="list-item">
			<? if($item['dispphone'] == '1' and $item['dispemail'] == '1') :?>
				<div class="contact-details-button <? echo translate("contact-details-lang");?> hasInfo ">
					<div class="showInfo">
					<? if($item['dispname'] == '1') :?>
					<? echo '<b>'.$item['first_name'].'</b>';?> 
					<? endif;?>
					<? if($item['dispphone'] == '1' and $item['cell_phone'] != '') :?>
					<? echo ': '.$item['cell_phone'];?>
					<? endif;?>
					<? if($item['dispemail'] == '1' and $item['email'] != '') :?>
					<? echo ' | <a href="mailto:'.$item['email'].'">'.$item['email'].'</a>';?>
					<? endif;?>
					</div>
				</div>
			<? else :?>
				<a href="send-message.php?email=<? echo $item['email'];?>"class="send-message-button <? echo translate("send-message-lang");?>"></a>
			<? endif;?>
			<div class="house-icon"><? echo $start + $n++;?></div>
			<h3><? echo number_format($item['Distance'], 1, '.', '');?>km <? //echo $item['location'];?></h3>
			<div class="clear"></div>
			<div class="left-box">
				<label><? echo translate("Up to");?>  <? echo $item['guest_capacity'];?> <? echo translate("people");?></label>
				<div class="clear"></div>
				<? echo ($item['children_ok'] == '1') ? '<div title="Accepts children" class="children"></div>' : '';?>
				<? echo ($item['dogs_ok'] == '1') ? '<div title="Accepts dogs" class="dogs"></div>' : '';?>
				<? echo ($item['cats_ok'] == '1') ? '<div title="Accepts cats" class="cats"></div>' : '';?>
				<? echo ($item['babygear'] == '1') ? '<div title="Has baby gear" class="baby"></div>' : '';?>
				<? echo ($item['airport'] == '1') ? '<div title="Can pickup" class="car"></div>' : '';?>
			</div>
			<div class="right-box">
				<p><? echo truncate($item['description'],MAX_DESC_CHARS);?></p>
			</div>
			<div class="clear"></div>
		</div>      
		<div class="clear"></div>
	<?  endforeach;	?>
	<? if($_GET['houseID']):?>
	<a href="housingAjax.php?<? echo $qUrl;?>" class="backToListing">Back to Full List</a>
	<? endif;?>
	<div class="pagination">
	<? if($totalPages != 1) :?>
		<? if($page == 1) :?>
			<div class="button left-disabled"></div>
		<? else:?>
			<a href="housingAjax.php?<? echo $qUrl;?>&page=<? echo $page - 1;?>"><div class="button left"></div></a>
		<? endif;?>
			<a href="housingAjax.php?<? echo $qUrl;?>&page=1"><div class="button <? echo ($page == 1) ? 'active' : '';?>">1</div></a>
		<? for($p = 2; $p <= $totalPages - 1; $p++) :?>
			<? if($p == $leftright + $page) :?>
				<div class="button">...</div>
			<? endif;?>
			<? if($p == $page - $leftright) :?>
				<div class="button">...</div>
			<? endif;?>
			<? if(($p > $leftright + $page - 1) or ($p < $page - $leftright + 1)) :?>
				<? continue;?>
			<? else :?>
				<a href="housingAjax.php?<? echo $qUrl;?>&page=<? echo $p;?>"><div class="button <? echo ($p == $page) ? 'active' : '';?>"><? echo $p;?></div></a>
			<? endif;?>
		<? endfor;?>
		
			<a href="housingAjax.php?<? echo $qUrl;?>&page=<? echo $totalPages;?>"><div class="button <? echo ($page == $totalPages) ? 'active' : '';?>"><? echo $totalPages;?></div></a>
		
		<? if($page < $totalPages) :?>
			<a href="housingAjax.php?<? echo $qUrl;?>&page=<? echo $page + 1;?>"><div class="button right"></div></a>
		<? else:?>
			<div class="button right-disabled"></div>
		<? endif;?>
	<? endif;?>
	</div>
	
</div>

<script type="text/javascript">
		$(".send-message-button").fancybox({
			modal : true,
			type: 'iframe',
			overlayOpacity : 0.9,
			overlayColor : '#000000',
			width : 450,
			height : 300,
			autoScale : false
		});

	$('.hasInfo').click(function() {
		$(this).removeClass('contact-details-button')
		$(this).children().show();
	});
	
	
	$(".pagination a").click(function() {
		$.ajax({
			type: "GET",
			url: $(this).attr('href'),
			beforeSend : function(){
				$(".list-item").css('opacity','0.5');
				$("#loading").show();
			},
			success: function(data) {
				if (data != "") {
					$("#list-view").html(data);	
				}
			},
			complete: function() {
				$(".list-item").css('opacity','1.0');
				$("#loading").hide();
			}
		});	
		return false;
	});			
	
	
	$(".backToListing").click(function() {
		$.ajax({
			type: "GET",
			url: $(this).attr('href'),
			beforeSend : function(){
				$(".list-item").css('opacity','0.5');
				$("#loading").show();
			},
			success: function(data) {
				if (data != "") {
					$("#list-view").html(data);	
					moveToPoint();
				}
			},
			complete: function() {
				$(".list-item").css('opacity','1.0');
				$("#loading").hide();
			}
		});	
		return false;
	});				
		
</script>
<? else :?>
	<div class="noResults">No results</div>
<? endif;?>
