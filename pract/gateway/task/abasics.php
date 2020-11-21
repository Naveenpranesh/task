<!DOCTYPE HTML>
<html>

<head>
    <title>FRAME Assessment 2</title>
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
    <label>Array Length:</label>
    <input type="number" name="array_length" id="array_length" autocomplete="off">
    <br>

    <button name="submit_arr" id="submit_arr" autocomplete="off">Submit</button>
    <br>
    <br>

    <!-- <label>Entered Array Length Value is:</label>
    <input type="number" name="length" value='' autocomplete="off" readonly>
    <br>
    <br> -->

    <div id='array_values'></div>
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


    <button name="proceed" id="proceed">Proceed</button>

    <br>
    <br>

    <label>Created Array Is:<p id='created'></p></label>


    <br>
    <br>

    <!-- <label>Ascending order Array Is:<p id='ascending'></p></label> -->


    <!-- <br>
    <br>

    <label>Descending order Array Is:<p id='descending'></p></label> -->

  

    <!-- <br>
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

    <label>5 elements inserting:<p id='fiveinsert'></p></label>
    
    <br>
    <br>

    <label>Displaying first 4 elements :<p id='displayfour'></p></label>


    <br>
    <br>

    <label>Index of the given element:<p id='index'></p></label>

    <br>
    <br>

    <label>Unique Element in an Array:<p id='unique'></p></label>
    
    <br>
    <br>

</body>

</html>