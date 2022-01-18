<?php
session_name('session_id');
session_start();
if (isset($_COOKIE['session_id'])) {
    if (!isset($_SESSION['checkAuth'])) {
        $_SESSION['checkAuth'] = false;
    }
} else {
    $_SESSION['checkAuth'] = false;
}
