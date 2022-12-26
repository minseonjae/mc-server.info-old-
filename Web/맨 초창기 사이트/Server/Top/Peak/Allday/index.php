<?php
	include "../../../../../API.php";
	
	/* 최고 동시 접속자 */
	
	$page = 1;
	
	if (!empty($_GET['page'])) $page = $_GET['page'];
	
	$top_list = getJSON("../../../../API/AlldayPlayersTop.json")->top;
	$top_size = count($top_list);
	$top_page = floor($top_size / 5) + ($top_size % 5 > 0 ? 1 : 0);
	
	$message = "";
	if ($top_page >= $page && 0 < $page) {
		$allplayer = getJSON("../../../../API/Players.json")->players;
		for ($i = ($page - 1) * 5; $i < ($top_page != $page ? ($page * 5) : $top_size); $i++) {
			$file1 = "../../../../API/Data/".$top_list[$i].".json";
			$file2 = "../../../../API/List/".$top_list[$i].".json";
			if (file_exists($file1) && file_exists($file2)) {
				$data_json = getJSON($file1);
				$list_json = getJSON($file2);
							$updown = $data_json->peak->yesterday->players > 0 ? (round($data_json->peak->today->players / $data_json->peak->yesterday->players * 10000) / 100) - 100 : 0;
							$message = $message.'
							<a href="../../../../Server/?name='.$top_list[$i].'" class="list-group-item">
								<div class="row">
									<div class="col-xs-2 col-md-2">
										<center>
											<h4><font color="#000">'.($i + 1).'</font></h4>
										</center>
									</div>
									<div class="col-xs-5 col-md-5">
										<h4><font color="#000">'.$top_list[$i].' 서버</font></h4>
									</div>
									<div class="col-xs-5 col-md-5">
										<h5><p class="text-right">'.$list_json->ip.'</p></h5>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-2">
										<h5>
											<center>
												<font color="#000">
													<font data-toggle="tooltip" data-placement="top" title="업타임" data-html="true"><span class="glyphicon glyphicon-circle-arrow-up" aria-hidden="true"></span> '.(round($data_json->uptime->get / $data_json->uptime->check * 10000) / 100).'%</font><br>
													<font data-toggle="tooltip" data-placement="top" title="어제 오늘<br>최고 동시 접속자 변경률" data-html="true"><span class="glyphicon glyphicon-sort" aria-hidden="true"></span> '.($updown > 0 ? '+'.$updown : $updown).'%</font><br>
													<font data-toggle="tooltip" data-placement="top" title="전체<br>동시 접속자 차지 비율" data-html="true"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.(round($data_json->players / $allplayer * 10000) / 100).'%</font>
												</font>
											</center>
										</h5>
									</div>
									<div class="col-xs-12 col-md-10">
										<br>
										<h4>'.replaceColor($data_json->motd).'</h4>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-xs-7 col-md-6">
										<span class="badge badge-dark">'.$data_json->version.'</span>
										'.($data_json->srv ? '<span class="badge badge-secondary ">SRV</span>' : '').'
									</div>
									<div class="col-xs-5 col-md-6">
										<p class="text-right">
											<span class="badge badge-success" data-toggle="tooltip" data-placement="top" title="최고 동시 접속자<br>'.$data_json->peak->allday->time.'" data-html="true">'.$data_json->peak->allday->players.'명</span>
											<span class="badge badge-info">'.$data_json->players.' / '.$data_json->maxplayers.'</span>
										</p>
									</div>
								</div>
							</a>
			';
			} else {
				$message = $message.'
				<li class="list-group-item">
				</li>
				';
			}
		}
		$i = $page - 2;
		$m = $page + 2;
		if ($i < 1) {
			$m = $m + (-$i) + 1;
			$m = $m > $top_page ? $top_page : $m;
			$i = 1;
		} else if ($m > $top_page) {
			$i = $i - ($m - $top_page);
			$m = $top_page;
		}
		$message = $message.'
							<li class="list-group-item">
								<center>
									<div class="btn-group" role="group">
										<button type="button" class="btn btn-default '.($page == 1 ? 'disabled' : '').'" onClick="location.href=\'../Allday/?page=1\'">맨 앞</button>';
		if ($page - 1 > 0) $message = $message.'<button type="button" class="btn btn-info" onClick="location.href=\'../Allday/?page='.($page - 1).'\'"><</button>';
		for (; $i <= $m; $i++) {
			$message = $message.'
										<button type="button" class="btn btn-default '.($page == $i ? 'disabled' : '').'" onClick="location.href=\'../Allday/?page='.$i.'\'">'.$i.'</button>
								';
		}
		if ($page + 1 < $top_page) $message = $message.'<button type="button" class="btn btn-info" onClick="location.href=\'../Allday/?page='.($page + 1).'\'">></button>';
		$message = $message.'
										<button type="button" class="btn btn-default '.($page == $top_page ? 'disabled' : '').'" onClick="location.href=\'../Allday/?page='.$top_page.'\'">맨 뒤</button>
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
<!DOCTYPE html>
<html lang="ko">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Minecraft Server Info</title>
		<meta name="description" content="Minecraft Server Info">
		
		<link rel="apple-touch-icon" href="../../../../icon.png">
		<link rel="shortcut icon" href="../../../../icon.png">

		<link href="../../../../css/bootstrap.css" rel="stylesheet">
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
								<li><a href="../../../../">홈</a></li>
								<li><a href="../../../../Add">추가</a></li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">서버 <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="../../Players">동시 접속자 순위</a></li>
										<li><a href="../Allday">최고 동시 접속자 순위</a></li>
										<li><a href="../Today">오늘 최고 동시 접속자 순위</a></li>
										<li><a href="../Yesterday">어제 최고 동시 접속자 순위</a></li>
									</ul>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">문의 <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a>Discord : McServerInfo#5047</a></li>
									</ul>
								</li>
								<li><a href="../../../../TermsAndConditions">이용약관</a></li>
								<li><a href="../../../../PrivacyAgreement">개인정보취급방침</a></li>
							</ul>
							<form action="../../../../Search" method="get" class="navbar-form navbar-right" role="search">
								<div class="form-group">
									<input type="text" name="search" class="form-control" placeholder="Search">
								</div>
								<button type="submit" class="btn btn-default">검색</button>
							</form>
						</div>
					</nav>
					<hr>
					<div class="row">
						<div class="col-md-12">
							<br>
							<div class="list-group">
								<div class="list-group-item">최고 동시 접속자 순위</div>
								<?php echo $message; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-2"></div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="../../../../js/bootstrap.min.js"></script>
		<script>
			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			})
		</script>
	</body>
</html>
