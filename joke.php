<?php 
     include('functions.php');  
     include('templates/header.php');  
?>

<html>
   <head>
      <title>Joke Page</title> 
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   </head>
   
   <body>

         <?php 
            if(isset($_SESSION['username'])){ //session is set, user is logged in ?>

            <h1>Welcome <?php echo $_SESSION['username']; ?></h1>  <br>
   
         <?php
            }else{
            echo "Please Login to give rating";
            header("Location: index.php ");
            }
         ?>

        <?php 
            $jokes = getJoke(); 
            $_SESSION['joke_setup'] = $jokes['setup']; 
            $_SESSION['joke_punchline'] = $jokes['punchline'];
			   echo $_SESSION['joke_setup'] . '<br>';
			   echo $_SESSION['joke_punchline'] . '<br>';
            writeToJokesTable($jokes); 
        ?>

   <form action="" method="post"> 
      Rate Joke:
      <select name = "rating"> 
         <option value="one"> 1 </option>
         <option value="two"> 2 </option>
         <option value="three"> 3 </option>
         <option value="four"> 4 </option>
         <option value="five"> 5 </option>
      </select> <br>
      <input type="submit"  name ="submit" /><br />
   </form>

    <?php
      if (isset($_POST['submit'])){
         if($_POST['rating']  == 'one') {
               $_SESSION['rating'] = 1;
         } 

         if($_POST['rating'] == 'two') {
               $_SESSION['rating'] = 2;
         }
         
         if($_POST['rating'] == 'three') {
               $_SESSION['rating'] = 3;
         }

         if($_POST['rating'] == 'four') {
               $_SESSION['rating'] = 4;
         }

         if($_POST['rating'] == 'five') {
            $_SESSION['rating'] = 5;
         }
         $jokeRating = $_SESSION['rating'];
         writeToReviewsTable($jokes, $jokeRating);
      }
   ?>

   <section class="section" id="topTen">
   <h3 class="title is-2">Top Ten Jokes</h3>
   <?php top_ten(); ?>
   </section>

   <section class="section" id="logout">
   <?php echo "<br> <a href='logout.php'> <input type=button value= logout name=logout></a>"; ?>
   </section>

   <?php
      include('templates/footer.php');
   ?>
   </body>
   
</html>