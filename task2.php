<?php
error_reporting(0);
//  static $arrays = array();
if (isset($_POST['submit'])) {
    $array_length = htmlspecialchars($_POST['array_length']);

} else if (isset($_POST['proceed'])) {
    $arrays = array();
    $length = $_POST['length'];

    for ($j = 0; $j < $_POST['length']; $j++) {
        array_push($arrays, $_POST[$j]);
    }
    $created_array = $arrays;
    if (!empty($_POST['insert'])) {
        $inserted_array = $arrays;
        array_push($inserted_array, $_POST['insert']);
    }
    if (!empty($_POST['delete'])) {
        array_pop($arrays);
        $deleted_array = $arrays;
    }
    if (!empty($_POST['num_delete'])) {
        $num_deleted_array = array_splice($arrays, 0, $length - 3);

    }
    if (!empty($_POST['search'])) {
        $search = array_search($_POST['search'], $created_array);

    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"> </script>

    
    <title>ASSESMENT 1-2 SCORE</title>
</head>

<body>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

        <label>Array Length:</label>
        <input type="number" name="array_length" autocomplete="off">
        <br>

        <input type="submit" name="submit" value="SUBMIT" autocomplete="off">
        <br>
        <br>

        <label>Entered Array Length Value is:</label>
        <input type="number" name="length" value='<?php echo $array_length; ?>' autocomplete="off" readonly>
        <br>
        <br>

        <?php
if (isset($_POST['submit'])) {
    for ($i = 0; $i < $array_length; $i++) {?>

        <label>Enter the value of array index <?php echo $i; ?>: </label>
        <input type="number" name='<?php echo $i; ?>' autocomplete="off"><br>
        <?php }}?>
        <br>
        <br>


        <label>Element to insert:</label>
        <input type="number" name='insert'><br>

        <br>
        <br>

        <label>Element to delete:</label>
        <input type="number" name='delete'><br>

        <br>
        <br>

        <label>Number of Elements to be deleted is:</label>
        <input type="number" name='num_delete'><br>

        <br>
        <br>


        <label>Element to search:</label>
        <input type="number" name='search'><br>

        <br>
        <br>


        <input type="submit" name="proceed" value="Proceed">

        <br>
        <br>

        <label>Created Array Is:</label>
        <?php print_r($created_array);?>

        <br>
        <br>

        <label>Ascending order Array Is:</label>
        <?php sort($created_array); print_r($created_array);?>

        <br>
        <br>

        <label>Descending order Array Is:</label>

        <?php rsort($created_array); print_r($created_array);?>

        <br>
        <br>


        <label>After Insertion is:</label>
        <?php print_r($inserted_array);?>

        <br>
        <br>

        <label>After Deletion is:</label>
        <?php print_r($deleted_array);?>

        <br>
        <br>

        <label>Copying of Array:</label>
        <?php $new_array = $created_array;
print_r($new_array);?>

        <br>
        <br>

        <label>Merged Array is:</label>
        <?php $merged_array = array_merge($created_array, $new_array);
print_r($merged_array);?>

        <br>
        <br>

        <label>After Removing 3 elements from an array is:</label>
        <?php print_r($num_deleted_array);?>

        <br>
        <br>


        <label>Finding the Initial Array Length:</label>
        <?php echo count($created_array); ?>
        <br>
        <br>

        <label>Finding the Merged Array Length :</label>
        <?php echo count($merged_array); ?>

        <br>
        <br>

        <label>5 elements inserting,:</label>
        <?php array_push($created_array, 'hi', 'hello', 'how are you?', 'I am Naveen', 'bi');
print_r($created_array)?>
        <br>
        <br>

        <label>Displaying first 4 elements :</label>
        <?php print_r(array_splice($created_array, 0, 4));?>

        <br>
        <br>

        <label>Index of the given element:</label>
        <?php echo $search; ?>
        <br>
        <br>

        <label>Unique Element in an Array:</label>
        <?php print_r(array_unique($created_array));?>
        <br>
        <br>


    </form>
    <?php

?>

</body>

</html>