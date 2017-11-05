<!DOCTYPE html>
<html>
    <body>
        <div class="form">
            <form action="/task4/form.php" method="get">
                <textarea name="text" placeholder="your text here..." required></textarea><br>
                <input type="submit" value="submit"/>
            </form> 
        </div>
    </body>
    <style>
        body {
            font-family: monospace;
        }
        .msg {
            font-family: inherit;
            padding: 20px;
            background-color: rgb(96, 125, 139);
            max-width: 300px;
            margin: 0 auto;
            word-wrap: break-word;
            color: white;
            border-radius: 15px;
            box-shadow: 2px 2px 18px -2px rgba(0,0,0,0.75);
        }
        .form {
            margin: 0 auto;
            width: 350px;
            margin-bottom: 40px;
        }
        textarea {
            width: 100%;
            resize: vertical;
            margin-top: 0px;
            margin-bottom: 0px;
            height: 77px;
            padding: 0;
            border: 0;
            margin: 0;
            background-color: rgb(239, 239, 239);
            /* box-shadow: 2px 2px 18px -2px rgba(0,0,0,0.75); */
        }
        input {
            margin: 0 auto;
            width: 100%;
            font-size: 13px;
            background-color: #71b6bf;
            border-radius: 7px;
            border: 0;
            padding: 0;
            padding: 19px 0px;
            color: white;
            box-shadow: 2px 2px 18px -2px rgba(0,0,0,0.75);
            text-transform: uppercase;
        }
    </style>
    <?
        $fileName = 'messages.json';

        //Получаем содержимое файла
        $commentsArr = file_get_contents($fileName);
        
        //Декодируем JSON
        $commentsArr = json_decode($commentsArr, true);

        //Проверка на пустоту 
        if(!empty($_GET['text'])) {

            //Формат элемента массива для JSON
            $comment = array(
                'date' => date("g:i:s j-m-y"),
                'text' => htmlspecialchars($_GET['text'])
            );

            $commentsArr[] = $comment;

        }

        //Если файл пуст, то ничего не выводить
        if(!empty($commentsArr)) {
            
            //Выводим все элементы 
            foreach($commentsArr as $key => $array) {
                echo '<div class="msg">',$array['date'],' ––– ',$array['text'], '</div>';
                echo('</br>');
            }

        }

        // Превращаем опять в JSON
        $commentsArr = json_encode($commentsArr);
        // Перезаписываем файл
        file_put_contents($fileName, $commentsArr);



    ?>
</html>