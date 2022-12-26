<?php

	$amount = count(explode("/", $_SERVER['REQUEST_URI']));
	$for_path = "";
	for ($i = 0; $i < $amount - 1; $i++) $for_path = $for_path."../";
	$stats_path = $for_path."total/";
	
	include_once $for_path."total.php";
?>
<!DOCTYPE html>
<html lang="ko">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Minecraft Server Info</title>
		<meta name="description" content="마인크래프트 서버 정보 및 통계 사이트">
		
		<link rel="apple-touch-icon" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/icon.png">
		<link rel="shortcut icon" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/icon.png">

		<link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/css/bootstrap.min.css" rel="stylesheet">
		
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-md-2"></div>
				<div class="col-xs-12 col-md-8">
					<p class="text-right"><small><?php echo "Today - ".$today_total."<br>Total - ".$total;?></small></p>
					<h1><strong>M</strong><small>ine</small><strong>C</strong><small>raft</small> <strong>S</strong><small>erver</small> <strong>I</strong><small>nfo</small></h1>
					<br>
					<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
						<a class="navbar-brand" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>"> HOME </a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse" id="navbarColor02">
							<ul class="navbar-nav mr-auto">
								<li class="nav-item">
									<a class="nav-link" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/Add/"> ADD </a>
								</li>
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> SERVER LIST </a>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/Server/Top/Players/">동시 접속자 순위</a>
										<a class="dropdown-item" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/Server/Top/Peak/AllDay/">최고 동시 접속자 순위</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/Server/Top/Peak/ToDay/">오늘 최고 동시 접속자 순위</a>
										<a class="dropdown-item" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/Server/Top/Peak/YesterDay/">어제 최고 동시 접속자 순위</a>
									</div>
								</li>
							</ul>
							<form action="https://<?php echo $_SERVER['HTTP_HOST']; ?>/Search/" method="get" class="form-inline my-2 my-lg-0">
								<input class="form-control mr-sm-2" type="text" name="search" placeholder="Search">
								<button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
							</form>
						</div>
					</nav>
					<hr>