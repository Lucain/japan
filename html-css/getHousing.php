<?
include 'config.php';
include 'fnc/fnc.php';
conn();

$sql = "select h.id, h.`lat`, h.`long` from housing as h
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
$res = mysql_query($sql);

while($row = mysql_fetch_assoc($res)) {
	$housing[] = $row;
}
echo json_encode($housing);
?>