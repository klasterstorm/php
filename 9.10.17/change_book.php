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
				<h3 class="medium-9 large-9 cell content-title">Изменить книгу</h3>
				<form action="change_book.php" method="post">
					<div class="grid-x grid-margin-x">

						<div class="small-6 medium-6 large-12 cell">
							<input class="content-input" name="id" placeholder="ID Книги" value="" aria-describedby="name-format">
						</div>

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
							<button class="content-button" type="submit" value="Submit">Изменить</button>
						</div>
					</div>
				</form>

				<?php
					@include 'extension.php';
					$dbh = pdoConnect();

					if (!empty($_POST)){
						$id = $_POST['id'];
						$author = $_POST['author'];
						$title = $_POST['title'];
						$genre = $_POST['genre'];
						$price = $_POST['price'];

						$sql = "SELECT books.id FROM books
							WHERE books.id = '$id'
						";

						$result = pushSQLtoDB($dbh, $sql);

						//Проверка на заполнение полей
						if($id){

							//Есть ли книга с таким ID
							if($result) {
								//Получаю ID Автора
								$id_author = getIDAuthor($dbh,$author);
								
								//Получаю ID Жанра
								$id_genre = getIDGenre($dbh,$genre);

								//Меняю данные в таблице на нужные
								$sql = "UPDATE books 
									SET books.id_author = '$id_author',
									books.title = '$title',
									books.id_genre = '$id_genre',
									books.price = '$price'
									WHERE books.id = '$id'
								";

								pushSQLtoDB($dbh, $sql);
								getSuccsess('Книга с ID '.$id.' успешно изменена');
							}
							else {
								getError('Книги с ID '.$id.' не найдена');
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