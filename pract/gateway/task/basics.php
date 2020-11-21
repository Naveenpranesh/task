<!DOCTYPE HTML>
<html>

<head>
    <title>FRAME Assessment 1</title>
    <script src="<?php echo APPLICATION_URL.'resources/js/jquery.min.js'; ?>"></script>
    <script src="<?php echo APPLICATION_URL.'resources/js/task/scripts.js'; ?>"></script>
    <script type="text/javascript">
    var mtsoc_vars = {
        'base_url': '<?php echo APPLICATION_URL; ?>',
        'application': '<?php echo $request['application']; ?>'
    }
    </script>
</head>

<body>

    <label>Input String:</label>
    <input type="text" name="string" autocomplete="off">
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
    <button name="submit" id="submit_data">Submit</button>

    <h2>Output:</h2>
    <label>
        <h4>Length of the String is:</h4>
        <p id="length"> </p>

    </label>
    <label>
        <h4>Shuffled String is:</h4>
        <p id="shuffled"></p>

    </label>
    <label>
        <h4>Word Count of the input is:</h4>
        <p id="count"> </p>

    </label>
    <label>
        <h4>Replaced String is:</h4>
        <p id="replace"></p>

    </label>
    <label>
        <h4>Given string position is: </h4>
        <p id="string"></p>

    </label>
    <label>
        <h4>Lower Case of the String is: </h4>
        <p id="lowerstring"></p>

    </label>
    <label>
        <h4>Upper Case of the String is: </h4>
        <p id="upperstring"></p>

    </label>
    <label>
        <h4>First Letter of the String is:</h4>
        <p id="firstLetter"></p>

    </label>
    <label>
        <h4>Last Letter of the String is:</h4>
        <p id="lastLetter"></p>

    </label>
    <label>
        <h4>Reversed String is: </h4>
        <p id="reversed"></p>

    </label>
    <label>
        <h4>First Letter Upper Case String is:</h4>
        <p id="firstLetterupper"></p>

    </label>
    <label>
        <h4>First Letter Lower Case String is: </h4>
        <p id="firstLetterlower"></p>

    </label>
    <label>
        <h4>Upper Case String is: </h4>
        <p id="upperstring"></p>

    </label>
    <label>
        <h4>MD5 converted String is:</h4>
        <p id="md5"></p>

    </label>
    <label>
        <h4>White Space Removed String is:</h4>
        <p id="space"></p>

    </label>
    <label>
        <h4>String Comparission: </h4>
        <p id="compare"></p>

    </label>

</body>

</html>