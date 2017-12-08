<!doctype html>
<html class="no-js" lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>SomeSite</title>
		<link rel="stylesheet" href="css/foundation.css">
		<link rel="stylesheet" href="css/app.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div class="grid-container">
			<div class="medium-12 large-12 cell header">
				<h1>БИБЛИОТЕКА</h1>
			</div>
			<div class="grid-x grid-margin-x">
				<!-- Меню -->
				<div class="medium-3 large-3 cell aside">
					<div class="grid-x grid-margin-x">
						<?php include('header.html'); ?>
					</div>
				</div>
				<!-- Контент -->
				<div class="medium-9 large-9 cell">
					<?php
						@include 'extension.php';
						getSuccsess("Для начала работы выберите пункт меню");
					?>
				</div>
			</div>
		</div>
		<script src="js/vendor/jquery.js"></script>
		<script src="js/vendor/what-input.js"></script>
		<script src="js/vendor/foundation.js"></script>
		<script src="js/app.js"></script>
	</body>
</html>
