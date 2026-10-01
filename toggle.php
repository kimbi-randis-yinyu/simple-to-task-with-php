
<?php
require __DIR__ .'/db.php';

//Get the ID from the hidden input 
$task_id=(int)($_POST['id'] ?? 0);

//if valid id flip the is_done value from 0
if($task_id > 0){
    mysqli_query(
        $mysqli,
        "UPDATE task SET is_done =IF(is_done=1,0,1) WHERE id =$task_id"
    );
}
header('Location:index.php');
exit;
?>