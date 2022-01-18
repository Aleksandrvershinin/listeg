<?php
$user = getUserAndGroups();

?>

<ul class="user-info__list">
    <li class="user-info__list_item">
        Ф. И. О - <?= $user['full_name'] ?>
    </li>
    <li class="user-info__list_item">
        email - <?= $user['email'] ?>
    </li>
    <li class="user-info__list_item">
        Телефон - <?= $user['phone'] ?>
    </li>
    <ul class="user-info__list-group">
        <h3>Группы в которых состоит пользователь</h3>
        <?
        foreach ($user['groups'] as $key => $value) { ?>
            <li class="user-info__list-group_item"><?= $value['name'] ?></li>
        <? } ?>
    </ul>
</ul>