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
						<a href="books.php" class="medium-12 large-12 cell aside-cell">
							Книги
						</a>
					<div class="medium-12 large-12 cell aside-category">Операции над читателями</div>
						<a href="readers.php" class="medium-12 large-12 cell aside-cell">
							Читатели
						</a>
					<div class="medium-12 large-12 cell aside-category">Операции над выдечей</div>
						<a href="getting.php" class="medium-12 large-12 cell aside-cell-active">
							Выдача книги
						</a>
					</div>
				</div>
				<!-- Контент -->
				<div class="medium-9 large-9 cell">
					<form action="getting.php" method="post">
						<div class="grid-x grid-margin-x">
							<div class="medium-6 large-6 cell">
								<input class="content-input" name="id_reader" placeholder="ID Читателя" value="" aria-describedby="name-format">
							</div>

							<div class="medium-6 large-6 cell">
								<input class="content-input" name="id_book" placeholder="ID Книги" value="" aria-describedby="name-format">
							</div>

							<div class="medium-6 large-6 cell">
								<input class="content-input" name="date_e" type="date" placeholder="Дата возврата книги"  value="" aria-describedby="name-format">
							</div>

							<div class="medium-6 large-6 cell">
								<button class="content-button" type="submit" value="Submit">Выдать книгу</button>
							</div>

						</div>
					</form>

					<?php
						@include 'extension.php';
						$dbh = dboConnect();

						if (!empty($_POST)){
							$id_reader = $_POST['id_reader'];
							$id_book = $_POST['id_book'];
							$date_e = $_POST['date_e'];

							//Проверка на заполнение полей
							if ($id_reader <> '' && $id_book <> '' && $date_e <> '') {

								$sql = "SELECT * FROM books,readers WHERE 
								books.id = '$id_book'
								AND readers.id = '$id_reader'
								";
	
								$result = pushSQLtoDB($dbh, $sql);


								//Проверка на книгу и читателя
								if($result <> NULL) {
									$sql = "SELECT books.amount FROM books WHERE 
									books.id = '$id_book'
									AND books.amount > 0
									";
									$result = pushSQLtoDB($dbh, $sql);

									//Проверка на книгу и колличество книг
									if($result <> NULL) {
										//Отнимаем книгу
										$sql = "UPDATE books SET books.amount = books.amount - 1 WHERE books.id = '$id_book'";
										setSQLtoDB($dbh, $sql);

										$sql = "INSERT INTO issue (id_reader, id_book, date_s, date_e) VALUES ($id_reader, $id_book, '$date', $date_e)";
										setSQLtoDB($dbh, $sql);


										date_default_timezone_set('Asia/Vladivostok');
										$date = date('Y-m-d', time());

										//Выводим
										$sql = "SELECT * FROM issue WHERE
										issue.id_reader = '$id_reader'
										AND issue.id_book = '$id_book'
										";
										$result = pushSQLtoDB($dbh, $sql);
										var_dump($result);
										getSuccsess('Книга выдана');
										$titleForTable = array(
											"id_reader" =>	"id_readerID",
											"id_book" =>	"id_book",
											"date_s" =>	"date_s",
											"date_e" =>	"date_e",
											"id"	=>	"id",
											"id_author"	=>	"id_author",
											"title" =>	"title",
											"id_genre"	=>	"id_genre",
											"price"	=>	"price",
											"amount"	=>	"amount",
										);
										getTable($result, $titleForTable);
									}
									else {
										getError("Увы, данные книги у нас закончились...");
									}
								}
								else {
									getError("Упс, кажется у нас нет информации по вашим данным...");
								}
							}
							else {
								getError("Необходимо заполнить все поля!");
							}	
						}
						else {
							getSystem("Введите данные");
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
