<?
include '../config.php';
include '../fnc/fnc.php';
unset($_SESSION['user']);
if(!user()){
	header('location: /');
}
?>
