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
				<h3 class="medium-9 large-9 cell content-title">Поиск читателя</h3>
				<form action="readers.php" method="post">
					<div class="grid-x grid-margin-x">
						<div class="medium-6 large-6 cell">
							<input class="content-input" name="id" placeholder="ID" value="" aria-describedby="name-format">
						</div>

						<div class="medium-6 large-6 cell">
							<input class="content-input" name="name" placeholder="Имя" value="" aria-describedby="name-format">
						</div>

						<div class="medium-6 large-6 cell">
							<input class="content-input" name="email" placeholder="Почта" aria-describedby="exampleHelpTex" data-abide-ignore>
						</div>

						<div class="medium-6 large-6 cell">
							<input class="content-input" name="phone" placeholder="Телефон" aria-describedby="exampleHelpTex" data-abide-ignore>
						</div>

						<div class="medium-3 large-3 cell">
							<button class="content-button" type="submit" value="Submit">Найти</button>
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

						$sql = "SELECT * FROM readers WHERE 
								id = CASE WHEN '$id' <> '' THEN '$id' ELSE id END
								AND name = CASE WHEN '$name' <> '' THEN '$name' ELSE name END
								AND email = CASE WHEN '$email' <> '' THEN '$email' ELSE email END
								AND phone = CASE WHEN '$phone' <> '' THEN '$phone' ELSE phone END";

						$result = pushSQLtoDB($dbh, $sql);

						$titleForTable = array(
							"id"    => "ID",
							"name"  => "Имя",
							"email"  => "Почта",
							"phone"  => "Номер телефона",
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