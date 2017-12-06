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
				<form action="books.php" method="post">
					<div class="grid-x grid-margin-x">
						<div class="small-12 medium-6 large-6 cell">
							<input class="content-input" name="author" placeholder="Автор" value="" aria-describedby="name-format">
						</div>

						<div class="small-12 medium-6 large-6 cell">
							<input class="content-input" name="title" placeholder="Название книги" value="" aria-describedby="name-format">
						</div>

						<div class="small-12 medium-6 large-6 cell">
							<input class="content-input" name="genre" placeholder="Жанр" value="" aria-describedby="name-format">
						</div>

						<div class="small-12 medium-6 large-6 cell">
							<input class="content-input" name="price" placeholder="Цена" value="" aria-describedby="name-format">
						</div>

						<div class="small-12 medium-6 large-6 cell">
							<div class="content-checkBox">
								<input id="amountTrue" name="amount" type="checkbox">
								<label for="amountTrue">Наличие</label>
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
							$author = $_POST['author'];
							$title = $_POST['title'];
							$genre = $_POST['genre'];
							$price = $_POST['price'];
							$amount = $_POST['amount'];

							$sql = "SELECT books.title, books.amount, books.price, authors.name AS author, 
								genre.name AS genre FROM books 
        						CROSS JOIN authors ON books.id_author = authors.id
        						CROSS JOIN genre ON books.id_genre = genre.id
								WHERE authors.name = CASE WHEN '$author' <> '' THEN '$author' ELSE authors.name END
								AND books.title = CASE WHEN '$title' <> '' THEN '$title' ELSE books.title END
								AND genre.name = CASE WHEN '$genre' <> '' THEN '$genre' ELSE genre.name END
								AND books.price = CASE WHEN '$price' <> '' THEN '$price' ELSE books.price END
								AND amount > CASE WHEN '$amount' = 'on' THEN 0 ELSE -1 END
							";

							$result = pushSQLtoDB($dbh, $sql);

							$titleForTable = array(
								"author"  => "Автор",
								"title"  => "Название книги",
								"genre"  => "Название жанра",
								"amount"  => "Количество",
								"price"  => "Цена"
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