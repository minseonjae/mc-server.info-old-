<?php
	
	// 대시보드

	include "../API.php";
	
	// 메인 공지
	$alert_json = getJSON("Alert.json");
	$alert = "";
	if ($alert_json->alert != "") {
		$alert = '
			<div class="col-sm-12">
                <div class="alert  alert-success alert-dismissible fade show" role="alert">
					'.$alert_json->alert.'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
		';
	}
	
	// 서버 개수, 모든 서버 접속자
	$servers = count(scandir("API/List/")) - 2;
	$players = getJSON("API/Players.json")->players;

	// 모든 날짜? 기준	
	$all_peak_json = getJSON("API/Peak/AllDay.json");
	$all_peak_time = $all_peak_json->time;
	$all_peak_players = $all_peak_json->players;

	// 하루 기준
	$peak_json = getJSON("API/Peak/Day.json");
	$peak_time = $peak_json->time;
	$peak_time = explode(":", $peak_time);
	$peak_time = $peak_time[0]."시 ".$peak_time[1]."분";
	$peak_players = $peak_json->players;
	
	// 어제 기준
	$yester_json = getJSON("API/Peak/Yester.json");
	$yester_time = $yester_json->time;
	$yester_time = explode(":", $yester_time);
	$yester_time = $yester_time[0]."시 ".$yester_time[1]."분";
	$yester_players = $yester_json->players;
	
	$all_chart_json = getJSON("API/Chart.json");
	$all_chart_time = "";
	$boo = false;
	foreach ($all_chart_json->time as $time_f) {
		if ($boo) $all_chart_time = $all_chart_time.', ';
		else $boo = true;
		$all_chart_time = $all_chart_time.'"'.$time_f.'"';
	}
	$all_chart_players = "";
	$boo = false;
	foreach ($all_chart_json->players as $players_f) {
		if ($boo) $all_chart_players = $all_chart_players.', ';
		else $boo = true;
		$all_chart_players = $all_chart_players.$players_f;
	}
	
	$version_chart_json = getJSON("API/Version.json");
	
	$version_chart_version = "";
	$version_chart_count = "";
	$color = "";
	$boo = false;
	foreach ($version_chart_json as $version => $count) {
		if ($boo) {
			$color = $color.', ';
			$version_chart_version = $version_chart_version.', ';
			$version_chart_count = $version_chart_count.', ';
		} else $boo = true;
		$version_chart_version = $version_chart_version.'"'.$version.'"';
		$version_chart_count = $version_chart_count.$count;
		$color = $color.'"rgba('.mt_rand(0, 255).', '.mt_rand(0, 255).', '.mt_rand(0, 255).', 1)"';
	}
?>
<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>마인크래프트 서버 정보</title>
    <meta name="description" content="마인크래프트 서버 정보 사이트">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="icon.png">
    <link rel="shortcut icon" href="icon.png">

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/scss/style.css">
    <link href="assets/css/lib/vector-map/jqvmap.min.css" rel="stylesheet">

    <link href="assets/css/googlefont.css" rel="stylesheet" type="text/css">
