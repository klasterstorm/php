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
					<div class="medium-12 large-12 cell aside-category">Операции над книгами</div>
						<a href="books.php" class="medium-12 large-12 cell aside-cell-active">
							Книги
						</a>
					<div class="medium-12 large-12 cell aside-category">Операции над читателями</div>
						<a href="readers.php" class="medium-12 large-12 cell aside-cell">
							Читатели
						</a>
					<div class="medium-12 large-12 cell aside-category">Операции над выдечей</div>
						<a href="getting.php" class="medium-12 large-12 cell aside-cell">
							Выдача книги
						</a>
					</div>
				</div>
				<!-- Контент -->
				<div class="medium-9 large-9 cell">
					<form action="books.php" method="post">
						<div class="grid-x grid-margin-x">
							<div class="small-12 medium-6 large-6 cell">
								<input class="content-input" name="id" placeholder="ID" value="" aria-describedby="name-format">
							</div>

							<div class="small-12 medium-6 large-6 cell">
								<input class="content-input" name="id_author" placeholder="Автор" value="" aria-describedby="name-format">
							</div>

							<div class="small-12 medium-6 large-6 cell">
								<input class="content-input" name="title" placeholder="Название" value="" aria-describedby="name-format">
							</div>

							<div class="small-12 medium-6 large-6 cell">
								<input class="content-input" name="id_genre" placeholder="Жанр" value="" aria-describedby="name-format">
							</div>

							<div class="small-12 medium-6 large-6 cell">
								<div class="content-checkBox">
									<input id="amountTrue" name="amount" type="checkbox"><label for="amountTrue">Наличие</label>
								</div>
							</div>

							<div class="small-12 medium-6 large-6 cell">
								<button class="content-button" type="submit" value="Submit">Поиск</button>
							</div>
						</div>
					</form>

					<?php
						@include 'extension.php';
						$dbh = dboConnect();

						if (!empty($_POST)){
							$id = $_POST['id'];
							$id_author = $_POST['id_author'];
							$title = $_POST['title'];
							$id_genre = $_POST['id_genre'];
							$amount = $_POST['amount'];

							$sql = "SELECT * FROM books WHERE 
								 id = CASE WHEN '$id' <> '' THEN '$id' ELSE id END
								 AND id_author = CASE WHEN '$id_author' <> '' THEN '$id_author' ELSE id_author END
								 AND title = CASE WHEN '$title' <> '' THEN '$title' ELSE title END
								 AND id_genre = CASE WHEN '$id_genre' <> '' THEN '$id_genre' ELSE id_genre END
								 AND amount > CASE WHEN '$amount' = 'on' THEN 0 ELSE -1 END
							";

							$result = pushSQLtoDB($dbh, $sql);

							$titleForTable = array(
								"id"    => "ID",
								"id_author"  => "ID Автора",
								"title"  => "Название книги",
								"id_genre"  => "ID Жанра",
								"amount"  => "Колличество"
							);
							getTable($result, $titleForTable);
						}
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
