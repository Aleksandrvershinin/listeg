<?php
// подключаем session
include $_SERVER['DOCUMENT_ROOT'] . "/include/session.php";
if ($_SESSION['checkAuth'] !== true) {
    header("Location: /?login=yes");
}
include $_SERVER['DOCUMENT_ROOT'] . "/templates/header.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/include/array_router.php";
$pathPage = $_SERVER['DOCUMENT_ROOT'] . getCurentPage($arrayRouter);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="left-collum-index">

            <h1>
                <?= $title ?>
            </h1>
            <? if (file_exists($pathPage)) {
                include $pathPage;
            } ?>
        </td>
        <td class="right-collum-index">
            <div class="project-folders-menu">
                <?php
                include $_SERVER['DOCUMENT_ROOT'] . "/include/auth.php";
                ?>
    </tr>
</table>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/footer.php";
