<?php
require_once ('./inc/class.Database.php');
require_once ('./inc/class.Session.php');

$logout = Session::destroy();

header('Location: index.php');