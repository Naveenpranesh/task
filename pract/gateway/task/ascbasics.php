<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <title>ASSESMENT 1-3 SCORE</title>
    <script src="<?php echo APPLICATION_URL.'resources/js/jquery.min.js'; ?>"></script>
    <script src="<?php echo APPLICATION_URL.'resources/js/scripts.js'; ?>"></script>
    <script type="text/javascript">
    var mtsoc_vars = {
        'base_url': '<?php echo APPLICATION_URL; ?>',
        'application': '<?php echo $request['application']; ?>'
    }
    </script>

</head>

<body>


    <label>Array Length:</label>
    <input type="number" id="asc_array_length" name="asc_array_length" autocomplete="off">
    <br>

    <button id="asc_arraylen_submit" name="asc_arraylen_submit">SUBMIT</button>
    <br>
    <br>
    <div id='asc_array_values'></div>
    <!-- <label>Entered Array Length Value is:</label>
    <input type="number" name="length" value='' readonly>
    <br>
    <br> -->

    <br>
    <br>


    <label>Element to insert:</label>
    <input type="number" name='asc_insert' autocomplete="off"><br>

    <br>
    <br>

    <label>Element to delete:</label>
    <input type="number" name='asc_delete' autocomplete="off"><br>

    <br>
    <br>

    <label>Number of Elements to be deleted is:</label>
    <input type="number" name='asc_num_delete' autocomplete="off"><br>

    <br>
    <br>

    <label>Element to search:</label>
    <input type="number" name='asc_search' autocomplete="off"><br>

    <br>
    <br>

    <button type="submit" id="asc_proceed" name="asc_proceed" ] autocomplete="off">Proceed</button>

    <br>
    <br>

    <label>Created Array Is:<p id='created'></p></label>

    <br>
    <br>


    <!-- <label>Ascending order Array Is:</label>

    <br>
    <br>

    <label>Descending order Array Is:</label>

    <br>
    <br> -->

    <label>After Insertion is:<p id='afterInsert'></p></label>


    <br>
    <br>

    <label>After Deletion is:<p id='afterDelete'></p></label>


    <br>
    <br>

    <label>Copying of Array:<p id='copy'></p></label>

    <br>
    <br>

    <label>Merged Array is:<p id='merged'></p></label>


    <br>
    <br>

    <label>After Removing 3 elements from an array is:<p id='removal'></p></label>


    <br>
    <br>


    <label>Finding the Initial Array Length:<p id='inilength'></p></label>

    <br>
    <br>

    <label>Finding the Merged Array Length :<p id='mergedlength'></p></label>


    <br>
    <br>

    <label>5 elements inserting,:<p id='fiveinsert'></p></label>

    <br>
    <br>

    <label>Displaying first 4 elements :<p id='displayfour'></p></label>


    <br>
    <br>

    <label>Index of the given element:<p id='index'></p></label>

    <br>
    <br>
<!-- 
    <label>Unique Element in an Array:<p id='unique'></p></label>

    <br>
    <br> -->

    <?php

?>

</body>

</html>