</head>
<body>
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a href="../" class="navbar-brand"><h5>마인크래프트 서버 정보</h5></a>
                <a href="../" class="navbar-brand hidden"><h6>MSI</h6></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
					<li>
                        <a href="../"> <i class="menu-icon fa fa-dashboard"></i>메인 </a>
                    </li>
					<li>
						<a href="ServerList/?players_page=1"> <i class="menu-icon fa fa-list-ul"></i>서버 목록</a>
                    </li>
					<li>
                        <a href="PlayersTop"> <i class="menu-icon fa fa-list"></i>서버 랭킹 </a>
                    </li>
					<li>
                        <a href="API"> <i class="menu-icon fa fa-code"></i>API </a>
                    </li>
					<li>
                        <a href="PatchNote"> <i class="menu-icon fa fa-file-text"></i>패치 노트 </a>
                    </li>
					<li>
                        <a href="Test"> <i class="menu-icon fa fa-check-circle"></i>테스트 </a>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>
    <div id="right-panel" class="right-panel">
        <header id="header" class="header">
            <div class="header-menu">
                <div class="col-sm-5">
					<div class="header-right">
						<a id="menuToggle" class="menutoggle pull-left"><i class="fa fa-hand-o-left"></i></a>
					</div>
				</div>
                <div class="col-sm-7">
					<div class="header-left float-right">
						<button class="search-trigger"><i class="fa fa-search"></i></button>
						<div class="form-inline">
							<form class="search-form" action="../ServerInfo/">
								<input class="form-control mr-sm-2" name="name" type="text" placeholder="서버 이름만 입력해주세요." aria-label="Search">
								<button type="submit"></button>
								<button class="search-close"><i class="fa fa-close"></i></button>
							</form>
						</div>
					</div>
                </div>
            </div>
        </header>
		
        <div class="content mt-3">
			<div class="row">
			<?php echo $alert; ?>
			</div>
			<div class="row">
				<div class="col-lg-4">
					<div class="card">
						<div class="card-body">
							<div class="stat-widget-one">
								<div class="stat-icon dib"><i class="ti-user text-primary border-primary"></i></div>
								<div class="stat-content dib">
									<div class="stat-text">모든 서버 동시 접속자</div>
									<div class="stat-digit"><?php echo $players; ?> 명</div>
								</div>
								<h4><small><span class="badge float-right mt-1"><?php echo Date("G시 i분"); ?></span></small></h4>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="card">
						<div class="card-body">
							<div class="stat-widget-one">
								<ul class="nav float-right" role="tablist">
									<li class="nav-item float-right dropdown" role="presentation">
										<a href="" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
										<div class="dropdown-menu">
											<a href="#all" class="dropdown-item" role="tab" data-toggle="tab">모두</a>
											<a href="#today" class="dropdown-item" role="tab" data-toggle="tab">오늘</a>
											<a href="#yester" class="dropdown-item" role="tab" data-toggle="tab">어제</a>
										</div>
									</li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="all">
										<div class="stat-icon dib"><i class="ti-user text-info border-info"></i></div>
										<div class="stat-content dib">
											<div class="stat-text">모든 서버 최고 동시 접속자</div>
											<div class="stat-digit"><?php echo $all_peak_players; ?> 명</div>
										</div>
										<h4><small><span class="badge float-right mt-1"><?php echo $all_peak_time; ?></span></small></h4>
									</div>
									<div role="tabpanel" class="tab-pane" id="today">
										<div class="stat-icon dib"><i class="ti-user text-primary border-primary"></i></div>
										<div class="stat-content dib">
											<div class="stat-text">오늘 모든 서버 최고 동시 접속자</div>
											<div class="stat-digit"><?php echo $peak_players; ?> 명</div>
										</div>
										<h4><small><span class="badge float-right mt-1"><?php echo $peak_time; ?></span></small></h4>
									</div>
									<div role="tabpanel" class="tab-pane" id="yester">
										<div class="stat-icon dib"><i class="ti-user text-warning border-warning"></i></div>
										<div class="stat-content dib">
											<div class="stat-text">어제 모든 서버 최고 동시 접속자</div>
											<div class="stat-digit"><?php echo $yester_players; ?> 명</div>
										</div>
										<h4><small><span class="badge float-right mt-1"><?php echo $yester_time; ?></span></small></h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="card">
						<div class="card-body">
							<div class="stat-widget-one">
								<div class="stat-icon dib"><i class="ti-server text-success border-success"></i></div>
								<div class="stat-content dib">
									<div class="stat-text">등록된 서버 개수</div>
									<div class="stat-digit"><?php echo $servers; ?> 개</div>
								</div>
								<h4><small><span class="badge float-right mt-1"><?php echo Date("G시 i분"); ?></span></small></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-7">
					<div class="card">
						<div class="card-body">
							<h4 class="mb-3">모든 서버 동시 접속자 통계</h4>
							<canvas id="Players Chart"></canvas>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="card">
						<div class="card-body">
							<h4 class="mb-3">모든 서버 버전 통계</h4>
							<canvas id="Servers Chart"></canvas>
						</div>
					</div>
				</div>
				<div class="col-lg-1"></div>
			</div>
        </div>
    </div>

    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/lib/chart-js/Chart.bundle.js"></script>
    <script>
( function ( $ ) {
    "use strict";
    var ctx = document.getElementById( "Players Chart" );
    ctx.height = 150;
    var myChart = new Chart( ctx, {
        type: 'line',
        data: {
            labels: [
				<?php echo $all_chart_time; ?>
			],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: [ {
                data: [ 
				<?php echo $all_chart_players; ?>
				],
                label: "Players",
                backgroundColor: 'rgba(0,103,255,0.15)',
                borderColor: 'rgba(0,103,255,0.5)',
                borderWidth: 3.5,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: 'rgba(0,103,255,0.5)',
                    } ]
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            legend: {
                display: false,
                position: 'top',
                labels: {
                    usePointStyle: true,
                    fontFamily: 'Montserrat',
                },


            },
            scales: {
                xAxes: [ {
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: false,
                        labelString: 'Month'
                    }
                        } ],
                yAxes: [ {
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Players'
                    }
                        } ]
            },
            title: {
                display: false,
            }
        }
    } );
	var ctx = document.getElementById( "Servers Chart" );
    ctx.height = 300;
    var myChart = new Chart( ctx, {
        type: 'pie',
        data: {
            datasets: [ {
                data: [
					<?php echo $version_chart_count; ?>
				],
                backgroundColor: [
									<?php echo $color; ?>
                                ],
                hoverBackgroundColor: [
									<?php echo $color; ?>
                                ]

                            } ],
            labels: [
			<?php echo $version_chart_version; ?>
                        ]
        },
        options: {
            responsive: true
        }
    } );
} )( jQuery );
	</script>
</body>
</html>
