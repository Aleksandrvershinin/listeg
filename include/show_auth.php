<li <?= htmlspecialchars($_GET["login"] ?? '') === 'yes' ? 'class="project-folders-v-active"' : '' ?>>
    <a href="/?login=yes">Авторизация</a>
</li>
<li <?= isset($_GET["checkin"]) ? 'class="project-folders-v-active"' : '' ?>><a href="/?checkin">Регистрация</a></li>
<li><a href="/">Забыли пароль?</a></li>
</div>

<!-- проверяем существует ли get запрос -->
<? if (htmlspecialchars($_GET["login"] ?? '') === 'yes') { ?>
    <?
    // проверяем существует ли post запрос
    if (!empty($_POST)) {
        // проверяем прошла  ли проверка на логин и пароль
        if ($check === true) {
            include $_SERVER['DOCUMENT_ROOT'] . "/include/success.php";
        } else {
            include $_SERVER['DOCUMENT_ROOT'] . "/include/error.php";
        }
    }
    ?>
    <div class="index-auth">
        <form action="/?login=yes" method="POST">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <?php include $_SERVER['DOCUMENT_ROOT'] . "/include/check_login.php"; ?>
                </tr>
                <tr>
                    <td class="iat">
                        <label for="password_id">Ваш пароль:</label>
                        <input id="password_id" value="<?= $gotPassword; ?>" size="30" name="password" type="password">
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" value="Войти"></td>
                </tr>
            </table>
        </form>
    </div>
    </td>
<? } else if (isset($_GET["checkin"])) { ?>
    <div class="index-auth">
        <form method="POST" action="/include/checkin.php">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="iat">
                        <label for="login">Ваш логин:</label>
                        <input id="login" value="" size="30" name="login" type="text">
                    </td>
                </tr>
                <tr>
                    <td class="iat">
                        <label for="pass">Ваш пароль:</label>
                        <input id="pass" value="" size="30" name="pass" type="password">
                    </td>
                </tr>
                <tr>
                    <td class="iat">
                        <label for="name">Ваше имя:</label>
                        <input id="name" value="" size="30" name="name" type="text">
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" value="Зарегистрироваться"></td>
                </tr>
            </table>
        </form>
    </div>
    </td>
<? }
