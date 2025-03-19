<?php
function redirect($url) {
    header("Location: " . $url);
    exit();
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function get_user_role() {
    if(isset($_SESSION['user_role'])) {
        return $_SESSION['user_role'];
    }
    return null;
}

function get_user_id() {
    if(isset($_SESSION['user_id'])) {
        return $_SESSION['user_id'];
    }
    return null;
}
?>