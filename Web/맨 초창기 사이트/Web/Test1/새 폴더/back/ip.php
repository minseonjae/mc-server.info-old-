<?php
	$ip = $_GET["ip"];
	$from = $ip;
	$result= dns_get_record('_minecraft._tcp.'.$ip,DNS_SRV) or die("SRV 해석 중 오류가 발생했습니다!");
	
	if ($result) $ip=$result[0]['target'];
	
	if (substr_count($ip , '.') != 4) $ip = gethostbyname($ip);
	
	
	
	$json = json_decode(file_get_contents("http://whois.kisa.or.kr/openapi/whois.jsp?query=".$ip."&key=2017081816140737948733&answer=json"));
	
	echo 'From IP : '.$from.'<br>';
	echo 'To IP : '.$ip.'<br>';
	if (!empty($json->whois->error)) {
		echo "에러 ".$json->whois->error->error_code." : ".$json->whois->error->error_msg;
		return;
	}
	echo 'Country : '.$json->whois->countryCode;
	if (empty($json->whois->korean) || empty($json->whois->korean->ISP)) return;
	echo '<br>Company : '.$json->whois->korean->ISP->netinfo->servName.'<br>';
	echo 'Company K : '.$json->whois->korean->ISP->netinfo->orgName;
?>