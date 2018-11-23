<?php 
     session_start();
    include('functions.php'); 
?>

<html>
   <head>
      <title>Logout</title>
   </head>
   
   <body>
		<h1>Welcome <?php //echo $_SESSION['username']; ?></h1>  <br>
        <?php 
			if (isset($_SESSION['username']) )
			{
				session_destroy();
				echo "<script>location.href='index.php' </script>";
			}
			else
				//echo "index.php";
				echo "<script>location.href='index.php' </script>";
        ?>
   </body>
   
</html>