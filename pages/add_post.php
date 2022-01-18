<?php
$user = getUserAndGroups();
$idGroup = 2;
$users = getGroupUsers($idGroup);
$chapters = getChapters();
if (!checkGroupsUser($user, $idGroup)) exit('Вы не можете создавать сообшения');
?>
<h2 id="add-message__response"></h2>
<form class="form__add-message">
    <label class="form__add-message_label" for="title">Заголовок сообщения</label>
    <input required class="form__add-message_input" type="text" name="title" id="title">
    <label class="form__add-message_label" for="content">Текст сообщения</label>
    <textarea required class="form__add-message_input" name="content" id="content" cols="30" rows="10"></textarea>
    <label class="form__add-message_label" for="geter">Выберете получателя</label>
    <select required class="form__add-message_input" name="geter" id="geter">
        <? foreach ($users as $key => $user) { ?>
            <option value="<?= $user['login'] ?>"><?= $user['login'] ?></option>
        <? } ?>
    </select>
    <label class="form__add-message_label" for="chapter">Выберете раздел</label>
    <select required class="form__add-message_input" name="chapter" id="chapter">
        <? foreach ($chapters as $key => $chapter) { ?>
            <option value="<?= $chapter['id'] ?>"><?= $chapter['name'] ?></option>
        <? } ?>
    </select>
    <input class="form__add-message_input form__add-message_btn" type="submit" value="отправить сообщение">
</form>
<script type="module" src="/include/send_post.js"></script>