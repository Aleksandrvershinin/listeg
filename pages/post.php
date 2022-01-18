<?php
function renderError($message)
{
    exit("<H2>$message</H2>");
}
function checkRights($user, $post)
{
    return ($user['login'] === $post['user_get_login'] || $user['login'] === $post['user_send_login']);
}
$messageNotFound = 'Сообщение не найдено!';
$messageNoRights = 'Нет прав на просмотр данного сообщения!';
$user = getUserAndGroups();
$postId = $_GET['id'] ?? null;
$postId = formatstr($postId);
if (empty($postId) || !is_numeric($postId)) renderError($messageNotFound);
$post = getPost($postId);
if (!$post) renderError($messageNotFound);
if (!checkRights($user, $post)) renderError($messageNoRights);
changeFlagWasRead('true', $post['id']);
?>
<p><b>От:</b> <?= $post['user_send_login'] ?></p>
<p><b>Кому:</b> <?= $post['user_get_login'] ?></p>
<p>Дата отправки: <?= $post['date_create'] ?></p>
<h2><?= $post['title'] ?></h2>
<p><?= $post['content'] ?></p>