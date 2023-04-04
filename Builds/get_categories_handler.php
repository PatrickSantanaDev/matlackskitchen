<?php
require_once('../Dao.php');
$dao = new Dao();

$categories = $dao->getBuildCategories();

return $categories;
?>
