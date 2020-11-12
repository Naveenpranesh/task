<?php


include 'connect.php';
include 'class.php';
// include "export.php";

if (isset($_POST['submit'])) {
    $sql = new report($_POST['report']);

     $result = mysqli_query($conn, $sql->sql());

     $test = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($conn);

        }

if(isset($_POST['download'])){

  
    $sql = new report($_POST['download']);

    $result = mysqli_query($conn, $sql->sql());
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    
 
   $output = fopen('php://output', 'w');
    
    fputcsv($output, array('Date','Total Count', 'Success', 'Failiure','Pending'));
    
    
    while ($row = mysqli_fetch_assoc($result)){ 
        fputcsv($output, $row);
    }

    //export($result);

 $csvFile = stream_get_contents($output);
fclose($output);

exit($csvFile);
mysqli_close($conn);
}
?>

<!DOCTYPE HTML>
<html>
<body>
<head>
    <title>Report</title>
    <link rel="stylesheet" href="style.css">
</head>
<h2>Report</h2>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
<div class="selection">
<label>Type of Report:</label>
        <select id="report" name="report" value=''>
        <option  value="Hour wise report">Hourly report</option>
        <option  value="Date wise report">Date Wise report(Last 10 Days)</option>
        <option  value="Month wise report">Month Wise report(Last 3 months)</option>
       
</select>
<button type="submit" name="submit">Submit</button>
</div>

<?php
if ($_POST['report']=='Hour wise report') {?>
<h4><u>Hourly Report</u></h4>
<label>Export: </label><input type="submit" name="download" value="Hour wise report"/><br><br>
           
            <table class='center'> 
            <tr>
                <th>Hours</th>
                <th>Total Count</th>
                <th>Success</th>
                <th>Failed</th>
                <th>Pending</th>
            </tr>
  <?php  foreach ($test as $index=>$key) { ?>
    <tr>
            <td><?php echo htmlspecialchars( $test[$index]["hour"]); ?></td>
            <td><?php echo htmlspecialchars( $test[$index]["totalcount"]); ?></td>
            <td><?php echo htmlspecialchars($test[$index]["Success"]); ?></td>
            <td><?php echo htmlspecialchars($test[$index]["Failed"]); ?></td>
            <td><?php echo htmlspecialchars($test[$index]["pending"]); ?></td>
    </tr>
  <?php }} ?>
  <?php
if ($_POST['report']=='Date wise report') {?>
<h4><u>Date Wise Report</u></h4>
<label>Export: <input type="submit" name="download" value="Date wise report"/></label><br><br>
           
<table class='center'> 
            <tr>
                <th>Date</th>
                <th>Total Count</th>
                <th>Success</th>
                <th>Failed</th>
                <th>Pending</th>
            </tr>
  <?php  foreach ($test as $index=>$key) { ?>
    <tr>
            <td><?php echo htmlspecialchars( $test[$index]["dates"]); ?></td>
            <td><?php echo htmlspecialchars( $test[$index]["totalcount"]); ?></td>
            <td><?php echo htmlspecialchars($test[$index]["Success"]); ?></td>
            <td><?php echo htmlspecialchars($test[$index]["Failed"]); ?></td>
            <td><?php echo htmlspecialchars($test[$index]["pending"]); ?></td>
    </tr>
  <?php }} ?>



  <?php
if ($_POST['report']=='Month wise report') {?>
<h4><u>Month Wise Report</u></h4>
<label>Export: <input type="submit" name="download" value="Month wise report"/></label><br><br>
           
<table class='center'> 
            <tr>
                <th>Month</th>
                <th>Total Count</th>
                <th>Success</th>
                <th>Failed</th>
                <th>Pending</th>
            </tr>
  <?php  foreach ($test as $index=>$key) { ?>
    <tr>
            <td><?php echo htmlspecialchars( $test[$index]["month"]); ?></td>
            <td><?php echo htmlspecialchars( $test[$index]["totalcount"]); ?></td>
            <td><?php echo htmlspecialchars($test[$index]["Success"]); ?></td>
            <td><?php echo htmlspecialchars($test[$index]["Failed"]); ?></td>
            <td><?php echo htmlspecialchars($test[$index]["pending"]); ?></td>
    </tr>
  <?php }} ?>

</table>
</body>
</form>
</html>