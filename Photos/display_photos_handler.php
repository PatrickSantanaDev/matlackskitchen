<?php
// Include the DAO
include_once '../Dao.php';

$dao = new Dao();

$photos = $dao->getAllPhotos();

echo '<div id="photosViewer">';
// display photo tiles
foreach ($photos as $photo) {
  echo '<div class="photoTile">';
  echo '<img src="' . $photo['file_name'] . '"/>';
  echo '<form class="deleteForm" method="post" action="delete_photo_handler.php">';
  echo '<input type="hidden" name="photoId" value="' . $photo['id'] . '">';
  echo '<button id="deletePhoto" type="submit">Delete</button>';
  echo '</form>';
  echo '</div>';
}
  
echo '</div>';
