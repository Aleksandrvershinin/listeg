<?php
$user = getUserAndGroups();
$posts = getPosts($user['login']);
$chapters = getChapters();
$idGroup = 2;
function renderPost($chapters, $post)
{
    $chapters = array_reverse($chapters);
    $str = "";
    foreach ($chapters as $key => $chapter) {
        $str = $str . "<div class='no-read-messages__item_chapter'><p>$chapter[name]</p>";
    }
    $str = $str . "<b><a class='no-read-messages__item_post' href='/route/post/?id=$post[id]'>$post[title]</a></b>";

    foreach ($chapters as $key => $chapter) {
        $str = $str . "</div>";
    }
    echo $str;
}

if (checkGroupsUser($user, $idGroup)) { ?>
    <a href="/route/posts/add/">Написать сообщение</a>
    <ul class="chapter__list">
        <li class="chapter__list_item">
            <h2>Отправленные сообшения</h2>
        </li>
        <li class="chapter__list_item">
            <h2>Входящие сообщения</h2>
            <ul class="get-messages__chapter_list">
                <li class="get-messages__chapter_item">
                    <h3>Не прочитанные сообщения</h3>
                    <ul class="no-read-messages__list">
                        <? foreach ($posts as $key => $post) {
                            if ($post['was_read'] === 'false') { ?>
                                <li class="no-read-messages__item">
                                    <? renderPost(getStructureChaptersPost($post['chapter_id'], $chapters), $post) ?>
                                </li>
                        <? }
                        } ?>
                    </ul>
                </li>
                <li class="get-messages__chapter_item">
                    <h3>Прочитанные сообщения</h3>
                    <ul class="no-read-messages__list">
                        <? foreach ($posts as $key => $post) {
                            if ($post['was_read'] === 'true') { ?>
                                <li class="no-read-messages__item">
                                    <? renderPost(getStructureChaptersPost($post['chapter_id'], $chapters), $post) ?>
                                </li>
                        <? }
                        } ?>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
<? } else { ?>
    <h2>Вы сможете отправлять сообщения после прохождения модерации</h2>
<? } ?>