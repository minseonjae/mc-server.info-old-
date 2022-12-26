<?php
	include "../../API.php";
	
	$page_name = "동시 접속자 순위";
	
	$page = 1;
	
	if (!empty($_GET['page'])) $page = $_GET['page'];
	
	$top_list = getJSON("../API/PlayersTop.json")->list;
	$top_size = count($top_list);
	$top_page = floor($top_size / 5) + ($top_size % 5 > 0 ? 1 : 0);
	
	$message = "";
	$AD_list = getJSON("../AD.json")->list;
	for ($i = 0; $i < count($AD_list); $i++) {
			$info_json = getJSON("../API/Status/".$AD_list[$i].".json");
			$peak_json = getJSON("../API/Peak/AllDay/".$AD_list[$i].".json");
			$peak1_json = getJSON("../API/Peak/Yester/".$AD_list[$i].".json");
			$peak1_time = explode(":", $peak1_json->time);
			$peak2_json = getJSON("../API/Peak/Day/".$AD_list[$i].".json");
			$peak2_time = explode(":", $peak2_json->time);
			$message = $message.'
							<li class="list-group-item">
								<a href="../ServerInfo/?name='.$AD_list[$i].'">
									<div class="row">
										<div class="col-2">
											<center>
												<h4>'.($i + 1).'</h4>
											</center>
										</div>
										<div class="col-5">
											<h5><font color="#000">'.$AD_list[$i].' 서버</font></h5>
										</div>
										<div class="col-5">
											<h5><p class="text-right">'.$info_json->ip.'</p></h5>
										</div>
									</div>
									<div class="row">
										<div class="col-2"></div>
										<div class="col-10">
											<h6>
												'.replaceColor($info_json->motd).'
											</h6>
										</div>
									</div>
									<div class="row">
										<div class="col-5">
											<span class="badge badge-dark">'.$info_json->version.'</span>
											'.($info_json->srv ? '<span class="badge badge-secondary ">SRV</span>' : '').'
										</div>
										<div class="col-7">
											<font color="#000">
												<p class="text-right">
													<span class="badge badge-secondary" data-toggle="tooltip" data-placement="bottom" data-html="true" title="어제 최고 동시 접속자<br>'.$peak1_time[0].'시 '.$peak1_time[1].'분">'.$peak1_json->players.' 명</span>
													<span class="badge badge-dark" data-toggle="tooltip" data-placement="bottom" data-html="true" title="오늘 최고 동시 접속자<br>'.$peak2_time[0].'시 '.$peak2_time[1].'분">'.$peak2_json->players.' 명</span>
													<span class="badge badge-success" data-toggle="tooltip" data-placement="bottom" data-html="true" title="최고 동시 접속자<br>'.$peak_json->time.'">'.$peak_json->players.'명 </span>
													<span class="badge badge-primary" data-toggle="tooltip" data-placement="bottom" data-html="true" title="현재 동시 접속자<br>'.Date("G시 i분").'">'.$info_json->players.' 명</span>
												</p>
											</font>
										</div>
									</div>
								</a>
							</li>
			';
	}
	if ($top_page >= $page && 0 < $page) {
		for ($i = ($page - 1) * 5; $i < ($top_page != $page ? ($page * 5) : $top_size); $i++) {
			$info_json = getJSON("../API/Status/".$top_list[$i].".json");
			$peak_json = getJSON("../API/Peak/AllDay/".$top_list[$i].".json");
			$peak1_json = getJSON("../API/Peak/Yester/".$top_list[$i].".json");
			$peak1_time = explode(":", $peak1_json->time);
			$peak2_json = getJSON("../API/Peak/Day/".$top_list[$i].".json");
			$peak2_time = explode(":", $peak2_json->time);
			$message = $message.'
							<li class="list-group-item">
								<a href="../ServerInfo/?name='.$top_list[$i].'">
									<div class="row">
										<div class="col-2">
											<center>
												<h4>'.($i + 1).'</h4>
											</center>
										</div>
										<div class="col-5">
											<h5><font color="#000">'.$top_list[$i].' 서버</font></h5>
										</div>
										<div class="col-5">
											<h5><p class="text-right">'.$info_json->ip.'</p></h5>
										</div>
									</div>
									<div class="row">
										<div class="col-2"></div>
										<div class="col-10">
											<h5>
												'.replaceColor($info_json->motd).'
											</h5>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-5">
											<span class="badge badge-dark">'.$info_json->version.'</span>
											'.($info_json->srv ? '<span class="badge badge-secondary ">SRV</span>' : '').'
										</div>
										<div class="col-7">
											<p class="text-right">
												<span class="badge badge-secondary" data-toggle="tooltip" data-placement="bottom" data-html="true" title="어제 최고 동시 접속자<br>'.$peak1_time[0].'시 '.$peak1_time[1].'분">'.$peak1_json->players.' 명</span>
												<span class="badge badge-dark" data-toggle="tooltip" data-placement="bottom" data-html="true" title="오늘 최고 동시 접속자<br>'.$peak2_time[0].'시 '.$peak2_time[1].'분">'.$peak2_json->players.' 명</span>
												<span class="badge badge-success" data-toggle="tooltip" data-placement="bottom" data-html="true" title="최고 동시 접속자<br>'.$peak_json->time.'">'.$peak_json->players.'명 </span>
												<span class="badge badge-primary" data-toggle="tooltip" data-placement="bottom" data-html="true" title="현재 동시 접속자<br>'.Date("G시 i분").'">'.$info_json->players.' 명</span>
											</p>
										</div>
									</div>
								</a>
							</li>
			';
		}
		$i = $page - 2;
		$m = $page + 2;
		if ($i < 1) {
			$m = $m + (-$i) + 1;
			$i = 1;
		} else if ($m > $top_page) {
			$i = $i - ($m - $top_page);
			$m = $top_page;
		}
		$message = $message.'
							<li class="list-group-item">
								<center>
									<div class="btn-group" role="group">
										<button type="button" class="btn btn-'.($page == 1 ? 'secondary' : 'success').'" onClick="location.href=\'../PlayersTop/?page=1\'">맨 앞</button>';
		if ($page - 1 > 0) $message = $message.'<button type="button" class="btn btn-info" onClick="location.href=\'../PlayersTop/?page='.($page - 1).'\'"><</button>';
		for (; $i <= $m; $i++) {
			$message = $message.'
										<button type="button" class="btn btn-'.($page == $i ? 'outline-' : '').'primary" onClick="location.href=\'../PlayersTop/?page='.$i.'\'">'.$i.'</button>
								';
		}
		if ($page + 1 < $top_page) $message = $message.'<button type="button" class="btn btn-info" onClick="location.href=\'../PlayersTop/?page='.($page + 1).'\'">></button>';
		$message = $message.'
										<button type="button" class="btn btn-'.($page == $top_page ? 'secondary' : 'success').'" onClick="location.href=\'../PlayersTop/?page='.$top_page.'\'">맨 뒤</button>
									</div>
								</center>
							</li>
							';
	} else {
		$message = $message.'
							<li class="list-group-item">
								<br>
								<br>
								<center>
									<h2>해당 페이지에 대한 데이터가 없습니다!</h2>
								</center>
								<br>
								<br>
							</li>
		';
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
							<strong class="card-title text-light"><?php echo $page_name; ?></strong>
						</div>
						<ul class="list-group list-group-flush">
							<?php echo $message; ?>
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
