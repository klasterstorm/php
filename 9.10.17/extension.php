<?php

    //Выборка SQL в DB
    function pushSQLtoDB($dbh, $sql) {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }

    //Поключение к базе данных
    function pdoConnect() {
        $user = 'root';
        $pass = 'root';
        $dbName = 'php';

        try {
            $dbh = new PDO('mysql:host=localhost;dbname='.$dbName.';charset=utf8', $user, $pass);
        } catch (PDOException $e) {
            die(getError($e->getMessage()));
        }
        return $dbh;
    }

    //Вывод ошибки
    function getError($outputText){
        echo'<div class="grid-x grid-margin-x">
            <div class="large-12 medium-12 cell content-errorBoard">',$outputText,'</div>
        </div>';
    }

    //Вывод сообщения
    function getSuccsess($outputText){
        echo'<div class="grid-x grid-margin-x">
            <div class="large-12 medium-12 cell content-succsessBoard">',$outputText,'</div>
        </div>';
    }

    //Системные сообщения
    function getSystem($outputText){
        echo'<div class="grid-x grid-margin-x">
            <div class="large-12 medium-12 cell content-systemBoard">',$outputText,'</div>
        </div>';
    }

    //Получение значения по ключу
    function getValue($result, $key) {
        if($result) {
            foreach($result as $row) {
                return $row[$key];
            }
        }
        else {
            getError('Не могу получить значение по ключу '.$key);
            getError(var_dump($result));
        }
    }

    //Вывод таблицы
    function getTable($result, $titleForTable) {

        //Так выглядит вызов этой функции

        //Ключи для построения/именования таблицы
        // $titleForTable = array(
        //     "id"    => "ID",
        //     "name"  => "Название",
        //     "email"  => "Почта",
        //     "phone"  => "Номер телефона",
        // );

        //Вызов построителя таблицы
        // getTable($result, $titleForTable);

        $keys = array_keys($titleForTable);

        if (!empty($result)){
            echo '<div class="grid-x grid-margin-x content-container">
                <div class="small-12 medium-12 large-12 cell content-table content-table-rowColor content-table-header">
                <table>
                <thead>
                <tr>';
            foreach($titleForTable as $index) {
                echo '<th>',$index ,'</th>';
            }
            echo '</tr>
                </thead>
                <tbody>';
            foreach($result as $row) {
                echo '<tr>';
                foreach($keys as $index) {
                    if ($row['date_s'] <> NULL && $row['date_s'] < date('Y-m-d', strtotime("-1 days"))) {
                        echo '<td class="content-table-errorRow">',$row[$index] ,'</td>';
                    }
                    else {
                        if(is_numeric($row['amount']) && $row['amount'] == 0){
                            echo '<td class="content-table-errorRow">',$row[$index] ,'</td>';
                        }
                        else {
                            echo '<td>',$row[$index] ,'</td>';
                        }
                    }
                }
                echo '</tr>';
            }
            echo '</tbody>
                </table>
                </div>
                </div>';
        }
        else {
            getError("Упс, кажется у нас нет информации по вашим данным...");
        }
    }


    //Две нижние функции можно объединить в 1 универсальную, но мне лень

    //Получение ID автора

    //Если автора нет, то добавляем его в базу авторов. Получаем его ID
    //Если автор есть, получаем его ID
    function getIDAuthor($dbh,$author) {
        //Поиск автора в базе
        $result = pushSQLtoDB($dbh,
        "SELECT authors.name FROM authors
            WHERE authors.name = CASE WHEN '$author' <> '' THEN '$author' ELSE authors.name END
        ");

        //Если автора нет в базе
        //Добавляем его
        if(!$result){
            $sql = "INSERT INTO authors (name) VALUES ('$author')";
            pushSQLtoDB($dbh, $sql);
            getSuccsess('Автор '.$author.' добавлен в базу');
        }

        //Получаем ID автора
        $sql = "SELECT authors.id, authors.name FROM authors
            WHERE authors.name = '$author'
        ";

        $result = pushSQLtoDB($dbh,$sql);
        $id_author = getValue($result, 'id');

        return $id_author;
    }

    //Получение ID жанра

    //Если жанра нет, то добавляем его в базу жанров. Получаем его ID
    //Если жанр есть, получаем его ID
    function getIDGenre($dbh,$genre) {
        $sql = "SELECT genre.name FROM genre
            WHERE genre.name = CASE WHEN '$genre' <> '' THEN '$genre' ELSE genre.name END
        ";
        $result = pushSQLtoDB($dbh,$sql);

        //Есть ли Жанр в базе
        //Добавляем его
        if(!$result){
            $sql = "INSERT INTO genre (name) VALUES ('$genre')";
            pushSQLtoDB($dbh, $sql);
            getSuccsess('Жанр '.$genre.' добавлен в базу');
        }

        //Получаем ID жанра
        $sql = "SELECT genre.id, genre.name FROM genre
            WHERE genre.name = '$genre'
        ";

        $result = pushSQLtoDB($dbh,$sql);
        $id_genre = getValue($result, 'id');

        return $id_genre;
    }


?>