<ul class="project-folders-v">
    <? if (isset($_SESSION['checkAuth'])) {
        if ($_SESSION['checkAuth'] === true) { ?>
            <a href="/include/logout.php">
                <button>Выйти</button>
            </a>
    <? } else {
            include_once $_SERVER['DOCUMENT_ROOT'] . "/include/show_auth.php";
        }
    } else {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/include/show_auth.php";
    }
    ?>
</ul>