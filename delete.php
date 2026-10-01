<?php
require __DIR__ .'/db.php';
$task_id =(int)($_POST['id'] ?? 0);

if($task_id > 0){
    mysqli_query($mysqli,"DELETE FROM task WHERE id=$task_id");

}
header('Location:index.php');
exit;
?>