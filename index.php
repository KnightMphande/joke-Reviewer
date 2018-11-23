<?php 
     session_start();
     include('functions.php'); 
?>

<?php 
   if(isset($_POST['submit']))
   { 
      $username = $_POST['username'];
      $user_password = $_POST['password'];
      toLogin($username, $user_password, $_POST['userID']);
      header("Location:joke.php");
   }
?>

<html>
   <head>
      <title>Index Page</title>
   </head>
   
   <body>
        <div>
         <div>
            <div>
               <h1><b>Login Page</b></h1>
            </div>
				
            <div>
               
               <form action="" method="post">
                  <label>UserName  :</label><input type="text" name="username" class="box" value="Knight"/><br /><br />
                  <label>Password  :</label><input type="password" name="password" class ="box" value="qwerty"/><br/><br />
                  <input type="submit" value="submit" name ="submit"/><br />
               </form>
               					
            </div>
				
         </div>
			
      <?php include('templates/footer.php'); ?>
   </body>
   
</html>