<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>마인크래프트 서버 정보</title>
    <meta name="description" content="Minecraft Server Status">
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

    <link href='assets/css/googlefont.css' rel='stylesheet' type='text/css'>
</head>
<body>
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./"><h5>Minecraft Server Status</h5></a>
                <a class="navbar-brand hidden" href="./"><h6><small>MSS</small></h6></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="./"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                    </li>
					<li class="menu-item-has-children dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Server List</a>
						<ul class="sub-menu children dropdown-menu">
							<li><i class="menu-icon fa fa-tasks"></i><a href="PlayersTopList/">Players</a></li>
							<li><i class="menu-icon fa fa-tasks"></i><a href="PeakPlayersTopList/">Peak Players</a></li>
						</ul>
                    </li>
					<li>
                        <a href="API/"> <i class="menu-icon fa fa-cloud"></i>API </a>
                    </li>
					<li>
                        <a href="Patch/"> <i class="menu-icon fa fa-desktop"></i>Patch </a>
                    </li>
					<h3 class="menu-title">서버 추가 문의 - Discord</h3>
					<li>
                        <a><i class="menu-icon fa fa-volume-up"></i>Seon_Jae#3694</a>
                    </li>
					
                </ul>
            </div>
        </nav>
    </aside>
    <div id="right-panel" class="right-panel">
        <header id="header" class="header">
            <div class="header-menu">
                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
					<div class="header-left">
						<button class="search-trigger"><i class="fa fa-search"></i></button>
						<div class="form-inline">
							<form class="search-form" action="ServerInfo/">
								<input class="form-control mr-sm-2" name="name" type="text" placeholder="서버 이름만 입력해주세요." aria-label="Search">
								<button type="submit"></button>
								<button class="search-close"><i class="fa fa-close"></i></button>
							</form>
						</div>
					</div>
                </div>
                <div class="col-sm-5"></div>
            </div>
        </header>
		
        <div class="content mt-3">
<?php
	$json_b = json_decode(file_get_contents("Broadcast.json"));
	if ($json_b->alert != "") {
		echo '
			<div class="col-sm-12">
                <div class="alert  alert-success alert-dismissible fade show" role="alert">
					'.$json_b->alert.'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
		';
	}
?>
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<h4 class="mb-3">All Server Players Chart</h4>
						<canvas id="Players Chart"></canvas>
					</div>
				</div>
                <div class="col-lg-5">
					<div class="card">
						<div class="card-body">
							<div class="stat-widget-one">
								<div class="stat-icon dib"><i class="ti-server text-success border-success"></i></div>
								<div class="stat-content dib">
									<div class="stat-text">Server</div>
									<div class="stat-digit"><?php echo count(scandir("List/")) - 2; ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-7">
					<div class="card">
						<div class="card-body">
							<div class="stat-widget-one">
								<div class="stat-icon dib"><i class="ti-user text-primary border-primary"></i></div>
								<div class="stat-content dib">
									<div class="stat-text">All Server Players</div>
									<div class="stat-digit"><?php echo json_decode(file_get_contents("All/Players.json"))->players; ?> 명</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="stat-widget-one">
								<div class="stat-icon dib"><i class="ti-user text-info border-info"></i></div>
								<div class="stat-content dib">
									<div class="stat-text">All Server Peak Players
<?php
	$json_m = json_decode(file_get_contents("All/MaxPlayers.json"));
	echo ' - '.$json_m->time;
?>									
									</div>
									<div class="stat-digit"><?php echo $json_m->players; ?> 명</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<h4 class="mb-3">Server Version Chart</h4>
						<canvas id="Servers Chart"></canvas>
					</div>
				</div>
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
<?php
	$json_players = json_decode(file_get_contents("All/Chart.json"));
	$msg_p1 = "";
	$boo_p1 = false;
	foreach ($json_players->time as $time) {
		if ($boo_p1) $msg_p1 = $msg_p1.', ';
		else $boo_p1 = true;
		$msg_p1 = $msg_p1.'"'.$time.'"';
	}
	echo $msg_p1;
?>
			],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: [ {
                data: [ 
				<?php
	$msg_p2 = "";
	$boo_p2 = false;
	foreach ($json_players->players as $players) {
		if ($boo_p2) $msg_p2 = $msg_p2.', ';
		else $boo_p2 = true;
		$msg_p2 = $msg_p2.$players;
	}
	echo $msg_p2;
?>
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
<?php
	$json_version = json_decode(file_get_contents("All/Version.json"));
	$msg_v1 = "";
	$boo_v1 = false;
	foreach ($json_version as $version => $count) {
		if ($boo_v1) $msg_v1 = $msg_v1.', ';
		else $boo_v1 = true;
		$msg_v1 = $msg_v1.$count;
	}
	echo $msg_v1;
?>
				],
                backgroundColor: [
<?php
	$msg_c1 = "";
	$boo_c1 = false;
	foreach ($json_version as $version => $count) {
		if ($boo_c1) $msg_c1 = $msg_c1.', ';
		else $boo_c1 = true;
		$msg_c1 = $msg_c1.'"rgba('.mt_rand(0, 255).', '.mt_rand(0, 255).', '.mt_rand(0, 255).', 1)"';
	}
	echo $msg_c1;
?>
                                ],
                hoverBackgroundColor: [
<?php
	echo $msg_c1;
?>
                                ]

                            } ],
            labels: [
<?php
	$msg_v2 = "";
	$boo_v2 = false;
	foreach ($json_version as $version => $count) {
		if ($boo_v2) $msg_v2 = $msg_v2.', ';
		else $boo_v2 = true;
		$msg_v2 = $msg_v2.'"  '.$version.'  "';
	}
	echo $msg_v2;
?>
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
