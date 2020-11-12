<?php

function export($x){

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    
 
   $output = fopen('php://output', 'w');
    
    fputcsv($output, array('Date','Total Count', 'Success', 'Failiure','Pending'));
    
    
    while ($row = mysqli_fetch_assoc($x)){ 
        fputcsv($output, $row);
    }
  

 $csvFile = stream_get_contents($output);
 fclose($output);

exit($csvFile);

}
?>