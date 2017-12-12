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
				<h3 class="medium-9 large-9 cell content-title">Удалить читателя</h3>
				<form action="remove_reader.php" method="post">
					<div class="grid-x grid-margin-x">

						<div class="medium-12 large-12 cell">
							<input class="content-input" name="id" placeholder="ID Читателя" value="" aria-describedby="name-format">
						</div>

						<div class="medium-3 large-3 cell">
							<button class="content-button" type="submit" value="Submit">Удалить</button>
						</div>

					</div>
				</form>

				<?php
					@include 'extension.php';
					$dbh = pdoConnect();

					if (!empty($_POST)){

						$id = $_POST['id'];
						$name = $_POST['name'];
						$email = $_POST['email'];
						$phone = $_POST['phone'];

						$sql = "SELECT readers.id 
							FROM readers
							WHERE readers.id = '$id'
						";
						$result = pushSQLtoDB($dbh, $sql);

						//Заполнение полей
						if($id){
							//Есть ли читатель с таким ID
							if($result){

								$sql = "SELECT * FROM issue
									WHERE issue.date_e IS NULL
									AND issue.id_reader = '$id'
								";
								$periodEnd = pushSQLtoDB($dbh, $sql);

								$sql = "SELECT COUNT(*) FROM issue
									WHERE issue.id_reader = '$id'
								";
								$result = pushSQLtoDB($dbh, $sql);
								$count = getValue($result,'COUNT(*)');
								echo($count);
								
								//Читатель сдал все книги ИЛИ у читателя нет записейв журнале 
								if(!$periodEnd || $count < 1){
									$sql = "DELETE FROM readers
										WHERE readers.id  = '$id'
									";
									pushSQLtoDB($dbh, $sql);
									getSuccsess('Читатель с ID '.$id.' удален');
								}
								else {
									getError('Данному читателю необходимо вернуть книги');
								}
							}
							else {
								getError('Не удалось найти читателя с ID '.$id);
							}
						}
						else {
							getError('Заполните все поля');
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