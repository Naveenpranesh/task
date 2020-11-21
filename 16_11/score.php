<?php

error_reporting(0);
include 'connect.php';


            $sql = "SELECT name,score,MAX(score) as high,AVG(score) as average from array_storage";
                
        $result = mysqli_query($conn, $sql);
 
      //  $test = mysqli_fetch_all($result, MYSQLI_ASSOC);

        
        while($row = mysqli_fetch_array($result)) {
            echo "<p>Average Score is ".$row['average'].'</p>';
         echo "<p> ".$row['name']." has the High Score of ".$row['high']. "</p>"; 

        }
        
        
        mysqli_free_result($test);

        mysqli_close($conn);
                


?>