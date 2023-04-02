<?php
require_once('../Dao.php');
$dao = new Dao();

$categories = $dao->getCategories();

return $categories;
?>
