<?php
	$host = $_SERVER['HTTP_HOST'];
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
							<form class="search-form" action="../ServerInfo/">
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
			<div class="card">
				<div class="card-body">
					<strong>배너 이미지</strong><br>
					https://<?php echo $host; ?>/Banner/<서버이름>.png
					<br><br>
					<strong>서버 정보 JSON - 1분 단위로 변경됨</strong><br>
					https://<?php echo $host; ?>/Status/<서버이름>.json
					<br><br>
					<strong>서버 인원 JSON - 10분 단위로 2시간 분량</strong><br>
					https://<?php echo $host; ?>/Chart/<서버이름>.json
					<br><br>
					<strong>서버 인원 JSON - 10분 단위로 하루 분량</strong><br>
					https://<?php echo $host; ?>/Chart/****년 **월 **일/<서버이름>.json
					<br><br>
					<strong>모든 서버 인원 JSON - 10분 단위로 2시간 분량 데이터</strong><br>
					https://<?php echo $host; ?>/All/Chart.json
					<br><br>
					<strong>모든 서버 인원 JSON - 10분 단위로 하루 분량 데이터</strong><br>
					https://<?php echo $host; ?>/All/Chart/****년 **월 **일.json
					<br><br>
					<strong>동시 접속자 랭킹 - 1분 단위로 변경됨</strong><br>
					https://<?php echo $host; ?>/All/Top1.json
					<br><br>
					<strong>최고 동시 접속자 랭킹 - 1분 단위로 변경됨</strong><br>
					https://<?php echo $host; ?>/All/Top2.json
					<br><br>
					<strong>최고 접속자 확인</strong><br>
					https://<?php echo $host; ?>/Max/<서버이름>.json
				</div>
			</div>
        </div>
    </div>

    <script src="../assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
