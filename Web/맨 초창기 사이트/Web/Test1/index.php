<?php
	include "../../API.php";
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
				<div class="col-xs-12 col-sm-7 col-md-9">
					<div class="card">
						<div class="card-header bg-dark">
							<strong class="card-title text-light">테스트</strong>
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item">
								<a href="#">
									<div class="row">
										<div class="col-2">
											<center>
												<h4>1</h4>
											</center>
										</div>
										<div class="col-5">
											<h5><font color="#000">테스트 서버</font></h5>
										</div>
										<div class="col-5">
											<h5><p class="text-right">Test.test</p></h5>
										</div>
									</div>
									<div class="row">
										<div class="col-2">
											<center>
												<font color="#000">
													<i class="fa fa-download"></i> <?php echo round(1 / 1440 * 100 * 100) / 100; ?>%<br>
													<i class="fa fa-retweet"></i> <?php echo round(110 / 300 * 100 * 100) / 100; ?>%<br>
													<i class="fa fa-globe"></i> <?php echo round(110 / 2131 * 100 * 100) / 100; ?>%
												</font>
											</center>
										</div>
										<div class="col-10">
											<br>
											<h5><?php echo replaceColor("§11§22§33§44§55§66§77§88§99§00§aa§bb§cc§dd§ee"); ?></h5>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-6">
											<span class="badge badge-dark">1.12.2</span>
											<span class="badge badge-secondary ">SRV</span>
										</div>
										<div class="col-6">
											<p class="text-right">
												<span class="badge badge-success"><i class="fa fa-users"></i> 300</span>
												<span class="badge badge-info">110 / 1000</span>
											</p>
										</div>
									</div>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-xs-12 col-sm-5 col-md-3">
					<div class="card">
						<div class="card-body">
							<center><h5><strong>정렬 기준</strong></h5></center>
							<br>
							<button type="button" class="btn btn-block btn-outline-dark" onClick="location.href='../PlayersTop/'">동시 접속자</button>
							<button type="button" class="btn btn-block btn-outline-dark" onClick="location.href='../AllDayPeakPlayersTop/'">최고 동시 접속자</button>
							<button type="button" class="btn btn-block btn-outline-dark" onClick="location.href='../DayPeakPlayersTop/'">최고 동시 접속자 (오늘)</button>
							<button type="button" class="btn btn-block btn-outline-dark" onClick="location.href='../YesterPeakPlayersTop/'">최고 동시 접속자 (어제)</button>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
    <script src="../assets/js/vendor/jquery-1.11.3.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
