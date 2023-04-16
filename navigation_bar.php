<!DOCTYPE html>
<!-- Navigation Bar -->
<div class="menu">
    <a <?php if ($currentPage == 'home') { echo 'class="active"'; } ?> href="../index.php">Home</a>
    <a <?php if ($currentPage == 'website') { echo 'class="active"'; } ?> href="https://www.matlacksboise.com/">Website</a>
    <a <?php if ($currentPage == 'menu') { echo 'class="active"'; } ?> href="../Menu/menu.php">Menu</a>
    <a <?php if ($currentPage == 'recipes') { echo 'class="active"'; } ?> href="../Recipes/recipes.php">Recipes</a>
    <a <?php if ($currentPage == 'builds') { echo 'class="active"'; } ?> href="../Builds/builds.php">Builds</a>
    <a <?php if ($currentPage == 'tasks') { echo 'class="active"'; } ?> href="../Tasks/tasks.php">Tasks</a>
    <a <?php if ($currentPage == 'ingredients') { echo 'class="active"'; } ?> href="../Ingredients/ingredients.php">Ingredients</a>
    <a <?php if ($currentPage == 'schedule') { echo 'class="active"'; } ?> href="../Schedule/schedule.php">Schedule</a>
    <a <?php if ($currentPage == 'photos') { echo 'class="active"'; } ?> href="../Photos/photos.php">Photos</a>
</div>
