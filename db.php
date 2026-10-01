<?php
define('DB_Host','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','full_stake_todo_app');

$mysqli=mysqli_connect(DB_Host,DB_USER,DB_PASS,DB_NAME);

if(!$mysqli){
    die('Database connection field:'.mysqli_connect_error());
  }else{
    //echo"Database has been connected";
}
mysqli_set_charset($mysqli,'utf8mb4');
?>