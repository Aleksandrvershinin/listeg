<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/session.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/functions.php';
$messageNoRights = 'Отказано в доступе!';
$messageError = 'Произошла ошибка на сервере!';
$messageEmpty = 'Не все поля заполнены!';
$messageSuccess = 'success';

if ($_SESSION['checkAuth'] !== true) exit(json_encode($messageNoRights));
$user = getUserAndGroups();
$idGroup = 2;
if (!checkGroupsUser($user, $idGroup)) exit(json_encode($messageNoRights));

if (!isset($_POST['title']) && !isset($_POST['content']) && !isset($_POST['geter']) && !isset($_POST['chapter'])) {
    exit(json_encode($messageError));
}
$data = [];
$data['content'] = formatstr($_POST['content']);
$data['title'] = formatstr($_POST['title']);
$data['geter'] = formatstr($_POST['geter']);
$data['chapter_id'] = formatstr($_POST['chapter']);
$data['sender'] = $_SESSION['login'];


foreach ($data as $key => $value) {
    if (empty($value)) {
        exit(json_encode($messageEmpty));
    }
}
if (addMessage($data)) {
    exit(json_encode($messageSuccess));
}
exit(json_encode($messageError));
