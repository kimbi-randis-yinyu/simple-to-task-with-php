<?php
require __DIR__ .'/db.php';

//Get the text from the form input 

$new_task_title=trim($_POST['task_title']?? '');

//only insert task task if the input is not empty

if($new_task_title!='' ){
    
    $escaped_title=mysqli_real_escape_string($mysqli,$new_task_title);
    //insert the new task into the database
    mysqli_query($mysqli,"INSERT INTO task (title) VALUES('$escaped_title')");
}

//Redirect back to index.php sp the page can show
header('Location:index.php');
exit;
?>