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
				<h3 class="medium-9 large-9 cell content-title">Просроченные книги</h3>
				<?php
					@include 'extension.php';
					$dbh = pdoConnect();

					$sql = "SELECT issue.date_s, issue.id_book, books.title AS title, 
						authors.name AS author_name, 
						readers.name AS reader_name FROM issue 
						LEFT JOIN books ON issue.id_book = books.id 
						LEFT JOIN authors ON authors.id = books.id_author 
						LEFT JOIN readers ON readers.id = issue.id_readeR 
						WHERE issue.date_e IS NULL 
						AND issue.date_s < CURRENT_DATE - INTERVAL 1 DAY
					";

					$result = pushSQLtoDB($dbh, $sql);

					$titleForTable = array(
						"id_book"  => "ID Книги",
						"reader_name"  => "Имя читателя",
						"author_name"  => "Имя автора",
						"title"  => "Название книги",
						"date_s"  => "Дата выдачи"
					);
					getTable($result, $titleForTable);

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