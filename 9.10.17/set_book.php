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
				<h3 class="medium-9 large-9 cell content-title">Добавить книгу</h3>
				<form action="set_book.php" method="post">
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

						<div class="small-12 medium-3 large-3 cell">
							<button class="content-button" type="submit" value="Submit">Добавить</button>
						</div>
					</div>
				</form>

				<?php
					@include 'extension.php';
					$dbh = pdoConnect();

					if (!empty($_POST)){
						$author = $_POST['author'];
						$title = $_POST['title'];
						$genre = $_POST['genre'];
						$price = $_POST['price'];

						$sql = "SELECT books.id, books.title, authors.name AS author FROM books
							CROSS JOIN authors ON books.id_author = authors.id
							WHERE authors.name = CASE WHEN '$author' <> '' THEN '$author' ELSE authors.name END
							AND books.title = CASE WHEN '$title' <> '' THEN '$title' ELSE books.title END
						";

						$result = pushSQLtoDB($dbh, $sql);

						//Заполнение полей
						if($author && $title){

							//Существует ли книга с таким Автором и Жанром
							if($result) {
								getSuccsess('Данная книга уже существует');

								$sql = "SELECT books.id, books.title, authors.name AS author FROM books
									CROSS JOIN authors ON books.id_author = authors.id
									WHERE authors.name = CASE WHEN '$author' <> '' THEN '$author' ELSE authors.name END
									AND books.title = CASE WHEN '$title' <> '' THEN '$title' ELSE books.title END
								";
								$result = pushSQLtoDB($dbh, $sql);
								$id_book = getValue($result, 'id');

								//Увеличиваем кол-во книг
								$sql = "UPDATE books SET books.amount = books.amount + 1 WHERE books.id = '$id_book'";
								pushSQLtoDB($dbh, $sql);

								getSuccsess('Количество данных книг увеличино на 1');

								$titleForTable = array(
									"id"  => "ID",
									"author"  => "Автор",
									"title"  => "Название книги",
								);
								getTable($result, $titleForTable);
							}
							else {
								//Получаю ID Автора
								$id_author = getIDAuthor($dbh,$author);

								//Получаю ID Жанра
								$id_genre = getIDGenre($dbh,$genre);

								//Добавляем книгу в базу
								$sql = "INSERT INTO books (id_author, title, id_genre, price, amount) VALUES ('$id_author', '$title', '$id_genre', '$price', '1')";
				
								pushSQLtoDB($dbh, $sql);
								getSuccsess('Книга добавлена');
							}
						}
						else {
							getError('Необходимо заполнить все поля');
						}
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