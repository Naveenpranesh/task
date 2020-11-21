<?php
// error_reporting(0);
//  static $arrays = array();
// if (isset($_POST['submit'])) {
//     $array_length = htmlspecialchars($_POST['array_length']);

// } else 
$array_length=5;
if (isset($_POST['submit'])) {
    $arrays = array();
    

    for ($j = 0; $j < $array_length; $j++) {
        // array_push($arrays, $_POST[$j]);
        $arrays[$_POST['index' . $j]] = $_POST[$j];
    }
    $created_array = $arrays;
    if (!empty($_POST['insert'])) {
        $inserted_array = $arrays;
        array_push($inserted_array, $_POST['insert']);
    }
   

}
?>

<!DOCTYPE HTML>
<html>

<body>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

        <?php

    for ($i = 0; $i <= $array_length; $i++) {?>

        <label>Enter the Name <?php echo $i; ?>: </label>
        <input type="text" name='<?php echo 'index' . $i; ?>' autocomplete="off">
        <label>Score<?php echo $i; ?>: </label>
        <input type="number" name='<?php echo $i; ?>' autocomplete="off"><br>
        <?php }?>
        <br>
        <br>

        <input type="submit" name="submit" value="Submit" autocomplete="off">

        <br>
        <br>

        <label>Created Array Is:</label>
        <?php print_r($created_array);?>

        <br>
        <br>

        <br>
        <br>
    </form>
    <?php

?>

</body>

</html>