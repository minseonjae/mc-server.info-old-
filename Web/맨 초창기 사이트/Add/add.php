<?php
	
	$user_json = json_decode(file_get_contents("http://whois.kisa.or.kr/openapi/ipascc.jsp?query=".$_SERVER['HTTP_CF_CONNECTING_IP']."&key=2017081816140737948733&answer=json"));
	
	$script = "";
	
	if (empty($user_json->whois->error)) {
		if ($user_json->whois->countryCode == "KR") {
			if (!empty($_POST['name']) && !empty($_POST['ip'])) {
				if (!empty($_POST['check'])) {
					$name = $_POST['name'];
					if (mb_strlen($name, "UTF-8") < 9) {
						$port = (empty($_POST['port']) ? 25565 : $_POST['port']);
						if (is_numeric($port)) {
						
							$name = $_POST['name'];
							$ip = $_POST['ip'];
				
							$srv = @dns_get_record('_minecraft._tcp.'.$ip, DNS_SRV);
				
							$host = $ip;
							$r_port = $port;
		
							if ($srv) {
								$ip = $srv[0]['target'];
								$port = $srv[0]['port'];
							}
							
							$main_ip = gethostbyname($ip);
							
							$server_json = json_decode(file_get_contents("http://whois.kisa.or.kr/openapi/ipascc.jsp?query=".$main_ip."&key=2017081816140737948733&answer=json"));
						
							if (empty($server_json->whois->error)) {
								if ($server_json->whois->countryCode == "KR") {
								
									include_once 'MinecraftServerStatus/status.class.php';
									$status = new MineCraftServerStatus();
								
									$server=$status->getStatus($ip, $port);
								
									if ($server) {
										$dir = "../API/List/";
							
										if ($dh = opendir($dir)) {
											$overlap = false;
								
											while (($file = readdir($dh)) !== false) {
												if (mb_strlen($file, 'UTF-8') < 6) continue;
												if (strtolower(substr($file, 0, strlen($file) - 5)) == strtolower($name)) {
													$overlap = true;
													break;
												}
												$server_info = json_decode(file_get_contents($dir.$file));
												if (empty($server_info->ip)) continue;
												if (strtolower($server_info->ip) == strtolower($host)) {
													$overlap = true;
													break;
												}
												$server_ip = $server_info->ip;
												$server_port = $server_info->port;
												$server_srv = @dns_get_record('_minecraft._tcp.'.$server_ip, DNS_SRV);
												if ($server_srv) {
													$server_ip = $server_srv[0]['target'];
													$server_port = $server_srv[0]['port'];
												}
												if (gethostbyname($server_ip) == $main_ip && $server_port == $port) {
													$overlap = true;
													break;
												}
											}
									
											if (!$overlap) {
												$server_j = fopen($dir.$name.".json", "w");
												$llog = "../../log/".date("Y년 m월 d일").".log";
												$log = fopen($llog, "ab");
												if ($server_j && $log) {
													$buffer = "";
													while (($char = fgetc($log)) !== false) {
														$buffer = $buffer.$char;
													}
													
													fwrite($log, $buffer."\n".date("[ H시 i분 s초 ]")." ".$_SERVER['HTTP_CF_CONNECTING_IP']." - ".$name." :: ".$host.":".$r_port);
													fwrite($server_j, '{
	"ip":"'.$host.'",	
	"port":'.$r_port.'
}');
													fclose($log);
													fclose($server_j);
													$script = "추가 성공!";
												} else $script = "에러! (2)";
											} else $script = "이름 또는 아이피 주소및 포트가 겹치는 서버가 있습니다!";
											closedir($dh);
										} else $script = "에러! (1)";
									} else $script = "해당 서버가 오프라인입니다.";
								} else $script = "해당 서버의 IP주소의 위치가 한국이 아닙니다.";
							} else $script = "해당 서버의 아이피또는 도메인이 잘못됐습니다.";
						} else $script = "포트에 숫자만 입력해주세요!";
					} else $script = "서버 이름은 8자이내로 적어주세요!";
				} else $script = "이용약관 및 개인정보 취급방침에 동의해주세요!";
			} else $script = "서버 이름 또는 주소를 입력해주세요!";
		} else $script = "이용자의 IP주소의 위치가 한국이 아닙니다!";
	} else $script = "이용자 IP주소 오류!";
?>
<html>
	<body>
		<script>
			alert("<?php echo $script; ?>");
			history.back();
		</script>
	</body>
</html>