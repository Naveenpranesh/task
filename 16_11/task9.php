<?php


?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"> </script>
    <script src="validate.js"></script>
    <script src="add.js"></script>

    <style>
    .centered {
        position: fixed;
        top: 50%;
        left: 50%;
        color: blue;
        transform: translate(-50%, -50%);
    }

    .border {
        border: #dbdbdb solid 1px;
        position: 'absolute';
        width: 50%;
        height: 'auto';
    }

    h3 {
        color: blue;
        text-align: center;
        text-transform: uppercase;
    }
    </style>
</head>

<body>

    <div action="<?php echo $_SERVER['PHP_SELF'] ?>">

        <h3>User Test Score</h3>
        <label>Name:</label>
        <input type="text" id="name" name="name" autocomplete="off" required>
        <br>
        <br>
        <label>Score:</label>
        <input type="number" id="score" name="score" autocomplete="off" required>
        <input type="number" id="array_index" name="array_index" value=0 autocomplete="off" readonly>
        <br>
        <br>

        <button type="submit" name="add_to_array" id="add_to_array" onclick="return validateForm();"
            autocomplete="off">ADD TO
            ARRAY</button>
        <input type="button" name="result" id="result" value="Local Display Results" autocomplete="off">
        <input type="button" name="b_score" id="b_score" value="Local Display Score" autocomplete="off">
       
       
        <input type="button" name="db_result" id="db_result" value="DB Display Results" autocomplete="off">
        <input type="button" name="db_score" id="db_score" value=" DB Display Score" autocomplete="off">
        <br>
        <br>
        <div>

            <h3>Results</h3>

            <div class="register_output" id="score_output"></div>
            <div class="register_output" id="register_output"></div>
          
           
            <div class="db_score_output" id="db_score_output"></div>
            <div class="db_register_output" id="db_register_output"></div>
          
            <div class="results" id="results"></div>
        </div>


        <script>
        
            $('#array_index').hide();
            $('#result').hide();
           $('#b_score').hide();
           $('#db_result').hide();
           $('#db_score').hide();

        </script>


    </div>
    <?php

?>

</body>

</html>