<?php
include 'core/auth.php';
logout_user();
header('Location: index.php')
?>