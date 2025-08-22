<?php

session_start();

require_once __DIR__.'/boot.php';

$_SESSION['user_id'] = null;
header('Location: index.php');