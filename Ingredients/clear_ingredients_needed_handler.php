<?php
require_once '../Dao.php';

$dao = new Dao();
$dao->clearIngredientsNeeded();

header('Location: ingredients.php');
exit;
