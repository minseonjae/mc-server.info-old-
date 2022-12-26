<?php
	$search = "";
	$content = "";
	if (!empty($_GET['search'])) {
		$search = $_GET['search'];
		$dir = "../API/List/";
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if (strlen($file) < 6) continue;
				$server_info = json_decode(file_get_contents($dir.$file));
				if (empty($server_info->ip)) continue;
				if (strpos(strtolower(substr($file, 0, strlen($file) - 5)), strtolower($search)) !== false) {
					$content = $content.'<a href="../Server/?name='.substr($file, 0, strlen($file) - 5).'" class="list-group-item">'.substr($file, 0, strlen($file) - 5).'서버 - '.$server_info->ip.'</a>';
				} else if (strpos(strtolower($server_info->ip), strtolower($search)) !== false) {
					$content = $content.'<a href="../Server/?name='.substr($file, 0, strlen($file) - 5).'" class="list-group-item">'.$server_info->ip.' - '.substr($file, 0, strlen($file) - 5).'서버</a>';
				}
			}
			if (strlen($content) < 1) {
				$content = '<a class="list-group-item">검색한 내용에 대한 결과가 없습니다!</a>';
			}
		} else $content = '<a class="list-group-item">오류가 발생했습니다! (1)</a>';
	} else $content = '<a class="list-group-item">검색한 값이 없습니다!</a>';
?>
<!DOCTYPE html>
<html lang="ko">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Minecraft Server Info</title>
		<meta name="description" content="Minecraft Server Info">
		
		<link rel="apple-touch-icon" href="../icon.png">
		<link rel="shortcut icon" href="../icon.png">

		<link href="../css/bootstrap.css" rel="stylesheet">
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
								<li><a href="../">홈</a></li>
								<li><a href="../Add">추가</a></li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">서버 <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="../Server/Top/Players">동시 접속자 순위</a></li>
										<li><a href="../Server/Top//Peak/Allday">최고 동시 접속자 순위</a></li>
										<li><a href="../Server/Top//Peak/Today">오늘 최고 동시 접속자 순위</a></li>
										<li><a href="../Server/Top//Peak/Yesterday">어제 최고 동시 접속자 순위</a></li>
									</ul>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">문의 <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a>Discord : McServerInfo#5047</a></li>
									</ul>
								</li>
								<li><a href="../TermsAndConditions">이용약관</a></li>
								<li><a href="../PrivacyAgreement">개인정보취급방침</a></li>
							</ul>
							<form action="../Search" method="get" class="navbar-form navbar-right" role="search">
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
							<h2>
								검색 결과
								<br>
								<small>"<?php echo $search; ?>"에 대한 검색 결과</small>
							</h2>
							<div class="list-group">
								<?php echo $content; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-2"></div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
	</body>
</html>