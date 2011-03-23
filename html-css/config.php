<?
session_start();
define('MAX_DESC_CHARS',590);
switch($_SERVER['HTTP_HOST']) {
	case 'lap.quakehousing' :
		define('DATABASE_HOST','localhost');
		define('DATABASE_USER','glavince');
		define('DATABASE_PASS','231030');
		define('DATABASE_NAME','japanese');
	break;
	case 'staging.quakehousing.com' :
		define('DATABASE_HOST','localhost');
		define('DATABASE_USER','staging');
		define('DATABASE_PASS','Spark123!');
		define('DATABASE_NAME','staging_quakehousing');
	break;
	default : 
		define('DATABASE_HOST','localhost');
		define('DATABASE_USER','sparkrelief');
		define('DATABASE_PASS','Spark123!');
		define('DATABASE_NAME','sparkrelief');
	break;
}
?>