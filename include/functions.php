<?php
// переменная логина
$gotLogin = "";
// переменная пароля
$gotPassword = "";
// функция проверки авторизации
function auth()
{
    // переменная проверки логина пароля
    $check = null;

    // проверяем был ли post запрос
    if (!empty($_POST)) {
        // очишаем от спец символов логин и пароль
        $login = htmlspecialchars($_POST["login"]);
        $pass = htmlspecialchars($_POST["password"]);

        $pdo = connect_bd();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE login = ?');
        $stmt->bindParam(1, $login, PDO::PARAM_STR);
        $stmt->execute();
        if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $check = password_verify($pass, $result['pass']);
        } else {
            $check = false;
        }
        $pdo = null;
        if ($check) {
            $_SESSION['checkAuth'] = true;
            $_SESSION['login'] = $login;
            setcookie("login", $login, time() + 60 * 60 * 24 * 30, "/");
        }
    }
    return $check;
}
function connect_bd()
{
    static $pdo = null;

    if (!$pdo) {
        try {
            $dsn = "mysql:host=127.0.0.1;dbname=my_db;charset=utf8";
            $pdo = new PDO($dsn, 'root', 'root');
        } catch (\Throwable $th) {
            exit('Произошла ошибка соеденения');
        }
    }
    return $pdo;
}

function getConnect()
{
    $pdo = null;
    if (!$pdo) {
        $pdo = connect_bd();
    }
    return $pdo;
}
function getGroupUsers($idGroup)
{
    $pdo = getConnect();
    $stmt = $pdo->prepare("SELECT `users`.full_name, `users`.id as user_id, `users`.login, `groups`.name as group_name, `groups`.id as group_id FROM `users` JOIN user_group ON users.id = user_group.user_id JOIN `groups` ON user_group.group_id = groups.id WHERE groups.id = ?");
    $stmt->bindParam(1, $idGroup, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getUser($login)
{
    $pdo = getConnect();
    $stmt = $pdo->prepare('SELECT * FROM users WHERE login = ?');
    $stmt->bindParam(1, $login, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function addMessage($data)
{
    $pdo = getConnect();
    $stmt = $pdo->prepare("INSERT INTO `messages`(`content`, `title`, `user_send_login`, `user_get_login`, `chapter_id`) VALUES (:content,:title,:sender,:geter,:chapter_id)");
    return $stmt->execute($data);
}
function getGroups($userId)
{
    $pdo = getConnect();
    $stmt = $pdo->prepare("SELECT * FROM `groups` JOIN user_group ON `groups`.id = user_group.group_id WHERE user_group.user_id = ?");
    $stmt->bindParam(1, $userId, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getPosts($login)
{
    $pdo = getConnect();
    $stmt = $pdo->prepare("SELECT * FROM `messages` WHERE messages.user_get_login = :login OR messages.user_send_login = :login");
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function changeFlagWasRead($wasRead, $postId)
{
    $pdo = getConnect();
    $stmt = $pdo->prepare("UPDATE `messages` SET `was_read`=:was_read WHERE id = :id");
    $stmt->bindParam(':was_read', $wasRead, PDO::PARAM_STR);
    $stmt->bindParam(':id', $postId, PDO::PARAM_STR);
    $stmt->execute();
}
function getPost($postId)
{
    $pdo = getConnect();
    $stmt = $pdo->prepare("SELECT * FROM `messages` WHERE messages.id = :id ");
    $stmt->bindParam(':id', $postId, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function getUserAndGroups()
{
    $user = getUser($_SESSION['login']);
    if (!$user) {
        exit('Пользователь не найден');
    }
    $user['groups'] = getGroups($user['id']);
    return $user;
}
function getChapters()
{
    $pdo = getConnect();
    $stmt = $pdo->query("SELECT * FROM `chapters_messages`");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getStructureChaptersPost($chapterId, $chapters)
{
    $array = [];
    $getChapter = function ($chapterId) use (&$array, &$getChapter, &$chapters) {
        if ($chapterId) {
            foreach ($chapters as $key => $chapter) {
                if ($chapter['id'] == $chapterId) {
                    $array[] = $chapter;
                    $getChapter($chapter['chapter_id']);
                }
            }
        }
    };
    $getChapter($chapterId, $chapters);
    return $array;
}
function checkGroupsUser($user, $idGroup)
{
    foreach ($user['groups'] as $key => $group) {
        if (($group['id']) == $idGroup) {
            return true;
        }
    }
    return false;
}
// условия сортировки
function build_sorter($key, $sort)
{
    if ($sort === "SORT_ASC") {
        return function ($a, $b) use ($key) {
            return $a[$key] <=> $b[$key];
        };
    } else {
        return function ($a, $b) use ($key) {
            if ($a[$key] == $b[$key]) {
                return 0;
            }
            return ($a[$key] > $b[$key]) ? -1 : 1;
        };
    }
}


// функция сортировки
function arraySort($array, $key, $sortDirection)
{
    array_multisort(array_column($array, $key), $sortDirection, $array);
    // usort($array, build_sorter($key, $sort));
    return $array;
};

// функция определения title
function getCurentTitle($arrayRouter)
{
    foreach ($arrayRouter as $item) {
        if (isCurrentUrl($item['path'])) {
            return $item['title'];
        }
    }
    return 'Страница не найдена';
}
// функция определения текущей страницы
function getCurentPage($arrayRouter)
{
    foreach ($arrayRouter as $item) {
        if (isCurrentUrl($item['path'])) {
            if (isset($item['path_page'])) {
                return $item['path_page'];
            } else {
                return 'undefined';
            }
        }
    }
    return '/pages/error.php';
}
function formatstr($str)
{
    $str = trim($str);
    $str = stripslashes($str);
    $str = htmlspecialchars($str);
    return $str;
}
// функция обрезки заголовка
function cutString($line, $appends = '...')
{
    return  mb_strimwidth($line, 0, 15, $appends);
}
//  функция содания меню
function showMenu($menu, $key, $sortDirection, $type)
{
    $arrayMenu = arraySort($menu, $key, $sortDirection);
    renderMenu($arrayMenu, $type);
}

// сравнение url
function isCurrentUrl($value)
{
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == $value;
}

function renderMenu($arrayMenu, $type)
{
?>
    <ul class="main-menu <?= $type ?>">
        <?php
        foreach ($arrayMenu as $key => $value) {
        ?>
            <li class="menu__footer__item">
                <a class="menu__footer__item__link <? if (isCurrentUrl($value['path'])) echo 'is-active'; ?>" href="<?= $value['path']; ?>"><?= cutString($value['title']) ?>
                </a>
            </li>
        <?php
        }
        ?>
    </ul>
<?  }
