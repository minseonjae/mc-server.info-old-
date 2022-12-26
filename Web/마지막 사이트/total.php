<?php
	$time = date("Y-m-d");
	$total = 0;
	$today_total = 0;
	
	//today total
	$today_stats_file_path = $stats_path.$time."/";
	
	if (!file_exists($today_stats_file_path)) mkdir($today_stats_file_path);
	
	$today_user_json_path = $today_stats_file_path.str_replace('.', '-', $_SERVER['HTTP_CF_CONNECTING_IP']);
	$today_user_json_path = str_replace(":", "-", $today_user_json_path).".json";
	
	if (!file_exists($today_user_json_path)) {
		$today_user_json_file = fopen($today_user_json_path, "ab");
		fwrite($today_user_json_file, '');
		fclose($today_user_json_file);
	}
	
	$today_total = count(scandir($today_stats_file_path)) - 2;
	
	//all total
	if ($stats_dir = opendir($stats_path)) {
		while (($day_dir = readdir($stats_dir)) !== false) {
			$all_files = $stats_path.$day_dir;
			if (!is_dir($all_files)) continue;
			if (mb_strlen($day_dir, 'UTF-8') < 3) continue;
			$total += count(scandir($all_files)) - 2;
		}
	}

	$total += 19556;
	
	closedir($stats_dir);
?>