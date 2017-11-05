<?
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);
    $email = htmlspecialchars($_POST['email']);
    echo($login);
    echo('</br>');
    echo($password);
    echo('</br>');
    echo($email);
?>