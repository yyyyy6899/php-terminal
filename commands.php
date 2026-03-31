<?php
session_start();

// ---------------------------
// PASSWORD PROTECTION
// ---------------------------
$public_password = "MySecret123"; // set your password

if (isset($_POST['password'])) {
    if ($_POST['password'] === $public_password) {
        $_SESSION['authenticated'] = true;
    } else {
        $error = "Wrong password!";
    }
}

if (!isset($_SESSION['authenticated'])) {
    include 'login.html';
    exit;
}

// ---------------------------
// COMMAND EXECUTION
// ---------------------------
$allowed_commands = [
    'List Files' => 'ls -l',
    'Uptime' => 'uptime',
    'Disk Usage' => 'df -h',
    'Who is logged in' => 'who'
];

$output = "";
if (isset($_GET['cmd']) && array_key_exists($_GET['cmd'], $allowed_commands)) {
    $cmd = $allowed_commands[$_GET['cmd']];
    $output = shell_exec($cmd);
}

include 'terminal.html';

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
