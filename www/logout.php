<?php

session_start();
$_SESSION = [];
session_regenerate_id();
header("location:/login.php");