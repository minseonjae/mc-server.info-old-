<?php
	include "../../API.php";
	
	$message = "";
	$javascript = "";
	if (!empty($_GET['name'])) {
		$name = $_GET['name'];
		$list_file = "../API/List/".$name.".json";
		$data_file = "../API/Data/".$name.".json";
		if (file_exists($list_file) && file_exists($data_file)) {
			$list_json = getJSON($list_file);
			$data_json = getJSON($data_file);
			$chart_file = "../API/Chart/".$name.".json";
			$message = '
				<h2>"'.$name.'"서버 정보 <small>마지막 정보 : '.$data_json->last->get.'</small></h2>
					<br>
					<div class="row">
						<div class="col-md-8">
							<div class="row">
								<div class="col-md-3">
									<ul class="list-group">
										<li class="list-group-item">
											<center><small><font color="#939393">상태</font><br>'.($data_json->online ? '온라인' : '오프라인').'</small></center>
										</li>
									</ul>
								</div>
								<div class="col-md-3">
									<ul class="list-group">
										<li class="list-group-item">
											<center><small><font color="#939393">Uptime</font><br>'.(round($data_json->uptime->get / $data_json->uptime->check * 10000) / 100).'%</small></center>
										</li>
									</ul>
								</div>
								<div class="col-md-3">
									<ul class="list-group">
										<li class="list-group-item">
											<center><small><font color="#939393">Ping</font><br>'.$data_json->ping.'ms</small></center>
										</li>
									</ul>
								</div>
								<div class="col-md-3">
									<ul class="list-group">
										<li class="list-group-item">
											<center><small><font color="#939393">인원</font><br>'.$data_json->players.' / '.$data_json->maxplayers.'</small></center>
										</li>
									</ul>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<ul class="list-group">
										<li class="list-group-item">
											<center><small><font color="#939393">Version</font><br>'.$data_json->version.'</small></center>
										</li>
									</ul>
								</div>
								<div class="col-md-6">
									<ul class="list-group">
										<li class="list-group-item">
											<center><small><font color="#939393">최고 동시 접속자 변경률 (오늘, 어제)</font><br>'.($data_json->peak->yesterday->players > 0 ? (round($data_json->peak->today->players / $data_json->peak->yesterday->players * 10000) / 100) - 100 : 0).'%</small></center>
										</li>
									</ul>
								</div>
							</div>
							<ul class="list-group">
								<li class="list-group-item">
									<center>
										'.replaceColor($data_json->motd).'
									</center>
								</li>
							</ul>
							<div class="panel panel-info">
								<div class="panel-body">
									접속자 그래프
									'.(file_exists($chart_file) ? '<canvas id="Players"></canvas>' : '<br><br><br><br><center>해당 서버의 그래프 데이터가 존재하지 않습니다.</center><br><br><br>').'
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="list-group">
								<a id="copy" class="list-group-item">
									<center><font color="#939393">서버 주소</font><br>'.$list_json->ip.'</center>
								</a>
							</div>
							<ul class="list-group">
								<li class="list-group-item">
									<strong>
										마지막 정보 확인
									</strong>
									<br>
									<small>'.$data_json->last->get.'</small>
								</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item">
									<strong>
										최고 동시 접속자
									</strong>
									<br>
									<small>'.$data_json->peak->allday->players.'명</small>
									<br><br>
									<small>'.$data_json->peak->allday->time.'</small>
								</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item">
									<strong>
										오늘 최고 동시 접속자
									</strong>
									<br>
									<small>'.$data_json->peak->today->players.'명</small>
									<br><br>
									<small>'.$data_json->peak->today->time.'</small>
								</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item">
									<strong>
										어제 최고 동시 접속자
									</strong>
									<br>
									<small>'.$data_json->peak->yesterday->players.'명</small>
									<br><br>
									<small>'.$data_json->peak->yesterday->time.'</small>
								</li>
							</ul>
						</div>
					</div>
			';
			if (file_exists($chart_file)) {
				$chart_json = getJSON($chart_file);
				$chart_time = "";
				foreach ($chart_json->time as $time) {
					$chart_time = strlen($chart_time) > 0 ? $chart_time.', "'.$time.'"' : '"'.$time.'"';
				}
				$chart_players = "";
				foreach ($chart_json->players as $players) {
					$chart_players = strlen($chart_players) > 0 ? $chart_players.', '.$players : $players;
				}
				$javascript = "
		<script>
function copyToClipboard(val) {
	var t = document.createElement(\"textarea\");
	document.body.appendChild(t);
	t.value = val;
	t.select();
	document.execCommand('copy');
	document.body.removeChild(t);
}
$('#copy').click(function() {
	copyToClipboard('".$list_json->ip."');
	alert('복사했습니다!');
});
		</script>
				";
				$javascript = $javascript.'
						<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
		<script>
var ctx = document.getElementById("Players").getContext(\'2d\');
new Chart(ctx, {
    type: \'line\',
    data: {
            labels: [
				'.$chart_time.'
			],
        datasets: [{
			data: ['.$chart_players.'],
			label: "Players",
			backgroundColor: \'rgba(0,103,255,0.15)\',
			borderColor: \'rgba(0,103,255,0.5)\',
			borderWidth: 3.5,
			pointStyle: \'circle\',
			pointRadius: 5,
			pointBorderColor: \'transparent\',
			pointBackgroundColor: \'rgba(0,103,255,0.5)\',
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    } 
});
		</script>
				';
			}
		} else {
			$message = '<center><br><br><h2>해당 서버의 데이터가 존재하지 않습니다!</h2></center>';
		}
	} else {
		$message = '<center><br><br><h2>데이터 오류!</h2></center>';
	}
?>
<!DOCTYPE html>
<html lang="ko">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Minecraft Server Info</title>
		<meta name="description" content="Minecraft Server Info">
		
		<link rel="apple-touch-icon" href="../icon.png">
		<link rel="shortcut icon" href="../icon.png">

		<link href="../css/bootstrap.css" rel="stylesheet">
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<br><br><br>
					<h1>Minecraft Server Info</h1>
					<br><br><br>
					<nav class="navbar navbar-default">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li><a href="../../">홈</a></li>
								<li><a href="../Add">추가</a></li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">서버 <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="../Server/Top/Players">동시 접속자 순위</a></li>
										<li><a href="../Server/Top//Peak/Allday">최고 동시 접속자 순위</a></li>
										<li><a href="../Server/Top//Peak/Today">오늘 최고 동시 접속자 순위</a></li>
										<li><a href="../Server/Top//Peak/Yesterday">어제 최고 동시 접속자 순위</a></li>
									</ul>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">문의 <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a>Discord : McServerInfo#5047</a></li>
									</ul>
								</li>
								<li><a href="../TermsAndConditions">이용약관</a></li>
								<li><a href="../PrivacyAgreement">개인정보취급방침</a></li>
							</ul>
							<form action="../Search" method="get" class="navbar-form navbar-right" role="search">
								<div class="form-group">
									<input type="text" name="search" class="form-control" placeholder="Search">
								</div>
								<button type="submit" class="btn btn-default">검색</button>
							</form>
						</div>
					</nav>
					<hr>
					<?php echo $message; ?>
				<div class="col-md-2"></div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<?php echo $javascript; ?>
		<script>
			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			})
		</script>
	</body>
</html>