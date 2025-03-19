<?php
session_start();

function is_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function login_user($user_id, $user_role) {
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_role'] = $user_role;
}

function logout_user() {
    session_unset();
    session_destroy();
}

function require_login() {
    if (!is_logged_in()) {
        redirect('login.php');
    }
}

function require_admin() {
    require_login();
    if (get_user_role() !== 'admin') {
        redirect('../index.php');
    }
}

function require_nauczyciel() {
    require_login();
    if (get_user_role() !== 'nauczyciel') {
        redirect('../index.php');
    }
}

function require_uczen() {
    require_login();
    if (get_user_role() !== 'uczen') {
        redirect('../index.php');
    }
}
?>