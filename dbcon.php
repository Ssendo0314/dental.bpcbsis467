<?php
//connection
//Offline
// $host ='localhost';
// $username = 'root';
// $password = '';
// $datebase = 'dental'; //Database name: dental

// online
$host ='localhost';
$username = 'u670315191_dental';//it can be seen on the Dashboard of hosting
$password = '#Moonlight0320'; //it can be seen on the Dashboard of hosting
$datebase = 'u670315191_dental'; //Database name: epiz_33563075_glow table: users

//create connection
$conn = mysqli_connect($host,$username,$password,$datebase); //this connection
if(!$conn){
	echo "Connection Failed: ".mysqli_error($conn);
	exit;
}
?>
