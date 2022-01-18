<?php
include_once './functions.php';

$login = filter_var(mb_strtolower(trim($_POST['login'])), FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);

if (mb_strlen($login) < 5 || mb_strlen($login) > 50) {
    echo "Недопустимая длинна логина (от 5 до 50)";
    exit();
} else if (mb_strlen($pass) < 3 || mb_strlen($pass) > 20) {
    echo "Недопустимая длинна пароля (от 3 до 20)";
    exit();
} else if (mb_strlen($name) < 5 || mb_strlen($name) > 50) {
    echo "Недопустимая длинна имени (от 5 до 50)";
    exit();
}
$pass = password_hash($pass, PASSWORD_DEFAULT);
$user = getUser($login);
if (!empty($user)) {
    echo "Пользователь с таким логином уже существует";
    exit();
} else {
    $pdo = getConnect();
    $stmt = $pdo->prepare("INSERT INTO users (`login`, `pass`, `full_name`) VALUES (?, ?, ?)");
    $stmt->execute([$login, $pass, $name]);
    $user = getUser($login);
    if (!empty($user)) {
        $stmt = $pdo->prepare("INSERT INTO `user_group` (`user_id`) VALUES (?)");
        $stmt->execute([$user['id']]);
    }
}
$pdo = null;

header('location: /');
