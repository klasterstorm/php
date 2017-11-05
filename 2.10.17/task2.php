<?
$array = array(
    'id'=>array(1,2,3,4),
    'user'=>array('Ivan', 'Sergey', 'Stepan', 'Vladimir'),
    'email'=>array('iv@mail.ru', 'ser@mail.ru', 'step@mail.ru', 'vl@mail.ru')
);

// Массив - Индекс - Значение
//foreach($array as $index => $value)

//Массив ключей
$keyArray = array_keys($array);

//Формируем таблицу
echo('<table border="1">');

//Выводим ключи
foreach($array as $index => $value){
    echo('<th>');
    echo($index);
    echo('</th>');
}

//Выводим содержимое таблицы
//Привязка длины таблицы, к длине массива с ID, тк значения в бд не могут быть без ID
for($j = 0; $j < count($array[$keyArray[0]]); $j++) {
    echo('<tr>');
    for($i = 0; $i < count($keyArray); $i++) {
        echo('<td>');
        //Если пусто, то выводим пустую ячейку, иначе выводим значение
        echo(!empty($array[$keyArray[$i]][$j]) ? $array[$keyArray[$i]][$j] : '');
        echo('</td>');
    }
    echo('</tr>');
}

echo('</table>');
?>