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

						<!-- <div class="small-12 medium-6 large-6 cell">
							<div class="content-checkBox">
								<input id="amountTrue" name="amount" type="checkbox">
								<label for="amountTrue">Наличие</label>
							</div>
						</div> -->

						<div class="small-12 medium-3 large-3 cell">
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

						$sql = "SELECT books.id, books.title, authors.name AS author FROM books
							CROSS JOIN authors ON books.id_author = authors.id
							WHERE authors.name = CASE WHEN '$author' <> '' THEN '$author' ELSE authors.name END
							AND books.title = CASE WHEN '$title' <> '' THEN '$title' ELSE books.title END
						";

						$result = pushSQLtoDB($dbh, $sql);

						//Заполнение полей
						if($author && $title && $genre && $price){

							//Существует ли книга с таким Автором и Жанром
							if($result) {
								getSuccsess('Данная книга уже существует');
								$titleForTable = array(
									"id"  => "ID",
									"author"  => "Автор",
									"title"  => "Название книги",
								);
								getTable($result, $titleForTable);
							}
							else {

								$result = pushSQLtoDB($dbh,
								"SELECT authors.name FROM authors
									WHERE authors.name = CASE WHEN '$author' <> '' THEN '$author' ELSE authors.name END
								");

								//Есть ли Автор в базе
								if(!$result){
									$sql = "INSERT INTO authors (name) VALUES ('$author')";
									pushSQLtoDB($dbh, $sql);
									getSuccsess('Автор '.$author.' добавлен в базу');
								}
								
								//Получаем ID автора
								$sql = "SELECT authors.id, authors.name FROM authors
									WHERE authors.name = CASE WHEN '$author' <> '' THEN '$author' ELSE authors.name END
								";
								$result = pushSQLtoDB($dbh,$sql);
								$id_author = getValue($result, 'id');

								$sql = "SELECT genre.name FROM genre
									WHERE genre.name = CASE WHEN '$genre' <> '' THEN '$genre' ELSE genre.name END
								";
								$result = pushSQLtoDB($dbh,$sql);

								//Есть ли Жанр в базе
								if(!$result){
									$sql = "INSERT INTO genre (name) VALUES ('$genre')";
									pushSQLtoDB($dbh, $sql);
									getSuccsess('Жанр '.$genre.' добавлен в базу');
								}

								//Получаем ID жанра
								$sql = "SELECT genre.id, genre.name FROM genre
									WHERE genre.name = CASE WHEN '$genre' <> '' THEN '$genre' ELSE genre.name END
								";
								$result = pushSQLtoDB($dbh,$sql);
								$id_genre = getValue($result, 'id');

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