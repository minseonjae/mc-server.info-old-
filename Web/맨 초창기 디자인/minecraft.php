<?php
$ip = $_GET["ip"];
$port = $_GET["port"];

include_once ('minecraftserver.php');

$status = new MinecraftServerStatus();

$main = $status->getStatus($ip, $port);

echo "서버 주소 : ".$ip."<br>";
echo "버전 : ".($main ? $main['version'] : "N/A")."<br>";
echo "인원 : ".($main ? $main['players']." / ".$main['maxplayers'] : "0 / 0")."<br>";
echo "핑 : ".($main ? $main['ping'] : "N/A");
?>