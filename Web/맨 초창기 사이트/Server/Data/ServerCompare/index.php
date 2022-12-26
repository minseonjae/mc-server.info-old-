<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>마인크래프트 서버 정보</title>
    <meta name="description" content="Minecraft Server Status">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="../icon.png">
    <link rel="shortcut icon" href="../icon.png">

    <link rel="stylesheet" href="../assets/css/normalize.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../assets/scss/style.css">
    <link href="../assets/css/lib/vector-map/jqvmap.min.css" rel="stylesheet">

    <link href='../assets/css/googlefont.css' rel='stylesheet' type='text/css'>
</head>
<body>
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./../"><h5>Minecraft Server Status</h5></a>
                <a class="navbar-brand hidden" href="./../"><h6>MSS</h6></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="./../"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                    </li>
					<li class="menu-item-has-children dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Server List</a>
						<ul class="sub-menu children dropdown-menu">
							<li><i class="menu-icon fa fa-tasks"></i><a href="../PlayersTopList/">Players</a></li>
							<li><i class="menu-icon fa fa-tasks"></i><a href="../PeakPlayersTopList/">Peak Players</a></li>
						</ul>
                    </li>
					<li>
                        <a href="../API/"> <i class="menu-icon fa fa-cloud"></i>API </a>
                    </li>
					<li>
                        <a href="../Patch/"> <i class="menu-icon fa fa-desktop"></i>Patch </a>
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
							<form class="search-form" action="../ServerInfo">
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
	if (!empty($_GET['name1']) && !empty($_GET['name2'])) {
		$name1 = $_GET['name1'];
		$name2 = $_GET['name2'];
	}
?>
			<div class="col-sm-1"></div>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-body">
						<canvas id="info"></canvas>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<div class="stat-widget-one">
							<div class="stat-icon dib"><i class="ti-user text-primary border-primary"></i></div>
							<div class="stat-content dib">
								<div class="stat-text">
<?php
	echo $name1." 서버";
?>									
								</div>
								<div class="stat-digit"><?php echo json_decode(file_get_contents("../Status/".$name1.".json"))->players; ?></div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<div class="stat-widget-one">
							<div class="stat-icon dib"><i class="ti-user text-danger border-danger"></i></div>
							<div class="stat-content dib">
								<div class="stat-text">
<?php
	echo $name2." 서버";
?>									
								</div>
								<div class="stat-digit"><?php echo json_decode(file_get_contents("../Status/".$name2.".json"))->players; ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-1"></div>
        </div>
    </div>
    <script src="../assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/main.js"></script>
<?php
	if (!empty($_GET['name1']) && !empty($_GET['name2'])) {
		$json_c1 = json_decode(file_get_contents("../Chart/".$name1.".json"));
		$json_c2 = json_decode(file_get_contents("../Chart/".$name2.".json"));
		$msg_t1 = "";
		$boo_t1 = false;
		foreach ($json_c1->time as $time) {
			if ($boo_t1) $msg_t1 = $msg_t1.', ';
			else $boo_t1 = true;
			$msg_t1 = $msg_t1.'"'.$time.'"';
		}
		$msg_p1 = "";
		$boo_p1 = false;
		foreach ($json_c1->players as $players) {
			if ($boo_p1) $msg_p1 = $msg_p1.', ';
			else $boo_p1 = true;
			$msg_p1 = $msg_p1.$players;
		}
		$msg_p2 = "";
		$boo_p2 = false;
		foreach ($json_c2->players as $players) {
			if ($boo_p2) $msg_p2 = $msg_p2.', ';
			else $boo_p2 = true;
			$msg_p2 = $msg_p2.$players;
		}
		echo "    <script src=\"../assets/js/lib/chart-js/Chart.bundle.js\"></script>
    <script>
( function ( $ ) {
    \"use strict\";
    var ctx = document.getElementById(\"info\");
    ctx.height = 150;
    var myChart = new Chart( ctx, {
        type: 'line',
        data: {
            labels: [
				".$msg_t1."
			],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: [ {
                data: [
				".$msg_p1."
				],
                label: \"".$name1." 서버\",
                backgroundColor: 'transparent',
                borderColor: 'rgba(0,103,255,0.5)',
                borderWidth: 3.5,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: 'rgba(0,103,255,0.5)',
                    },{
                data: [
				".$msg_p2."
				],
                label: \"".$name2." 서버\",
                backgroundColor: 'transparent',
                borderColor: 'rgba(220,53,69,0.75)',
                borderWidth: 3.5,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: 'rgba(220,53,69,0.75)',
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
} )( jQuery );
		</script>";
	}
?>
</body>
</html>
