<?php 
date_default_timezone_set('Asia/Makassar');
// include('koneksi.php');
// $jam = date('H:i:s');
// $querytambah = mysqli_query($koneksi, "INSERT INTO suhu VALUES(NULL, '$jam')") or die(mysqli_error());

$client = new Mosquitto\Client();
$client->onConnect('connect');
$client->onDisconnect('disconnect');
$client->onSubscribe('subscribe');
$client->onMessage('message');
$client->connect("188.166.239.119", 1883, 5);
$client->subscribe('sensorSuhuSave', 1);

while (true) {
	$client->loop();
	sleep(2);
}

$client->disconnect();
unset($client);

function connect($r) {
	echo "I got code {$r}\n";
}

function subscribe() {
	echo "Subscribed to a topic\n";
}

function message($message) {
	include('koneksi.php');
	printf("\nGot a message on topic %s with payload:%s", 
		$message->topic, $message->payload);
	$tahun = date('Y');
	$bulan = date('M');
	$jam = date('H:i:s');
	$hari = date('l');
	$suhu = $message->payload;
	$querytambah = mysqli_query($koneksi, "INSERT INTO suhu_log VALUES(NULL, '$jam', '$bulan', '$tahun', '$hari', '$suhu')") or die(mysqli_error());
}

function disconnect() {
	echo "Disconnected cleanly\n";
}

