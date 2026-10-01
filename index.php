<?php
require __DIR__ .'/db.php';

//run a query to get   all task from the database

$task_result_set=mysqli_query(
  $mysqli,
  "SELECT id, title, is_done FROM task ORDER BY id DESC"
);

//store all row of data in a php array for letter use
$task_rows=[];
while($task_row=mysqli_fetch_assoc($task_result_set)){
 //convert is_done to integer (0 or 1)
 $task_row['is_done'] = (int)$task_row['is_done'];
 $task_rows[]=$task_row;
}

//cont totals for the todo tracker
$total_task_count = count($task_rows);
$completed_task_count = 0;
foreach($task_rows as $task){
  if($task['is_done'] === 1){
    $completed_task_count++;
  }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FullStake Todo App</title>
<style>
*{ margin:0; padding:0; box-sizing: border-box; }
body{ font-family: "Lato", sans-serif; background:#f8f9fa; overflow-x:hidden; }
.container{ width:90%; max-width:500px; margin:auto; }
main{ text-align:center; margin-top: 3rem; padding-bottom:3rem; }

/* todo tracker */
.todo_tracker{ 
  display: flex; 
  align-items: center; 
  justify-content: space-between;
  border: 1px solid #ddd; 
  border-radius:8px; 
  width:100%;
  min-height: 150px; 
  margin:0 auto; 
  padding:1.5rem;
  background:white;
  gap:1rem;
}
h2{ font-size:clamp(20px, 5vw, 36px); } /* scales text */
.completed-subheading{ text-align:left; padding-top: 5px; font-style:italic; font-size:clamp(12px, 3vw, 16px); letter-spacing:1px; }
.task-counter{ 
  background-color:blue; 
  color:white;
  width:clamp(70px, 20vw, 100px); 
  height:clamp(70px, 20vw, 100px);
  border-radius:50%; 
  display:flex;
  align-items:center; 
  justify-content:center; 
  font-weight: bold; 
  font-size:clamp(18px, 5vw, 32px); 
  flex-shrink:0;
}
.spacer{ padding:0 5px; }
.task-form{ margin:2rem auto; display:flex; align-items:center; justify-content: center; gap:1rem; width:100%; }
.task-input{ 
  flex:1; /* takes remaining space */
  min-width:0;
  height:45px; 
  padding:0 16px; 
  outline:none; 
  border-radius:30px; 
  border:1px solid #333 
}
.submit-btn{ height:45px; width:45px; border-radius:50%; border:none; background-color:blue; color:white; cursor:pointer; flex-shrink:0; display:flex; align-items:center; justify-content:center; }
.plus{ font-size:28px; }

.task-list{ display:flex; align-items:center; flex-direction:column; gap:1rem; list-style:none; padding: 0; margin: 2rem auto; width:100%; }
.li-text.done{
  text-decoration:line-through;
  opacity: 0.6;
}

.inline-form{
  display: inline;
  margin:0;
}
.task-item{ 
  display:flex; 
  align-items:center; 
  justify-content:space-between; 
  border:1px solid #333; 
  padding:1rem; 
  width:100%;
  min-height:60px; 
  border-radius:8px; 
  background:white;
  gap: 1rem;
  flex-wrap:wrap; /* allows wrapping on small screens */
}
.li-text{ text-align:left; flex:1; word-break:break-word; }
.task-icons{ display:flex; align-items:center; justify-content:flex-end; gap: .8rem; flex-shrink:0; }
.icon-btn{ border:none; background:none; cursor:pointer; padding:0; font-size:20px; }
.icon-btn .tik{ color:#3cb371; }
.icon-btn .cross{ color:#822222; }
.clear-all-btn{ margin-bottom:3rem; width: 135px; height:50px; font-size:18px; font-weight:bold; cursor:pointer; background-color:#B22222; border:none; color:white; border-radius:8px; }

/* TABLET */
@media screen and (max-width:768px){
  main{ margin-top:2rem; }
  .todo_tracker{ flex-direction: column; height:auto; text-align:center; }
  .completed-subheading{ text-align:center; }
}

/* MOBILE */
@media screen and (max-width:480px){
  .container{ width:95%; }
  .task-form{ flex-direction: column; }
  .task-input{ height: 2rem; width:100%;padding: 10px; }
  .submit-btn{ width:100%; border-radius:30px; height:45px; }
  .plus{ display:none; }
  .submit-btn::after{ content:"Add Task"; font-size:16px; font-weight:700; }
}
</style>
</head>
<body>
<main>
  <div class="container">
    <div class="todo_tracker">
      <div class="task-tracker-text">
        <h2>Tasks Completed</h2>
        <p class="completed-subheading">Keep it up</p>
      </div>
      <div class="task-counter"> <?php echo $completed_task_count; ?><span class="spacer">/</span><?php echo $total_task_count; ?></div>
    </div>

    <form action="add.php" method="POST" class="task-form">
      <input type="text" name="task_title" class="task-input" placeholder="You next task is...." required>
      <button class="submit-btn" type="submit">
        <span class="plus">+</span>
      </button>
    </form>

    <ul class="task-list">
      <?php if (empty($task_rows)):?>
        <li class="task-item">
          <div class="li-text">Add a task to get started......</div>
        </li>
        <?php else:?>
          <?php foreach($task_rows as $task):?>
      <li class="task-item">
        <div class="li-text <?php echo $task['is_done'] ? 'done':'' ?> ">
          <?php echo $task['title'];?>
        </div>
        
        <div class="task-icons">
          <form action="toggle.php" method="POST" class="inline-form">
            <button  type="submit" class="icon-btn" title="Toggle complete"><span class="tik">&check;</span></button>
            <input type="hidden" name="id" value="<?php echo $task['id'] ?>">
          </form>
          <form action="delete.php" method="POST" class="inline-form">
          <button type="submit" class="icon-btn" title="Delete Task"><span class="cross">&times;</span></button>
          <input type="hidden" name="id" value="<?php echo $task['id'] ?>">
          </form>
        </div>
      </li>
      <?php endforeach;?>
       <?php endif;?>
    </ul>
    <form  id="clear-form" action="clear.php" method ="POST">
       <button type="submit" class="clear-all-btn">Clear All Tasks</button>
    </form>
  </div>
</main>
<script>
   const clearForm =document.getElementById("clear-form");
   clearForm.addEventListener("submit",function(e){
    const yesSubmit=confirm("Are you sure you want to DELETE ALL tasks?");
     if(!yesSubmit){
       e.preventDefault();
     }
    
   });
</script>
</body>
</html>