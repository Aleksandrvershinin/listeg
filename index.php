<?
// подключаем session
include $_SERVER['DOCUMENT_ROOT'] . "/include/session.php";
// подключаем header
include $_SERVER['DOCUMENT_ROOT'] . "/templates/header.php";
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="left-collum-index">

            <h1>
                <?=
                $title
                ?>
            </h1>
            <p>Вести свои личные списки, например покупки в магазине, цели, задачи и многое другое. Делится списками с друзьями и просматривать списки друзей.</p>


        </td>


        <td class="right-collum-index">

            <div class="project-folders-menu">
                <?php
                include $_SERVER['DOCUMENT_ROOT'] . "/include/auth.php";
                ?>


    </tr>
</table>
<?php
// подключаем footer
include $_SERVER['DOCUMENT_ROOT'] . "/templates/footer.php";
?>