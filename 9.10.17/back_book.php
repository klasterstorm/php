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
				<h3 class="medium-9 large-9 cell content-title">Возврат книги</h3>
				<form action="back_book.php" method="post">
					<div class="grid-x grid-margin-x">
						<div class="small-12 medium-6 large-6 cell">
							<input class="content-input" name="id_reader" placeholder="ID Читателя" value="" aria-describedby="name-format">
						</div>

						<div class="small-12 medium-6 large-6 cell">
							<input class="content-input" name="id_book" placeholder="ID Книги" value="" aria-describedby="name-format">
						</div>

						<div class="small-12 medium-3 large-3 cell">
							<button class="content-button" type="submit" value="Submit">Возвратить</button>
						</div>
					</div>
				</form>

				<?php
					@include 'extension.php';
					$dbh = pdoConnect();

					if (!empty($_POST)){
						$id_book = $_POST['id_book'];
						$id_reader = $_POST['id_reader'];


						//Проверка на заполнение полей
						if($id_book && $id_reader) {
							$sql = "SELECT * FROM issue
								WHERE issue.id_book = '$id_book'
								AND issue.id_reader = '$id_reader'
								AND issue.date_e IS NULL
							";

							$result = pushSQLtoDB($dbh, $sql);
				
							if($result) {
								date_default_timezone_set('Asia/Vladivostok');
								$date = date('Y-m-d', time());

								$sql = "UPDATE issue 
									SET issue.date_e = '$date'
									WHERE issue.id_book = '$id_book'
									AND issue.id_reader = '$id_reader'
								";

								pushSQLtoDB($dbh, $sql);
								getSuccsess('Книга успешно сдана');
							}
							else {
								getError('Проверьте правильность заполнения полей');
							}
						}
						else {
							getError('Необходимо заполнить все поля!');
						}

						// $sql = "SELECT books.id FROM issue
						// 	WHERE books.id = '$id'
						// ";

						// $result = pushSQLtoDB($dbh, $sql);
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