<?php
require __DIR__ .'/db.php';

//Delete all task from database

mysqli_query($mysqli,"DELETE FROM task");

header('Location:index.php');
exit;
?>