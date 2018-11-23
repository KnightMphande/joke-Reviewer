<?php 
    function isConnSet()
    {
        require("config.php"); 
        $conn = new mysqli($servername, $username, $password, $db);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        return $conn;
    }

    function toLogin($username, $user_password, $userId)
    {
        var_dump($userId);
        $conn = isConnSet();
        if (!$conn)
        {
            return false;
        }
        
        $userDB = "SELECT * FROM users WHERE name = '$username' AND user_password = '$user_password' " ; 
        $query = mysqli_query($conn, $userDB);
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
        if (!empty($row['name']) && !empty($row['user_password']) )
        {
            if (mysqli_num_rows($query) == 1 )
            {
                $_SESSION['user_id'] = $userId;
                $_SESSION['username'] = $row['name'];
                $_SESSION['user_password'] = $row['user_password'] ;
                header("location:joke.php");
            } 
        }else{
            exit('ERROR');
        }
    } 

    function getJoke()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://08ad1pao69.execute-api.us-east-1.amazonaws.com/dev/random_joke");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // grab URL and pass it to the browser
        $curl_output =  curl_exec($ch);
        echo curl_error($ch);
        $jokes = json_decode($curl_output, true);
        joke_exists($jokes);
        // close cURL resource to free up system resources
        curl_close($ch);
        return $jokes;
    } 

    function joke_exists($jokes) { 
        $conn = isConnSet();
        if(!$conn) {
            return false;
        }
        $joke_id = $jokes['id'];
        $sql = "SELECT id FROM jokes WHERE id = '$joke_id'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) < 1) {
            writeToJokesTable($jokes);
        }
        
        return true;
    }

    function writeToJokesTable($jokes)
    {
        $conn = isConnSet();
        $_SESSION['joke_id'] = $jokes['id']; 
        $joke_id = $_SESSION['joke_id'];
        $joke_setup = $jokes['setup'];
        $joke_punchline = $jokes['punchline'];
        $sql = "INSERT INTO jokes (id, setup, punchline) VALUES (\"$joke_id\", \"$joke_setup\", \"$joke_punchline\");"; 
        $result =  mysqli_query($conn, $sql);
        $conn->close();
    }

    function writeToReviewsTable($jokes, $jokeRating)
    {
        $conn = isConnSet();
        $_SESSION['joke_id'] = $jokes['id']; 
        $joke_id = $_SESSION['joke_id'];
        $joke_setup = $jokes['setup'];
        $joke_punchline = $jokes['punchline']; 
        $user_id = 1; 
        $rating = $jokeRating;
        $sql = "INSERT INTO reviews (user_id, joke_id, rating) VALUES ($user_id, $joke_id, $rating);"; 
        $result =  mysqli_query($conn, $sql);
        if ($conn->query($sql) == TRUE) {
            echo "Rating submitted" . "<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

    function top_ten() {
        $conn = isConnSet();
        if(! $conn ) {
            die('Could not connect: ' . mysql_error());}
        $sql = "SELECT joke_id, jokes.setup AS jokeSetup, jokes.punchline AS jokePunchline, SUM(rating) AS total, COUNT(rating) AS count, SUM(rating)/COUNT(rating) as total_rating
                FROM reviews
                    INNER JOIN jokes ON reviews.joke_id=jokes.id
                GROUP BY joke_id
                ORDER BY total_rating DESC
                LIMIT 10";
        $results =  mysqli_query($conn, $sql);
        if(!$results) {
            die('Could not get data: ' . mysql_error());
         }
      
         while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
            echo "Joke setup : {$row['jokeSetup']} <br> ".
            "Punchline : {$row['jokePunchline']} <br> ".
            "total Rating : {$row['total_rating']} <br> ".
               "--------------------------------<br>";
         } 
         mysqli_close($conn);
        
    }
?>
