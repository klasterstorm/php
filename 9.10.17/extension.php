<?php

    //Выборка SQL в DB
    function pushSQLtoDB($dbh, $sql) {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }

    //Изменение в DB
    function setSQLtoDB($dbh, $sql) {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
    }

    //Поключение к базе данных
    function dboConnect() {
        $user = "root";
        $pass = "root";
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=php;charset=utf8', $user, $pass);
        } catch (PDOException $e) {
            die('Подключение не удалось: ' . error($e->getMessage()));
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

    //Вывод таблицы
    function getTable($result, $titleForTable) {

        // $titleForTable = array(
        //     "id"    => "ID",
        //     "name"  => "Название",
        //     "email"  => "Почта",
        //     "phone"  => "Номер телефона",
        // );
        // getTable($result, $titleForTable);


        $keys = array_keys($titleForTable);

        if (!empty($result)){
            echo '<div class="grid-x grid-margin-x">
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
                    if(is_numeric($row[$index]) && $row[$index] == 0){
                        echo '<td class="content-table-errorRow">',$row[$index] ,'</td>';
                    }
                    else {
                        echo '<td>',$row[$index] ,'</td>';
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
            getError("Не удается построить таблицу по пустому запросу");
        }
    }

?>