<?php
	
	// 서버 정보 조회
	
	include "../../API.php";
?>
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
                <a href="../../" class="navbar-brand"><h5>마인크래프트 서버 정보</h5></a>
                <a href="../../" class="navbar-brand hidden"><h6>MSI</h6></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
					<li>
                        <a href="../../"> <i class="menu-icon fa fa-dashboard"></i>메인 </a>
                    </li>
					<li>
						<a href="../ServerList/?players_page=1"> <i class="menu-icon fa fa-list-ul"></i>서버 목록</a>
                    </li>
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
							<i class="menu-icon fa fa-list"></i> 서버 랭킹
						</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-list-ol"></i><a href="../PlayersTop">동시 접속자</a></li>
                            <li><i class="fa fa-list-ol"></i><a href="../AllDayPeakPlayersTop">최고 동시 접속자</a></li>
                            <li><i class="fa fa-list-ol"></i><a href="../DayPeakPlayersTop">최고 동시 접속자 (오늘)</a></li>
                            <li><i class="fa fa-list-ol"></i><a href="../YesterPeakPlayersTop">최고 동시 접속자 (어제)</a></li>
                        </ul>
                    </li>
					<li>
                        <a href="../API"> <i class="menu-icon fa fa-code"></i>API </a>
                    </li>
					<li>
                        <a href="../PatchNote"> <i class="menu-icon fa fa-file-text"></i>패치 노트 </a>
                    </li>
					<li>
                        <a href="../Test"> <i class="menu-icon fa fa-check-circle"></i>테스트 </a>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>
    <div id="right-panel" class="right-panel">
        <header id="header" class="header">
            <div class="header-menu">
                <div class="col-sm-5">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa-hand-o-left"></i></a>
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
		
        <div class="container">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
<?php
	if (!empty($_GET['name'])) {
		$name = $_GET['name'];
		if (!file_exists("../API/List/".$name.".json")) {
			echo '
				<div class="card">
					<div class="card-body">
						<strong>해당 서버 데이터가 존재하지 않습니다!</strong>
					</div>
				</div>
			';
		} else {
			$json_i = getJSON("../API/List/".$name.".json");
			echo '
				<div class="card">
					<div class="card-body">
						<strong>'.$name.' 서버</strong>
						<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#serverip">주소</button>
						<button type="button" class="btn btn-sm btn-danger float-right" data-toggle="modal" data-target="#servermaxplayers">최고 동시 접속자</button>
					</div>
				</div>
				<div class="card">
					<img class="card-img-top" src="../API/Banner/'.$name.'.png?v='.Date("Y.m.d.G.i").'">
					<div class="card-body">
						<div class="input-group">
							<input type="text" class="form-control" value=\'<img src="http://mc-server.info/API/Banner/'.$name.'.png">\'">
							<div class="input-group-addon">위젯 소스</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h4 class="mb-3">Player Chart</h4>
						<canvas id="info"></canvas>
					</div>
				</div>
			';
		}
	} else {
		echo '
				<div class="card">
					<div class="card-body">
						<strong>데이터를 입력해주세요!</strong>
					</div>
				</div>
			';
	}
?>
				<div class="col-sm-2"></div>
			</div>
			<div class="col-sm-2"></div>
        </div>
    </div>
	
	
	
<?php
	if (!empty($_GET['name']) && file_exists("../API/List/".$name.".json")) {
		$json_m = getJSON("../API/Peak/AllDay/".$name.".json");
		echo '
	<div class="modal fade" id="serverip" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="smallmodalLabel">주소 복사</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="text" id="text-input" name="text-input" class="form-control" value="'.$json_i->ip.'">
						<small class="form-text text-muted">
							복사하시면 됩니다.
						</small>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="servermaxplayers" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="smallmodalLabel">최고 동시 접속자</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h1><strong>'.$json_m->players.' 명</strong></h1> <h5><small>기준 - '.$json_m->time.'</small></h5>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
		';
	}
?>
    <script src="../assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/main.js"></script>
<?php
	if (!empty($_GET['name']) && file_exists("../API/List/".$name.".json")) {
		$json_c = getJSON("../API/Chart/".$name.".json");
		$msg_p1 = "";
		$boo_p1 = false;
		foreach ($json_c->time as $time) {
			if ($boo_p1) $msg_p1 = $msg_p1.', ';
			else $boo_p1 = true;
			$msg_p1 = $msg_p1.'"'.$time.'"';
		}
		$msg_p2 = "";
		$boo_p2 = false;
		foreach ($json_c->players as $players) {
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
				".$msg_p1."
			],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: [ {
                data: [
				".$msg_p2."
				],
                label: \"Players\",
                backgroundColor: 'rgba(0,103,255,.15)',
                borderColor: 'rgba(0,103,255,0.5)',
                borderWidth: 3.5,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: 'rgba(0,103,255,0.5)',
                    }, ]
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
