<?php
	include "../API.php";
	
	$chart_json = getJSON("API/Chart.json");
	
	$chart_time = "";
	foreach ($chart_json->time as $time) {
		$chart_time = strlen($chart_time) > 0 ? $chart_time.', "'.$time.'"' : '"'.$time.'"';
	}
	$chart_players = "";
	foreach ($chart_json->players as $players) {
		$chart_players = strlen($chart_players) > 0 ? $chart_players.', '.$players : $players;
	}
	
	$version_json = getJSON("API/Version.json");
	
	$color = "";
	$version_name = "";
	$version_count = "";
	foreach ($version_json as $name => $count) {
		$version_name = strlen($version_name) > 0 ? $version_name.', "'.$name.'"' : '"'.$name.'"';
		$version_count = strlen($version_count) > 0 ? $version_count.', '.$count : $count;
		$cc = '"rgba('.mt_rand(0, 255).', '.mt_rand(0, 255).', '.mt_rand(0, 255).', 1)"';
		$color = strlen($color) > 0 ? $color.', '.$cc : $cc;
	}
	
	$players_json = getJSON("API/Players.json");
?>
<!DOCTYPE html>
<html lang="ko">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Minecraft Server Info</title>
		<meta name="description" content="마인크래프트 서버 정보 및 통계 사이트">
		
		<link rel="apple-touch-icon" href="icon.png">
		<link rel="shortcut icon" href="icon.png">

		<link href="css/bootstrap.css" rel="stylesheet">
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10">
							<br><br>
							<h1><a href="https://mc-server.info"><font color=BLACK>Minecraft Server Info</font></a></h1>
							<br><br>
						</div>
						<div class="col-md-1"></div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-2">
							<button class="btn btn-default btn-block" type="submit">Button</button>
						</div>
						<div class="col-md-10">
											<div class="row">
						<div class="col-md-4">
							<ul class="list-group">
								<li class="list-group-item">
									<br>
									<strong>
										전체 동시 접속자
									</strong>
									<br>
									<small><?php echo $players_json->players;?>명</small>
									<br><br>
								</li>
							</ul>
						</div>
						<div class="col-md-4">
							<div class="list-group">
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane fade in active" id="allday">
										<a href="#today" aria-controls="settings" role="tab" data-toggle="tab" class="list-group-item">
											<strong>
												최고 전체 동시 접속자
											</strong>
											<br>
											<small><?php echo $players_json->peak->allday->players;?>명</small>
											<br><br>
											<small><?php echo $players_json->peak->allday->time;?></small>
										</a>
									</div>
									<div role="tabpanel" class="tab-pane fade" id="today">
										<a href="#yesterday" aria-controls="settings" role="tab" data-toggle="tab" class="list-group-item">
											<strong>
												오늘 최고 전체 동시 접속자
											</strong>
											<br>
											<small><?php echo $players_json->peak->today->players;?>명</small>
											<br><br>
											<small><?php echo $players_json->peak->today->time;?></small>
										</a>
									</div>
									<div role="tabpanel" class="tab-pane fade" id="yesterday">
										<a href="#allday" aria-controls="settings" role="tab" data-toggle="tab" class="list-group-item">
											<strong>
												어제 최고 전체 동시 접속자
											</strong>
											<br>
											<small><?php echo $players_json->peak->yesterday->players;?>명</small>
											<br><br>
											<small><?php echo $players_json->peak->yesterday->time;?></small>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<ul class="list-group">
								<li class="list-group-item">
									<br>
									<strong>
										등록된 서버 개수
									</strong>
									<br>
									<small><?php echo (count(scandir("API/List/")) - 2);?>개</small>
									<br><br>
								</li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<div class="panel panel-info">
								<div class="panel-body">
									전체 동시 접속자 그래프
									<canvas id="Players"></canvas>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="panel panel-warning">
								<div class="panel-body">
									버전 통계
									<canvas id="Version"></canvas>
								</div>
							</div>
						</div>
					</div>
						</div>
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script>
var ctx = document.getElementById("Players").getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
            labels: [
				<?php echo $chart_time; ?>
			],
        datasets: [{
			data: [<?php echo $chart_players; ?>],
			label: "Players",
			backgroundColor: 'rgba(0,103,255,0.15)',
			borderColor: 'rgba(0,103,255,0.5)',
			borderWidth: 3.5,
			pointStyle: 'circle',
			pointRadius: 5,
			pointBorderColor: 'transparent',
			pointBackgroundColor: 'rgba(0,103,255,0.5)',
        }]
    },
    /* options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    } */
});
var ctx = document.getElementById('Version').getContext('2d');
new Chart(ctx, {
			type: 'pie',
			data: {
				datasets: [{
                data: [<?php echo $version_count; ?>],
                backgroundColor: [<?php echo $color; ?>],
				}],
            labels: [<?php echo $version_name; ?>]
			},
			options: {
				responsive: true
			}
		});
		</script>
	</body>
</html>