<?php

	// API
	
	$host = $_SERVER['HTTP_HOST'];
?>
<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>마인크래프트 서버 정보</title>
    <meta name="description" content="마인크래프트 서버 정보 사이트">
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

    <link href="../assets/css/googlefont.css" rel="stylesheet" type="text/css">
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
					<li>
                        <a href="../PlayersTop"> <i class="menu-icon fa fa-list"></i>서버 랭킹 </a>
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
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-8">
					<div class="card">
						<div class="card-body">
							<strong>배너 이미지</strong><br>
							https://<?php echo $host; ?>/API/Banner/<서버이름>.png
							<br><br>
							<strong>서버 정보 JSON - 1분 단위로 변경됨</strong><br>
							https://<?php echo $host; ?>/API/Status/<서버이름>.json
							<br><br>
							<strong>서버 인원 JSON - 10분 단위로 2시간 분량</strong><br>
							https://<?php echo $host; ?>/API/Chart/<서버이름>.json
							<br><br>
							<strong>서버 인원 JSON - 10분 단위로 하루 분량</strong><br>
							https://<?php echo $host; ?>/API/Chart/****년 **월 **일/<서버이름>.json
							<br><br>
							<strong>모든 서버 인원 JSON - 10분 단위로 2시간 분량 데이터</strong><br>
							https://<?php echo $host; ?>/API/Chart.json
							<br><br>
							<strong>모든 서버 인원 JSON - 10분 단위로 하루 분량 데이터</strong><br>
							https://<?php echo $host; ?>/API/Chart/All/****년 **월 **일.json
							<br><br>
							<strong>동시 접속자</strong><br>
							https://<?php echo $host; ?>/API/Players.json
							<br><br>
							<strong>최고 동시 접속자</strong><br>
							https://<?php echo $host; ?>/API/Peak/AllDay.json
							<br><br>
							<strong>오늘 하루 최고 동시 접속자</strong><br>
							https://<?php echo $host; ?>/API/Peak/Day.json
							<br><br>
							<strong>동시 접속자 랭킹</strong><br>
							https://<?php echo $host; ?>/API/PlayersTop.json
							<br><br>
							<strong>최고 동시 접속자 랭킹</strong><br>
							https://<?php echo $host; ?>/API/Peak/AllDayTop.json
							<br><br>
							<strong>오늘 하루 최고 동시 접속자 랭킹</strong><br>
							https://<?php echo $host; ?>/API/Peak/DayTop.json
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-8"></div>
			</div>
        </div>
    </div>

    <script src="../assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
