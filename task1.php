<?php
error_reporting(0);
if (isset($_POST['submit'])) {
    $input = htmlspecialchars($_POST['input']);

    $needtoreplace = htmlspecialchars($_POST['needtoreplace']);
    $replace_word = htmlspecialchars($_POST['replace_word']);
    $string_position = htmlspecialchars($_POST['string_position']);

    $len = strlen($input);
    $shuffled = str_shuffle($input);
    $wordcount = str_word_count($input);
    $replaced = str_replace($needtoreplace, $replace_word, $input);
    $position = strrpos($replaced, $string_position);
    $lower = strtolower($input);
    $upper = strtoupper($input);

    $first_letter = $input[0];
    $last_letter = $input[$len - 1];

    $reversed = strrev($input);

    $f_upper = ucwords($input);

    $f_lower = strtolower($input[0]) . substr($input, 1, $len - 1);
    $md5 = md5($input);
    $whitespaceremoved = trim($input);
    $stringcompare = strcmp($input, $input);

}

?>


<!DOCTYPE HTML>
<html>

<body>

    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">


        <label>Input String:</label>
        <input type="text" name="input" autocomplete="off">
        <br>
         <br>

        <label>String need to be replaced:</label>
        <input type="text" name="needtoreplace" autocomplete="off">
        <br>
         <br>

        <label>Replacing String:</label>
        <input type="text" name="replace_word" autocomplete="off">
        <br>
         <br>

        <label>Input String to find its position:</label>
        <input type="text" name="string_position" autocomplete="off">
        <br>
         <br>
        <input type="submit" name="submit" autocomplete="off">

        <h2>Output:</h2>
        <label><h4>Length of the String is: <?php echo $len; ?></h4></label>
        <label><h4>Shuffled String is: <?php echo $shuffled; ?></h4></label>
        <label><h4>Word Count of the input is: <?php echo $wordcount; ?></h4></label>
        <label><h4>Replaced String is: <?php echo $replaced; ?></h4></label>
        <label><h4>Given string position is: <?php echo $position; ?></h4></label>
        <label><h4>Lower Case of the String is: <?php echo $lower; ?></h4></label>
        <label><h4>Upper Case of the String is: <?php echo $upper; ?></h4></label>
        <label><h4>First Letter of the String is: <?php echo $first_letter; ?></h4></label>
        <label><h4>Last Letter of the String is: <?php echo $last_letter; ?></h4></label>
        <label><h4>Reversed String is: <?php echo $reversed; ?></h4></label>
        <label><h4>First Letter Upper Case String is: <?php echo $f_upper; ?></h4></label>
        <label><h4>First Letter Lower Case String is: <?php echo $f_lower; ?></h4></label>
        <label><h4>md5 converted String is: <?php echo $md5; ?></h4></label>
        <label><h4>White Space Removed String is: <?php echo $whitespaceremoved; ?></h4></label>
        <label><h4>String Comparission: <?php echo $stringcompare; ?></h4></label>


    </form>
</body>

</html>