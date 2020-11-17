<?php

error_reporting(0);
include 'connect.php';


            $sql = "SELECT name,score  from array_storage ORDER BY score desc limit 5";
                
        $result = mysqli_query($conn, $sql);
 
      //  $test = mysqli_fetch_all($result, MYSQLI_ASSOC);

        echo "<table>
        <tr>
        <th>NAME </th>

        <th>SCORE</th>
       
        </tr>";
        while($row = mysqli_fetch_array($result)) {
          echo "<tr>";
          echo "<td>" . $row['name'] . "</td>";
          echo "<td>" . $row['score'] . "</td>";
        
          echo "</tr>";
        }
        echo "</table>";
        
        mysqli_free_result($test);

        mysqli_close($conn);
                


?>