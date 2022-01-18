<?php
// подключаем session
include $_SERVER['DOCUMENT_ROOT'] . "/include/session.php";
$_SESSION['checkAuth'] = false;
header("Location: /");
