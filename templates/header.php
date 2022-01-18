<?php
// подключаем массив с меню
include $_SERVER['DOCUMENT_ROOT'] . "/include/main_menu.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/include/array_router.php";
// подключаем функции
include $_SERVER['DOCUMENT_ROOT'] . "/include/functions.php";

// пулучаем текущий пункт меню из url
$title = getCurentTitle($arrayRouter);

// запускаем авторизацию
$check = auth();

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="/styles.css" rel="stylesheet">
    <title><?= $title ?></title>
</head>

<body>

    <div class="header">
        <div class="logo"><img src="/i/logo.png" width="68" height="23" alt="Project"></div>
        <div class="clearfix"></div>
    </div>
    <nav class="clear">

        <?
        // верстаем меню
        showMenu($menu, 'sort', SORT_ASC, '');

        ?>

    </nav>